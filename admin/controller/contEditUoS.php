<?php  
	//Prevents scripting and SQL injection
   function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
   }

    function validate_input(&$id, &$unitName, &$unitDescription) {
    	if (empty($_POST['unit_ID'])){       
            $errUnitID = 'Please enter a Unit ID';
        } else {
            $id = test_input($_POST["unit_ID"]);  
        }
        //Check first name
        if (empty($_POST['unit_Name'])) {        
           $errUnitName = 'Please enter a Unit Name';
        } else {
            $unitName = test_input($_POST["unit_Name"]);               
        }
        //Check last name 
        if (empty($_POST['unit_Description'])) {   
            $errUnitDescription = 'Place enter a Unit Description';
        } else {
            $unitDescription = test_input($_POST["unit_Description"]); 
        }
	}

	function update_database(&$id, &$unitName, &$unitDescription) {
		
		validate_input($id, $unitName, $unitDescription);

		if (!$errUnitName && !$errUnitDescription){
                $result = edit_unit($id, $unitName, $unitDescription);
            }

        $id = $unitName = $unitDescription = $e = "";
        return $result;
    }

    function get_details_from_database(&$id, &$unitName, &$unitDescription) {
        
        if (empty($_POST['unit_ID'])){ 
                $errID = 'Please enter a Unit ID';
            } else {
                $id = test_input($_POST["unit_ID"]);
                get_unit_details($id, $unitName, $unitDescription);
            }
    }
?>