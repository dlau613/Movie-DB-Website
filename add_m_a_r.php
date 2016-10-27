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
    <script>
      $( function() {
        var actorTags = [<?php $arr = get_actors();echo '"'.implode('","',$arr).'"'?>];
        $( "#actortags" ).autocomplete({
          source: function(request, response) {
            var results = $.ui.autocomplete.filter(actorTags, request.term);
            response(results.slice(0, 10));
          }
        });
      } );
      $( function() {
        var movieTags = [<?php $arr = get_movies();echo '"'.implode('","',$arr).'"'?>];
        $( "#movietags" ).autocomplete({
          source: function(request, response) {
            var results = $.ui.autocomplete.filter(movieTags, request.term);
            response(results.slice(0, 10));
          }
        });
      } );
    </script>
  </head>
  <body>
    <?php
      require("navbar.php");
    ?>
    <script>
      document.getElementById("addMovieActorRelation").className="active";
    </script>
      <div class="page-content">
        <div class="horizontal-center">
        <div class="container border">
          <div class="row">
            <!-- <div class="col-sm-12 col-sm-offset-3 col-md-10 col-md-offset-2 main"> -->
            <div class="col-md-12">
              <h2>Add Movie Actor Relation</h2>
              <form method="GET" action="#">
                <div class="ui-widget">
                  <label for="actortags">Actor: </label>
                  <input id="actortags" name="actor">
                </div>
                <div class="ui-widget">
                  <label for="movietags">Movie: </label>
                  <input id="movietags" name="movie">
                </div>
                <div class="form-group">
                  <label for="Role">Role:</label>
                  <input type="text" class="form-control" placeholder="Role" name="role" id="role">
                </div>
                <button type="submit" class="btn btn-default" name="add_m_a_r">Add!</button>
              </form>
            </div>
          </div>
          <div class="row" style="margin-top:20px">
            <div class="col-md-12">
              <?php
                if (isset($_GET["add_m_a_r"])) {
                  add_m_a_r($db);
                }
              ?>
            </div>
          </div>
        </div> <!-- /.container-fluid -->
        </div>
      </div>

  

</body>
</html>
