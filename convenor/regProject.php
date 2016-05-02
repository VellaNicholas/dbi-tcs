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
        $proUnitID = $proTeamID = $proID = $proDescription = $proSemester = $proYear = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            $result = insert_to_database($proUnitID, $proTeamID, $proID, $proDescription, $proSemester, $proYear);
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
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Project Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                 <!-- Div for Semester -->
                                  <label for="pro_Semester">*Select Semester:</label>
                                  <select class="form-control" id="proSemester" name="proSemester">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                    <option>Summer</option>
                                    <option>Winter</option>
                                  </select>
                                </div>

                                <!-- Div for Year -->
                               <div class="form-group">
                                  <label for="pro_Year">*Select Year:</label>
                                  <select class="form-control" id="proYear
                                  " name="proYear">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
                                </div>
                                         
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="proUnitID"
                                    placeholder="Enter Unit ID">

                                   <?php echo "<p class='text-danger'>$errProUnitID</p>"; ?>
                                </div>

                                <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name="proTeamID"
                                    placeholder="Enter Team ID">

                                   <?php echo "<p class='text-danger'>$errProTeamID</p>"; ?>
                                </div> 

                                <div class="form-group">
                                    <label>*Project ID</label>
                                    <input class="form-control"
                                    name="proID"
                                    placeholder="Enter Project ID">

                                   <?php echo "<p class='text-danger'>$errProID</p>"; ?>
                                </div> 


                                <div class="form-group">
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    rows="4"
                                    name="proDescription" 
                                    placeholder="Enter Description">

                                    <?php echo "<p class='text-danger'>$errProDescription</p>"; ?>
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
