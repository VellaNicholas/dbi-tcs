<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegProject.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Team Allocation</title>
    <
</head>

<body>
    <?php
        //Initialize Variables
        $teamAlloSemester = $teamAlloYear = $teamAlloUnitID = $teamAlloTeamID = $teamAlloProID = $teamAlloEmpID = "";

        //Checks if submit botton is pressed
        if (isset($_POST["submit"])) {
            
            //if there are no errors, submit to the DB otherwise the exception is displayed to the user
        }           
        
    ?>
    <?php

        //stops the page load for all except admins
        if (! IsConvenor() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Team Allocation</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Team Allocation Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                 <div class="form-group">
                                  <label for="teamAlloSemester">*Select Semester:</label>
                                  <select class="form-control" id="teamAlloSemester" name="teamAlloSemester">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                    <option>Summer</option>
                                    <option>Winter</option>
                                  </select>
                                </div>
                                
                                <div class="form-group">
                                  <label for="teamAlloYear">*Select Year:</label>
                                  <select class="form-control" id="teamAlloYear
                                  " name="teamAlloYear">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
                                </div>

                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="teamAlloUnitID"
                                    placeholder="Enter Unit ID">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div>

                                <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name="teamAlloTeamID"
                                    placeholder="Enter Team ID">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div> 

                                <div class="form-group">
                                    <label>*Project ID</label>
                                    <input class="form-control"
                                    name="teamAlloProID"
                                    placeholder="Enter Project ID">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div> 

                                 <div class="form-group">
                                    <label>*Employee ID</label>
                                    <input class="form-control"
                                    name="teamAlloEmpID"
                                    placeholder="Enter Employee Username">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
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
                                        <p>Team Allocation successfully added!</p>
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
