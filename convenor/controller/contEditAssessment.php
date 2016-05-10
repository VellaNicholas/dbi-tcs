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
    function validate_input(&$assessmentID, &$title, &$description, &$isIndividualGroup, &$dueDate, &$projectID) {
        
        //Check unit ID isn't empty
        if (empty($_POST['ass_ID'])) {
           throw new Exception('Please enter an Assessment ID');
        } else {
            $assessmentID = test_input($_POST["ass_ID"]);                
        }
        //Check unit name
        if (empty($_POST['ass_Title'])) {
            throw new Exception('Please enter an Assessment Title');
        } else {
            $title = test_input($_POST["ass_Title"]);
        }

        //Check unit description
        if (empty($_POST['ass_Description'])){
            throw new Exception('Please enter a Description');
        } else {
            $description = test_input($_POST["ass_Description"]);
        }

        //Check unit ID isn't empty
        if (empty($_POST['ass_Individual'])) {
           throw new Exception('Please enter whether it is an Individual or Group Assessment');
        } else {
            $assessmentID = test_input($_POST["ass_Individual"]);                
        }

        //Check unit ID isn't empty
        if (empty($_POST['ass_dueDate'])) {
           throw new Exception('Please enter a Due Date');
        } else {
            $assessmentID = test_input($_POST["ass_dueDate"]);                
        }

        //Check unit ID isn't empty
        if (empty($_POST['ass_projectID'])) {
           throw new Exception('Please enter a Project ID');
        } else {
            $assessmentID = test_input($_POST["ass_projectID"]);                
        }
    }

    //Validates the input, then if there are no errors in validation connects to the database and updates the unit.
    function update_database(&$assessmentID, &$title, &$description, &$isIndividualGroup, &$dueDate, &$projectID) {
        
        try {
            validate_input($assessmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);
            $result = edit_assessment($assessmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);
            $assessmentID = $title = $description = $isIndividualGroup = $dueDate = $projectID = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }

    //Checkes the Unit ID isn't empty, then connects to the database and retrieves the details of the given unit
    function get_details_from_database(&$assessmentID, &$title, &$description, &$isIndividualGroup, &$dueDate, &$projectID) {
        
        if (empty($_POST['ass_ID'])){ 
            $result = '<div class="span alert alert-danger fade in">Please enter a Unit ID</div>';
        } else {
            $assessmentID = test_input($_POST["ass_ID"]);
            $result = get_unit_details($assessmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);
        }

        return $result;
    }
?>