<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Email Verification</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>

    <div id="main-info" class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
          <h2>Email Verification</h2>
          <?php
            require_once('./mysqlaccess.php');
            if(!isset($_GET['selector'], $_GET['token'])) { ?>
                <p>Incomplete link. Please ensure that the link you followed is complete. If the link was correct, you can try getting another email.</p>
                <p><a class="btn btn-default" href="/email_confirmation" role="button">Get another email</a></p> 
            <?php } else { 
              try {
                  $auth->confirmEmail($_GET['selector'], $_GET['token']);
              
                  // email address has been verified
                  ?>
                  <p>Your email address has been verified. You can log in now.</p>
                  <button class="btn btn-primary" onclick="enableLogin()">Log In</button>
                  <?php
              }
              catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
                  // invalid token
                  ?>
                  <p>Invalid Token. Please ensure that the link you followed is complete. If the link was correct, you can try getting another email.</p>
                  <p><a class="btn btn-default" href="/email_confirmation" role="button">Get another email</a></p> 
                  <?php
              }
              catch (\Delight\Auth\TokenExpiredException $e) {
                  // token expired
                  ?>
                  <p>Token expired. You took too long to verify your email.</p>
                  <p><a class="btn btn-default" href="/email_confirmation" role="button">Try again</a></p> 
                  <?php
              }
              catch (\Delight\Auth\TooManyRequestsException $e) {
                  // too many requests
                  echo "<p>Too Many Requests have been made from this IP. Please try again later.</p>";
              }
            }
          ?>
        </div>
        <div class="col-md-2">
       </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2017</p>
      </footer>
    </div> <!-- /container -->
    <?php require_once('./js/corejs.php'); ?>
    <script type="text/javascript" src="js/email_confirmation.js"></script>
    
    </body>
</html>
