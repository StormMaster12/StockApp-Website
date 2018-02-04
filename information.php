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
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 id="productName">Product Name</h1>
					<h2 id="productBrand">Product Brand</h2>
				</div>
			</div>
			<div class="row">
				<div id="nutritionInformation" class="col-md-12">
					<h3>Nutritional Information</h3>
					<h4>No Information Provided</h4>
				</div>
			</div>
			<div class="row">
				<div id="ingredients" class="col-md-12">
					<h3>Ingredients</h3>
					<h4>No Ingredients Have Been Provided</h4>
				</div>
			</div>
			
			<div id="productInformation" class="row">
				<div id="productCharacteristicsCol" class="col-md-6">
					<h3>Product Characteristics</h3>
					<ul id="productCharacteristics" class="informationList"></ul>
				</div>
				<div id="qtyContentsCol" class="col-md-6">
					<h3>Contents</h3>
					<ul id="qtyContents" class="informationList"></ul>
				</div>
			</div>
			</div>
		<?php include 'css/templates/footer.html' ?>
		<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
		<script src="scripts/information.js"></script>
	</body>
</html>