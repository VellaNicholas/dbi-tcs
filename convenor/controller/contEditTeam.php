<!--
    This file is responsible for the controller layer of the editTeam page. It contains business logic and validation.
-->

<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    //Validates all of the input from on the current page
    function validate_input(&$unitID, &$unitYear, &$unitSemester, &$teamID, &$team_member, &$teamSupervisor) {

        //Check Unit ID isn't empty
        if (empty($_POST['unit_ID'])) {
           throw new Exception('Please enter a Unit ID');
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        //Check Supervisor ID isn't emoty
        if (empty($_POST['supervisor_ID'])) {
            throw new Exception('Please enter a Team Supervisor');
        } else {
            $teamSupervisor = test_input($_POST["supervisor_ID"]);
        }


        //Check Team ID isn't empty
        if (empty($_POST['team_ID'])) {
            throw new Exception('Please enter a Team ID');
        } else {
            $teamID = test_input($_POST["team_ID"]);
        }

        //Get all Team Member values
        for ($i = 1; $i <= 12; $i++) {
            $fieldName = 'team_Member' . $i;
            if (test_input($_POST[$fieldName]) != "") {
                $team_member[$i - 1] = test_input($_POST[$fieldName]);
            }
        }

        debug_to_console('count:' . count($team_member));
        if (count($team_member) < 2) {
            throw new Exception('Please enter at least two students');
        }

        $unitSemester = test_input($_POST["unit_Semester"]);
        $unitYear = test_input($_POST["unit_Year"]);
    }

    //Validates the input, then if there are no errors in validation connects to the database and updates the student.
	function update_database(&$unitID, &$unitYear, &$unitSemester, &$teamID, &$team_member, &$teamSupervisor) {

        try {
            validate_input($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
            $result = update_team($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
            $unitID = $unitYear = $unitSemester = $teamID = $team_member = $teamSupervisor = "";
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }


        return $result;
    }

    //Checkes the Student ID isn't empty, then connects to the database and retrieves the details of the given student
    function get_details_from_database(&$unitID, &$unitYear, &$unitSemester, &$teamID, &$team_member, &$teamSupervisor) {
        
        try {
            if (empty($_POST['team_ID'])){ 
                throw new Exception('Please enter a Team ID');
            } else {
                $teamID = test_input($_POST["team_ID"]);
            }
            if (empty($_POST['unit_ID'])){ 
                throw new Exception('Please enter a Unit ID');
            } else {
                $unitID = test_input($_POST["unit_ID"]);
            }

            $unitSemester = test_input($_POST["unit_Semester"]);
            $unitYear = test_input($_POST["unit_Year"]);
            
            $result = get_team_details($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }
?>

