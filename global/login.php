<?php

session_start();
$_SESSION["username"] = "";
$_SESSION["permissions"] = "";


        function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
        }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Log In</title>

    <!-- Bootstrap -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
      body{
        background: url(http://41.media.tumblr.com/tumblr_mc9rbdd8J51qa0rheo1_1280.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
      .vertical-offset-100{
        padding:100px;
      }
      .col-md-4{
        padding: 20px 25px 3px;
        margin: 0 auto 25px;
        margin-top: 50px;
      }
      .col-centered{
        float: none;
        margin: 0 auto;
      }
      .panel-heading{
        font-family: "Helvetica", Sans-Serif;
        font-size: 15px;
      }
    </style>
  </head>


  <body>
    <?php
        //error_reporting(E_ALL);
        //ini_set('display_errors', 'On');
        $username = $password = $permissions = "";

        //Check if submit button is pressed
        if (isset($_POST["submit"])) {
          debug_to_console("Posted");

            $username = test_input($_POST["username"]);
            $password = test_input($_POST["password"]);

            $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

            $sql = 'BEGIN AUTHENTICATE_USER(:username, :password, :permissions); END;';

            $stmt = oci_parse($conn,$sql);

            //Bind the inputs
            oci_bind_by_name($stmt, ':username',$username,32);
            oci_bind_by_name($stmt, ':password',$password,32);
            oci_bind_by_name($stmt, ':permissions',$permissions,32);


            oci_execute($stmt);

       //     $e = oci_error($stmt);
       //     echo htmlentities($e['message']);
       //     //If oracle codes
       //     //if ($e != ""){
       //         //echo
       //     //} 
            oci_commit($conn);

            $_SESSION["username"] = $username;
            $_SESSION["permissions"] = $permissions;

            debug_to_console("sessions:");
            debug_to_console($_SESSION["username"]);
            debug_to_console($_SESSION["permissions"]);


            if ($permissions > 0) {
                header("Location: ../global/dash.php");
                exit();
            } else {
                $result='<div class="span alert alert-danger fade in">Invalid Username.</div>';
            }
            
        }           

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    ?>

    <div class="container-fluid" style="max-width: 1200px;">
      <div class="row vertical-offset-100">
        <div class="col-md-4 col-centered">
          <div class="panel panel-default" style="background-color: rgba(245, 245, 245, 0.9);">
            <div class="panel-heading">
              TCS User Login
            </div> 
            <div class="panel-body">
            <!--  <form role="form" method="post" action=../global/dash.php>
              <fieldset>
                <div class="form-group">
                  <input class="form-control" placeholder="User ID" name="userID" type="text">
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Password" name="password" type="password" value="">
                </div>
                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login >>" name="submit">
                <?php debug_to_console("Form Loaded"); ?>
              </fieldset>
              </form> -->

              <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <fieldset>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control"
                        name="username"
                        placeholder="Enter Username">
                      </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" 
                        name="password" 
                        placeholder="Enter password"
                        type="password">
                      </div>
                                            
                    <input class="btn btn-lg btn-success btn-block" type="submit"   name="submit" value="Login >>">

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <?php echo $result; ?>  
                        </div>
                    </div>
  
                </fieldset>
              </form>

              <div class="modal modal-dialog fade"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  </body>


</html>