<!--
    This file is responsible for the controller layer of the editStudent page. It contains business logic and validation.
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
    function validate_input(&$id, &$firstName, &$lastName, &$email, &$contact) {

        //Check Student ID isn't empty
        if (empty($_POST['stu_ID'])){
            throw new Exception('Student ID required');
        } else {
            $id = test_input($_POST["stu_ID"]);
        }

        //Check Student ID matches business rules
        if (!is_numeric($id)){
            $xPos = strpos($id, 'x');
            if ($xPos != 7){
                throw new Exception('Invalid student ID');
            }
        }

        //Check first name
        if (empty($_POST['stu_FName'])) {
           throw new Exception('First name required');
        } else {
            $firstName = test_input($_POST["stu_FName"]);                
        }

        //Check last name
        if (empty($_POST['stu_LName'])) {
            throw new Exception('Surname required');
        } else {
            $lastName = test_input($_POST["stu_LName"]);
        }

        //Check email isn't empty
        if (empty($_POST['stu_Email'])) {
            throw new Exception('Email address required');
        } else {
            $email = test_input($_POST["stu_Email"]);
        }
        
        //Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email address');
        }
        
        //Check Contact Number is either null or numeric
        if (is_numeric($_POST['stu_Contact']) || empty($_POST['stu_Contact'])) {
            $contact = test_input($_POST["stu_Contact"]);
        } else {
            throw new Exception('Please enter a valid contact number');
        }
	}

    //Validates the input, then if there are no errors in validation connects to the database and updates the student.
	function update_database(&$id, &$firstName, &$lastName, &$email, &$contact) {

        try {
            validate_input($id, $firstName, $lastName, $email, $contact);
            $result = edit_student($id, $firstName, $lastName, $email, $contact);
            $id = $unitName = $unitDescription = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }


        return $result;
    }

    //Checkes the Student ID isn't empty, then connects to the database and retrieves the details of the given student
    function get_details_from_database(&$id, &$firstName, &$lastName, &$email, &$contact) {
        
        if (empty($_POST['stu_ID'])){ 
            $result = '<div class="span alert alert-danger fade in">Please enter a Student ID</div>';
        } else {
            $id = test_input($_POST["stu_ID"]);
            $result = get_student_details($id, $firstName, $lastName, $email, $contact);
        }

        return $result;
    }
?>

