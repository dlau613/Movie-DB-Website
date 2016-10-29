<?php
  // require_once("database.php");
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
      require("queries.php");
      require_once("database.php");
      require("navbar.php");
    ?>
    <script>
      document.getElementById("addContent").className="active";
      document.getElementById("addActor").className="active";
    </script>
      <div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <!-- <div class="col-sm-12 col-sm-offset-3 col-md-10 col-md-offset-2 main"> -->
            <div class="col-md-12">
              <h2>Add New Actor/Director</h2>
              <form method = "GET" action="#">
                <label class="radio-inline">
                  <input type="radio" checked="checked" name="identity" value="Actor"/>Actor
                </label>
                <label class="radio-inline">
                  <input type="radio" name="identity" value="Director"/>Director
                </label>
                <div class="form-group">
                  <label for="first_name">First Name</label>
                  <input type="text" class="form-control" placeholder="First Name"  name="first_name" id="first_name"/>
                </div>
                <div class="form-group">
                  <label for="last_name">Last Name</label>
                  <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name"/>
                </div>
                <label class="radio-inline">
                    <input type="radio" name="sex" checked="checked" value="male">Male
                </label>
                <label class="radio-inline">
                    <input type="radio" name="sex" value="female">Female
                </label>
                <div class="form-group">
                  <label for="dob">Date of Birth</label>
                  <input type="text" class="form-control" placeholder="YYYY-MM-DD" name="dob" id="dob">
                </div>
                <div class="form-group">
                  <label for="dod">Date of Death</label>
                  <input type="text" class="form-control" placeholder="Leave Blank if Alive" name="dod" id="dod">
                </div>
                <button type="submit" class="btn btn-default" name="add_actor" >Add!</button>
              </form>
            </div>
          </div>
          <div class="row" style="margin-top:20px">
            <div class="col-md-12">
              <?php
                if (isset($_GET["add_actor"])) {
                  add_actor($db);
                }
              ?>
            </div>
          </div>
        </div> <!-- /.container-fluid -->
      </div>

  

</body>
</html>
