<?php
require_once('./mysqlaccess.php');

$showQuantity = $auth->isLoggedIn();

$userChamps = array();
$userSpells = array();
$userRelics = array();
$userEquipment = array();

if ($showQuantity) {
    // user is signed in
    $userID = $auth->getUserId();
    //retrieve all champion records from the UserCollection
    $query = "SELECT * FROM UserCollection WHERE UserID = " . $userID;
    $userCollectionQuery = $mysqli->query($query);
    
    while($row = $userCollectionQuery->fetch_assoc()) {
        if($row["Type"] == 1) {
            $userChamps[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 2) {
            $userRelics[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 3) {
            $userSpells[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 4) {
            $userEquipment[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        }
    }
    
    if(count($userChamps) == 0 || count($userSpells) == 0 || count($userRelics) == 0 || count($userEquipment) == 0) {
        $showQuantity = false;
    }
}
else {
    // user is *not* signed in yet
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>PoxBrain - Collection stats</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css" type="text/css" />
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>

    <div id="main-info" class="container">
      <!-- Example row of columns -->
      <div class="row">
        <?php if(!$auth->isLoggedIn()) { ?>
          <div class="col-md-3"></div>
          <div id="unregistered" class="col-md-6">
              You are not logged in. Please log in.
              <button class="btn btn-primary" onclick="enableLogin()">Log In</button>
          </div>
          <div class="col-md-3"></div>
        <?php } else { ?>
          <div class="col-md-3">
            
          </div>
          <div class="col-md-9">
            <p>Collection statistics:</p>
          </div>
        <?php } ?>
      </div>
      <hr>

      <footer>
        <p>&copy; 2017</p>
      </footer>
    </div> <!-- /container -->
    <?php require_once('./js/corejs.php'); ?>
    
    </body>
</html>