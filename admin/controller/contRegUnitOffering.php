<!--
    This file is responsible for the controller layer of the regUnitOffering page. It contains business logic and validation.
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
    function validate_input(&$unitID, &$unitSemester, &$unitYear, &$unitConvenor) {

        //Check Unit ID isn't empty
    	if (empty($_POST['unit_ID'])) {
           $errID = 'Please enter a Unit ID';
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        //Check Convenor ID isn't empty
        if (empty($_POST['unit_Convenor'])) {
            $errConvenor = 'Please enter a Unit Convenor';
        } else {
            $unitConvenor = test_input($_POST["unit_Convenor"]);
        }

        $unitSemester = test_input($_POST["unit_Semester"]);
        $unitYear = test_input($_POST["unit_Year"]);


	}

    //Validates the input, then if there are no errors in validation connects to the database and inserts the unit offering.
	function insert_to_database(&$unitID, &$unitSemester, &$unitYear, &$unitConvenor) {
		
		validate_input($unitID, $unitSemester, $unitYear, $unitConvenor);

		if (!$errID && !$errConvenor){
            $result = insert_unit_offering($unitID, $unitSemester, $unitYear, $unitConvenor);
        }

        return $result;
    }
?>