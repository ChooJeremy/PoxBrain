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
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>
    
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

    <div id="main-info" class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
          <form id="login" class="" method="post" action="login.php" onsubmit="return performLogin()">
            <div class="form-group">
              <label for="login-email">Email address</label>
              <input type="email" class="form-control" id="login-email" name="email" required="required" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="login-password">Password</label>
              <input type="password" class="form-control" id="login-password" name="password" required="required" placeholder="Password">
            </div>
            <div class="checkbox">
              <label for="login-remember">
                <input type="checkbox" name="remember" id="login-remember"> Remember Me
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
        <div class="col-md-6">
          <form id="signup" class="" method="post" action="signup.php" onsubmit="return performRegister()">
            <div class="form-group">
              <label for="register-email">Email address</label>
              <input type="email" class="form-control" id="register-email" name="email" required="required" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="register-password">Password</label>
              <input type="password" class="form-control" id="register-password" name="password" required="required" placeholder="Password">
            </div>
              <div class="form-group">
              <label for="register-password-confirm">Confirm Password</label>
              <input type="password" class="form-control" id="register-password-confirm" name="password-confirm" required="required" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="register-username">Username</label>
              <input type="username" class="form-control" id="register-username" name="username" required="required" placeholder="Username">
            </div>
            <button type="submit" class="btn btn-info">Register</button>
          </form>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; 2017</p>
      </footer>
    </div> <!-- /container -->
    <?php require_once('./js/corejs.php'); ?>
    
    </body>
</html>