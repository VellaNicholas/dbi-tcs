-- Drop all tables in the database in an order that doesn't violate foreign key constraints

DROP TABLE Permissions;
DROP TABLE EnrolledStudent;
DROP TABLE UnitOffering;
DROP TABLE Employee;
DROP TABLE Unit;
DROP TABLE TeachingPeriod;
DROP TABLE Student;

/

Create Table Employee (
  EmpId number PRIMARY KEY,
  Username varchar2(40) NOT NULL,
  FirstName varchar2(30) NOT NULL,
  LastName varchar2(60) NOT NULL,
  Email varchar2(100) NOT NULL,
  ContactNo varchar2(10)
);
/

Create Table Unit (
	UnitId varchar2(10) PRIMARY KEY,
	Name varchar2(30) NOT NULL,
	Description varchar2(100)
);
/

Create Table UnitOffering (
	OfferingId number PRIMARY KEY,
	UnitId varchar(10) NOT NULL,
	TeachingPeriod varchar2(20) NOT NULL,
	Year number NOT NULL,
	ConvenorEmpId number NOT NULL,
	FOREIGN KEY (ConvenorEmpId) REFERENCES Employee,
	FOREIGN KEY (UnitId) REFERENCES Unit
);

/

Create Table Student (
	SurStuId number PRIMARY KEY,
	StuId varchar2(10) NOT NULL UNIQUE,
	FirstName varchar2(30) NOT NULL,
	LastName varchar2(60) NOT NULL,
	Email varchar2(100) NOT NULL,
	ContactNo varchar2(10)
);

/

Create Table EnrolledStudent (
	EnrolStuId number PRIMARY KEY,
	StuId number NOT NULL,
	OfferingId number NOT NULL,
	FOREIGN KEY (StuId) REFERENCES Student,
	FOREIGN KEY (OfferingId) REFERENCES UnitOffering
);

/

-- Permissions and Login Table. Is automatically inserted into when users are created.
-- Contains their username, hashed password, and booleans representing their permissions.
-- Oracle Database doesn't have boolean fields, so numbers constrainted to 0 or 1 have been used.

Create Table Permissions (
	Username varchar2(30) PRIMARY KEY,
	Password varchar2(100) NOT NULL,
	IsAdmin number NOT NULL,
	IsConvenor number NOT NULL,
	IsSupervisor number NOT NULL,
	IsStudent number NOT NULL,
	IsResetRequired number NOT NULL,
	CONSTRAINT admin_bool CHECK (IsAdmin = 0 OR IsAdmin = 1),
	CONSTRAINT convenor_bool CHECK (IsConvenor = 0 OR IsConvenor = 1),
	CONSTRAINT supervisor CHECK (IsSupervisor = 0 OR IsSupervisor = 1),
	CONSTRAINT student_bool CHECK (IsStudent = 0 OR IsStudent = 1),
	CONSTRAINT reset_bool CHECK (IsResetRequired = 0 OR IsResetRequired = 1)
);

-- Creates the Sequence needed for primary keys in the above fields

CREATE SEQUENCE StuIdSeq;
CREATE SEQUENCE EmpIdSeq;
CREATE SEQUENCE UnitOffIdSeq;

/

-- Inserts all the needed data for students into the student table, as well as creating users in the Permissions table

CREATE OR REPLACE PROCEDURE INSERT_STUDENT (pStuId varchar2, pFirstName varchar2, pLastName varchar2, pEmail varchar2, pContactNo varchar2) AS
BEGIN
	INSERT INTO Student VALUES (StuIdSeq.NextVal, pStuId, pFirstName, pLastName, pEmail, pContactNo);
	INSERT INTO Permissions VALUES (pStuId, GET_HASH(pStuId, '12345'), 0, 0, 0, 1, 1);
		-- Booleans represent (IsAdmin, IsConvenor, IsSupervisor, IsStudent, IsResetRequired) as per Permissions table
END;

/

-- Inserts all the needed data for employees into the employee table, as well as creating users in the Permissions table

CREATE OR REPLACE PROCEDURE INSERT_EMPLOYEE (pUsername varchar2, pFirstName varchar2, pLastName varchar2, pEmail varchar2, pContactNo varchar2) AS
BEGIN
	INSERT INTO Employee VALUES (EmpIdSeq.NextVal, pUsername, pFirstName, pLastName, pEmail, pContactNo);
	INSERT INTO Permissions VALUES (pUsername, GET_HASH(pUsername, '12345'), 0, 0, 0, 0, 1);
		-- Booleans represent (IsAdmin, IsConvenor, IsSupervisor, IsStudent, IsResetRequired) as per Permissions table
