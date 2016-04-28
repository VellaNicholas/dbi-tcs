<?php

	session_start();


	function IsAdmin() {

		if ($_SESSION["permissions"] % 2 != 0) {
			return true;
			
		} else {
			return false;
			
		}
	}

	function IsConvenor() {
		$convenorValues = array(2, 3, 6, 7, 10, 14, 15);
	
		if (in_array($_SESSION["permissions"],$convenorValues)) {
			return true;
		} else {
			return false;
		}
	}
	
	function IsSupervisor() {
		$supervisorValues = array(4, 5, 6, 7, 12, 13, 14, 15);
	
		if (in_array($_SESSION["permissions"],$supervisorValues)) {
			return true;
		} else {
			return false;
		}
	}
	
	function IsStudent() {
		$studentValues = array(8, 9, 10, 11, 12, 13, 14, 15);
	
		if (in_array($_SESSION["permissions"],$studentValues)) {
			return true;
		} else {
			return false;
		}
	}

//1 - A
//2 - C
//3 - AC
//4 - S
//5 - AS
//6 - CS
//7 - ACS
//8 - T
//9 - AT
//10 - CT
//11 - ACT
//12 - ST
//13 - AST
//14 - CST
//15 - ACST

?>



