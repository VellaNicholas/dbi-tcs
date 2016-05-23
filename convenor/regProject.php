<?php 
    //Includes all relevant files
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegProject.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Project</title>
</head>

<body>
    <?php
        $proUnitID =  $proName = $teachingPeriod = $year = $descriptionPath = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            $result = insert_to_database($proUnitID,  $proName, $teachingPeriod, $year, $descriptionPath);
        }
    ?>
    <?php
        if (! IsConvenor() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Project</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <?php echo $result; ?> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Project Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                    <label>*Project Name</label>
                                    <input class="form-control"
                                    name="pro_name"
                                    placeholder="Enter Project Name">

                                   <?php echo "<p class='text-danger'>$errProID</p>"; ?>
                                </div> 
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">

                                   <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?>
                                </div>

                                
                                <div class="form-group">
                                 <!-- Div for Semester -->
                                  <label for="teaching_period">*Select Semester:</label>
                                  <select class="form-control" id="teaching_period" name="teaching_period">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                    <option>Summer</option>
                                    <option>Winter</option>
                                  </select>
                                </div>

                                <!-- Div for Year -->
                               <div class="form-group">
                                  <label for="year">*Select Year:</label>
                                  <select class="form-control" id="year" name="year">
                                    <option><?php echo date("Y"); ?></option>
                                    <option><?php echo date("Y") + 1; ?></option>
                                    <option><?php echo date("Y") + 2; ?></option>
                                    <option><?php echo date("Y") + 3; ?></option>
                                  </select>
                                </div>
                
                                <label>*Upload a Project Description:</label>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <br>
                                                                                           
                                <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">
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
