<html>
	<?php include "../inc/dbinfo.inc"; ?>
    
	<?php include "css/templates/head.html" ?>
	<body>
		<?php include 'css/templates/header.html' ?>
		<div class="container" style="display:block;">
			<div class="row">
				<div class="col-md-12">
					<h1> James Scotlands Stock App </h1>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-8">
					<h3>About this Project</h3>
					<p>This project came about from wanting to increase my knoledge of C# and App Development. I also wanted to create a way to keep track of the items that are stored in my kitchen, and then use the list to help create shopping lists in an attempt to avoid running out of crucial items. <br/>In order to use this tool, sign into your google account via the google sign in button. Once signed in you can add items via the add item button. Inputing the unique identification number or 'PAN'. The pan will be checked against the tesco product API and if its present the name will be displayed bellow. Confirming the correct name will add the item to your account. The same items will be avaialbe from wherever as long as you sign in via your account. Downloading the app also allows a way to add items to your account.</p>
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