<?php 
    //Good and Bad News, Figured out how to make a input change the input fields
    //bad news is that I don't know how to limit it, so if you enter 300 it will have 300 input fields
    //secondly page doesn't load
    // How I did it can be found here
    // http://stackoverflow.com/questions/14853779/adding-input-elements-dynamically-to-form
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contRegTeam.php';
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
        $unitID = $unitYear = $unitSemester = $teamSupervisor = $teamID = $team_member = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            $result = insert_to_database($$unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
        }
    ?>
    <?php
        if (! IsConvenor() ) {
            include '../global/noPermissions.php';
            exit;
        };
    ?>
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
                    <?php echo $result; ?>  
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
                                    <div class="form-group">
                                        <label>*Unit ID</label>
                                        <input class="form-control"
                                        name="unit_ID"
                                        placeholder="Enter Unit ID">
    
                                    </div> 
                                    <label for="unit_Semester">Select Semester:</label>
                                        <select class="form-control" id="unit_Semester" name="unit_Semester">
                                            <option>Semester 1</option>
                                            <option>Semester 2</option>
                                            <option>Summer</option>
                                            <option>Winter</option>
                                        </select>
                                </div>
    
                                <!-- Div for Year -->
                                <div class="form-group">
                                  <label for="unit_Year">Select Year:</label>
                                  <select class="form-control" id="unit_Year" name="unit_Year">
                                    <option><?php echo date("Y"); ?></option>
                                    <option><?php echo date("Y") + 1; ?></option>
                                    <option><?php echo date("Y") + 2; ?></option>
                                    <option><?php echo date("Y") + 3; ?></option>
                                  </select>
                                </div>

                                 <div class="form-group">
                                    <label>*Superviser Username</label>
                                    <input class="form-control"
                                    name="supervisor_ID"
                                    placeholder="Enter Supervisor Username">
    
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
