<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$teamAlloSemester, &$teamAlloYear, &$teamAlloUnitID, &$teamAlloTeamID, &$teamAlloProID, &$teamAlloEmpID) {

          
    	    
           //Check team allocation semester
            if (empty($_POST['teamAlloSemester'])) {
               $errTeamAlloSemester = 'Please enter a Team Allocation Semester';
            } else {
                $teamAlloSemester = test_input($_POST["teamAlloSemester"]);                
            }

            //Check ID
            if (empty($_POST['teamAlloYear'])) {
               $errTeamAlloYear = 'Please enter a Team Unit';
            } else {
                $teamAlloYear = test_input($_POST["teamAlloYear"]);
            }

            if (empty($_POST['teamAlloUnitID'])) {
               $errTeamAlloUnitID = 'Please enter a Team Allocation Unit ID';
            } else {
                $teamAlloUnitID = test_input($_POST["teamAlloUnitID"]);
            }

            if (empty($_POST['teamAlloTeamID'])) {
               $errTeamAlloTeamID = 'Please enter a Team Allocation Team ID';
            } else {
                $teamAlloTeamID = test_input($_POST["teamAlloTeamID"]);
            }

            if (empty($_POST['teamAlloProID'])) {
               $errTeamAlloProID = 'Please enter a Project ID for the Allocated team';
            } else {
                $teamAlloProID = test_input($_POST["teamAlloProID"]);
            }

            if (empty($_POST['teamAlloEmpID'])) {
               $errTeamAlloEmpID = 'Please enter a Employee ID for the team';
            } else {
                $teamAlloEmpID = test_input($_POST["teamAlloEmpID"]);
            }
	}

	function insert_to_database(&$teamAlloSemester, &$teamAlloYear, &$teamAlloUnitID, &$teamAlloTeamID, &$teamAlloProID, &$teamAlloEmpID) {
		
		validate_input($teamAlloSemester, $teamAlloYear, $teamAlloUnitID, $teamAlloTeamID, $teamAlloProID, $teamAlloEmpID);
        //The ones below here are the errors don't forget to change them cunt
		if (!$errTeamAlloSemester && !$errTeamAlloYear && !$errTeamAlloUnitID && !$errTeamAlloTeamID && !$errTeamAlloProID && !$errTeamAlloEmpID){

            $result = insert_team_allocation($teamAlloSemester, $teamAlloYear, $teamAlloUnitID, $teamAlloTeamID, $teamAlloProID, $teamAlloEmpID);
        }

        return $result;
    }
?>

