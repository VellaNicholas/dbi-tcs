<!--
    This file is responsible for the view layer of the regUnitOffering page. It controls user input and output.
-->

<?php 
    session_start();
    //Includes the required files for the page
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegUnitOffering.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Unit Of Study Offering</title>
    <
</head>

<body>
    <?php
        //Initialize Variables
        $unitID = $unitSemester = $unitYear = $unitConvenor = "";

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = insert_to_database($unitID, $unitSemester, $unitYear, $unitConvenor);            
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
                    <h1 class="page-header">Register Unit Of Study Offering</h1>
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
                            Enter Unit Offering Details
                        </div> 
                    <!-- Panel body -->
                    <div class="panel-body">
                        <!-- Initialise form with POST method -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <!-- Begin register unit offering input form controls -->
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Convenor Username</label>
                                    <input class="form-control"
                                    name="unit_Convenor"
                                    placeholder="Enter Unit Convenor">

                                    <?php echo "<p class='text-danger'>$errConvenor</p>"; ?>
                                </div>
                                <div class="form-group">
                                  <label for="unit_Semester">Select Semester:</label>
                                  <select class="form-control" id="unit_Semester" name="unit_Semester">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                    <option>Summer</option>
                                    <option>Winter</option>
                                  </select>
                                </div>
                                
                                <div class="form-group">
                                  <label for="unit_Year">Select Year:</label>
                                  <select class="form-control" id="unit_Year
                                  " name="unit_Year">
                                    <!--TODO: Dynamically Generate:-->
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
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
