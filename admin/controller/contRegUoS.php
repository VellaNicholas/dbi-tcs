<!--
    This file is responsible for the controller layer of the regUoS page. It contains business logic and validation.
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
    function validate_input(&$unitID, &$unitName, &$unitDescription) {

    	//Check unit ID isn't empty
            if (empty($_POST['unit_ID'])) {
               $errID = 'Please enter a Unit ID';
            } else {
                $unitID = test_input($_POST["unit_ID"]);                
            }
            //Check unit name
            if (empty($_POST['unit_Name'])) {
                $errName = 'Place enter a Unit Name';
            } else {
                $unitName = test_input($_POST["unit_Name"]);
            }

            //Check unit description
            if (empty($_POST['unit_Description'])){
                $errDescription = 'Please enter a Description';
            } else {
                $unitDescription = test_input($_POST["unit_Description"]);
            }
	}

    //Validates the input, then if there are no errors in validation connects to the database and inserts the student.
	function insert_to_database(&$unitID, &$unitName, &$unitDescription) {
		
		validate_input($unitID, $unitName, $unitDescription);

		if (!$errID && !$errName && !$errDescription){
                $result = insert_unit($unitID, $unitName, $unitDescription);
            }

        return $result;
    }
?>

