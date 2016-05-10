<!--
    This file is responsible for the view layer of the editStudent page. It controls user input and output.
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
    <title>Edit assessment</title>
</head>

<body>
    <?php
        //Initialise All Vairables to NULL
        $assessmentID = $title = $description = $isIndividualGroup = $dueDate = $projectID = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
            $result = get_details_from_database($assessmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($assessmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);            
        }           
    ?>

    <?php
    //Permits only convenors to view the page
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
                <!-- Output the result of the transaction (success or failure) -->
                <?php echo $result; ?>  
                <!-- Initialise form with POST method -->
                    <form role="form" method="post">
                        <fieldset>
                            <!-- Begin assessment ID panel -->
                            <div class="panel panel-default">
                            <!-- assessment ID panel heading -->
                                <div class="panel-heading">
                                    Enter Assessment ID
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- assement ID entry input form control -->
                                    <div class="form-group">
                                        <label>Enter Assessment ID:</label>
                                        <input class="form-control"
                                        name="ass_ID"
                                        placeholder="Enter assessment ID"
                                        value=<?php echo $assessmentID ?> >
                                    </div>
        
                                    <!-- Submit Button -->
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find assessment">
                                </div>
                            </div>
                            <!-- Begin Edit details panel -->
                            <div class="panel panel-default">
                            <!-- Edit assessment details heading -->
                                <div class="panel-heading">
                                    Edit Assessment Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- Begin edit assessment input form controls -->
                                    <div class="form-group">
                                        <label>* Title</label>
                                        <input class="form-control" 
                                        name="ass_Title" 
                                        placeholder="Title"
                                        value=<?php echo $title ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>*Description</label>
                                        <input class="form-control" 
                                        name="ass_Description" 
                                        placeholder="Description"
                                        value=<?php echo $description ?> >
                                    </div>  
                                    <div class="form-group">
                                        <label>*isIndividualGroup address</label>
                                        <input class="form-control" 
                                        name="ass_Individual" 
                                        placeholder="Edit Individual or Group"
                                        value=<?php echo $isIndividualGroup ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>Due Date</label>
                                        <input class="form-control"
                                        name="ass_dueDate" 
                                        placeholder="Edit Due Date"
                                        value=<?php echo $dueDate ?> >
                                    </div> 
                                    <br>
                                    <!-- Cancel and submit buttons -->
                                    <div class="text-center"> 
                                        <a href="../global/dash.php" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                        <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
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
