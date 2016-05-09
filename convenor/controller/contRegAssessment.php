<!-- Controller file is called by Create Assessment file, checks that fields are not empty and calls DataAccess file to commit to database. -->

<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$ass_ID, &$ass_Title, &$ass_Description, &$ass_Individual, &$ass_DueDate, &$ass_ProjectID) {
    	    
            //Check ID
            if (empty($_POST['ass_ID'])) {
               $errID = 'Please enter an Assignment ID';
            } else {
                $ass_ID = test_input($_POST["ass_ID"]);                
            }
            
            //Check assessment title
            if (empty($_POST['ass_Title'])) {
                $errTitle = 'Place enter an Assignment Title';
            } else {
                $ass_Title = test_input($_POST["ass_Title"]);
            }
            
            //Check assessment description
            if (empty($_POST['ass_Description'])){
                $errDescription = 'Please enter a Project ID';
            } else {
                $ass_Description = test_input($_POST["ass_Description"]);
            }
            
            //Check whether assessment is individual or group
            if (empty($_POST['ass_Individual'])){
                $errIndividual = 'Is this an Individual or Group Assignment?';
            } else {
                $ass_Individual = test_input($_POST["ass_Individual"]);
            }

            //Check assessment due date
            if (empty($_POST['ass_DueDate'])){
                $errDueDate = 'Please enter a Due Date';
            } else {
                $ass_DueDate = test_input($_POST["ass_DueDate"]);
            }

            //Check assessment project ID
            if (empty($_POST['ass_ProjectID'])){
                $errProjectID = 'Please enter a Project ID';
            } else {
                $ass_ProjectID = test_input($_POST["ass_ProjectID"]);
            }
	}

    //Function inserts the data, into the database, validates the input and checks there are no errors. 
	function insert_to_database(&$ass_ID, &$ass_Title, &$ass_Description, &$ass_Individual, &$ass_DueDate, &$ass_ProjectID) {
		
		validate_input($ass_ID, $ass_Title, $ass_Description, $ass_Individual, $ass_DueDate, $ass_ProjectID);
        //The ones below here are the errors don't forget to change them cunt

		if (!$errID && !$errTitle && !$errDescription && !$errIndividual && !$errDueDate && !$errProjectID){

            $result = insert_assignment($ass_ID, $ass_Title, $ass_Description, $ass_Individual, $ass_DueDate, $ass_ProjectID);

        }

        return $result;
    }
?>

