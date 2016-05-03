<!-- UPON THE CONSUMPTION OF A HSP, ALLAH WILL BLESS THIS CODE AND BANISH ALL SYNTAX ERRORS AND COMPILATION ERRORS. MASHALLAH -->
<!-- This page handles the presentation layer of the register employee page, available only to users with Admin permissions -->
<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';
?>

<!-- Having some issues with jQuery not loading properly, this ensures that jQuery works fine by downloading it straight
from the source. Remember to add this to the jqueryref.php file, or alternatively, ini.php -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Employee</title>
</head>

<body>
    <!-- This needs to go to a separate file -->
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $firstName = $lastName = $userName = $email = $contact = $e = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
            
            //Check first name
            if (empty($_POST['emp_FName'])) {
               $errFName = 'Please enter a first name';
            } else {
                $firstName = test_input($_POST["emp_FName"]);                
            }
            //Check last name
            if (empty($_POST['emp_LName'])) {
                $errLName = 'Place enter a last name';
            } else {
                $lastName = test_input($_POST["emp_LName"]);
            }

            if (empty($_POST['emp_UName'])){
                $errID = 'Please enter a Username';
            } else {
                $userName = test_input($_POST["emp_UName"]);
            }

            //Check email.
            if (empty($_POST['emp_Email'])) {
                $errEmail = 'Please enter an email address';
            } else {
                $email = test_input($_POST["emp_Email"]);
            }
            //Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errEmail = "Invalid email format. Please try again";
                $email = "";
            }

            if (is_numeric($_POST['emp_Contact']) || empty($_POST['emp_Contact'])) {
                $contact = test_input($_POST["emp_Contact"]);
            } else {
                $errContact = 'Please enter a valid contact number';
            }

            if (!$errID && !$errFName && !$errLName && !$errEmail && !$errContact){

                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';

                        //REMEMBER TO REMOVE CONNECTION LOGIC LATER. KEEP IT IN LOGIN
                $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

                $sql = 'BEGIN INSERT_EMPLOYEE(:username, :firstname, :lastname, :email, :contactno); END;';

                $stmt = oci_parse($conn,$sql);

                //Bind the inputs
                oci_bind_by_name($stmt, ':username',$userName);
                oci_bind_by_name($stmt, ':firstname',$firstName);
                oci_bind_by_name($stmt, ':lastname',$lastName);
                oci_bind_by_name($stmt, ':email',$email);
                oci_bind_by_name($stmt, ':contactno',$contact);

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

        //Prevents XSS and SQL injection
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Remove later. Not necessary
        function debug_to_console( $data ) {

            if ( is_array( $data ) )
                $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
            else
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

            echo $output;
        }

        /*function validate_emp_csv(){
            $row = 1;
            if (($handle = fopen("csvInput", "r+")) !== FALSE){
                while (($data = fgetcsv($handle)) !== FALSE){
                    $num = count($data);
                    echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        echo $data[$c] . "<br />\n";
                    }
                }
            fclose($handle);
            }
        }*/

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
                    <h1 class="page-header">Register Employee v.j</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter Employee Details
                        </div> 
                    <div class="panel-body">            
                        <form id="empForm" role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" data-parsley-validate="">
                            <p class="help-block">All fields marked with * are mandatory.</p>
                            <fieldset>

                                <div class="form-group">
                                    <label>*Username</label>
                                    <input class="form-control"
                                    name="emp_UName"
                                    placeholder="Enter Username"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errID</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*First Name</label>
                                    <input class="form-control" 
                                    name="emp_FName" 
                                    placeholder="Enter firstname"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errFName</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>*Surname</label>
                                    <input class="form-control" 
                                    name="emp_LName" 
                                    placeholder="Enter surname"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errLName</p>"; ?>
                                </div>  
                                <div class="form-group">
                                    <label>*Email address</label>
                                    <input class="form-control" 
                                    name="emp_Email"
                                    type="email" 
                                    placeholder="Enter email"
                                    data-parsley-trigger="change"
                                    data-parsley-type="email"
                                    required="">

                                    <?php echo "<p class='text-danger'>$errEmail</p>"; ?>
                                </div>
                                <div class="form-group">
                                    <label>Contact number</label>
                                    <input class="form-control" name="emp_Contact" placeholder="Enter phone number"
                                    data-parsley-type="number">

                                    <?php echo "<p class='text-danger'>$errContact</p>"; ?>                                    
                                </div>                                                           
                                <div class="text-center">
                                    <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Register >>">
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <?php echo $result; ?>  
                                    </div>
                                </div> 

                                <div class="text-right">
                                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#csvUpload">Import .csv</button>-->
                                    <br><a data-toggle="modal" data-Target="#csvUpload"><i class="fa fa-upload"></i> Import CSV</a>
                                </div>

                            </fieldset>
                        </form>

                        <!--<?php
                            /*$row = 1;
                            if (isset($_FILE["csvInput"])){
                                if (($handle = fopen("csvInput", "r+")) !== FALSE){
                                    while (($data = fgetcsv($handle)) !== FALSE){
                                        $num = count($data);
                                        echo "<p> $num fields in line $row: <br /></p>\n";
                                        $row++;
                                        for ($c=0; $c < $num; $c++) {
                                            echo $data[$c] . "<br />\n";
                                        }
                                    }
                                fclose($handle);
                                }
                            }
                            */
                        ?> -->
                        <!-- CSV MODAL -->
                        <div id="csvUpload" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Import CSV</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Please select a CSV file from your local machine to import</p>
                                        <br>
                                        <label class="control-label">Select CSV File</label>
                                        <input name="csvInput" id="csvInput" type="file" class="file" accept=".csv">

                                        <!-- Will output an error if file selected in browser is not a csv. -->
                                        <p id="csvError" class="text-danger"></p>

                                        <!-- TO OUTPUT ALL RESULTS OF CSV VALIDATION -->
                                        <!-- <textarea readonly>HIDE THIS! ONLY USE THIS TO DISPLAY OUTPUT ONCE CSV VALIDATION IS DONE YO</textarea> -->

                                        <!-- NEW TECH! YAY! 
                                        Maybe clear the fileInput control when the CANCEL button is pressed? Are there any repercussions? Do it later.
                                        AJAX is absolutely required to send variables (the cleaned rows) to PHP for further validation and entry to database
                                        Inititalise csv upload javascript -->
                                        <script type="text/javascript">
        
                                            //Simply handles when the upload button is pressed. Messy, but it works. As it stands, there is no
                                            //simpler way of doing this with the fileInput js plugin installed.

                                            //  --ENTRY POINT--
                                            //When the user selects a file, look for the btn that contains the index = 3 (upload) and the button that contains the index = 1 (remove).
                                            $(document).ready(function() {
                                                document.getElementById("csvInput").addEventListener('change', function(){
                                                    //The file input upload button is index = 3 of all btn classes on page. The remove button is index = 1. Refer to these buttons as i=3 and i=1 respectively. Again, no way to make this simpler. Research this further.
                                                    var removeBtn = document.getElementsByClassName("btn")[1];
                                                    var uploadBtn = document.getElementsByClassName("btn")[3];
    
                                                    //When the upload button is clicked, get the filename/filepath
                                                    uploadBtn.addEventListener("click", function(){
    
                                                        var file = document.getElementById("csvInput").files[0];
                                                        console.log(file);
    
                                                        //move to Upload Data function later m8
                                                        if (loadValidCSV(file)){
                                                            console.log("ALLAH HAS BLESSED US, file is validated");
                                                        } else {
                                                            console.log("FUCK something went wrong, file is shit");
                                                        }
    
                                                    });

                                                    removeBtn.addEventListener("click", function(){
                                                        //Clear the error messages on cancel.
                                                        document.getElementById("csvError").innerHTML = "";
                                                    });
                                                });
                                            });
    
                                            //Retrieves the file extension by finding the substring after the character '.' and returns that substring
                                            function getExtension(path) {
                                                var parts = path.split('.');
                                                return parts[parts.length - 1];
                                            }
                                            
                                            //Checks if the provided filePath is actually a csv file. Does this by calling getExtension, and comparing 
                                            //the result with "csv". Returns true if the file is a CSV.
                                            function isCSV(csvPath){
                                                var extension = getExtension(csvPath);
                                                if (extension.toLowerCase() == "csv")
                                                {
                                                    return true;
                                                } else {
                                                    return false;
                                                }
                                            }

                                            //Checks if the CSV file has the appropriate number of fields. If it doesn't, it rejects the file and spits back an error message.
                                            function validateNumFields(row, data){
                                                var numFields = data[row].length;
                                                if (numFields < 5 || numFields > 5){
                                                    //ONE row could reject the whole file. Is this okay?
                                                    document.getElementById("csvError").innerHTML = "The requested file does not have the correct number of fields. Ensure that ALL fields in the requested file strictly consists of 5 fields per row (username, firstName, lastName, email, contact)";
                                                    return false;

                                                } else if (numFields == 5){
                                                    return true;
                                                }
                                            }

                                            //Cannot be null. Max characters?
                                            function validateUsername(username){
                                                //Apply validation logic here
                                                var maxUserChars = 40;
                                                //var usernameOutput = "";
                                                if (username == null || username == ""){
                                                    return false;
                                                } else {
                                                    return true;
                                                }
                                                
                                            }

                                            //Handles firstname and lastnames. Cannot contain numbers. Cannot be null. Max characters? Set to 40 to account for
                                            //people with last names like: "Wolfeschlegelsteinhausenbergerdorff" (Yes, its actually a thing).
                                            function validateName(name){
                                                var maxNameChars = 40;
                                            }

                                            function validateEmail(email){

                                            }

                                            //FIX THIS ASAP
                                            function validateRow(row, data){
                                                for (var item in data[row]){
                                                    var output = "";
                                                    //Put switch statement here
                                                    if (item == 0){
                                                        //Run the validateUsername function
                                                        var usernameInput = validateUsername(data[row][item]);
                                                        //If the validate function returns a string, output the error.
                                                        if (usernameInput == false){
                                                            return {type:"noUsernameErr", validated:false, row:row};
                                                            break;
                                                        //Else, the validation was successful (validation function should return a bool)
                                                        } else {
                                                            //Just for debugging CHANGE LATER
                                                            output = "username successfully validated on row " + row;
                                                            console.log(output);
                                                            return {type:"success", validated:true, row:row};
                                                        }
                                                    }
                                                }
                                            }

                                            function outputResults(rows, message){
                                                if (rows.length == 0){
                                                    return "";
                                                } else {
                                                    var rowsOutput = rows.toString();
                                                    console.log(message + " ROWS: (" + rowsOutput + ")");
                                                }
                                            }

                                            
                                            //Main validation method. Loads data, then validates it.
                                            function loadValidCSV(csvFile){
                                                if (isCSV(csvFile.name)) {
                                                    //Main validation code
                                                    var validateMsg = "";
                                                    var reader = new FileReader();
                                                    reader.readAsText(csvFile);

                                                    reader.onload = function(event){
                                                        var csv = event.target.result;
                                                        var data = $.csv.toArrays(csv);

                                                        //Declare arrays for all possible output messages. THis will store the affected rows.
                                                        var addedRows = [];
                                                        var noUsernameErrRows = [];

                                                        //For every row, 
                                                        for (var row in data){
                                                            //Not entirely necessary, but i need to find a way to get rows before the for loop. Only realistically checks once though before breaking so...
                                                            if (validateNumFields(row, data) == false){
                                                                break;
                                                            }

                                                            // If everything is all good, assign validateMsg with an error if validateRow() provides one.
                                                            //If validateRow returns false, add violating row to array.
                                                            var activeRow = validateRow(row,data);
                                                            if (activeRow["validated"] == false){
                                                                switch (activeRow["type"]){
                                                                    case "noUsernameErr":
                                                                        //do something
                                                                        noUsernameErrRows.push(activeRow["row"]);
                                                                        break;
                                                                }

                                                            } else {
                                                                //Add row
                                                                addedRows.push(activeRow["row"]);
                                                            }
                                                        }

                                                        outputResults(addedRows, "SUCCESSFULLY ADDED");
                                                        outputResults(noUsernameErrRows, "NO USERNAME FOUND ERROR OCCURED ON");
                                                    }
                                                    return true;
                                                } else {
                                                    document.getElementById("csvError").innerHTML = "The requested file is not a CSV. Please try again.";
                                                    return false;
                                                }
                                            }                                         
                                        </script>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
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
