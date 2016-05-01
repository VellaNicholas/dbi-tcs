<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$unitID, &$unitName, &$unitDescription) {
    	//Check ID
            if (empty($_POST['unit_ID'])) {
               $errID = 'Please enter a Unit ID';
            } else {
                $unitID = test_input($_POST["unit_ID"]);                
            }
            //Check last name
            if (empty($_POST['unit_Name'])) {
                $errName = 'Place enter a Unit Name';
            } else {
                $unitName = test_input($_POST["unit_Name"]);
            }

            if (empty($_POST['unit_Description'])){
                $errDescription = 'Please enter a Description';
            } else {
                $unitDescription = test_input($_POST["unit_Description"]);
            }
	}

	function insert_to_database(&$unitID, &$unitName, &$unitDescription) {
		
		validate_input($unitID, $unitName, $unitDescription);

		if (!$errID && !$errName && !$errDescription){
                $result = insert_unit($unitID, $unitName, $unitDescription);
            }

        return $result;
    }
?>

