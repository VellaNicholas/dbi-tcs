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

        //This block connects to the database and puts the unit of study details into the database when the button is pressed
        if (isset($_POST["submit"])) {
            $result = insert_to_database($unitID, $unitSemester, $unitYear, $unitConvenor);            
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
                    <h1 class="page-header">Register Unit Of Study Offering</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Unit Offering Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
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
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
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
                                        <p>Unit successfully offered!</p>
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
