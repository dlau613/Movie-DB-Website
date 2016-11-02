<?php
function fnameValid($name) {
	return !($name == ""or strlen($name)>20);
}
function lnameValid($name) {
	return !($name == "" or strlen($name)>20);
}
function dateValid($date) {
	$valid = "~^\d{4}-\d{2}-\d{2}$~";
  	if (!(preg_match($valid, $date)))
  		return false;
  	$year = (int)substr($date,0,4);
  	$month = (int)substr($date,5,2);
  	$day = (int)substr($date,8,2);
  	if (checkdate($month,$day,$year))
  		return true;
  	return false;
}
function actorValid($actor) {
	return !($actor=="");
}
function titleValid($title) {
	return !($title == "" or strlen($title)>100);
}
function companyValid($company) {
	return !($company == "" or strlen($company)>50);
}
function yearValid($year) {
	$valid = "~^\d+$~";
	return (preg_match($valid,$year));
}
function roleValid($role) {
	return !($role == "" or strlen($role)>50);
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

function movie_title_and_year($id) {
	require("database.php");
	$query = "SELECT title,year FROM Movie WHERE id=".$id.";";
	if (!$rs = queryWrapper($query,$db)) {
		return;
	}
	$row = $rs->fetch_assoc();
	$result = $row["title"]." (".$row["year"].")";
	return $result;
}
function select_directors($db) {
	$query = "SELECT * FROM Director;";
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
		$titleYear[] = addslashes($row["title"]." (".$row["year"].")");
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
		$nameDate[] = addslashes($row["first"]." ".$row["last"]." (".$row["dob"].")");
	}
	$length = count($ids);
	$i=0;
	for ($i=0; $i<$length;$i++) {
		echo '{label: "'.$nameDate[$i].'", value: "'.$ids[$i].'"},';
	}
}

function create_director_tags() {
	require("database.php");
	$directors = select_directors($db);
	$ids = [];
	$nameDate = [];
	foreach ($directors as $row) {
		$ids[] = $row["id"];
		$nameDate[] = addslashes($row["first"]." ".$row["last"]." (".$row["dob"].")");
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
	$directors = [];
	while ($row = $rs->fetch_assoc()) {
		$directors[] = $row["first"]." ".$row["last"]." (".$row["dob"].")";
	}
	$director = implode(", ",$directors);

	$query = "SELECT AVG(rating) as avg_score, COUNT(*) as num_review FROM Review WHERE mid=".$id.";";
	if (!$rs = queryWrapper($query,$db)) {
		return;
	}
	$row = $rs->fetch_assoc();
	$avg_score = round($row["avg_score"],1);	
	$num_review = $row["num_review"];
	



	echo 	'<div class="container-fluid">
				<div class="row">
					<div class="col-xs-9">
						<span class="h2">'.$title.'<small> ('.$year.')</small></span><br>
						<span class="h5">'.$rating;
							if (!empty($genre)) {
								echo '&nbsp &nbsp | &nbsp &nbsp'.implode(", ",$genre);
							}
	echo 				'</span><br>
						<span class="h5">Director: '.$director.'</span><br>
						<span class="h5">Company: '.$company.'</span>
					</div>
					<div class="col-xs-3 text-right">
						<span class="h3">'.$avg_score.'<small>/5<br>'.$num_review.' votes</small></span>
					</div>
				</div>';
						
	echo	'<div class="container-fluid">
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
			<h3>User Reviews</h3>';

	$query = "SELECT * FROM Review WHERE mid=".$id.";";
	if (!$rs = queryWrapper($query,$db)) {
		return;
	}
	while ($row = $rs->fetch_assoc()) {
		$score = $row["rating"];
		$name = $row["name"];
		$time = $row["time"];
		$comment = $row["comment"];
		echo $score.' out of 5 | by '.$name.
			' | '.$time.'<br>'.$comment.'<br><br>';
	}

	echo	'<a href="add_review.php?mid='.$id.'">Add Review</a>'.'
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
		$names[] = addslashes($row["first"]." ".$row["last"]);
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
		$titles[] = addslashes($row["title"]." (".$row["year"].")");
	}
	$length = count($mids);
	for ($i=0;$i<$length;$i++) {
		echo '{label: "'.$titles[$i].'", value: "movie_info.php?mid='.$mids[$i].'"},';
	}
}

