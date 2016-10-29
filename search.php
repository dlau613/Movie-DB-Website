<?php 
  require_once("database.php");
  require_once("queries.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>IMBd Movies and Actors IMBd</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link href="css/project1c.css" rel="stylesheet">
    
  </head>
  <body>
    <?php
      require("navbar.php");
    ?>
    <script>
      document.getElementById("addMovieActorRelation").className="active";
    </script>
    <div class="page-content">
      <div class="container-fluid">
        <h2>Actors</h2>
        <div class="table-responsive">
          <table class="table table-striped table-condensed table-hover">
            <thead>
              <tr><th>Name</th><th>Born</th></tr>
            </thead>
            <tbody>
            <?php
              $search = $_GET["search-term"];
              search_actor_results($search);
            ?>
            </tbody>
          </table>
        </div>
        <h2>Movies</h2>
        <div class="table-responsive">
          <table class="table table-striped table-condensed table-hover">
            <thead>
              <tr><th>Title</th><th>Year</th></tr>
            </thead>
            <tbody>
            <?php
              $search = $_GET["search-term"];
              search_movie_results($search);
            ?>
            </tbody>
          </table>
        </div>
      </div>
      </div>
    </div> 
</body>
</html>
