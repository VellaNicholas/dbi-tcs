<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Student</title>
    <?php include 'ini.php'; ?>
</head>

<body>
    <?php
        include 'adminnav.php'; 
        include 'permissions.php';

        if (! IsStudent() ) {
            include 'nopermissions.php';
            exit;
        };
    ?>

    <div id="wrapper">
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Generic Blank Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <?php include 'jqueryref.php'; ?>
</body>

</html>


    <?php
        include 'adminnav.php'; 
        include 'permissions.php';
    
        if (! IsAdmin() ) {
            include 'nopermissions.php';
        };
    ?>