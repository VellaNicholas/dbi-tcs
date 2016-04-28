<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Unit Of Study</title>
</head>

<body>
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $unitID = $unitName = $unitDescription = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            
            //Check ID
            if (empty($_POST['unit_ID'])) {
               $errID = 'Please enter a Unit ID';
            } else {
                $unitID = test_input($_POST["unit_ID"]);                
            }
            //Check last name
            if (empty($_POST['unit_Name'])) {
                $errName = 'Place enter a Unit Name';
            } else {
                $unitName = test_input($_POST["unit_Name"]);
            }

            if (empty($_POST['unit_Description'])){
                $errDescription = 'Please enter a Description';
            } else {
                $unitDescription = test_input($_POST["unit_Description"]);
            }

            if (!$errID && !$errName && !$errDescription){

                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';

                        //REMEMBER TO REMOVE CONNECTION LOGIC LATER. KEEP IT IN LOGIN
                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN INSERT_UNIT(:unitid, :name, :description); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs
                oci_bind_by_name($stmt, ':unitid', $unitID);
                oci_bind_by_name($stmt, ':name', $unitName);
                oci_bind_by_name($stmt, ':description', $unitDescription);

                oci_execute($stmt);

                $e = oci_error($stmt);
                echo htmlentities($e['message']);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

            } else {
                $result='<div class="span alert alert-danger fade in"><strong>Oops! </strong>something unexpected happened! Please try registering this Employee later.</div>';
            }
        }           

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <?php
        if (! IsAdmin() ) {
            include '../global/noPermissions/global/permissions.php';
            exit;
        };
    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Unit Of Study</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Unit Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Name</label>
                                    <input class="form-control" 
                                    name="unit_Name" 
                                    placeholder="Enter Unit Name">

                                    <?php echo "<p class='text-danger'>$errName</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Description</label>
                                    <input class="form-control" 
                                    rows="4"
                                    name="unit_Description" 
                                    placeholder="Enter Description">

                                    <?php echo "<p class='text-danger'>$errDescription</p>"; ?>
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
