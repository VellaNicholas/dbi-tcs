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

        //This block connects to the database and inputs the student details to the database
        if (isset($_POST["submit"])) {
            $result = insert_to_database($id, $firstName, $lastName, $email, $contact);            
        }           
    ?>
    <?php
    
        //stops the page load for all except admins
        if (! IsAdmin() ) {
            include '../global/noPermissions';
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
