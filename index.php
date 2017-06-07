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
				<div class="col-md-4">
					<h2>Track your PoxNora collection on PoxBrain!</h2>
					<p>
						You can now save your PoxNora collection here, which will allow you to see how much of each rune you own on PoxBrain, such as in search results. You'll be able to filter by owned quantity while searching as well.
						All you need is an account here so we can link your collection to someone.
					</p>
					<p><a class="btn btn-default" href="/collectionstart" role="button">Get Started</a></p>
					<p>
						Other changes: <br />
						I think search might be somewhat confusing with all the different potential options, so I made a guided search page. It should now be significantly easier and simpler to find what you're looking for, like any runes that you need for quests.
					</p>
					<p><a class="btn btn-default" href="/advancedsearch" role="button">Try a guided search</a></p>
				</div>
				<div class="col-md-4">
					<h2>New update: Search by ability</h2>
					<p>
						There's been a new update to PoxBrain. New features include the ability to search by ability!
						You can search by ability by searching as <a href='search?search=ability:"ability-here"'>ability:"ability-here"</a>. For example, to try and find champions with flight, teleport, leap and charge, you can try the search term:
						<a href='/search?search=ability:"flight" ability:"leap" ability:"teleport" ability:"charge"'>ability:"flight" ability:"leap" ability:"teleport" ability:"charge"</a> Note that no champion has all of these abilities, so you'll see champions with as many of them as possible.
						<p>You'll also find a button to search for champions with this ability when you're on an ability page like the following:</p>
					</p>
					<p><a class="btn btn-default" href="/rune?id=2501&type=7" role="button">Look at Cast: Light as a Feather</a></p>
					<p>All of the above is simplified now, you can perform a <a class="btn btn-default" href="/advancedsearch" role="button">Guided search</a></p>
				</div>
				<div class="col-md-4">
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