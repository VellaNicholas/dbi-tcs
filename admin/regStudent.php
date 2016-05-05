<!--
    This file is responsible for the view layer of the regStudent page. It controls user input and output.
-->

<?php
    session_start();
    include '../global/ini.php'; 
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegStudent.php';
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

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = insert_to_database($id, $firstName, $lastName, $email, $contact);            
        }           
    ?>
    <?php
        //Permits only Admins to view the page
        if (! IsAdmin() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>

    <!-- Begin page wrapper -->
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <!-- Page Header -->
                    <h1 class="page-header">Register Student</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <!-- Panel heading -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Student Details
                        </div> 
                    <!-- Panel body -->
                    <div class="panel-body"> 
                        <!-- Initialise form with POST method -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <!-- Begin register student input form controls -->
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
                                <!-- Submit Button --> 
                                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">

                                <!-- Output the result of the transaction (success or failure) -->
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php echo $result; ?>  
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                   </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- include all javascript references -->
    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
