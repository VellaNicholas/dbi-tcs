<?php 
    session_start();
    include '../global/ini.php';
    include '../global/navigation.php';

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
    <title>Swinburne TCS</title>
</head>

<body>
    <?php

        $stuCount = $empCount = $unitCount = 0;

        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN GET_STUDENT_COUNT(:stuCount); END;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt, ':stuCount',$stuCount,32);
        oci_execute($stmt);

        $sql = 'BEGIN GET_EMPLOYEE_COUNT(:empCount); END;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt, ':empCount',$empCount,32);
        oci_execute($stmt);

        $sql = 'BEGIN GET_UNIT_OF_STUDY_COUNT(:unitCount); END;';
        $stmt = oci_parse($conn,$sql);
        oci_bind_by_name($stmt, ':unitCount',$unitCount,32);
        oci_execute($stmt);

    ?>
    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- NEW ROW HERE -->
            <div class="row">
                <div class="col-lg-6">
                    <strong> Welcome, <?php echo $_SESSION["username"]; ?></strong><br><br>
                    <p>
                        <?php
                            print_r($_SESSION);
                        ?>
                    </p><br><br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-graduation-cap fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $stuCount; ?>
                                    </div>
                                    <div>Registered Students</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-briefcase fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $empCount; ?>
                                    </div>
                                    <div>Registered Employees</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-university fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
                                        <?php echo $unitCount; ?>
                                    </div>
                                    <div>Registered Units of Study</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <?php include '../global/jqueryref.php'; 

        

    ?>
</body>

</html>
