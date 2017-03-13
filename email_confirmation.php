<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Resend Confirmation Email</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>

    <div class="container" style="text-align: left; margin-top: 20px">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
          <h2>Resend Confirmation Email</h2>
          <p>If you don't see the confirmation email in your inbox, or if the link has expired, you can get another confirmation email here.</p>
          <p>First, enter in the email address you used for the account here:</p>
            <form class="form-inline" action="/accounts/resend_confirmation.php" method="get" onsubmit="return email_confirm();" >
              <input type="email" name="email" id="email_confirm_input" placeholder="Email" class="form-control">
              <button id="email_submit" type="submit" class="btn btn-success">Submit</button>
            </form>
          <p id="email-result"></p>
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
