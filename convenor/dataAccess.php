<?php

    function insert_project(&$proUnitID, &$proTeamID, &$proID, &$proDescription, &$proSemester, &$proYear) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_PROJECT(:prounitid, :proteamid, :proid, :prodescription, :prosemester, :proyear); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':prounitid', $proUnitID);
        oci_bind_by_name($stmt, ':proteamid', $proTeamID);
        oci_bind_by_name($stmt, ':proid', $proID);
        oci_bind_by_name($stmt, ':prodescription', $proDescription);
        oci_bind_by_name($stmt, ':prosemester', $proSemester);
        oci_bind_by_name($stmt, ':proyear', $proYear);

        oci_execute($stmt);

        $e = oci_error($stmt);
        echo htmlentities($e['message']);
        //If oracle codes
        //if ($e != ""){
            //echo
        //} 
        oci_commit($conn);
    }

    function insert_team_allocation (&$teamAlloSemester, &$teamAlloYear, &$teamAlloUnitID, &$teamAlloTeamID, &$teamAlloProID, &$teamAlloEmpID) {
         $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';

        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_TEAM_ALLOCATION(:teamalloyear, :teamallosemester, :teamalloproid, :teamalloempid, :teamuallounitid, :teamalloteamid); END;';

        $stmt = oci_parse($conn,$sql);

                //Bind the inputs
        oci_bind_by_name($stmt, ':teamuallounitid', $teamAlloUnitID); 
        oci_bind_by_name($stmt, ':teamalloteamid', $teamAlloTeamID); 
        oci_bind_by_name($stmt, ':teamalloyear', $teamAlloYear);
        oci_bind_by_name($stmt, ':teamallosemester', $teamAlloSemester); 
        oci_bind_by_name($stmt, ':teamalloproid', $teamAlloProID);
        oci_bind_by_name($stmt, ':teamalloempid', $teamAlloEmpID);
                      
        oci_execute($stmt);

        $e = oci_error($stmt);
        //TODO Exception handeling
        echo htmlentities($e['message']);

        oci_commit($conn);
    }
    
    function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    
        echo $output;
        }

?>