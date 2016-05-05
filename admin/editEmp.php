<!--
    This file is responsible for the view layer of the editStudent page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Employee</title>
</head>

<body>
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $id = $firstName = $lastName = $email = $contact = $e = "";

        function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
        }


        //Check if Find button is pressed
        if (isset($_POST["find"])) {
            if (empty($_POST['emp_username'])){
                $errID = 'Please enter an Username';
            } else {
                $id = test_input($_POST["emp_username"]);

                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN GET_EMPLOYEE_DETAILS(:username, :firstname, :lastname, :email, :contactno); END;';

                $stmt = oci_parse($conn,$sql);

                oci_bind_by_name($stmt, ':username',$id, 32);               //input
                oci_bind_by_name($stmt, ':firstname',$firstName, 32);    //output
                oci_bind_by_name($stmt, ':lastname',$lastName, 32);      //output
                oci_bind_by_name($stmt, ':email',$email, 32);            //output
                oci_bind_by_name($stmt, ':contactno',$contact, 32);      //output

                oci_execute($stmt);

                $e = oci_error($stmt);
                echo htmlentities($e['message']);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

                debug_to_console( "Got Details" );
            }
        }

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {

            debug_to_console( "Submit Pressed" );

            if (empty($_POST['emp_username'])){
                $errID = 'Please enter an Employee username';
            } else {
                $id = test_input($_POST["emp_username"]);
            }
            //VALIDATION
            //Check first name
            if (empty($_POST['emp_FName'])) {
               $errFName = 'Please enter a first name';
            } else {
                $firstName = test_input($_POST["emp_FName"]);                
            }
            //Check last name
            if (empty($_POST['emp_LName'])) {
                $errLName = 'Place enter a last name';
            } else {
                $lastName = test_input($_POST["emp_LName"]);
            }
            //Check email.
            if (empty($_POST['emp_Email'])) {
                $errEmail = 'Please enter an email address';
            } else {
                $email = test_input($_POST["emp_Email"]);
            }
            //Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errEmail = "Invalid email format. Please try again";
                $email = "";
            }
            //Check contact number
            if (empty($_POST['emp_Contact'])) {
                $errContact = 'Please enter a contact number';
            } else {
                $contact = test_input($_POST["emp_Contact"]);
            }
            //Contact no. String must contain numbers
            if (!is_numeric($contact)) {
                $errContact = "Only numeric values can be entered in this field";
                $contact = "";
            }

            if (!$errFName && !$errLName && !$errEmail && !$errContact){

                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';

                        //REMEMBER TO REMOVE CONNECTION LOGIC LATER. KEEP IT IN LOGIN
                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                debug_to_console( "Running SQL" );

                $sql = 'BEGIN UPDATE_EMPLOYEE(:username, :firstname, :lastname, :email, :contactno); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs
                oci_bind_by_name($stmt, ':username',$id, 32);
                oci_bind_by_name($stmt, ':firstname',$firstName, 32);
                oci_bind_by_name($stmt, ':lastname',$lastName, 32);
                oci_bind_by_name($stmt, ':email',$email, 32);
                oci_bind_by_name($stmt, ':contactno',$contact, 32);

                oci_execute($stmt);

                $e = oci_error($stmt);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

                $id = $firstName = $lastName = $email = $contact = $e = "";

                debug_to_console( "SQL Committed" );

            } else {
                $result='<div class="span alert alert-danger fade in"><strong>Oops! </strong>something unexpected happened! Please try registering this Employee later.</div>';

                debug_to_console( "Failed Validation" );
            }
        }           

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <?php
        if (! IsAdmin() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Employee</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <form role="form" method="post">
                        <fieldset>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Enter Employee Username
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <div class="form-group">
                                        <label>Enter Employee Username:</label>
                                        <input class="form-control"
                                        name="emp_username"
                                        placeholder="Employee ID"
                                        value=<?php echo $id ?> >
                                    </div>
        
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find Employee">
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Edit Employee Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                        <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" 
                                    name="emp_FName" 
                                    placeholder="Edit firstname"
                                    value=<?php echo $firstName ?> >
                                </div>
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input class="form-control" 
                                    name="emp_LName" 
                                    placeholder="Edit surname"
                                    value=<?php echo $lastName ?> >
                                </div>  
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input class="form-control" 
                                    name="emp_Email" 
                                    placeholder="Edit email"
                                    value=<?php echo $email ?> >
                                </div>
                                <div class="form-group">
                                    <label>Contact number</label>
                                    <input class="form-control"
                                    name="emp_Contact" 
                                    placeholder="Edit phone number"
                                    value=<?php echo $contact ?> >
                                </div> 
                                <br>
                                <div class="text-center"> 
                                    <a href="admindash.html" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                    <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
                                </div>
    
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php echo $result; ?>  
                                    </div>
                                </div>
                                </div>
                        </fieldset>
                    </form>
                   
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
