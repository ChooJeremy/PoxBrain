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
    <link rel="stylesheet" href="css/account.css" type="text/css" />
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
            <h3>Login into your PoxBrain account</h3>
            <div class="form-group row">
              <label class="col-sm-2" for="login-email">Email address</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="login-email" name="email" required="required" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2" for="login-password">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="login-password" name="password" required="required" placeholder="Password">
              </div>
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
            <h3>Register for a new account.</h3>
            <div class="form-group row">
              <label class="col-sm-2" for="register-email">Email address</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="register-email" name="email" required="required" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2" for="register-password">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="register-password" name="password" required="required" placeholder="Password">
              </div>
            </div>
              <div class="form-group row">
              <label class="col-sm-2" for="register-password-confirm">Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="register-password-confirm" name="password-confirm" required="required" placeholder="Password">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2" for="register-username">Username</label>
              <div class="col-sm-10">
                <input type="username" class="form-control" id="register-username" name="username" required="required" placeholder="Username">
              </div>
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