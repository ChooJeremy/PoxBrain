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
    <link rel="stylesheet" href="css/collectionstart.css" type="text/css" />
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>
    
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <h2>Track your collection on PoxNora in PoxBrain!</h2>
          <p>
            You can now show your PoxNora collection in PoxBrain! We just need you to follow some steps, then you'll start seeing your collection all over PoxBrain!
            For example, you'll find collection amounts on search hints (supported in Firefox & Chrome), search results and rune pages! More support is planned, such as collection statistics.
          </p>
          <?php if(!$auth->isLoggedIn()) { ?>
          <p>To do so, you first need to create an account. We need someone to associate the collection with, after all!</p>
          <form id="collection-register" method="post" action="signup.php" onsubmit="return collectionRegister()">
            <div class="form-group">
              <label for="email">Email address: </label>
              <input type="email" class="form-control" id="collection-register-email" name="email" required="required" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="password">Password: </label>
              <input type="password" class="form-control" id="collection-register-password" name="password" required="required" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="password-confirm">Confirm Password: </label>
              <input type="password" class="form-control" id="collection-register-password-confirm" name="password-confirm" required="required" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="username">Username: </label>
              <input type="username" class="form-control" id="collection-register-username" name="username" required="required" placeholder="Username">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
          </form>
          <p id="signup-result"></p>
          <div id="login-div">
            <form id="collection-login" method="post" action="login.php" onsubmit="return collectionLogin()">
              <div class="form-group">
                <label for="email">Email address: </label>
                <input type="email" class="form-control" id="collection-login-email" name="email" required="required" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="password">Password: </label>
                <input type="password" class="form-control" id="collection-login-password" name="password" required="required" placeholder="Password">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember" id="collection-login-remember"> Remember Me
                </label>
              </div>
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p id="login-result"></p>
          </div>
          <?php } ?>
          <div id="collection-div" <?php if($auth->isLoggedIn()) { echo "style=\"display: block;\""; } ?> >
            <p>Please make sure you're logged in on <a href="https://www.poxnora.com" target="_blank">poxnora.com</a></p>
            <p>Next, we need you to visit <a href="https://www.poxnora.com/runes/load-forge.do?m=checklist" target="_blank">this page</a>. Select everything (Ctrl+A) and copy it (Ctrl+C) into the text box below:</p>
            <textarea id="c-textarea"></textarea>
            <button id="c-submit" type="button" class="btn btn-primary" onclick="collectionComplete()">Finish</button>
            <p id="c-help-text"></p>
          </div>
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
    <script type="text/javascript" src="js/collectionstart.js"></script>
    
    </body>
</html>
