<?php
    //THIS FILE STORES ASOCIATED HTML INTO VARIABLES FOR PERMISSIONS HANDLING IN nav.php
    //ADMIN
	// Create and populate ADMIN sub-menu variables with associated html.
	$admHead = 		'<li class="disabled">
                        <a class = "transparent"><i class="fa fa-terminal fa-fw"></i><b> Admin </b></a>  
                    </li>
                    <ul class="nav nav-second-level">';
    $students =		'	<li>
                    		<a href="#"><i class="fa fa-graduation-cap fa-fw"></i> Students<span class="fa arrow"></span></a>
                    		<ul class="nav nav-third-level">
                        		<li>
                            		<a href="../admin/regStudent.php"><i class="fa fa-plus fa-fw"></i> Register Student</a>
                        		</li>
                        		<li>
                            		<a href="../admin/editStudent.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Student</a>
                        		</li>
                                <li>
                                    <a href="../admin/regEnrolment.php"><i class="fa fa-folder-open fa-fw"></i> Enrol Student</a>
                                </li>
                    		</ul>
                		</li>';
    $employees =	'	<li>
                    		<a href="#"><i class="fa fa-briefcase fa-fw"></i> Employees<span class="fa arrow"></span></a>
                    		<ul class="nav nav-third-level">
                        		<li>
                            		<a href="../admin/regEmp.php"><i class="fa fa-plus fa-fw"></i> Register Employee</a>
                        		</li>
                        		<li>
                            		<a href="../admin/editEmp.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Employee</a>
                        		</li>
                    		</ul>
                		</li>';
    $units =    	'	<li>
                			<a href="#"><i class="fa fa-university fa-fw"></i> Units of Study<span class="fa arrow"></span></a>
                			<ul class="nav nav-third-level">
                    			<li>
                        			<a href="../admin/regUoS.php"><i class="fa fa-plus fa-fw"></i> Register UoS</a>
                    			</li>
                    			<li>
                        			<a href="../admin/editUoS.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit UoS</a>
                    			</li>
                                <li>
                                    <a href="../admin/regUnitOffering.php"><i class="fa fa-folder-open fa-fw"></i> Offer UoS</a>
                                </li>
                			</ul>
            			</li>';
    $admReports =	'	<li>
                        	<a href="genReports.php"><i class="fa fa-bar-chart fa-fw"></i> Generate Reports</a>
                    	</li>
                    </ul>';   
	//ADMIN VARIABLE: Includes all associated sub-links. Concat all variables and combine them into $admin
	$admin = $admHead . $students . $employees . $units . $admReports;

	// Create and populate Convenor sub-menu variables with associated html.
    $conHead =      '<li class="disabled">
                        <a class = "transparent"><i class="fa fa-cubes fa-fw"></i><b> Convenor </b></a>  
                    </li>
                    <ul class="nav nav-second-level">';
    $convStudents = '   <li>
                            <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> Students<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="../admin/regEnrolment.php"><i class="fa fa-pencil-square-o fa-fw"></i> Enrol Student</a>
                                </li>
                            </ul>
                        </li>';
    $teams =        '   <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Teams<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="../convenor/regTeam.php"><i class="fa fa-plus fa-fw"></i> Register Team</a>
                                </li>
                                <li>
                                    <a href="../convenor/editTeam.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Team</a>
                                </li>
                            </ul>
                        </li>';
    $projects =     '   <li>
                            <a href="#"><i class="fa fa-line-chart fa-fw"></i> Projects<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="../convenor/regProject.php"><i class="fa fa-plus fa-fw"></i>Register Project</a>
                                </li>
                                <li> 
                                    <a href="../convenor/editProject.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Project</a>
                                </li>
                            </ul>
                        </li>';
    // fuck this
    $assessments =  '   <li>
                            <a href="#"><i class="fa fa-file-o fa-fw"></i> Assessments<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="../convenor/regAssessment.php"><i class="fa fa-plus fa-fw"></i> Create Assessment</a>
                                </li>
                                <li>
                                    <a href="../convenor/editAssessment.php"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Assessment</a>
                                </li>
                            </ul>
                        </li>';
    $allocations =  '   <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Project Allocations<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="../convenor/regTeamAllocation.php"><i class="fa fa-plus fa-fw"></i> Allocate Project to Team</a>
                                </li>
                                <li>
                                    <a href="../convenor/removeTeamAllocation.php"><i class="fa fa-trash-o fa-fw"></i> Clear Project Allocation</a>
                                </li>
                            </ul>
                        </li>';
    $conReports =   '   <li>
                            <a href="genReports.html"><i class="fa fa-bar-chart fa-fw"></i> Generate Reports</a>
                        </li>
                    </ul>';

    //CONVENOR VARIABLE: Includes all associated sub-links. Concat all variables and combine them into $convenor

    $convenor = $conHead . $convStudents . $teams . $projects . $assessments . $allocations . $conReports;

    //SUPERVISOR
    // Create and populate SUPERVISOR sub-menu variables with associated html.
    $supHead =      '<li class="disabled">
                        <a class = "transparent"><i class="fa fa-terminal fa-fw"></i><b> Supervisor </b></a>  
                    </li>
                    <ul class="nav nav-second-level">';
    $supBook =      '<li>
                            <a href="../supervisor/bookMeeting.php"><i class="fa fa-plus fa-fw"></i> Book Meeting</a>
                        </li>';
    $supConduct =      '<li>
                            <a href="../supervisor/conductMeeting.php"><i class="fa fa-plus fa-fw"></i> Conduct Meeting</a>
                        </li>';

    $supReviewMeeting = '<li>
                            <a href="../supervisor/reviewMeeting.php"><i class="fa fa-plus fa-fw"></i> Book Meeting</a>
                        </li>';
    $supReviewStudentWork = '<li>
                            <a href="../supervisor/reviewStudentWork.php"><i class="fa fa-plus fa-fw"></i> Book Meeting</a>
                            </li>';



    //ADMIN VARIABLE: Includes all associated sub-links. Concat all variables and combine them into $admin
    $supervisor = $supHead . $supBook . $supConduct . $supReviewMeeting . $supReviewStudentWork;

?>