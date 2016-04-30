<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$id, &$firstName, &$lastName, &$email, &$contact) {
    	if (empty($_POST['stu_ID'])){

            $errID = 'Invalid student ID';
        } else {
            $id = test_input($_POST["stu_ID"]);
        }

        //VALIDATION
        if (!is_numeric($id)){
            $x = 'x';
            $xPos = strpos($id, $x);
            if ($xPos != 7){
                $errID = 'Invalid student ID';
            }
        }

        //Check first name
        if (empty($_POST['stu_FName'])) {
           $errFName = 'First name required';
        } else {
            $firstName = test_input($_POST["stu_FName"]);                
        }

        //Check last name
        if (empty($_POST['stu_LName'])) {
            $errLName = 'Surname required';
        } else {
            $lastName = test_input($_POST["stu_LName"]);
        }

        //Check email.
        if (empty($_POST['stu_Email'])) {
            $errEmail = 'Email address required';
        } else {
            $email = test_input($_POST["stu_Email"]);
        }
        
        //Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errEmail = "Invalid email address";
            $email = "";
        }
        
        //Check Contact Number is either null or numeric
        if (is_numeric($_POST['stu_Contact']) || empty($_POST['stu_Contact'])) {
            $contact = test_input($_POST["stu_Contact"]);
        } else {
            $errContact = 'Please enter a valid contact number';
        }
	}

	function insert_to_database(&$id, &$firstName, &$lastName, &$email, &$contact) {
		
		validate_input($id, $firstName, $lastName, $email, $contact);

		if (!$errID && !$errFName && !$errLName && !$errEmail && !$errContact){
                $result = insert_student($id, $firstName, $lastName, $email, $contact);
            }

        return $result;
    }
?>

