<!--
    This file is responsible for the controller layer of the editUoS page. It contains business logic and validation.
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
    function validate_input(&$id, &$unitName, &$unitDescription) {
    	
        //Check Unit ID isn't empty
        if (empty($_POST['unit_ID'])){       
            $errUnitID = 'Please enter a Unit ID';
        } else {
            $id = test_input($_POST["unit_ID"]);  
        }
        //Check unit name
        if (empty($_POST['unit_Name'])) {        
           $errUnitName = 'Please enter a Unit Name';
        } else {
            $unitName = test_input($_POST["unit_Name"]);               
        }
        //Check unit description 
        if (empty($_POST['unit_Description'])) {   
            $errUnitDescription = 'Place enter a Unit Description';
        } else {
            $unitDescription = test_input($_POST["unit_Description"]); 
        }
	}

    //Validates the input, then if there are no errors in validation connects to the database and updates the unit.
	function update_database(&$id, &$unitName, &$unitDescription) {
		
		validate_input($id, $unitName, $unitDescription);

		if (!$errUnitName && !$errUnitDescription){
                $result = edit_unit($id, $unitName, $unitDescription);
            }

        $id = $unitName = $unitDescription = $e = "";
        return $result;
    }

    //Checkes the Unit ID isn't empty, then connects to the database and retrieves the details of the given unit
    function get_details_from_database(&$id, &$unitName, &$unitDescription) {
        
        if (empty($_POST['unit_ID'])){ 
                $errID = 'Please enter a Unit ID';
            } else {
                $id = test_input($_POST["unit_ID"]);
                get_unit_details($id, $unitName, $unitDescription);
            }
    }
?>