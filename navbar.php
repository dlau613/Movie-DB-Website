 


  <script>
    $( function() {
        var searchTags = [<?php create_search_tags();?>];
        $( "#search-term" ).autocomplete({
          source: function(request, response) {
            var results = $.ui.autocomplete.filter(searchTags, request.term);
            response(results.slice(0, 10));
          },
          focus: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
          },
          select: function(event,ui) {
            window.location.href = ui.item.value;
            return false;
          },
          change: function(event,ui){
            $(this).val((ui.item ? ui.item.label : ""));
          }
        });
      } );
  </script>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="index.php"> IMBd </a>
      </div> <!-- /.navbar-header -->
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li id="home"><a href="index.php">Home</a></li>
          <li id="addContent" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add Content
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li id="addActor"><a href="add_actor.php">Add Actor/Director</a></li>
              <li id="addMovie"><a href="add_movie.php">Add Movie Information</a></li>
              <li id="addMovieActorRelation"><a href="add_m_a_r.php">Add Movie/Actor Relation</a></li> 
              <li><a href="#">Add Movie/Director Relation</a></li> 
            </ul>
          </li>
          <form method="GET" action="#" class="navbar-form navbar-left">
            <div class="form-group">
              <label for="search-term"></label>
              <input type="text" class="form-control" placeholder="Search Actor or Movie" id="search-term">
            </div>
            <button type="submit" class="btn btn-default" name="search">Submit</button>
          </form>
          <!-- <li><a href="#">Page 1</a></li> -->
        </ul>
      </div> <!-- /.navbar-collapse -->
    </div> <!-- /.container-fluid -->
  </nav>


