<html>
	<?php include "../inc/dbinfo.inc"; ?>
    
	<head>
		<meta name="google-signin-client_id" content="50844503444-be95c6rb3kt3vjqsmue2ss4osic08atg.apps.googleusercontent.com">
		<link href="css/stylemain.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<?php include 'css/templates/header.html' ?>
		<div class="container" style="display:block;">
			<div class="row">
				<div class="col-md-12">
					<h1> James Scotlands Stock App </h1>
				</div>
			</div>			
			<div class="row"> 
				<div class="col-md-12">
					<div id="resultsTable">
					<p> It looks like you have not signed into an google account, please sign in to see your inventory</p>
						</div>
				</div>
			</div>
		</div>
		<?php include 'css/templates/footer.html' ?>
		<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
		<script src="scripts/main.js"></script>
	</body>
</html>