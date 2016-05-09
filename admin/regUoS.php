<!--
    This file is responsible for the view layer of the regUoS page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegUoS.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Unit Of Study</title>
</head>

<body>
    <?php
        //Initalise variable to null
        $unitID = $unitName = $unitDescription = "";

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = insert_to_database($unitID, $unitName, $unitDescription);
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
                    <h1 class="page-header">Register Unit Of Study</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <!-- Output the result of the transaction (success or failure) -->
                <?php echo $result; ?>  
                    <!-- Panel heading -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Unit Details
                        </div>
                    <!-- Panel body --> 
                    <div class="panel-body">      
                        <!-- Initialise form with POST method -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <!-- Begin register student input form controls -->
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Name</label>
                                    <input class="form-control" 
                                    name="unit_Name" 
                                    placeholder="Enter Unit Name">

                                    <?php echo "<p class='text-danger'>$errName</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    rows="4"
                                    name="unit_Description" 
                                    placeholder="Enter Description">

                                    <?php echo "<p class='text-danger'>$errDescription</p>"; ?>
                                </div>  
                                       
                                <!-- Submit Button --> 
                                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">
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
