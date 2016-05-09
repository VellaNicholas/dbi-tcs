<!--
    This file is responsible for the view layer of the editStudent page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contEditStudent.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Student</title>
</head>

<body>
    <?php
        //Initialise All Vairables to NULL
        $proUnitID = $proID = $proDescription = $proSemester = $proYear = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
             get_details_from_database($proUnitID, $proID, $proDescription, $proSemester, $proYear);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($proUnitID, $proID, $proDescription, $proSemester, $proYear);            
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
                    <h1 class="page-header">Edit Project</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <!-- Initialise form with POST method -->
                    <form role="form" method="post">
                        <fieldset>
                            <!-- Begin students username panel -->
                            <div class="panel panel-default">
                            <!-- students username panel heading -->
                                <div class="panel-heading">
                                    Enter Project and Unit ID
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- students username entry input form control -->
                                        <div class="form-group">
                                        <label>Enter Project ID:</label>
                                        <input class="form-control"
                                        name="proID"
                                        placeholder="Project ID"
                                        value=<?php echo $proID ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>Enter Unit ID:</label>
                                        <input class="form-control"
                                        name="proUnitID"
                                        placeholder="Unit ID"
                                        value=<?php echo $proUnitID ?> >
                                    </div>
                                    
        
                                    <!-- Submit Button -->
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find   Project">
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
                                    <!-- Begin edit student input form controls -->
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
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    rows="4"
                                    name="proDescription" 
                                    placeholder="Enter Description">

                                    <?php echo "<p class='text-danger'>$errProDescription</p>"; ?>
                                </div>
                                    <br>
                                    <!-- Cancel and submit buttons -->
                                    <div class="text-center"> 
                                        <a href="../global/dash.php" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                        <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
                                    </div>
                                    <!-- Output the result of the transaction (success or failure) -->
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-2">
                                            <?php echo $result; ?>  
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
