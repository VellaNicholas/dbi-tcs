<!--
    This files controls all communications between the application and the database
-->

<?php

    //Connects to the database and inserts the student into the Student and Permissions tables
    //Returns a successful message or a specified exception
    function insert_student(&$id, &$firstName, &$lastName, &$email, &$contact) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_STUDENT(:stuid, :firstname, :lastname, :email, :contactno); END;';
        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':stuid',$id,32);               //input
        oci_bind_by_name($stmt, ':firstname',$firstName,32);    //input
        oci_bind_by_name($stmt, ':lastname',$lastName,32);      //input
        oci_bind_by_name($stmt, ':email',$email,32);            //input
        oci_bind_by_name($stmt, ':contactno',$contact,32);      //input

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    //Connects to the database and update the student in the Student table
    //Returns a successful message or a specified exception
    function edit_student(&$id, &$firstName, &$lastName, &$email, &$contact) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN UPDATE_STUDENT(:stuid, :firstname, :lastname, :email, :contactno); END;';
        $stmt = oci_parse($conn,$sql);

        oci_bind_by_name($stmt, ':stuid',$id, 32);
        oci_bind_by_name($stmt, ':firstname',$firstName, 32);
        oci_bind_by_name($stmt, ':lastname',$lastName, 32);
        oci_bind_by_name($stmt, ':email',$email, 32);
        oci_bind_by_name($stmt, ':contactno',$contact, 32);

        oci_execute($stmt);
        oci_commit($conn);

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully updated!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    //Connects to the database and accesses the student details
    //Assigns the student details into the passed in perameters
    function get_student_details(&$id, &$firstName, &$lastName, &$email, &$contact) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN GET_STUDENT_DETAILS(:stuid, :firstname, :lastname, :email, :contactno); END;';
        $stmt = oci_parse($conn,$sql);

        oci_bind_by_name($stmt, ':stuid',$id, 32);               //input
        oci_bind_by_name($stmt, ':firstname',$firstName, 32);    //output
        oci_bind_by_name($stmt, ':lastname',$lastName, 32);      //output
        oci_bind_by_name($stmt, ':email',$email, 32);            //output
        oci_bind_by_name($stmt, ':contactno',$contact, 32);      //output

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        //TODO: Actual codes
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully updated!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
    }

    //Connects to the database and inserts the employee into the Employee and Permissions tables
    //Returns a successful message or a specified exception
    function insert_employee($userName, $firstName, $lastName, $email, $contact) {

        $sql = 'BEGIN INSERT_EMPLOYEE(:username, :firstname, :lastname, :email, :contactno); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':username',$userName);
        oci_bind_by_name($stmt, ':firstname',$firstName);
        oci_bind_by_name($stmt, ':lastname',$lastName);
        oci_bind_by_name($stmt, ':email',$email);
        oci_bind_by_name($stmt, ':contactno',$contact);

        oci_execute($stmt);

        $e = oci_error($stmt);

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Employee with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        oci_commit($conn);

        return $result;

    }

    //Connects to the database and inserts the unit into the Unit Table
    //Returns a successful message or a specified exception
    function insert_unit(&$unitID, &$unitName, &$unitDescription) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_UNIT(:unitid, :name, :description); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':unitid', $unitID);
        oci_bind_by_name($stmt, ':name', $unitName);
        oci_bind_by_name($stmt, ':description', $unitDescription);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        //TODO: Exceptions
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Unit successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Unit with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
    }

    //Connects to the database and accesses the unit details
    //Assigns the unit details into the passed in perameters
    function get_unit_details(&$id, &$unitName, &$unitDescription) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN GET_UNIT_OF_STUDY_DETAILS(:unitid, :unitname, :unitdescription); END;';
        $stmt = oci_parse($conn,$sql);

        oci_bind_by_name($stmt, ':unitid',$id, 32);                             //input
        oci_bind_by_name($stmt, ':unitname',$unitName, 32);                     //output
        oci_bind_by_name($stmt, ':unitdescription',$unitDescription, 32);       //output

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        //TODO: Exceptions
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Unit successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Unit with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
    }

    //Connects to the database and update the unit in the Unit table
    //Returns a successful message or a specified exception
    function edit_unit(&$id, &$unitName, &$unitDescription) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        
        $sql = 'BEGIN UPDATE_UNIT(:unitid, :unitname, :unitdescription); END;';
        $stmt = oci_parse($conn,$sql);

        //Bind the inputs 
        oci_bind_by_name($stmt, ':unitid',$id, 32);     
        oci_bind_by_name($stmt, ':unitname',$unitName, 32);
        oci_bind_by_name($stmt, ':unitdescription',$unitDescription, 32);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        //TODO: Exception Handling
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully updated!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    //Connects to the database and inserts the UnitOffering in the UnitOffering table
    //Returns a successful message or a specified exception
    function insert_unit_offering(&$unitID, &$unitSemester, &$unitYear, &$unitConvenor) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN OFFER_UNIT(:unitid, :teachingperiod, :year, :convenor); END;';
        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':unitid', $unitID); //input 
        oci_bind_by_name($stmt, ':teachingperiod', $unitSemester); //input
        oci_bind_by_name($stmt, ':year', $unitYear);//input  
        oci_bind_by_name($stmt, ':convenor', $unitConvenor); //input 

        oci_execute($stmt);
        oci_commit($conn);
        
        $e = oci_error($stmt);
        //TODO Exception handling
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully updated!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
        
        return $result;

    }

    //Used for debugging of code during development, and when unknown exceptions occur
    function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
    }
?>