<!--
    This file is responsible for the view layer of the editTeam page. It controls user input and output.
-->

<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
    include 'dataAccess.php';
    include './controller/contEditTeam.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Team</title>
</head>

<body onload="addFields()">
    <?php
        //Initialise All Vairables to NULL
        $unitID = $unitYear = $unitSemester = $teamSupervisor = $teamID = $team_member = "";

        //When the find button is pressed, call the database function from the controller layer
        if (isset($_POST["find"])) {
            $result = get_details_from_database($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
        }

        //When the submit button is pressed, call the database function from the controller layer
        if (isset($_POST["submit"])) {
            $result = update_database($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);            
        }           
    ?>

    <?php
    //Permits only Convenors to view the page
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
                    <h1 class="page-header">Edit Team</h1>
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
                    <form role="form" method="post" >
                        <fieldset>
                            <!-- Begin students username panel -->
                            <div class="panel panel-default">
                            <!-- students username panel heading -->
                                <div class="panel-heading">
                                    Enter Team Details
                                </div> 
                                <!-- Panel body -->
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- students username entry input form control -->
                                    <div class="form-group">
                                    <label>*Team ID</label>
                                    <input class="form-control"
                                    name="team_ID"
                                    placeholder="Enter Team ID"
                                    value=<?php echo $teamID ?> >
    
                                   <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                </div>
                                <div class="form-group">
                                    <label>*Unit ID</label>
                                    <input class="form-control"
                                    name="unit_ID"
                                    placeholder="Enter Unit ID"
                                    value=<?php echo $unitID ?>>
    
                                </div> 
                                <label for="unit_Semester">Select Semester:</label>
                                    <select class="form-control" id="unit_Semester" name="unit_Semester" value=<?php echo $unitSemester ?>>
                                        <option>Semester 1</option>
                                        <option>Semester 2</option>
                                        <option>Summer</option>
                                        <option>Winter</option>
                                    </select>
                                
    
                                <!-- Div for Year -->
                                <div class="form-group">
                                  <label for="unit_Year">Select Year:</label>
                                  <select class="form-control" id="unit_Year" name="unit_Year" value=<?php echo $unitYear ?>>
                                    <option><?php echo date("Y"); ?></option>
                                    <option><?php echo date("Y") + 1; ?></option>
                                    <option><?php echo date("Y") + 2; ?></option>
                                    <option><?php echo date("Y") + 3; ?></option>
                                  </select>
                                </div>
        
                                    <!-- Submit Button -->
                                    <input class="btn btn-md btn-success btn-block" type="submit" name="find" value="Find Student">
                                </div>
                            </div>
                            <!-- Begin Edit details panel -->
                            <div class="panel panel-default">
                            <!-- Edit student details heading -->
                                <div class="panel-heading">
                                    Edit Team Details
                                </div> 
                                <div class="panel-body">
                                    <p class="help-block">All fields marked with * are mandatory.</p>
                                    <!-- Begin edit student input form controls -->
                                    <div class="form-group">
                                        <label>*Superviser Username</label>
                                        <input class="form-control"
                                        name="supervisor_ID"
                                        placeholder="Enter Supervisor Username"
                                        value=<?php echo $teamSupervisor ?>>
    
                                       <!-- <?php echo "<p class='text-danger'>$errID</p>"; ?> Change this -->
                                    </div>
    
                                    <div class="form-group">
                                        <label>*Team Size </label>
                                        <select class="form-control"
                                        id="team_Size"
                                        name="team_Size"
                                        onchange="addFields('size')">
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
    <script type='text/javascript'>
        function addFields(source){
            if (source == 'size') {
                var number = document.getElementById("team_Size").value;
            } else {
                var number = <?php echo count($team_member);?>
            }
            <?php
                echo 'var values = ['; 
                foreach ($team_member as $value) {
                    echo '"' . $value . '",';
                }
                echo '];';
            ?>
            // Number of inputs to create
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
                    if (source == 'size') {
                        input.value = "";
                    } else {
                        input.value = values[i];
                    } 
                    container.appendChild(input);
                    // Append a line break 
                    container.appendChild(document.createElement("br"));
                }
            }
        }
    </script>
</body>

</html>
