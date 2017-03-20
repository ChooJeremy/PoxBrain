<?php
require_once('./mysqlaccess.php');

$username = "Accounts";
$userID = null;
$shards = 0;
if($auth->isLoggedIn()) {
    $username = $auth->getUsername();
    $userID = $auth->getUserId();
    
    //retrieve information about this user from the db
    $query = "SELECT * FROM UserData WHERE UserID = " . $userID;
    $userCollectionQuery = $mysqli->query($query);
    
    while($row = $userCollectionQuery->fetch_assoc()) {
        $shards = $row["Shards"];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>PoxBrain - <?php echo $username; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="css/account.css" type="text/css" />
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
          <div id="registered">
              <div class="col-md-12">
                  <?php echo $username." - "; echo $shards; Shards ?> 
              </div>
              <div class="col-md-3">
                  <ul>
                      <li onclick="showAccountInfo(this)" class="active">My Account</li>
                      <li onclick="showCollection(this)">Collection</li>
                      <!-- <li onclick="performLogout()">Logout</li> -->
                  </ul>
              </div>
              <div class="col-md-9">
                  <div id="account-info">
                    Your email address is: <?php echo $auth->getEmail(); ?>
                    <div id="change-password">
                      <h2>Change password</h2>
                        <form method="post" action="/accounts/changepassword.php" onsubmit="return attemptChangePassword()">
                          <div>For security reasons, please re-enter your password: </div>
                          <div class="form-group">
                            <input class="form-control" type="password" name="oldpassword" id="oldpassword" placeholder="Old Password"/>
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="New Password" />
                            <input class="form-control" type="password" name="newpassword-confirm" id="newpassword-confirm" placeholder="Re-enter new password" />
                            <div id="password-change-match" class="hide">The two passwords do not match.</div>
                          </div>
                          <input type="submit" value="Change Password" class="btn btn-primary"/>
                        </form>
                        <p id="change-password-result"></p>
                    </div>
                  </div>
                  <div id="collection" class="hide">
                    <h2>Track your collection on PoxNora in PoxBrain!</h2>
                    <p>
                        You can now show your PoxNora collection in PoxBrain! We just need you to follow some steps, then you'll start seeing your collection all over PoxBrain!
                        For example, you'll find collection amounts on search hints (supported in Firefox & Chrome), search results and rune pages! More support is planned, such as collection statistics.
                    </p>
                    <p>Step 1: Make sure you're logged in on <a href="https://www.poxnora.com" target="_blank">poxnora.com</a></p>
                    <p>Step 2: Visit <a href="https://www.poxnora.com/runes/load-forge.do?m=checklist" target="_blank">this page</a>. Select everything (Ctrl+A) and copy it (Ctrl+C) into the text box below:</p>
                    <textarea id="collection-textarea"></textarea>
                    <button id="collection-submit" type="button" class="btn btn-primary" onclick="processCollection()">Step 3: Click here!</button>
                    <p id="collection-help-text"></p>
                  </div>
              </div>
          </div>
          <?php  } ?>
      </div>

      <hr>

      <footer>
        <p>&copy; 2017</p>
      </footer>
    </div> <!-- /container -->
    <?php require_once('./js/corejs.php'); ?>
    <script type="text/javascript" src="js/account.js"></script>
    
    </body>
</html>