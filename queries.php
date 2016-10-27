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
	function actorValid($actor) {
		return !($actor=="");
	}
	function titleValid($title) {
		return !($title == "");
	}
	function companyValid($company) {
		return !($company == "");
	}
	function yearValid($year) {
		$valid = "~^\d*$~";
		return (preg_match($valid,$year));
	}
	function roleValid($role) {
		return !($role == "");
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

	function get_actors() {
		require('database.php');
		$query = "SELECT id,first,last,dob FROM Actor;";
		$results = [];
		if (!$rs = queryWrapper($query,$db)) {
			return $results;
		}
		while($row = $rs->fetch_assoc()) {
			array_push($results,$row["id"]." ".$row["first"]." ".$row["last"]. " (".$row["dob"].")");
		}
		return $results;
	}
	function get_movies() {
		require('database.php');
		$query = "SELECT id,title,year FROM Movie";
		$results = [];
		if (!$rs = queryWrapper($query,$db)) {
			return $results;
		}
		while($row = $rs->fetch_assoc()) {
			array_push($results,$row["id"]." ".$row["title"]." "." (".$row["year"].")");
		}
		return $results;
	}
	function create_movie_tags() {
		$movies = get_movies();
		$ids = [];
		$titleYear = [];
		foreach ($movies as $idTitleYear) {
			$arr = explode(" ",$idTitleYear);
			array_push($ids, $arr[0]);
			array_push($titleYear, implode(" ", array_slice($arr,1)));
		}
		$length = count($ids);
		$i=0;
		for ($i=0; $i<$length;$i++) {
			echo '{label: "'.$titleYear[$i].'", value: "'.$ids[$i].'"},';
		}
	}
	function create_actor_tags() {
		$actors = get_actors();
		$ids = [];
		$nameDate = [];
		foreach ($actors as $idNameDate) {
			$arr = explode(" ",$idNameDate);
			array_push($ids, $arr[0]);
			array_push($nameDate, implode(" ", array_slice($arr,1)));
		}
		// echo '"'.implode('","',$nameDate).'"';
		$length = count($ids);
		$i=0;
		for ($i=0; $i<$length;$i++) {
			echo '{label: "'.$nameDate[$i].'", value: "'.$ids[$i].'"},';
		}
	}
	function add_actor($db) {
		// require('database.php');
		//should probably stirp spaces and sanitize first
		$identity = $_GET["identity"];
		$fname = $_GET["first_name"];
		$lname = $_GET["last_name"];
		$sex = $_GET["sex"];
		$dob = $_GET["dob"];
		$dod = $_GET["dod"];

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
		$newID = $row["id"];

		// create insert statement. depends on date of death and actor/director
		$query = "INSERT INTO ".$identity." VALUES (".$newID.",'".$lname."','".
			$fname."','";
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
	function add_movie($db) {
		// require("database.php");
		//should probably stirp spaces and sanitize first
		$title = $db->real_escape_string($_GET["title"]);
		$company = $db->real_escape_string($_GET["company"]);
		$year = $db->real_escape_string($_GET["year"]);
		$rating = $db->real_escape_string($_GET["rating"]);
		$genre = $_GET["genre"];

		$inputError = 0;
		if (!titleValid($title)) {
			echo "Invald Title<br>";
			$inputError = 1;
		}
		if (!companyValid($company)) {
			echo "Invalid Company<br>";
			$inputError = 1;
		}
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
		$newID = $row["id"];

		// create insert statement. depends on date of death and actor/director
		$query = "INSERT INTO Movie VALUES (".$newID.",'".$title."',".
			$year.",'".$rating."','".$company."');";
		
		echo $query."<br>";

		if (!$rs = queryWrapper($query,$db)) {
			echo "Failed to insert movie <br>";
			return;
		}

		// add movie genres as well. if no genre selected then array is empty and will skip loop
		foreach ($genre as $g) {
			add_movie_genre($db,$newID,$g);
		}
		echo "Movie " . $title ." successfully added! <br>";
		if (!$rs = queryWrapper("update MaxMovieID set id=id+1;",$db)) {
			return;
		}
	}

	function add_m_a_r($db) {
		$actor = $db->real_escape_string($_GET["actor"]);
		$movie = $db->real_escape_string($_GET["movie"]);
		$role = $db->real_escape_string($_GET["role"]);
		$aid = $_GET["actorid"];
		$mid = $_GET["movieid"];
		echo $actor."<br>".$movie."<br>".$role."<br>".$aid."<br>".$mid."<br>";
		$inputError = 0;
		if (!actorValid($actor)) {
			echo "Invald Actor<br>";
			$inputError = 1;
		}
		if (!titleValid($movie)) {
			echo "Invalid Title<br>";
			$inputError = 1;
		}
		if (!roleValid($role)) {
			echo "Invalid Role<br>";
			$inputError = 1;
		}
		if ($inputError) {
			return;
		}

		// create insert statement. depends on date of death and actor/director
		$query = "INSERT INTO MovieActor VALUES (".$mid.",".$aid.",'".$role."');";
		
		echo $query."<br>";

		if (!$rs = queryWrapper($query,$db)) {
			echo "Failed to insert movie actor relation <br>";
			return;
		}

	}
?>