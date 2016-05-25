<?php 
    //Includes all relevant files
    //This page is for booking meetings
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contBookMeeting.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Meeting</title>
</head>

<body>
    <?php
        //$proUnitID =  $proID = $proDescription = $proSemester = $proYear = "";

        //Check if submit button is pressed
        /*if (isset($_POST["submit"])) {
            $result = insert_to_database($proUnitID, $proID, $proDescription, $proSemester, $proYear);
        } */
    ?>
    <?php
        //Supervisor Permissions
        if (! IsSupervisor() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Conduct Meeting</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter meeting details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                    <label>*Semester ID</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="Enter Semester ID">

                                   <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Employee ID</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="Enter Employee ID">

                                  <!-- <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?> -->
                                </div>
                                <div class="form-group">
                                  <label for="">*Select Year:</label>
                                  <select class="form-control" id="" 
                                  name="">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="Enter Unit ID">

                                  <!-- <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?> -->
                                </div>
                                <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="Enter Team ID">

                                  <!-- <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?> -->
                                </div>
                                <!--
                                <div class="form-group">
                                    <label>*Meeting Date</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="DD">
                                    <input class="form-control"
                                    name=""
                                    placeholder="MM">

                                  <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?>
                                </div> -->
                                <!--
                                 <div class="form-group">
                                    <label>*Meeting Date</label>
                                    <input class="form-control"
                                    name=""
                                    placeholder="Time">
                                    
                                  <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?>
                                </div> -->        
                                                                                           
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
                                        <p>Unit successfully added!</p>
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
