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
        var availableTags = [
                     {label: "Sao Paulo", value: 1},
                     {label: "Sorocaba", value: 2},
                     {label: "Paulinia", value: 3},
                     {label: "Sao Roque", value: 4},
        ]; 
        var actorTags = [<?php create_actor_tags();?>];
        $( "#actortags" ).autocomplete({
          source: function(request, response) {
            var results = $.ui.autocomplete.filter(actorTags, request.term);
            response(results.slice(0, 10));
          },
          // source: availableTags,
          focus: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
          },
          select: function(event,ui) {
            $("#actorid").val(ui.item.value);
            return false;
          },
          change: function(event,ui){
            $(this).val((ui.item ? ui.item.label : ""));
          }
        });
      } );
      $( function() {
        var movieTags = [<?php create_movie_tags()?>];
        $( "#movietags" ).autocomplete({
          source: function(request, response) {
            var results = $.ui.autocomplete.filter(movieTags, request.term);
            response(results.slice(0, 10));
          },
          focus: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
          },
          select: function(event,ui) {
            $("#movieid").val(ui.item.value);
            return false;
          },
          change: function(event,ui){
            $(this).val((ui.item ? ui.item.label : ""));
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
      document.getElementById("addContent").className="active";
      document.getElementById("addMovieActorRelation").className="active";
    </script>
      <div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <!-- <div class="col-sm-12 col-sm-offset-3 col-md-10 col-md-offset-2 main"> -->
            <div class="col-md-12">
              <h2>Add Movie Actor Relation</h2>
              <form method="GET" action="#">
                <div class="form-group">
                  <label for="actortags">Actor: </label>
                  <input type="text" class="form-control" id="actortags" name="actor">
                </div>
                <div class="form-group">
                  <label for="movietags">Movie: </label>
                  <input type="text" class="form-control" id="movietags" name="movie">
                </div>
                <div class="form-group">
                  <label for="Role">Role:</label>
                  <input type="text" class="form-control" placeholder="Role" name="role" id="role">
                </div>
                <div class="form-group">
                  <label for="actorid">aid</label>
                  <input type="text" class="form-control" id="actorid" name="actorid">
                </div>
                <div class="form-group">
                  <label for="movieid">mid</label>
                  <input type="number" class="form-control" id="movieid" name="movieid">
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

  

</body>
</html>
