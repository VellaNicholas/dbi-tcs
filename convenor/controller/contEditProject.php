<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$proUnitID, &$proID, &$proDescription, &$proSemester, &$proYear) {
    	    
            //Check ID
            if (empty($_POST['proUnitID'])) {
               $errProUnitID = 'Please enter a Unit ID for the Project';
            } else {
                $proUnitID = test_input($_POST["proUnitID"]);                
            }
            if (empty($_POST['proID'])){
                $errProID = 'Please enter a Project ID';
            } else {
                $proID = test_input($_POST["proID"]);
            }

            if (empty($_POST['proDescription'])){
                $errProDescription = 'Please enter a Description';
            } else {
                $proDescription = test_input($_POST["proDescription"]);
            }

            if (empty($_POST['proSemester'])){
                $errProSemester = 'Please enter a Semester';
            } else {
                $proSemester = test_input($_POST["proSemester"]);
            }
            if (empty($_POST['proYear'])){
                $errProYear = 'Please enter a Year';
            } else {
                $proYear = test_input($_POST["proYear"]);
            }
	}

	function edit_project(&$proUnitID, &$proID, &$proDescription, &$proSemester, &$proYear) {
		
		validate_input($proUnitID, $proID, $proDescription, $proSemester, $proYear);
        
		if (!$errProDescription && !$errProSemester && !$errProYear){
            $result = insert_project($proUnitID, $proID, $proDescription, $proSemester, $proYear);
        }
        $proUnitID = $proID = $proDescription = $proSemester = $proYear = $e =  "";
        return $result;
    }

    function get_project_details(&$proUnitID, &$proID, &$proDescription, &$proSemester, &$proYear) {
        
        if (empty($_POST['proUnitID'])){ 
                $errID = 'Please enter a Project Unit ID'; 
            } or if (empty($_POST['proID'])){ 
                $errID = 'Please enter a Project ID'; 
            }
             else {
                $proUnitID = test_input($_POST["proUnitID"]);
                $proID = test_input($_POST["proID"]);

                get_project_details($proUnitID, $proID, $proDescription, $proSemester, $proYear);
            }
    }


?>

