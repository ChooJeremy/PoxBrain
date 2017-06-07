<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>PoxBrain Advanced Search</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="css/jumbotron.css" rel="stylesheet">
		<link rel="stylesheet" href="css/main.css" type="text/css" />
		<link rel="stylesheet" href="css/advancedsearch.css" type="text/css" />
		<link rel="stylesheet" href="css/bootstrap-multiselect.css">
	</head>

	<body>
		
		<?php require_once('./header.php'); ?>

		<div id="main-info" class="container">
			<!-- Example row of columns -->
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-8">
					<p class="head">Advanced Search</p>
					<p class="head-section">
						Find runes that match as many of the following as possible:
					</p>
					<div class="search-row">
						<div class="search-left">
							In general, has the following:
						</div>
						<div class="search-right">
							<input id="search-general" class="form-control" type="text" placeholder="" />
						</div>
					</div>
					<div class="search-row">
						<div class="search-left">
							Has abilities that have the following in their names:
						</div>
						<div class="search-right">
							<input id="search-ability-general" class="form-control" type="text" placeholder="e.g. nova, tunnel" />
						</div>
					</div>
					<div class="search-row">
						<div class="search-left">
							Have the following abilities:
						</div>
						<div class="search-right">
							<p id="search-ability">Building ability list. Please wait. Note: JavaScript is required.</p>
						</div>
					</div>
					<div class="search-row">
						<div class="search-left">
							Is a ... (Race)
						</div>
						<div class="search-right">
							<p id="search-race">Building race list. Please wait. Note: JavaScript is required.</p>
						</div>
					</div>
					<div class="search-row">
						<div class="search-left">
							Is a ... (Class)
						</div>
						<div class="search-right">
							<p id="search-class">Building class list. Please wait. Note: JavaScript is required.</p>
						</div>
					</div>
					<div class="search-row">
						<div class="search-right">
							<button class="btn btn-primary" type="button" onclick="doAdvancedSearch()">Search</button>
						</div>
					</div>
				</div>
				<div class="col-md-1 ">
			 	</div>
			</div>

			<hr>

			<footer>
				<p>&copy; 2017</p>
			</footer>
		</div> <!-- /container -->
		<?php require_once('./js/corejs.php'); ?>
		<script src="js/bootstrap-multiselect.js"></script>
		<script src="js/advancedsearch.js"></script>
		</body>
</html>