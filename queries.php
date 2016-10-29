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
		if (!$rs = $db->query($query)) {
			$errmsg = $db->error;
			print "Query failed: $errmsg <br />";
		}
		return $rs;
	}

	function select_movies($db) {
		$query = "SELECT * FROM Movie;";
		if (!$rs = queryWrapper($query,$db)) {
			return [];
		}
		$results = [];
		while($row = $rs->fetch_assoc()) {
			$results[] = $row;
		}
		return $results;
	}
	function select_actors($db) {
		$query = "SELECT * FROM Actor;";
		if (!$rs = queryWrapper($query,$db)) {
			return [];
		}
		$results = [];
		while($row = $rs->fetch_assoc()) {
			$results[] = $row;
		}
		return $results;
	}
	// function get_movies_id_title_year($db) {
	// 	$query = "SELECT id,title,year FROM Movie;";
	// 	if (!$rs = queryWrapper($query,$db)) {
	// 		return [];
	// 	}
	// 	$results = [];
	// 	while($row = $rs->fetch_assoc()) {
	// 		$results[] = $row;
	// 	}
	// 	return $results;
	// }

	// function get_actors_id_first_last_dob($db) {
	// 	$query = "SELECT id,first,last,dob FROM Actor;";
	// 	$results = [];
	// 	if (!$rs = queryWrapper($query,$db)) {
	// 		return $results;
	// 	}
	// 	while($row = $rs->fetch_assoc()) {
	// 		$results[] = $row;
	// 	}
	// 	return $results;
	// }

	// function get_actors_id_first_last($db) {
	// 	$query = "SELECT id,first,last FROM Actor;";
	// 	if (!$rs = queryWrapper($query,$db)) {
	// 		return [];
	// 	}
	// 	$actors = [];
	// 	while($row = $rs->fetch_assoc()) {
	// 		$actors[] = $row;
	// 	}
	// 	return $actors;
	// }

	// function get_movies_id_title($db) {
	// 	$query = "SELECT id,title FROM Movie;";
	// 	if (!$rs = queryWrapper($query,$db)) {
	// 		return [];
	// 	}
	// 	$movies = [];
	// 	while($row = $rs->fetch_assoc()) {
	// 		$movies[] = $row;
	// 	}
	// 	return $movies;
	// }
	function create_movie_tags() {
		require("database.php");
		// $movies = get_movies_id_title_year($db);
		$movies = select_movies($db);
		$ids = [];
		$titleYear = [];
		foreach ($movies as $row) {
			$ids[] = $row["id"];
			$titleYear[] = $row["title"]." (".$row["year"].")";
		}
		$length = count($ids);
		$i=0;
		for ($i=0; $i<$length;$i++) {
			echo '{label: "'.$titleYear[$i].'", value: "'.$ids[$i].'"},';
		}
	}
	
	function create_actor_tags() {
		require("database.php");
		// $actors = get_actors_id_first_last_dob($db);
		$actors = select_actors($db);
		$ids = [];
		$nameDate = [];
		foreach ($actors as $row) {
			$ids[] = $row["id"];
			$nameDate[] = $row["first"]." ".$row["last"]." (".$row["dob"].")";
		}
		$length = count($ids);
		$i=0;
		for ($i=0; $i<$length;$i++) {
			echo '{label: "'.$nameDate[$i].'", value: "'.$ids[$i].'"},';
		}
	}
	function show_actor_info($id) {
		require("database.php");
		$query = "SELECT * FROM Actor WHERE id=".$id.";";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		$row = $rs->fetch_assoc();
		$name = $row["first"]." ".$row["last"];
		$sex = $row["sex"];
		$dob = $row["dob"];
		$dod = ($row["dod"]==null) ? "Alive" : $row["dod"];
		echo 	'<div class="container-fluid">
				<h2>Actor Information</h2>
				<div class="table-responsive"> 
                	<table class="table table-hover">
                		<thead> 
                			<tr><th>Name</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>
		              	</thead>
        				<tbody>
        					<tr>
		        				<td>'.$name.'</td>
		        				<td>'.$sex.'</td>
		        				<td>'.$dob.'</td>
		        				<td>'.$dod.'</td>
		        			</tr>
		        		</tbody>
		        	</table>
		        </div>
		        <h3>Filmography</h3>';
		echo 	'<div class="table-responsive">
					<table class="table table-striped table-condensed table-hover">
						<thead>
							<tr><th>Movie Title</th><th>Role</th><th>Year</th></tr>
						</thead>
						<tbody>';

		$query = "SELECT mid,title,year,role FROM MovieActor AS A, Movie AS B WHERE A.aid=".$id." AND A.mid=B.id;";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		while($row = $rs->fetch_assoc()) {
			echo 	'<tr><td><a href="movie_info.php?mid='.$row["mid"].'">'.$row["title"].'</a></td><td>'.$row["role"].'</td><td>'.$row["year"].'</td></tr>';
		}

		echo 			'</tbody>
					</table>
				</div>
			</div>';



	}
	
	function show_movie_info($id) {
		require("database.php");
		$query = "SELECT * FROM Movie WHERE id=".$id.";";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		$row = $rs->fetch_assoc();
		$title = $row["title"];
		$year = $row["year"];
		$company = $row["company"];
		$rating = $row["rating"];
		
		$query = "SELECT genre FROM MovieGenre WHERE mid=".$id.";";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		$genre = [];
		while ($row = $rs->fetch_assoc()) {
			$genre[] = $row["genre"];
		}
		$query = "SELECT first,last,dob FROM MovieDirector as M, Director as D WHERE M.mid=".$id." AND M.did=D.id;";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		$row = $rs->fetch_assoc();
		$director = $row["name"]." ".$row["last"]." (".$row["dob"].")";

		echo 	'<div class="container-fluid ">
					<div class="row">
						<div class="col-xs-10">
							<span class="h2">'.$title.'<small> ('.$year.')</small></span>
						</div>
						<div class="col-xs-2">
							<span class="h3">Score</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<span class="h5">'.$rating;
								if (!empty($genre)) {
									echo '&nbsp &nbsp | &nbsp &nbsp'.implode(", ",$genre);
								}
		echo				'</span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<span class="h5">Director: '.$director.
							'</span>
						</div>
						<div class="col-xs-12">
							<span class="h5">Company: '.$company.
							'</span>
						</div>
					</div>
				</div>
				<div class="container-fluid">
				<h2>Cast</h2>';

		echo 	'<div class="table-responsive">
					<table class="table table-striped table-condensed table-hover">
						<thead>
							<tr><th>Name</th><th>Role</th></tr>
						</thead>
						<tbody>';

		$query = "SELECT aid,role,first,last FROM MovieActor AS MA, Actor AS A WHERE MA.mid=".$id." AND A.id=MA.aid;";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		while($row = $rs->fetch_assoc()) {
			$name = $row["first"]." ".$row["last"];
			echo 	'<tr><td><a href="actor_info.php?aid='.$row["aid"].'">'.$name.'</a></td><td>'.$row["role"].'</td></tr>';
		}

		echo 			'</tbody>
					</table>
				</div>
			</div>';

		// echo 	'<div class="table-responsive"> 
  //               	<table class="table table-hover">
  //               		<thead> 
  //               			<tr><th>Title</th><th>Sex</th><th>Date of Birth</th><th>Date of Death</th></tr>
		//               	</thead>
  //       				<tbody>
  //       					<tr>
		//         				<td>'.$name.'</td>
		//         				<td>'.$sex.'</td>
		//         				<td>'.$dob.'</td>
		//         				<td>'.$dod.'</td>
		//         			</tr>
		//         		</tbody>
		//         	</table>
		//         </div>
		//         <h3>Filmography</h3>';
		// echo 	'<div class="table-responsive">
		// 			<table class="table table-striped table-condensed table-hover">
		// 				<thead>
		// 					<tr><th>Movie Title</th><th>Role</th><th>Year</th></tr>
		// 				</thead>
		// 				<tbody>';

		$query = "SELECT mid,title,year,role FROM MovieActor AS A, Movie AS B WHERE A.aid=".$id." AND A.mid=B.id;";
		if (!$rs = queryWrapper($query,$db)) {
			return;
		}
		while($row = $rs->fetch_assoc()) {
			echo 	'<tr><td><a href="movie_info.php?mid='.$row["mid"].'">'.$row["title"].'</a></td><td>'.$row["role"].'</td><td>'.$row["year"].'</td></tr>';
		}

		echo 			'</tbody>
					</table>
				</div>';


	}

	function create_search_tags() {
		require("database.php");
		$aids = [];
		$names = [];
		// $actors = get_actors_id_first_last($db);
		$actors = select_actors($db);
		foreach ($actors as $row) {
			$aids[] = $row["id"];
			$names[] = $row["first"]." ".$row["last"];
		}
		$length = count($aids);
		for ($i=0;$i<$length;$i++) {
			echo '{label: "'.$names[$i].'", value: "actor_info.php?aid='.$aids[$i].'"},';
		}

		$mids = [];
		$titles = [];
		// $movies = get_movies_id_title($db);
		$movies = select_movies($db);
		foreach ($movies as $row) {
			$mids[] = $row["id"];
			$titles[] = $row["title"]." (".$row["year"].")";
		}
		$length = count($mids);
		for ($i=0;$i<$length;$i++) {
			echo '{label: "'.$titles[$i].'", value: "movie_info.php?mid='.$mids[$i].'"},';
		}

		// echo '{label: "Sao Paulo", value: "actor_info.php?aid=1"},
  //                    {label: "Sorocaba", value: "actor_info.php?aid=2"},
  //                    {label: "Paulinia", value: 3},
  //                    {label: "Sao Roque", value: 4}';
	
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