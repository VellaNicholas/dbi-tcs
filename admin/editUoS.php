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
        $id = $unitName = $unitDescription = $e = "";

        //Check if Find button is pressed
        if (isset($_POST["find"])) {
             get_details_from_database($id, $unitName, $unitDescription);
        }

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            $result = update_database($id, $unitName, $unitDescription);            
        }     
    ?>

    <?php
        if (! IsAdmin() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Unit of Study</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <form role="form" method="post">
                        <fieldset>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Enter Unit of Study ID
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
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

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Edit Unit of Study Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                        <div class="form-group">
                                            <label>Unit Name</label>
                                                <!-- CHANGE THIS -->
                                            <input class="form-control" 
                                            name="unit_Name" 
                                            placeholder="Edit Unit Name"
                                            value=<?php echo $unitName ?> >
                                        </div>
                                <div class="form-group">
                                    <label>Unit Description</label>
                                    <!-- CHANGE THIS -->
                                    <input class="form-control" 
                                    name="unit_Description" 
                                    placeholder="Edit Unit Description"
                                    value=<?php echo $unitDescription ?> >
                                </div>  
                                <br>
                                <div class="text-center"> 
                                    <a href="admindash.html" class="btn btn-md btn-warning" type="cancel">Cancel</a>
                                    <input class="btn btn-md btn-success" type="submit" value="Submit" name="submit">
                                </div>
    
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
    <?php include '../global/jqueryref.php'; ?>
</body>

</html>
