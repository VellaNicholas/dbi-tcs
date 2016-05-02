<?php

    function insert_project(&$pro_unit_ID, &$pro_team_ID, &$pro_ID, &$pro_Description, &$pro_Semester, &$pro_Year) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_PROJECT(:prounitid, :proteamid, :proid, :prodescription, :prosemester, :proyear); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':prounitid', $pro_unit_ID);
        oci_bind_by_name($stmt, ':proteamid', $pro_team_ID);
        oci_bind_by_name($stmt, ':proid', $pro_ID);
        oci_bind_by_name($stmt, ':prodescription', $pro_Description);
        oci_bind_by_name($stmt, ':prosemester', $pro_Semester);
        oci_bind_by_name($stmt, ':proyear', $pro_Year);

        oci_execute($stmt);

        $e = oci_error($stmt);
        echo htmlentities($e['message']);
        //If oracle codes
        //if ($e != ""){
            //echo
        //} 
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