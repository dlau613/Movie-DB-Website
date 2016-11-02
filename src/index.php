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
      $page = "home";
      require("navbar.php");
    ?>
    <script>
      document.getElementById('home').className='active';
    </script>
    <div class='page-content'>
        <div class='container-fluid'>
          <div class='jumbotron'>
            Instructions! <br><br>

             Use the Search bar at the top of the page to search for actors/actresses and movies.<br>
             Pressing submit will show a search page with all matches.<br>
             Selecting an option from the autocomplete list will take you directly to the page.<br><br>
             The Add Content dropdown menu will take you to pages to let you add new actors/directors,
             movies, and movie/actor and movie/director relationships.


          </div>
          <div class="row" style="margin-top:20px">
            <div class='col-md-12'>
              <?php
                // create_search_tags();
                // if (isset($_GET['add_actor'])) {
                //   add_actor();
                // }
              ?>
            </div>
          </div>
        </div> <!-- /.container -->
      </div>
    

  

</body>
</html>
