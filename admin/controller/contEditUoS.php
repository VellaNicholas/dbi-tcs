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
    	
        //Check unit ID isn't empty
        if (empty($_POST['unit_ID'])) {
           throw new Exception('Please enter a Unit ID');
        } else {
            $id = test_input($_POST["unit_ID"]);                
        }
        //Check unit name
        if (empty($_POST['unit_Name'])) {
            throw new Exception('Place enter a Unit Name');
        } else {
            $unitName = test_input($_POST["unit_Name"]);
        }

        //Check unit description
        if (empty($_POST['unit_Description'])){
            throw new Exception('Please enter a Description');
        } else {
            $unitDescription = test_input($_POST["unit_Description"]);
        }
	}

    //Validates the input, then if there are no errors in validation connects to the database and updates the unit.
	function update_database(&$id, &$unitName, &$unitDescription) {
		
        try {
            validate_input($id, $unitName, $unitDescription);
            $result = edit_unit($id, $unitName, $unitDescription);
            $id = $unitName = $unitDescription = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }

    //Checkes the Unit ID isn't empty, then connects to the database and retrieves the details of the given unit
    function get_details_from_database(&$id, &$unitName, &$unitDescription) {
        
        if (empty($_POST['unit_ID'])){ 
            $result = '<div class="span alert alert-danger fade in">Please enter a Unit ID</div>';
        } else {
            $id = test_input($_POST["unit_ID"]);
            $result = get_unit_details($id, $unitName, $unitDescription);
        }

        return $result;
    }
?>