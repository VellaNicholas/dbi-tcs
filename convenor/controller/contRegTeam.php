<!--
    This file is responsible for the controller layer of the regUnitOffering page. It contains business logic and validation.
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
    //NOTE: unitSemester and unitYear aren't needed to be validated because they come from drop down menus
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

    //Validates the input, then if there are no errors in validation connects to the database and inserts the unit offering.
	function insert_to_database(&$unitID, &$unitYear, &$unitSemester, &$teamID, &$team_member, &$teamSupervisor) {
        try {
            validate_input($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
            $result = insert_team($unitID, $unitYear, $unitSemester, $teamID, $team_member, $teamSupervisor);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }
?>

