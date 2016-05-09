<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Employee</title>
</head>

<body>
    <!-- This needs to go to a separate file -->
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $firstName = $lastName = $userName = $email = $contact = $e = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            
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

            if (empty($_POST['emp_UName'])){
                $errID = 'Please enter a Username';
            } else {
                $userName = test_input($_POST["emp_UName"]);
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

            if (is_numeric($_POST['emp_Contact']) || empty($_POST['emp_Contact'])) {
                $contact = test_input($_POST["emp_Contact"]);
            } else {
                $errContact = 'Please enter a valid contact number';
            }

            if (!$errID && !$errFName && !$errLName && !$errEmail && !$errContact){

                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';

                        //REMEMBER TO REMOVE CONNECTION LOGIC LATER. KEEP IT IN LOGIN
                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN INSERT_EMPLOYEE(:username, :firstname, :lastname, :email, :contactno); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs
                oci_bind_by_name($stmt, ':username',$userName);
                oci_bind_by_name($stmt, ':firstname',$firstName);
                oci_bind_by_name($stmt, ':lastname',$lastName);
                oci_bind_by_name($stmt, ':email',$email);
                oci_bind_by_name($stmt, ':contactno',$contact);

                oci_execute($stmt);

                $e = oci_error($stmt);
                echo htmlentities($e['message']);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

            } else {
                $result='<div class="span alert alert-danger fade in"><strong>Oops! </strong>something unexpected happened! Please try registering this Employee later.</div>';
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
                    <h1 class="page-header">Register Employee</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Employee Details
                        </div> 
                    <div class="panel-body">            
                        <form id="empForm" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" data-parsley-validate="">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>

                                <div class="form-group">
                                    <label>*Username</label>
                                    <input class="form-control"
                                    name="emp_UName"
                                    placeholder="Enter Username"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*First Name</label>
                                    <input class="form-control" 
                                    name="emp_FName" 
                                    placeholder="Enter firstname"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errFName</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Surname</label>
                                    <input class="form-control" 
                                    name="emp_LName" 
                                    placeholder="Enter surname"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errLName</p>"; ?>
                                </div>  
                                <div class="form-group">
                                    <label>*Email address</label>
                                    <input class="form-control" 
                                    name="emp_Email"
                                    type="email" 
                                    placeholder="Enter email"
                                    data-parsley-trigger="change"
                                    data-parsley-type="email"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errEmail</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>Contact number</label>
                                    <input class="form-control" name="emp_Contact" placeholder="Enter phone number"
                                    data-parsley-type="number">

                                    <?php echo "<p class='text-danger'>$errContact</p>"; ?>                                    
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" name="emp_IsAdmin" placeholder="Enter phone number"
                                    data-parsley-type="number">

                                    <?php echo "<p class='text-danger'>$errContact</p>"; ?>                                    
                                </div>                                                           
                                <div class="text-center">
                                    <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php echo $result; ?>  
                                    </div>
                                </div> 

                                <div class="text-right">
                                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#csvUpload">Import .csv</button>-->
                                    <br><a data-toggle="modal" data-Target="#csvUpload"><i class="fa fa-upload"></i> Import CSV</a>
                                </div>

                            </fieldset>
                        </form>

                        <!-- CSV MODAL -->
                        <div id="csvUpload" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Import CSV</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Please select a CSV file from your local machine to import</p>
                                        <br>
                                        <label class="control-label">Select CSV File</label>
                                        <input id="csvInput" type="file" class="file" accept=".csv">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
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
