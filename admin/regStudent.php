<?php
    session_start();
    include '../global/ini.php'; 
    include '../global/navigation.php';
    include 'dataAccess.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Student</title>
</head>

<body>
    <?php

        //Initalise variable to null
        $id = $firstName = $lastName = $email = $contact = $e = "";

        //This block connects to the database and inputs the student details to the database
        if (isset($_POST["submit"])) {
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
            //Check contact number
            if (empty($_POST['stu_Contact'])) {
                $errContact = 'Contact number required';
            } else {
                $contact = test_input($_POST["stu_Contact"]);
            }
            //Contact no. String must contain numbers
            if (!is_numeric($contact)) {
                $errContact = "Invalid contact number";
                $contact = "";
            }

            //If there are no errors, submit to the database, otherwise an exception is displayed to the user
            if (!$errID && !$errFName && !$errLName && !$errEmail && !$errContact){

 /*               $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN INSERT_STUDENT(:stuid, :firstname, :lastname, :email, :contactno); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs
                oci_bind_by_name($stmt, ':stuid',$id,32);               //input
                oci_bind_by_name($stmt, ':firstname',$firstName,32);    //input
                oci_bind_by_name($stmt, ':lastname',$lastName,32);      //input
                oci_bind_by_name($stmt, ':email',$email,32);            //input
                oci_bind_by_name($stmt, ':contactno',$contact,32);      //input

                oci_execute($stmt);

                $e = oci_error($stmt);

                if ($e != "") {
                    $result = parse_exception($e);
                }
                
                oci_commit($conn); */

                $result = insert_student($id, $firstName, $lastName, $email, $contact);

            }
        }           

        //Prevents scripting and SQL injection
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <?php
    
        //stops the page load for all except admins
        if (! IsAdmin() ) {
            include '../global/noPermissions/global/permissions.php';
            exit;
        };
    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Student</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Student Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                    <label>*Student ID</label>
                                    <input class="form-control"
                                    name="stu_ID"
                                    placeholder="Enter student ID">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*First Name</label>
                                    <input class="form-control" 
                                    name="stu_FName" 
                                    placeholder="Enter firstname">

                                    <?php echo "<p class='text-danger'>$errFName</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Surname</label>
                                    <input class="form-control" 
                                    name="stu_LName" 
                                    placeholder="Enter surname">

                                    <?php echo "<p class='text-danger'>$errLName</p>"; ?>
                                </div>  
                                <div class="form-group">
                                    <label>*Email address</label>
                                    <input class="form-control" 
                                    name="stu_Email" 
                                    placeholder="Enter email">

                                    <?php echo "<p class='text-danger'>$errEmail</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>Contact number</label>
                                    <input class="form-control" name="stu_Contact" placeholder="Enter phone number">

                                    <?php echo "<p class='text-danger'>$errContact</p>"; ?>                                    
                                </div>                                                                 
                                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">

                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php echo $result; ?>  
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- MODALS -->
                        <div id="successModal" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Success!</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Student successfully added!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success btn-block" data-dismiss="modal">Return to Dashboard
                                        </button>
                                    </div>
                                </div>    
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
