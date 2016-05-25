<!--
    This file is responsible for the controller layer of the regEnrolment page. It contains business logic and validation.
-->

<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Validates all of the input from on the current page
    //NOTE: unitSemester and unitYear aren't needed to be validated because they come from drop down menus
    function validate_input(&$unitID, &$unitSemester, &$unitYear, &$stuID) {

        //Check Unit ID isn't empty
    	if (empty($_POST['unit_ID'])) {
           throw new Exception('Please enter a Unit ID');
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        //Check Student ID isn't empty
        if (empty($_POST['stu_ID'])) {
            throw new Exception('Please enter a Student ID');
        } else {
            $stuID = test_input($_POST["stu_ID"]);
        }

        $unitSemester = test_input($_POST["unit_Semester"]);
        $unitYear = test_input($_POST["unit_Year"]);


	}

    //Validates the input, then if there are no errors in validation connects to the database and inserts the unit offering.
	function insert_to_database(&$unitID, &$unitSemester, &$unitYear, &$stuID) {
        try {
            validate_input($unitID, $unitSemester, $unitYear, $stuID);
            $result = insert_enrolment($unitID, $unitSemester, $unitYear, $stuID);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }
?>