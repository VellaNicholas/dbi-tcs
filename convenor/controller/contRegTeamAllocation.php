<?php  
	//Prevents scripting and SQL injection
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_input(&$proName, &$teamID, &$semester, &$year, &$unitID) {

        //Check Assignment Title isn't empty
        if (empty($_POST['pro_name'])){
            throw new Exception('Project Name required');
        } else {
            $proName = test_input($_POST["pro_name"]);
        }

        //Check Team ID
        if (empty($_POST['team_ID'])) {
           throw new Exception('Team ID required');
        } else {
            $teamID = test_input($_POST["team_ID"]);                
        }

        //Check unit ID name
        if (empty($_POST['unit_ID'])) {
           throw new Exception('Unit ID required');
        } else {
            $unitID = test_input($_POST["unit_ID"]);                
        }

        $semester = test_input($_POST["teaching_period"]);
        $year = test_input($_POST["year"]);
    }

    //Function inserts the data, into the database, validates the input and checks there are no errors. 
    function insert_to_database(&$proName, &$teamID, &$semester, &$year, &$unitID) {
        
        try {
            validate_input($proName, $teamID, $semester, $year, $unitID);
            $result = allocate_project($proName, $teamID, $semester, $year, $unitID);
        } catch (Exception $e) {
            $result = '<div class="span alert alert-danger fade in">' . $e->getMessage() . '</div>';
        }

        return $result;
    }
?>

