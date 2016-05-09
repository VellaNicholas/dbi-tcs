<!--
    This file is responsible for the view layer of the editStudent page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contEditUoS.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Unit of Study</title>
</head>

<body>
    <?php
        //Initialise All Vairables to NULL
        $id = $unitName = $unitDescription = $e = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
             $result = get_details_from_database($id, $unitName, $unitDescription);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($id, $unitName, $unitDescription);            
        }     
    ?>

    <?php
    //Permits only Admins to view the page
        if (! IsAdmin() ) {
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
                    <h1 class="page-header">Edit Unit of Study</h1>
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
                            <!-- Begin Unit Of Study ID panel -->
                            <div class="panel panel-default">
                                <!-- Unit Of Study ID panel heading -->
                                <div class="panel-heading">
                                    Enter Unit of Study ID
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- Unit of Study ID entry input form control -->
                                    <div class="form-group"> 
                                        <label>Enter Unit of Study:</label> <!-- CHANGE THIS -->
                                        <input class="form-control"
                                        name="unit_ID"   
                                        placeholder="Unit of Study ID"
                                        value=<?php echo $id ?> >
                                    </div>
        
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find Unit of Study">
                                </div>
                            </div>

                            <!-- Begin Edit details panel -->
                            <div class="panel panel-default">
                            <!-- Edit student details heading -->
                                <div class="panel-heading">
                                    Edit Unit of Study Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                        <!-- Begin edit unit of study input form controls -->
                                    <div class="form-group">
                                        <label>Unit Name</label>
                                        <input class="form-control" 
                                        name="unit_Name" 
                                        placeholder="Edit Unit Name"
                                        value=<?php echo $unitName ?> >
                                    </div>
                                    <div class="form-group">
                                        <label>Unit Description</label>
                                        <input class="form-control" 
                                        name="unit_Description" 
                                        placeholder="Edit Unit Description"
                                        value=<?php echo $unitDescription ?> >
                                    </div>  
                                    <br>
                                    <!-- Cancel and submit buttons -->
                                    <div class="text-center"> 
                                        <a href="../global/dash.php" class="btn btn-md btn-warning" type="cancel"> Cancel</a>
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
