<?php
//Connect to the database
$host = "127.0.0.1";
$user = "choojeremy";
$pass = "";
$db = "c9";
$port = 3306;
$mysqli = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

$table = "";
if($_GET["type"] == 1) {
    $table = "Champions";
} else if($_GET["type"] == 2) {
    $table = "Relics";
} else if($_GET["type"] == 3) {
    $table = "Spells";
} else if($_GET["type"] == 4) {
    $table = "Equipment";
} else if($_GET["type"] == 5) {
    $table = "Conditions";
} else if($_GET["type"] == 6) {
    $table = "Mechanics";
} else if($_GET["type"] == 7) {
    $table = "Ability";
} else {
    die("No such type");
}

if (!($dbCheck = $mysqli->prepare("SELECT * FROM " . $table . " WHERE ID = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
}

if (!$dbCheck->bind_param("i", $_GET["id"])) {
    echo "Binding parameters failed: (" . $dbCheck->errno . ") " . $dbCheck->error; die();
}

if (!$dbCheck->execute()) {
    echo "Execute failed: (" . $dbCheck->errno . ") " . $dbCheck->error;  die();
}

$meta = $dbCheck->result_metadata(); 
while ($field = $meta->fetch_field()) 
{ 
    $params[] = &$row[$field->name]; 
} 

call_user_func_array(array($dbCheck, 'bind_result'), $params); 

while ($dbCheck->fetch()) { 
    foreach($row as $key => $val) 
    { 
        $c[$key] = $val; 
    } 
    $result[] = $c; 
}
$dbCheck->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="search-form" class="navbar-collapse collapse">
          <form class="navbar-form" action="/search.php" method="post" onsubmit="return performSearch()" >
            <div id="search-group">
              <input type="text" id="search" placeholder="Search..." autocomplete="off" class="form-control">
              <input type="text" id="hard-search" disabled="disabled" class="form-control">
              <div id="search-items">
              </div>
            </div>
            <button id="search-submit" type="submit" class="btn btn-success">Go</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!--<div class="factions">
      <div class="container">
        <div class="col-md-6">
            <div id="f-s" class="col-md-3">
                Forglar Swamp
            </div>
            <div id="f-w" class="col-md-3">
                Forsaken Wastes
            </div>
            <div id="i-s" class="col-md-3">
                Ironfist Stronghold
            </div>
            <div id="k-f" class="col-md-3">
                K'thir Forest
            </div>
        </div>
        <div class="col-md-6">
            <div id="s-t" class="col-md-3">
                Savage Tundra
            </div>
            <div id="s-p" class="col-md-3">
                Shattered Peaks
            </div>
            <div id="s-l" class="col-md-3">
                Sundered Lands
            </div>
            <div id="u-d" class="col-md-3">
                Underdepths
            </div>
        </div>
      </div>
    </div>-->
    
    <div class="container" style="padding-top: 20px;">
      <?php echo json_encode($result); ?>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/jquery-3.1.1.min.js"><\/script>')</script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/updatedatabase.js"></script>
    <script src="/js/search.js"></script>
    </body>
</html>
