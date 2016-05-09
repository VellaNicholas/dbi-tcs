<!--
    This file is responsible for the view layer of the editStudent page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contEditStudent.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Student</title>
</head>

<body>
    <?php
        //Initialise All Vairables to NULL
        $id = $firstName = $lastName = $email = $contact = $e = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
            $result = get_details_from_database($id, $firstName, $lastName, $email, $contact);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($id, $firstName, $lastName, $email, $contact);            
        }           
    ?>

    <?php
    //Permits only Admins to view the page
        if (! IsAdmin() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>

    <!-- Begin Page Wrapper -->
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <!-- Page Header -->
                    <h1 class="page-header">Edit Student</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <!-- Output the result of the transaction (success or failure) -->
                <?php echo $result; ?>  
                <!-- Initialise form with POST method -->
                    <form role="form" method="post">
                        <fieldset>
                            <!-- Begin students username panel -->
                            <div class="panel panel-default">
                            <!-- students username panel heading -->
                                <div class="panel-heading">
                                    Enter Student ID
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- students username entry input form control -->
                                    <div class="form-group">
                                        <label>Enter Student ID:</label>
                                        <input class="form-control"
                                        name="stu_ID"
                                        placeholder="Student ID"
                                        value=<?php echo $id ?> >
                                    </div>
        
                                    <!-- Submit Button -->
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find   Student">
                                </div>
                            </div>
                            <!-- Begin Edit details panel -->
                            <div class="panel panel-default">
                            <!-- Edit student details heading -->
                                <div class="panel-heading">
                                    Edit Student Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- Begin edit student input form controls -->
                                    <div class="form-group">
                                        <label>*First Name</label>
                                        <input class="form-control" 
                                        name="stu_FName" 
                                        placeholder="Edit firstname"
                                        value=<?php echo $firstName ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>*Surname</label>
                                        <input class="form-control" 
                                        name="stu_LName" 
                                        placeholder="Edit surname"
                                        value=<?php echo $lastName ?> >
                                    </div>  
                                    <div class="form-group">
                                        <label>*Email address</label>
                                        <input class="form-control" 
                                        name="stu_Email" 
                                        placeholder="Edit email"
                                        value=<?php echo $email ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>Contact number</label>
                                        <input class="form-control"
                                        name="stu_Contact" 
                                        placeholder="Edit phone number"
                                        value=<?php echo $contact ?> >
                                    </div> 
                                    <br>
                                    <!-- Cancel and submit buttons -->
                                    <div class="text-center"> 
                                        <a href="../global/dash.php" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                        <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
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
    <!-- include all javascript references -->
    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
