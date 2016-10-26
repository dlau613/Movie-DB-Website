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
	function yearValid($year) {
		$valid = "~^\d*$~";
		return (preg_match($valid,$year));
	}
	function queryWrapper($query,$db) {
		// $db = new mysqli('localhost','cs143','','TEST');
		// if ($db->connect_errno > 0) {
		// 	die('Unable to connect to database [' . $db->connect_error . ']');
		// }
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
		$fname = $_GET['first_name'];
		$lname = $_GET['last_name'];
		$sex = $_GET['sex'];
		$dob = $_GET['dob'];
		$dod = $_GET['dod'];

		$inputError = 0;
		if ( !fnameValid($fname)) {
			echo "Invalid First Name <br>";
			$inputError = 1;
		}
		if ( !lnameValid($lname)) {
			echo "Invalid Last Name <br>";
			$inputError = 1;
		}
		if ( !dateValid($dob)) {
			echo "Invalid Date of Birth <br>";
			$inputError = 1;
		}
		if ( $dod != "") {
			if (!dateValid($dod)) {
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
		$query = $query.$dob;
		if ($dod == "") {
			$query = $query."',null);";
		}
		else {
			$query = $query."','".$dod."');";
		}
		
		echo $query."<br>";
		// else {
		// 	$query = "INSERT INTO ".$identity." VALUES (".$newID.",'".$fname."','".
		// 		$lname."','".$sex."','".$dob."','".$dod."');";
		// }

		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		echo $identity . " " . $fname . " " . $lname . " successfully added! <br>";
		if (!$rs = queryWrapper("update MaxPersonID set id=id+1;",$db)) {
			return;
		}
	}
	function add_movie_genre($db, $mid,$genre) {
		$query = "INSERT INTO MovieGenre VALUES (".$mid.",'".$genre."');";
		if (!$rs = queryWrapper($query,$db))
			echo "failed <br>";
			return false;
		return true;
	}
	function add_movie() {
		require('database.php');
		//should probably stirp spaces and sanitize first
		$title = $db->real_escape_string($_GET['title']);
		$company = $db->real_escape_string($_GET['company']);
		$year = $db->real_escape_string($_GET['year']);
		$rating = $db->real_escape_string($_GET['rating']);
		$genre = $_GET['genre'];


		$inputError = 0;
		if ( !yearValid($year)) {
			echo "Invalid Year<br>";
			$inputError = 1;
		}
		if ($inputError) {
			return;
		}

		if (!$rs = queryWrapper("Select id from MaxMovieID",$db)) {
			return;
		}

		$row = $rs->fetch_assoc();
		$newID = $row['id'];

		// create insert statement. depends on date of death and actor/director
		$query = "INSERT INTO Movie VALUES (".$newID.",'".$title."',".
			$year.",'".$rating."','".$company."');";
		
		echo $query."<br>";

		if (!$rs = queryWrapper($query,$db)) {
			echo "Failed to insert movie <br>";
			return;
		}

		// // add movie genres as well
		// add movie genres as well
		foreach ($genre as $g) {
			add_movie_genre($db,$newID,$g);
		}
		echo "Movie " . $title ." successfully added! <br>";
		if (!$rs = queryWrapper("update MaxMovieID set id=id+1;",$db)) {
			return;
		}
	}
?>