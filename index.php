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

    <div id="main-info" class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
          <h2>New update: Search by ability</h2>
          <p>
            There's been a new update to PoxBrain. New features include the ability to search by ability!
            You can search by ability by searching as <a href='search.php?search=ability:"ability-here"'>ability:"ability-here"</a>. For example, to try and find champions with flight, teleport, leap and charge, you can try the search term:
            <a href='/search.php?search=ability:"flight" ability:"leap" ability:"teleport" ability:"charge"'>ability:"flight" ability:"leap" ability:"teleport" ability:"charge"</a> Note that no champion has all of these abilities, so you'll see champions with as many of them as possible.
            <p>You'll also find a button to search for champions with this ability when you're on an ability page like the following:</p>
          </p>
          <p><a class="btn btn-default" href="/rune.php?id=2501&type=7" role="button">Look at Cast: Light as a Feather</a></p>
        </div>
        <div class="col-md-6">
          <h2>A new database?</h2>
          <p>This site is currently available for testing. Please report any bugs, inconsistencies or any comments onto the forum thread.</p>
          <p>Try out the search function and the rune viewing option! (Start by searching any term on the top right)</p>
          <p><a class="btn btn-default" href="http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/" role="button">View thread</a></p>
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