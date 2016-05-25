<!--
    This file is responsible for the view layer of the editAssessment page. It controls user input and output.
-->



<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contEditAssessment.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Assessment</title>
</head>

<body>
    <?php
        //Initialise All Vairables to NULL
        $assTitle = $unitID = $semester = $year = $description = $isIndividualGroup = $dueDate = $markingGuidePath = $proName = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
             $result = get_details_from_database($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($assTitle, $unitID, $semester, $year, $description, $isIndividualGroup, $dueDate, $markingGuidePath, $proName);            
        }           
    ?>

    <?php
    //Permits only Admins to view the page
        if (! IsConvenor() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>

    <!-- Begin Page Wrapper -->
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <!-- Page Header -->
                    <h1 class="page-header">Edit Assessment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <?php echo $result; ?>
                <!-- Initialise form with POST method -->
                    <form role="form" method="post" enctype="multipart/form-data">
                        <fieldset>
                            <!-- Begin students username panel -->
                            <div class="panel panel-default">
                            <!-- students username panel heading -->
                                <div class="panel-heading">
                                    Enter Project Details
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- students username entry input form control -->
                                        <div class="form-group">
                                            <label>*Assessment Title</label>
                                            <input class="form-control"
                                            name="ass_Title"
                                            placeholder="Enter Assessment Title"
                                            value=<?php echo $assTitle?> >
                                        </div>
                                        <div class="form-group">
                                            <label>*Unit ID</label>
                                            <input class="form-control"
                                            name="unit_ID"
                                            placeholder="Enter Unit ID"
                                            value=<?php echo $unitID?> >
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
                                        placeholder="Enter Project Name"
                                        value=<?php echo $proName?> >
                                    </div>
        
                                    <!-- Submit Button -->
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find Project">
                                </div>
                            </div>

                            <!-- Begin Edit details panel -->
                            <div class="panel panel-default">
                            <!-- Edit student details heading -->
                                <div class="panel-heading">
                                    Edit Project Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>

                                    <div class="form-group">
                                        <label>*Description</label>
                                        <input class="form-control" 
                                        name="ass_Description" 
                                        placeholder="Enter Description"
                                        value=<?php echo $description ?> >
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
                                        placeholder="Enter Due Date"
                                        value=<?php echo $dueDate ?> >
                                    </div>

                                    <br>
                                    <a href=<?php echo '"' . substr($markingGuidePath, 13) . '"' ?> class="btn btn-default">View Existing Marking Guide</a>

                                    <br>

                                    <label>*Upload a New Marking Guide:</label>
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                    <br>

                                    <!-- Cancel and submit buttons -->
                                    <div class="text-center"> 
                                        <a href="../global/dash.php" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                        <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
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
    <!-- include all javascript references -->
    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
