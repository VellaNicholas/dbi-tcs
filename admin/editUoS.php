<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Unit of Study</title>
</head>

<body>
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $id = $unitName = $unitDescription = $e = "";

        function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
        }


        //Check if Find button is pressed
        if (isset($_POST["find"])) {
            if (empty($_POST['unit_ID'])){ 
                $errID = 'Please enter a Unit ID';
            } else {
                $id = test_input($_POST["unit_ID"]); 

                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN GET_UNIT_OF_sTUDY_DETAILS(:unitid, :unitname, :unitdescription); END;';

                $stmt = oci_parse($conn,$sql);

                oci_bind_by_name($stmt, ':unitid',$id, 32);            //input
                oci_bind_by_name($stmt, ':unitname',$unitName, 32);    //output
                oci_bind_by_name($stmt, ':unitdescription',$unitDescription, 32);      //output

                oci_execute($stmt);

                $e = oci_error($stmt);
                echo htmlentities($e['message']);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

                debug_to_console( "Got Details" );
            }
        }

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {

            debug_to_console( "Submit Pressed" );

            if (empty($_POST['unit_ID'])){       
                $errUnitID = 'Please enter a Unit ID';
            } else {
                $id = test_input($_POST["unit_ID"]);  
            }
            //VALIDATION
            //Check first name
            if (empty($_POST['unit_Name'])) {        
               $errUnitName = 'Please enter a Unit Name';
            } else {
                $unitName = test_input($_POST["unit_Name"]);               
            }
            //Check last name 
            if (empty($_POST['unit_Description'])) {   
                $errUnitDescription = 'Place enter a Unit Description';
            } else {
                $unitDescription = test_input($_POST["unit_Description"]); 
            }
           
            
            if (!$errUnitName && !$errUnitDescription){

                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Unit of Study successfully registered!</div>';

                        //REMEMBER TO REMOVE CONNECTION LOGIC LATER. KEEP IT IN LOGIN
                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                debug_to_console( "Running SQL" );

                $sql = 'BEGIN UPDATE_UNIT(:unitid, :unitname, :unitdescription); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs 
                oci_bind_by_name($stmt, ':unitid',$id, 32);     
                oci_bind_by_name($stmt, ':unitname',$unitName, 32);
                oci_bind_by_name($stmt, ':unitdescription',$unitDescription, 32);
                

                oci_execute($stmt);

                $e = oci_error($stmt);
                //If oracle codes
                //if ($e != ""){
                    //echo
                //} 
                oci_commit($conn);

                $id = $unitName = $unitDescription = $e = ""; 

                debug_to_console( "SQL Committed" );

            } else {
                $result='<div class="span alert alert-danger fade in"><strong>Oops! </strong>something unexpected happened! Please try registering this Unit of Study later.</div>';

                debug_to_console( "Failed Validation" );
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