END;

/

-- Inserts the unit into the Unit table

CREATE OR REPLACE PROCEDURE INSERT_UNIT (pUnitId varchar2, pName varchar2, pDescription varchar2) AS
BEGIN
	INSERT INTO Unit VALUES (pUnitId, pName, pDescription);
END;

/

-- Takes in a username and outputs a boolean representing if the user is required to reset their password
-- Will return TRUE if the user has never logged in

CREATE OR REPLACE PROCEDURE IS_RESET_REQUIRED (pUsername varchar2, pIsResetRequired out boolean) AS
	vIsResetRequired number;
BEGIN
	SELECT IsResetRequired
		INTO vIsResetRequired
		FROM Permissions
		WHERE Username = pUsername;

	IF (vIsResetRequired = 1) THEN
		pIsResetRequired := TRUE;
	ELSE
		pIsResetRequired := FALSE;
	END IF;
END;

/

-- Simple procedures for determining how many of each of Students, Employees and Units

CREATE OR REPLACE PROCEDURE GET_STUDENT_COUNT (pCount out number) AS
BEGIN
  	SELECT Count(*) INTO pCount
  	FROM Student;
END;

/

CREATE OR REPLACE FUNCTION GET_EMPLOYEE_COUNT RETURN number AS
  vCount number := 0;
BEGIN
  SELECT Count(*) INTO vCount
  FROM Employee;
  
  Return vCount;
END;

/

CREATE OR REPLACE FUNCTION GET_UNIT_COUNT RETURN number AS
  vCount number := 0;
BEGIN
  SELECT Count(*) INTO vCount
  FROM Unit;
  
  Return vCount;
END;

/

-- Used for all password storage and comparison. Takes in the username and password, and combines the two
-- to create a 40 character long hash of the two. Ensures password are never stored unencrypted

CREATE OR REPLACE FUNCTION GET_HASH (pUsername varchar2, pPassword varchar2) RETURN varchar2 AS
BEGIN
	RETURN DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(UPPER(pUsername) || UPPER(pPassword)),DBMS_CRYPTO.HASH_SH1);
END;

/

-- Used when a password is required to be reset, either on first login or after being forgot.
-- Takes in the Usernamem, current password, and new password.
-- Will only insert the new password if the old password is entered correctly.

CREATE OR REPLACE PROCEDURE CHANGE_PASSWORD (pUsername varchar2, pOldPassword varchar2, pNewPassword varchar2) AS
	v_rowid  ROWID;
BEGIN
	SELECT rowid
		INTO   v_rowid
		FROM   Permissions
		WHERE  Username = pUsername
		AND    Password = GET_HASH(pUsername, pOldPassword)
		FOR UPDATE;
	
	UPDATE Permissions
		SET    Password = GET_HASH(pUsername, pNewPassword)
		WHERE  rowid    = v_rowid;

	UPDATE Permissions
		SET    IsResetRequired = 0
		WHERE  rowid    = v_rowid;
END;

/

/*	Takes in a username and password, and returns a number that represents the result.
 	Oracle Database doesn't have boolean fields, so numbers are used that will be set to 1 or 0.
 	If the username and password are not found in the database, the exception handling section returns a 0 for permissions.
 	Possible return values outlined below. */

CREATE OR REPLACE PROCEDURE AUTHENTICATE_USER (pUsername in varchar2, pPassword in varchar2, pPermissions out number) AS
	vIsAdmin number := 0;
	vIsConvenor number := 0;
	vIsSupervisor number := 0;
	vIsStudent number := 0;
BEGIN
      
	SELECT IsAdmin
		INTO 	vIsAdmin
		FROM 	Permissions
		WHERE	Username = pUsername
		AND  	Password = GET_HASH(pUsername, pPassword);

	SELECT IsConvenor
		INTO 	vIsConvenor
		FROM 	Permissions
		WHERE	Username = pUsername
		AND  	Password = GET_HASH(pUsername, pPassword);

	SELECT IsSupervisor
		INTO 	vIsSupervisor
		FROM 	Permissions
		WHERE	Username = pUsername
		AND  	Password = GET_HASH(pUsername, pPassword);

	SELECT IsStudent
		INTO 	vIsStudent
		FROM 	Permissions
		WHERE	Username = pUsername
		AND  	Password = GET_HASH(pUsername, pPassword);

	pPermissions := (1 * vIsAdmin) + (2 * vIsConvenor) + (4 * vIsSupervisor) + (8 * vIsStudent);

	/* 	RETURN VALUES:
		The return value uses binary logic to enable a user to have multiple roles in the system
		Initialied to 0000, values representing Student, Supervisor, Convenor, Admin
		The complete range of possible return values can be found on the webserver at /var/www/html/pages/permissions.php */
    
