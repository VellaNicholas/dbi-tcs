<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$proUnitID,  &$proName, &$teachingPeriod, &$year, &$descriptionPath) {

        if (empty($_POST['proName'])){ 
            throw new Exception('Please enter a Project Name');
        } else {
            $proName = test_input($_POST["proName"]);
        }
        if (empty($_POST['proUnitID'])){ 
            throw new Exception('Please enter a Unit ID');
        } else {
            $proUnitID = test_input($_POST["proUnitID"]);
        }

        $teachingPeriod = test_input($_POST["pro_Semester"]);
        $year = test_input($_POST["pro_Year"]);

        //file upload
        $target_dir = "/var/www/html/uploads/";
        $target_file = $target_dir . $proName . $proUnitID . $teachingPeriod . $year . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        debug_to_console($fileType);
    
        // Allow certain file formats
        if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf" ) {
            throw new Exception('Please upload a DOC, DOCX or PDF document');
        }
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $descriptionPath = $target_file;
        } else {
            throw new Exception('Description was not uploaded, unknown error occurred');
        }
    }

	function update_database(&$proUnitID, &$proName, &$teachingPeriod, &$year, &$descriptionPath) {
		
        try {
            validate_input($proUnitID, $proName, $teachingPeriod, $year, $descriptionPath);
            $result = edit_project($proUnitID, $proName, $teachingPeriod, $year, $descriptionPath);
            $proUnitID = $proName = $teachingPeriod = $year = $descriptionPath = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }

    function get_details_from_database(&$proUnitID, &$proName, &$teachingPeriod, &$year, &$descriptionPath) {
        
        try {
            if (empty($_POST['proName'])){ 
                throw new Exception('Please enter a Project Name');
            } else {
                $proName = test_input($_POST["proName"]);
            }
            if (empty($_POST['proUnitID'])){ 
                throw new Exception('Please enter a Unit ID');
            } else {
                $proUnitID = test_input($_POST["proUnitID"]);
            }

            $teachingPeriod = test_input($_POST["pro_Semester"]);
            $year = test_input($_POST["pro_Year"]);
            
            $result = get_project_details($proUnitID, $proName, $teachingPeriod, $year, $descriptionPath);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }


?>

