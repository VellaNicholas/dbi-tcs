<?php 
    //Good and Bad News, Figured out how to make a input change the input fields
    //bad news is that I don't know how to limit it, so if you enter 300 it will have 300 input fields
    //secondly page doesn't load
    // How I did it can be found here
    // http://stackoverflow.com/questions/14853779/adding-input-elements-dynamically-to-form
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Team</title>
</head>

<body onload="addFields()">
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
    <!--
    <?php
        if (! IsConvenor() ) {
            include '../global/noPermissions/global/permissions.php';
            exit;
        };
    ?>
    -->
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Register Team</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Team Details
                        </div> 
                    <div class="panel-body">            
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>
                                <div class="form-group">
                                 <!-- Div for Semester -->
                                  <label for="unit_Semester">Select Semester:</label>
                                  <select class="form-control" id="team_Semester" name="team_Semester">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                    <option>Summer</option>
                                    <option>Winter</option>
                                  </select>
                                </div>

                                <!-- Div for Year -->
                                <div class="form-group">
                                  <label for="unit_Year">Select Year:</label>
                                  <select class="form-control" id="team_Year
                                  " name="team_Year">
                                    <option>2017</option>
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                  </select>
                                </div>
                                         
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div>

                                <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name="team_ID"
                                    placeholder="Enter Team ID">

                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div>

                                <div class="form-group">
                                    <label>*Team Size </label>
                                    <select class="form-control"
                                    id="team_Size"
                                    name="team_Size"
                                    onchange="addFields()">
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <div id="container"/>
                                    </div>
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
                                        <p>Team successfully added!</p>
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
    <script type='text/javascript'>
        function addFields(){
            // Number of inputs to create
            var number = document.getElementById("team_Size").value;
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");
            // Clear previous contents of the container
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            if (number > 1 & number <13){ 
                for (i=0;i<number;i++){
                    // Append a node with a random text
                    var label = document.createElement("label");
                    label.innerHTML = "Student ID " + (i+1);
                    container.appendChild(label);
                    // Create an <input> element, set its type and name attributes
                    var input = document.createElement("input");
                    input.className = "form-control";
                    input.name = "team_Member" + (i+1);
                    input.id = "team_Member" + (i+1);
                    input.placeholder = "Enter Student ID";
                    container.appendChild(input);
                    // Append a line break 
                    container.appendChild(document.createElement("br"));
                    }
            }
        }
    </script>
</body>

</html>
