<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$assTitle, &$unitID, &$semester, &$year, &$description, &$isIndividualGroup, &$dueDate, &$markingGuidePath, &$proName) {

        //Check Assignment Title isn't empty
        if (empty($_POST['ass_Title'])){
            throw new Exception('Assignment Title required');
        } else {
            $assTitle = test_input($_POST["ass_Title"]);
        }

        //Check unit ID name
        if (empty($_POST['unit_ID'])) {
           throw new Exception('Unit ID required');
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        $semester = test_input($_POST["teaching_period"]);
        $year = test_input($_POST["year"]);
        $isIndividualGroup = test_input($_POST["ass_Individual"]);

        //Check Project Name
        if (empty($_POST['proj_name'])) {
           throw new Exception('Project Name required');
        } else {
            $proName = test_input($_POST["proj_name"]);                
        }
        //Check Description
        if (empty($_POST['ass_Description'])) {
           throw new Exception('Assignment Description required');
        } else {
            $description = test_input($_POST["ass_Description"]);                
        }

        if (empty($_POST['due_Date'])) {
           throw new Exception('Due Date required');
        } else {
            $dueDate = test_input($_POST["due_Date"]);               
        }

        //file upload
        $target_dir = "/var/www/html/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
    
        // Check if file already exists
        debug_to_console('_FILES value:' . $_FILES["fileToUpload"]["name"]);
        debug_to_console('targetfile value:' . $target_file);
        if (file_exists($target_file)) {
            throw new Exception('File with this name already exists');
        }
    
        // Allow certain file formats
        if($fileType != "doc" && $fileType != "docx" && $fileType != "pdf" ) {
            throw new Exception('Please upload a DOC, DOCX or PDF document');
        }
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $markingGuidePath = $target_file;
        } else {
            throw new Exception('Marking Guide was not uploaded, unknown error occurred');
        }
    }

	function update_database(&$assTitle, &$unitID, &$semester, &$year, &$description, &$isIndividualGroup, &$dueDate, &$markingGuidePath, &$proName) {
		
        try {
            validate_input($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);
            $result = edit_assessment($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);
            $assTitle = $unitID = $semester = $year = $description = $isIndividualGroup = $dueDate = $markingGuidePath = $proName = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }

    function get_details_from_database(&$assTitle, &$unitID, &$semester, &$year, &$description, &$isIndividualGroup, &$dueDate, &$markingGuidePath, &$proName) {
        
        try {
            //Check Assignment Title isn't empty
            if (empty($_POST['ass_Title'])){
                throw new Exception('Assignment Title required');
            } else {
                $assTitle = test_input($_POST["ass_Title"]);
            }
    
            //Check unit ID name
            if (empty($_POST['unit_ID'])) {
               throw new Exception('Unit ID required');
            } else {
                $unitID = test_input($_POST["unit_ID"]);                
            }
    
            $semester = test_input($_POST["teaching_period"]);
            $year = test_input($_POST["year"]);

            //Check Project Name
            if (empty($_POST['proj_name'])) {
               throw new Exception('Project Name required');
            } else {
                $proName = test_input($_POST["proj_name"]);                
            }
            $result = get_assessment_details($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }


?>

