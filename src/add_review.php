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
      $id = $_GET["mid"];
    ?>
    <div class="page-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12">
            <h2>Add Review for <?php $title=movie_title_and_year($id); echo '<a href="movie_info.php?mid='.$id.'">'.$title.'</a>'?></h2>
            <form method="GET" action="#">
              <div class="form-group">
                <input type="hidden" id="mid" name="mid" value=<?php echo $id ?>>
              </div>
              <div class="form-group">
                <label for="name">Your name</label>
                <input type="text" name="name"class="form-control" placeholder="Your Name" id="name">
              </div>
              <div class="form-group">
                  <label for="score">Rating</label>
                  <select class="form-control" name="score" id="score">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option selected="selected" value="5">5</option>
                  </select>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="comment" rows="5" placeholder="no more than 500 characters" ></textarea><br> 
              </div>
              <button type="submit" class="btn btn-default" name="add_review">Submit Review</button>
            </form>
          </div>
        </div>
        <div class="row" style="margin-top:20px">
            <div class="col-md-12">
              <?php
                if (isset($_GET["add_review"])) {
                  add_review($db);
                }
              ?>
            </div>
          </div>
      </div>
    </div> 

  

</body>
</html>
