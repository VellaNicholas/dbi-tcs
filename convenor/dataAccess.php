<?php

    function insert_project(&$proUnitID,  &$proID, &$proDescription, &$proSemester, &$proYear) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');
        $sql = 'BEGIN INSERT_PROJECT(:prounitid, :proid, :prodescription, ;prosemester, :proyear); END;';

        $stmt = oci_parse($conn,$sql);

        //Bind the inputs
        oci_bind_by_name($stmt, ':prounitid', $proUnitID);
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