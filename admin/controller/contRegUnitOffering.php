<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$unitID, &$unitSemester, &$unitYear, &$unitConvenor) {
        //Check ID
    	if (empty($_POST['unit_ID'])) {
           $errID = 'Please enter a Unit ID';
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        //Check Convenor
        if (empty($_POST['unit_Convenor'])) {
            $errConvenor = 'Please enter a Unit Convenor';
        } else {
            $unitConvenor = test_input($_POST["unit_Convenor"]);
        }

        $unitSemester = test_input($_POST["unit_Semester"]);
        $unitYear = test_input($_POST["unit_Year"]);


	}

	function insert_to_database(&$unitID, &$unitSemester, &$unitYear, &$unitConvenor) {
		
		validate_input($unitID, $unitSemester, $unitYear, $unitConvenor);

		if (!$errID && !$errConvenor){
            $result = insert_unit_offering($unitID, $unitSemester, $unitYear, $unitConvenor);
        }

        return $result;
    }
?>