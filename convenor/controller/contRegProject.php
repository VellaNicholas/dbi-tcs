<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$proUnitID,  &$proName, &$teachingPeriod, &$year, &$descriptionPath) {

        //Check Student ID isn't empty
        if (empty($_POST['pro_name'])){
            throw new Exception('Project Name required');
        } else {
            $proName = test_input($_POST["pro_name"]);
        }

        //Check first name
        if (empty($_POST['unit_ID'])) {
           throw new Exception('Unit ID required');
        } else {
            $proUnitID = test_input($_POST["unit_ID"]);                
        }

        $teachingPeriod = test_input($_POST["teaching_period"]);
        $year = test_input($_POST["year"]);


        //file upload
        $target_dir = "/var/www/html/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
    
        // Check if file already exists
        if (file_exists($target_file)) {
            throw new Exception('File with this name already exists');
        }
    
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

    //Validates the input, then if there are no errors in validation connects to the database and inserts the student.
    function insert_to_database(&$proUnitID,  &$proName, &$teachingPeriod, &$year, &$descriptionPath) {
        
        try {
            validate_input($proUnitID,  $proName, $teachingPeriod, $year, $descriptionPath);
            $result = insert_project($proUnitID,  $proName, $teachingPeriod, $year, $descriptionPath);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }
?>

