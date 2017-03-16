<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>PoxBrain</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css" type="text/css" />
  </head>

  <body>
    <?php require_once('./header.php'); ?>

    <div id="main-info" class="container" style="margin-top: 30px;">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <?php if(!isset($_GET["selector"]) && !isset($_GET["token"])) { ?>
            <p>If you've forgotten your password, enter your email into the field below. We'll send you an email with further instructions.</p>
            <form class="form-group" method="post" action="accounts/resetpassword.php" onsubmit="return sendresetpassword()">
              <input class="form-control" id="password-reset-email" name="email" placeholder="Email" />
              <input type="submit" class="btn btn-primary" />
            </form>
            <p id="email-reset-result"></p>
          <?php } else if($auth->canResetPassword($_GET['selector'], $_GET['token']) || true) { ?>
            <form class="form-group" method="post" action="accounts/resetpassword.php" onsubmit="return sendresetpasswordrequest()">
              <h3>Password Reset Request</h3>
              <input class="form-control" type="password" id="password-reset-field" name="password" placeholder="New Password">
              <input class="form-control" type="password" id="password-reset-confirm" name="password-confirm" placeholder="New Password (Again)">
              <p id="reset-password-match" style="color: red;" class="hide">The two passwords do not match</p>
              <input type="hidden" value="<?php echo $_GET['selector']; ?>" id="selector" name="selector" />
              <input type="hidden" value="<?php echo $_GET['token']; ?>" id="token" name="token" />
              <input type="submit" class="btn btn-primary" />
              <p id="password-reset-result"></p>
            </form>
          <?php } else { ?>
            <p>Invalid link. Either it is not copied fully or it has expired. If you'd like to attempt another request, fill in your email below: </p>
            <form class="form-group" method="post" action="accounts/resetpassword.php" onsubmit="return sendresetpassword()">
              <input class="form-control" id="password-reset-email" name="email" placeholder="Email" />
              <input type="submit" class="btn btn-primary" />
            </form>
            <p id="email-reset-result"></p>
          <?php } ?>
        </div>
        <div class="col-md-3">
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2017</p>
      </footer>
    </div> <!-- /container -->
    <?php require_once('./js/corejs.php'); ?>
    <script src="js/forgetpassword.js"></script>
    
    </body>
</html>