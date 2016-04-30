<?php

    function insert_student(&$id, &$firstName, &$lastName, &$email, &$contact) {
        $conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

        $sql = 'BEGIN INSERT_STUDENT(:stuid, :firstname, :lastname, :email, :contactno); END;';
        $stmt = oci_parse($conn,$sql);
        //Bind the inputs
        oci_bind_by_name($stmt, ':stuid',$id,32);               //input
        oci_bind_by_name($stmt, ':firstname',$firstName,32);    //input
        oci_bind_by_name($stmt, ':lastname',$lastName,32);      //input
        oci_bind_by_name($stmt, ':email',$email,32);            //input
        oci_bind_by_name($stmt, ':contactno',$contact,32);      //input
        oci_execute($stmt);
        oci_commit($conn);

        $e = oci_error($stmt);

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Student successfully registered!</div>';
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

        return $result;
    }

    function insert_employee($userName, $firstName, $lastName, $email, $contact) {

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

        switch ($e['code']) {
            case "":
                $result='<div class="span alert alert-success fade in"><strong>Success! </strong>Employee successfully registered!</div>';
                break;
            case 1:
                $result = '<div class="span alert alert-danger fade in">Employee with this ID already exists</div>';
                break;
            case 12899:
                $result = '<div class="span alert alert-danger fade in">Too many characters in field</div>';
                break;
            default:
                $result = '<div class="span alert alert-danger fade in">Unknown Error Occurred</div>';
                debug_to_console( $e[message] );
                break;
        }

        oci_commit($conn);

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



