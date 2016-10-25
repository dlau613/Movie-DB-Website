<?php
	function fnameValid($name) {
		return !($name == "");
	}
	function lnameValid($name) {
		return !($name == "");
	}
	function dateValid($date) {
		$valid = "~^\d{4}-\d{2}-\d{2}$~";
	  	return (preg_match($valid, $date));
	}
	function queryWrapper($query,$db) {
		if (!$rs = $db->query($query)) {
			$errmsg = $db->error;
			print "Query failed: $errmsg <br />";
		}
		return $rs;
	}
	function add_actor() {
		require('database.php');
		//should probably stirp spaces and sanitize first
		$identity = $_GET['identity'];
		$fname = $_GET['fname'];
		$lname = $_GET['lname'];
		$sex = $_GET['sex'];
		$dateb = $_GET['dateb'];
		$dated = $_GET['dated'];

		$inputError = 0;
		if ( !fnameValid($fname)) {
			echo "Invalid First Name <br>";
			$inputError = 1;
		}
		if ( !lnameValid($lname)) {
			echo "Invalid Last Name <br>";
			$inputError = 1;
		}
		if ( !dateValid($dateb)) {
			echo "Invalid Date of Birth <br>";
			$inputError = 1;
		}
		if ( $dated != "") {
			if (!dateValid($dated)) {
				echo "Invalid Date of Death <br>";
				$inputError = 1;
			}
		}
		if ($inputError) {
			return;
		}
		if (!$rs = queryWrapper("Select id from MaxPersonID",$db)) {
			return;
		}

		$row = $rs->fetch_assoc();
		$newID = $row['id'];

		// create insert statement. depends on date of death and actor/director
		$query = "INSERT INTO ".$identity." VALUES (".$newID.",'".$fname."','".
			$lname."','";
		if ($identity == "Actor") {
			$query = $query .$sex."','";				
		}
		$query = $query.$dateb;
		if ($dated == "") {
			$query = $query."',null);";
		}
		else {
			$query = $query."','".$dated."');";
		}
		
		echo $query."<br>";
		// else {
		// 	$query = "INSERT INTO ".$identity." VALUES (".$newID.",'".$fname."','".
		// 		$lname."','".$sex."','".$dateb."','".$dated."');";
		// }

		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		echo $identity . " " . $fname . " " . $lname . " successfully added! <br>";
		if (!$rs = queryWrapper("update MaxPersonID set id=id+1;",$db)) {
			return;
		}

		// validate input values
		// grab next id from MaxPersonID
		// insert new person
		// print a message

	}
?>