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
        $id = $firstName = $lastName = $email = $contact = $e = "";

        //Check if Find button is pressed
        if (isset($_POST["find"])) {
             get_details_from_database($id, $firstName, $lastName, $email, $contact);
        }

        if (isset($_POST["submit"])) {
            $result = update_database($id, $firstName, $lastName, $email, $contact);            
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
                    <h1 class="page-header">Edit Student</h1>
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
                                    Enter Student ID
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <div class="form-group">
                                        <label>Enter Student ID:</label>
                                        <input class="form-control"
                                        name="stu_ID"
                                        placeholder="Student ID"
                                        value=<?php echo $id ?> >
                                    </div>
        
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find   Student">
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Edit Student Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                        <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" 
                                    name="stu_FName" 
                                    placeholder="Edit firstname"
                                    value=<?php echo $firstName ?> >
                                </div>
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input class="form-control" 
                                    name="stu_LName" 
                                    placeholder="Edit surname"
                                    value=<?php echo $lastName ?> >
                                </div>  
                                <div class="form-group">
                                    <label>Email address</label>
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
