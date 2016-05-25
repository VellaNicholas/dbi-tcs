<?php
//include '../dataAccess.php';
//function validate_input(&$username, &$firstName, &$lastName, &$email, &$contact){
    //Check Student ID isn't empty
	$row = test_input($_POST["row"]);

 	if (empty($_POST['username'])){
        throw new Exception('Username required');
    } else {
        $username = test_input($_POST["username"]);
    }
    
    //Check first name
    if (empty($_POST['firstName'])) {
       throw new Exception('First name required');
    } else {
        $firstName = test_input($_POST["firstName"]);
    }                
    
    //Check last name
    if (empty($_POST['lastName'])) {
        throw new Exception('Surname required');
    } else {
        $lastName = test_input($_POST["lastName"]);
    }
    
    //Check email isn't empty
    if (empty($_POST['email'])) {
        throw new Exception('Email address required');
    } else {
        $email = test_input($_POST["email"]);
    }
    
    //Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address');
    }
    
    //Check Contact Number is either null or numeric
    if (is_numeric($_POST['contact']) || empty($_POST['contact'])) {
        $contact = test_input($_POST["contact"]);
    } else {
        throw new Exception('Please enter a valid contact number');
    }

    function insert_employee(&$userName, &$firstName, &$lastName, &$email, &$contact) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN INSERT_EMPLOYEE(:username, :firstname, :lastname, :email, :contactno); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':username',$userName, 32);
        oci_bind_by_name($stmt, ':firstname',$firstName, 32);
        oci_bind_by_name($stmt, ':lastname',$lastName, 32);
        oci_bind_by_name($stmt, ':email',$email, 32);
        oci_bind_by_name($stmt, ':contactno',$contact, 32);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Employee - Employee with username ' . $userName .  ' already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Employee - Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Employee - Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;

    }

    $result = insert_employee($username, $firstName, $lastName, $email, $contact);

    if (strpos($result, 'already exists') !== false) {
    	echo $row;
    }


    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
//}
?>