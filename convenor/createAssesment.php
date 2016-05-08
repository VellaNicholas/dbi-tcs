<!-- Page creates and inserts the data of Assesments into the database. Only accessible by convenors. -->
<?php
    session_start();
    include '../global/ini.php'; 
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contCreateAssesment.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create an Assesment</title>
</head>

<body>
    <?php
        //Initalise variable to null
        $assesmentID = $title = $description = $isIndividualGroup = $dueDate = $projectID = "";

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = insert_to_database($assesmentID, $title, $description, $isIndividualGroup, $dueDate, $projectID);            
        }           
    ?>
    <?php
    
        //stops the page load for all except admins
        if (! IsAdmin() ) {
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
                    <h1 class="page-header">Create Assesment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                <!-- Panel Heading -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Assesment Details
                        </div> 
                        <!-- Panel Body -->
                    <div class="panel-body">
                        <!-- Initialise form with POST method -->
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                            <!-- Begin create assesment input form controls -->
                                <div class="form-group">
                                    <label>*Assesment ID</label>
                                    <input class="form-control"
                                    name="ass_ID"
                                    placeholder="Enter Assesment ID">


                                    <?php echo "<p class='text-danger'>$errId</p>"; ?>
                            <?php echo "<p class='text-danger'>$errAssId</p>"; ?>

                                </div>
                                <div class="form-group">
                                    <label>*Title</label>
                                    <input class="form-control" 
                                    name="ass_Title" 
                                    placeholder="Enter Title">

                                    <?php echo "<p class='text-danger'>$errTitle</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    name="ass_Description" 
                                    placeholder="Enter Description">

                                    <?php echo "<p class='text-danger'>$errDescription</p>"; ?>
                                </div>  
                                <div class="form-group">
                                    <label>*Individual or Group</label>
                                    <input class="form-control" 

                                    name="ass_Individual"> 
                                    <option>Individual</option>
                                    <option>Group</option>
                                  </select>
                                </div>
                                    <?php echo "<p class='text-danger'>$errIndividual</p>"; ?>
                                </div>

                                <div class="form-group">
                                    <label>*Due Date</label>
                                    <input class="form-control" name="ass_DueDate" placeholder="Enter Due Date">

                                    <?php echo "<p class='text-danger'>$errDueDate</p>"; ?>         
                                </div> 
                                <div class="form-group">
                                    <label>*Project ID</label>
                                    <input class="form-control"
                                    name="ass_ProjectID"
                                    placeholder="Enter Project ID">

                                    <?php echo "<p class='text-danger'>$errProjectID</p>"; ?>
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

                                        <p>Assesment successfully added!</p>
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