EXCEPTION
    WHEN NO_DATA_FOUND THEN
      pPermissions := 0;
END;

/

-- Takes in a Student's ID number, and returns the rest of their information from the database

CREATE OR REPLACE PROCEDURE GET_STUDENT_DETAILS (pStuId in varchar2, pFirstName out varchar2, pLastName out varchar2, pEmail out varchar2, pContactNo out varchar2) AS
	vStuRow Student%ROWTYPE;
BEGIN
	SELECT * INTO vStuRow
	FROM Student
	WHERE pStuId = StuId;

	pFirstName := vStuRow.FirstName;
	pLastName := vStuRow.LastName;
	pEmail := vStuRow.Email;
	pContactNo := vStuRow.ContactNo;
END;

/

-- Allows updating of all student information in the database
-- Matches based on the student ID passed in, and updates the remaining information
-- Has no capability to update a student ID

CREATE OR REPLACE PROCEDURE UPDATE_STUDENT (pStuId varchar2, pFirstName varchar2, pLastName varchar2, pEmail varchar2, pContactNo varchar2) AS
	NO_STU_UPDATED EXCEPTION;
BEGIN
	UPDATE Student
	SET FirstName = pFirstName,
		LastName = pLastName,
		Email = pEmail,
		ContactNo = pContactNo
	WHERE StuId = pStuId;

	IF (SQL%ROWCOUNT = 0) THEN
		RAISE NO_STU_UPDATED;
	END IF;
EXCEPTION
	WHEN NO_STU_UPDATED THEN
		RAISE_APPLICATION_ERROR(-20001, 'No Students Updated');
END;

/

-- Takes in a Employee's username, and returns the rest of their information from the database

CREATE OR REPLACE PROCEDURE GET_EMPLOYEE_DETAILS (pUsername in varchar2, pFirstName out varchar2, pLastName out varchar2, pEmail out varchar2, pContactNo out varchar2) AS
	vEmpRow Employee%ROWTYPE;
BEGIN
	SELECT * INTO vEmpRow
	FROM Employee
	WHERE pUsername = Username;

	pFirstName := vEmpRow.FirstName;
	pLastName := vEmpRow.LastName;
	pEmail := vEmpRow.Email;
	pContactNo := vEmpRow.ContactNo;
END;

/

-- Takes in a UoS's ID, and returns the rest of its information from the database

CREATE OR REPLACE PROCEDURE GET_UNIT_OF_STUDY_DETAILS (pUosId in varchar2, pName out varchar2, pDesc out varchar2) AS
	vUosRow UNIT%ROWTYPE;
BEGIN
	SELECT * INTO vUosRow
	FROM UNIT
	WHERE pUosId = UnitId;

	pName := vUosRow.Name;
	pDesc := vUosRow.Description;
END;

/

-- Allows updating of all employee information in the database
-- Matches based on the username passed in, and updates the remaining information
-- Has no capability to change a username

CREATE OR REPLACE PROCEDURE UPDATE_EMPLOYEE (pUsername varchar2, pFirstName varchar2, pLastName varchar2, pEmail varchar2, pContactNo varchar2) AS
BEGIN
	UPDATE Employee
	SET FirstName = pFirstName,
		LastName = pLastName,
		Email = pEmail,
		ContactNo = pContactNo
  WHERE Username = pUsername;
END;

/

-- Allows updating of all unit information in the database
-- Matches based on the unit ID passed in, and updates the remaining information
-- Has no capability to change a unit ID

CREATE OR REPLACE PROCEDURE UPDATE_UNIT (pUosId varchar2, pName varchar2, pDesc varchar2) AS
BEGIN
	UPDATE UNIT
		SET Name = pName,
			Description = pDesc
		WHERE UnitID = pUosid;
END;
/

-- Inserts the unit and it's available time into the UnitOffering Table, enabling students to enrol into it
-- Also gives the assigned convenor convenor priveledges in the system

CREATE OR REPLACE PROCEDURE OFFER_UNIT (pUosId in varchar2, pTeachingPeriod in varchar2, pYear in number, pUsername in varchar2) AS

BEGIN
	INSERT INTO UnitOffering VALUES
		(UnitOffIdSeq.NextVal,
		pUosId,
		pTeachingPeriod,
		pYear,
		(SELECT EmpId
			FROM Employee
			WHERE Username = pUsername)
		);

	UPDATE Permissions
		SET IsConvenor = 1
		WHERE Username = pUsername;
END;

