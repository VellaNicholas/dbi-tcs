<!-- Handles all navigation including top bar and dynamically generating sidebar. -->

<?php
    //Add start session here.
    session_start();
    include '../global/permissions.php';
    include '../global/navbarElements.php';

?>

<!-- Top Navbar -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="http://www.swinburne.edu.au/" class="pull-left"><img src="http://www.teamswinburne.com/wp-content/uploads/2015/01/RGB-Swinburne-Logo-Horizontal-e1425465869282.png" height="60"></a>
        <a class="navbar-brand" href="../global/dash.php">Team Contribution System</a>
    </div>
    <!-- /.navbar-header -->

    <!-- Handles the user icon dropdown on the right of the page (logout, settings etc.) -->
    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown for user -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="../global/login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
        </li>
        <!-- /.dropdown for user -->
    </ul>
    <!-- /.navbar-top-links -->
    <!-- SIDEBAR -->
    
    <!-- OI FIND A WAY TO MERGE THE BUTTONS UL TAGS -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="../global/dash.php"><i class="fa fa-home fa-fw"></i> Dashboard
                    </a>
                </li>
                <!-- ADMIN -->
                <li>      
                    <?php
                        //Check user permissions. Only show Admin sidebar options if the user has Admin permissions.
                        if (IsAdmin()){
                            echo $admin;
                        } else{
                            echo "";
                        }
                    ?>        
                </li>
                <!-- end ADMIN -->
                <!-- CONVENOR -->
                <li>
                    <?php
                        //Check user permissions. Only show Convenor sidebar options if the user has Convenor permissions.
                        if (IsConvenor()){
                            echo $convenor;
                        } else{
                            echo "";
                        } 
                    ?>
                </li>
                <!-- end CONVENOR -->
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>