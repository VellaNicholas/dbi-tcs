<?php

    function insert_project(&$proUnitID,  &$proName, &$teachingPeriod, &$year, &$descriptionPath) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN INSERT_PROJECT(:unitid, :name, :semester, :year, :description); END;';

        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':unitid', $proUnitID);
        oci_bind_by_name($stmt, ':name', $proName);
        oci_bind_by_name($stmt, ':semester', $teachingPeriod);
        oci_bind_by_name($stmt, ':year', $year);
        oci_bind_by_name($stmt, ':description', $descriptionPath);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Project successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Project - Project with name ' . $proName . ' is already part of ' . $unitID . ' in ' . $unitSemester . ' ' . $unitYear . '</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Project - Too many characters in field</div>';
                break;
            case 20003:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Project - ' . $proUnitID . ' not offered in ' . $teachingPeriod . ' ' . $year . '</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Enrolment - Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    function insert_assessment(&$assTitle, &$unitID, &$semester, &$year, &$description, &$isIndividualGroup, &$dueDate, &$markingGuidePath, &$proName) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN INSERT_ASSESSMENT(:title, :unitid, :semester, :year, :description, :individualgroup, :duedate, :markingguide, :proname); END;';

        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':title', $assTitle);
        oci_bind_by_name($stmt, ':unitid', $unitID);
        oci_bind_by_name($stmt, ':semester', $semester);
        oci_bind_by_name($stmt, ':year', $year);
        oci_bind_by_name($stmt, ':description', $description);
        oci_bind_by_name($stmt, ':individualgroup', $isIndividualGroup);
        oci_bind_by_name($stmt, ':duedate', $dueDate);
        oci_bind_by_name($stmt, ':markingguide', $markingGuidePath);
        oci_bind_by_name($stmt, ':proname', $proName);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Assessment successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Assessment - Project ' . $proName . ' already has an assignment called ' . $assTitle . '</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Assessment - Too many characters in field</div>';
                break;
            case 20003:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Assessment - ' . $unitID . ' not offered in ' . $semester . ' ' . $year . '</div>';
                break;
            case 20005:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Assessment - No Project called ' . $proName . ' for ' . $unitID . ' in ' . $semester . ' ' . $year . '</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Enrolment - Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    function allocate_project(&$proName, &$teamID, &$semester, &$year, &$unitID) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN ALLOCATE_PROJECT(:proname, :teamid, :unitid, :semester, :year); END;';
        
        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':proname', $proName);
        oci_bind_by_name($stmt, ':teamid', $teamID);
        oci_bind_by_name($stmt, ':unitid', $unitID);
        oci_bind_by_name($stmt, ':semester', $semester);
        oci_bind_by_name($stmt, ':year', $year);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Assessment successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - Project ' . $proName . ' has already been allocated to Team ' . $teamID . '</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - Too many characters in field</div>';
                break;
            case 20003:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - ' . $unitID . ' not offered in ' . $semester . ' ' . $year . '</div>';
                break;
            case 20005:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - No Project called ' . $proName . ' for ' . $unitID . ' in ' . $semester . ' ' . $year . '</div>';
                break;
            case 20006:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - No Team with Team ID ' . $teamID . ' for ' . $unitID . ' in ' . $semester . ' ' . $year . '</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Failed to Allocate Project - Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    function insert_team(&$unitID, &$unitYear, &$unitSemester, &$teamID, &$team_member, &$teamSupervisor) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN INSERT_TEAM_PKG.INSERT_TEAM(:unitid, :unitsemester, :unityear, :teamid, :teammembers, :supervisor); END;';

        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':teamid', $teamID);
        oci_bind_by_name($stmt, ':unitid', $unitID);
        oci_bind_by_name($stmt, ':unityear', $unitYear);
        oci_bind_by_name($stmt, ':unitsemester', $unitSemester);
        oci_bind_by_name($stmt, ':supervisor', $teamSupervisor);
        oci_bind_array_by_name($stmt, ':teammembers', $team_member, 12, -1, SQLT_CHR);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Team successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Team - Student ' . $stuID . ' is already in a team for ' . $unitID . ' in ' . $unitSemester . ' ' . $unitYear . '</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Team - Too many characters in field</div>';
                break;
            case 20003:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Team - ' . $unitID . ' not offered in ' . $unitSemester . ' ' . $unitYear . '</div>';
                break;
            case 20004:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Team - Supervisor\'s Username not found</div>';
                break;
            case 1400:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Team - Student Not Enrolled in ' . $unitID . ' in ' . $unitSemester . ' ' . $unitYear . '</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Failed to Add Enrolment - Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        return $result;
    }

    function get_project_details(&$proUnitID,  &$proID, &$proDescription, &$proSemester, &$proYear) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN GET_PROJECT_DETAILS(:prounitid, :proid, :prodescription, ;prosemester, :proyear); END;';
        $stmt = oci_parse($conn,$sql);

        oci_bind_by_name($stmt, ':prounitid', $proUnitID, 32);
        oci_bind_by_name($stmt, ':proid', $proID, 32);
        oci_bind_by_name($stmt, ':prodescription', $proDescription, 32);
        oci_bind_by_name($stmt, ':prosemester', $proSemester, 32);
        oci_bind_by_name($stmt, ':proyear', $proYear, 32);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);
        //TODO: Exceptions
        /*
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Unit successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Unit with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
        */
    }

    //Connects to the database and update the unit in the Unit table
    //Returns a successful message or a specified exception
    function edit_project(&$proUnitID,  &$proID, &$proDescription, &$proSemester, &$proYear) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN UPDATE_PROJECT(:prounitid, :proid, :prodescription, ;prosemester, :proyear); END;';
        $stmt = oci_parse($conn,$sql);

        oci_bind_by_name($stmt, ':prounitid', $proUnitID, 32);
        oci_bind_by_name($stmt, ':proid', $proID, 32);
        oci_bind_by_name($stmt, ':prodescription', $proDescription, 32);
        oci_bind_by_name($stmt, ':prosemester', $proSemester, 32);
        oci_bind_by_name($stmt, ':proyear', $proYear, 32);

        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        //TODO: Exception Handling
        /*
        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully updated!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Student with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }
        */
        return $result;
    }
    
    function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
        }

?>