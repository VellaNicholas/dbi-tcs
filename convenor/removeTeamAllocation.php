<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRemoveTeamAllocation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Clear Project Allocation</title>
</head>

<body>
    <?php
        //Initialize Variables
        $proName = $teamID = $semester = $year = $unitID  = "";

        //Checks if submit botton is pressed
        if (isset($_POST["submit"])) {
            $result = remove_from_database($proName, $teamID, $semester, $year, $unitID);
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
                    <h1 class="page-header">Clear Project Allocation</h1>
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
                            Enter Team Allocation Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>

                                <div class="form-group">
                                    <label>*Project Name</label>
                                    <input class="form-control"
                                    name="pro_name"
                                    placeholder="Enter Project Name">
                                </div> 

                                <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name="team_ID"
                                    placeholder="Enter Team ID">
                                </div> 

                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">
                                </div>

                                <div class="form-group">
                                    <label for="teaching_period">*Select Semester:</label>
                                    <select class="form-control" id="teaching_period" name="teaching_period">
                                        <option>Semester 1</option>
                                        <option>Semester 2</option>
                                        <option>Summer</option>
                                        <option>Winter</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="year">*Select Year:</label>
                                    <select class="form-control" id="year" name="year">
                                        <option><?php echo date("Y"); ?></option>
                                        <option><?php echo date("Y") + 1; ?></option>
                                        <option><?php echo date("Y") + 2; ?></option>
                                        <option><?php echo date("Y") + 3; ?></option>
                                    </select>
                                </div>
                                                                                           
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

    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