function add_actor($db) {
	// require('database.php');
	//should probably stirp spaces and sanitize first
	$identity = $db->real_escape_string($_GET["identity"]);
	$fname = $db->real_escape_string($_GET["first_name"]);
	$lname = $db->real_escape_string($_GET["last_name"]);
	$sex = $db->real_escape_string($_GET["sex"]);
	$dob = $db->real_escape_string($_GET["dob"]);
	$dod = $db->real_escape_string($_GET["dod"]);

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
	
	// echo $query."<br>";


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
	
	// echo $query."<br>";

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

function search_actor_results($search_term) {
	require("database.php");
	$words = explode(" ",$db->real_escape_string($search_term));
	$concat = 'concat(first," ",last) ';
	$concatLike = [];
	foreach ($words as $val) {
		$concatLike[] = $concat.'LIKE "%'.$val.'%"';
	}
	$concatLikeAnd = implode(" AND ",$concatLike);
	$query = "SELECT id,first,last,dob FROM Actor WHERE ".$concatLikeAnd;
	if (!$rs = queryWrapper($query,$db)) {
		echo "Search Failed <br>";
		return;
	}

	while($row = $rs->fetch_assoc()) {
		$name = $row["first"]." ".$row["last"];
		echo 	'<tr><td><a href="actor_info.php?aid='.$row["id"].'">'.$name.'</a></td><td>'.$row["dob"].'</td></tr>';
	}
}

function search_movie_results($search_term) {
	require("database.php");
	$words = explode(" ",$db->real_escape_string($search_term));
	$titleLike = [];
	foreach ($words as $val) {
		$titleLike[] = 'title LIKE "%'.$val.'%"';
	}
	$titleLikeAnd = implode(" AND ",$titleLike);
	$query = "SELECT id,title,year FROM Movie WHERE ".$titleLikeAnd;
	if (!$rs = queryWrapper($query,$db)) {
		echo "Search Failed <br>";
		return;
	}
	while($row = $rs->fetch_assoc()) {
		$title = addslashes($row["title"]);
		echo 	'<tr><td><a href="movie_info.php?mid='.$row["id"].'">'.$title.'</a></td><td>'.$row["year"].'</td></tr>';
	}
}

function add_m_d_r($db) {
	$director = $db->real_escape_string($_GET["director"]);
	$movie = $db->real_escape_string($_GET["movie"]);
	$did = $_GET["directorid"];
	$mid = $_GET["movieid"];

	$inputError = 0;
	if (!actorValid($director)) {
		echo "Invald Director<br>";
		$inputError = 1;
	}
	if (!titleValid($movie)) {
		echo "Invalid Title<br>";
		$inputError = 1;
	}
	if ($inputError) {
		return;
	}

	// create insert statement. depends on date of death and actor/director
	$query = "INSERT INTO MovieDirector VALUES (".$mid.",".$did.");";
	echo $query."<br>";
	if (!$rs = queryWrapper($query,$db)) {
		echo "Failed to insert movie director relation <br>";
		return;
	}
	echo 'Successfully added '.$director.
		' as director to <a href="movie_info.php?mid='.$mid.'">'.$movie.'</a>!';
}

function add_m_a_r($db) {
	$actor = $db->real_escape_string($_GET["actor"]);
	$movie = $db->real_escape_string($_GET["movie"]);
	$role = $db->real_escape_string($_GET["role"]);
	$aid = $_GET["actorid"];
	$mid = $_GET["movieid"];

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
	
	// echo $query."<br>";

	if (!$rs = queryWrapper($query,$db)) {
		echo "Failed to insert movie actor relation <br>";
		return;
	}
	echo 'Successfully added <a href="actor_info.php?aid='.$aid.'">'.$actor.
		'</a> to <a href="movie_info.php?mid='.$mid.'">'.$movie.'</a> as '.$role.'!';

}

function add_review() {
	require("database.php");
	$mid = $db->real_escape_string($_GET["mid"]);
	$comment = $db->real_escape_string($_GET["comment"]);
	$name = $db->real_escape_string($_GET["name"]);
	if (!fnameValid($name)) {
		echo 'Invalid Name';
		return;
	}
	$score = $db->real_escape_string($_GET["score"]);
	$timestamp = date('Y-m-d H:i:s');
	$title = movie_title_and_year($mid);
	$query = "INSERT INTO Review VALUES('".$name."', '".$timestamp."', ".$mid.", ".$score.", '".$comment."');";
	if (!$rs = queryWrapper($query,$db)) {
		echo "Failed to Add Review <br>";
		return;
	}
	echo 'Successfully Added Review for <a href="movie_info.php?mid='.$mid.'">'.$title.'</a>!<br>';

}
?>








