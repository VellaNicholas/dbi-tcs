<?php
    session_start();
    include '../global/ini.php'; 
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegAssessment.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create an Assessment</title>
</head>

<body>
    <?php
        //Initalise variable to null
        $assTitle = $unitID = $semester = $year = $description = $isIndividualGroup = $dueDate = $markingGuidePath = $proName = "";

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = insert_to_database($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);
        }           
    ?>
    <?php
    
        //stops the page load for all except admins
        if (! IsConvenor() ) {
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
                    <h1 class="page-header">Create Assessment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <?php echo $result; ?>
                <!-- Panel Heading -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Assessment Details
                        </div> 
                        <!-- Panel Body -->
                    <div class="panel-body">
                        <!-- Initialise form with POST method -->
                        <form role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                            <!-- Begin create assessment input form controls -->
                                <div class="form-group">
                                    <label>*Assessment Title</label>
                                    <input class="form-control"
                                    name="ass_Title"
                                    placeholder="Enter Assessment Title">
                                </div>
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">
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
                                <div class="form-group">
                                    <label>*Project Name</label>
                                    <input class="form-control"
                                    name="proj_name"
                                    placeholder="Enter Project Name">
                                </div>

                                <div class="form-group">
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    name="ass_Description" 
                                    placeholder="Enter Description">
                                </div>
                                <div class="form-group">
                                    <label for="ass_Individual">*Individual or Group</label>
                                    <select class="form-control" id = ass_Indiviual name="ass_Individual">
                                        <option>Individual</option>
                                        <option>Group</option>
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label>*Due Date</label>
                                    <input class="form-control"
                                    name="due_Date"
                                    placeholder="Enter Due Date">
                                </div>

                                <label>*Upload a Marking Guide:</label>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <br>

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
