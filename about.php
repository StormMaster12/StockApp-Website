<html>
	<?php include "../inc/dbinfo.inc"; ?>
    
	<?php include "css/templates/head.html" ?>
	<body>
		<?php include 'css/templates/header.html' ?>
		<div class="container" style="display:block;">
			<div class="row">
				<div class="col-md-12">
					<h1> About James Scotland </h1>
					<p>James Scotland is a 22 year old self taught programer who has an interest in multiple aspects of computers and programing. <br> 
					He has self taught himself: python, C#, javascript and PHP, along with having dabled in C++ and Java. He has used this knoledge to create several projects which include this Stock App project which involves an Android App writen in C# using the Xamarin Libaries as well as this website which uses html Javascript and PHP. </p>
					<h2>Programing Projects</h2>
					<h3>C# and PHP</h3>
					<p>As part of my Apprenticeship with JustIT I wanted to create an android app that would allow someone an easy to use way to keep track of their house hold invetory. The main idea behind it was that someone would be able to scan an item which would then be recognised and returned to the user as an item. This was done through integration with the Tesco products Api. The app also needed to be able to keep track of what products the person had in their invetory so I implemented a mySql database on an AWS server. In order for there to be multiple users of the app I added Google Sigin into the app to allow for one the user to get their invetory from anywhere and to allow unique invetories per user. In order to get the information to and from the database I needed a way to communicate and this is where I had to use PHP as the backend language, this comunicates with the database and sends the results back to the app. <br><a href="https://github.com/StormMaster12/StockApp">Github Link to the Stock App project</a></p>
					
					
					<h3>Python</h3>
					<p>Designed two programs to run on the raspberry pi that use the python language. The first one was an internet radio, with channel control and a small LCD screen to show the current station was selected. This was interesting as I was taking external inputs and using them to change the state of the program, something I had never done from scratch before. 
						<br>
						The second program I have made for the raspberry pi is what I call a smart mirror. It displays the time and date in the left hand side of the mirror with a calendar that shows the current day. Below that it has an api call to google calendar to show my current activities for the day. On the right had of the display I have the weather being shown, five days in advance with the current weather showing temperature; cloud cover and predicted rain fall. In order to get this program to run on boot I had to get to understand the Linux operating system, which was challenging as it is vastly different to windows. <br> <a href="https://github.com/StormMaster12/MirrorScreen">Github Link to Mirror Screen Project</a>
					</p>
					<h3>Matlab</h3>
					<p>While at university in Birmingham, I had to do a course with Matlab. The first part involved taking a distorted picture and sharping it up. This is achieved by running the image through a convolution function which moves 3 different filters, each a 3x3 3d array over the image. Once the image has been run through these filters it is then finds the edges of the image and turning it into a binary image.
						
						The second part involved using recursion to produce a recursive image with the intention of creating a piece of jewellery. The image used 3 base shapes which are then manipulated through rotation to create a shield shape, with a flower type shape in the center.
						<br><a href="https://drive.google.com/open?id=0B9gXFPJytN6hSTZoM2o0NXc2UGM">Link to My First program and report</a>
						<br><a href="https://drive.google.com/open?id=0B9gXFPJytN6hbjl4b1R4M1hzdk0">Link to My Second program and Report</a>
					</p>
					<h3>Java</h3>
					<p>I have done some work in Java, trying to write my own game. The backbone of this program was a class which on startup would parse and xml file and then create and fill the correct classes. For example it would create a ship class which would then populate the variables with the correct data, it would then go onto create the weapons and defences so that they belonged to that ‘ship’. I got it to work with a text based command system.
					</p>
					<h3>C++</h3>
					<p>Having created a basic game in Java, I decided to have a go in C++ to see if I could make it any better. The base framework stayed the same of parsing in an xml file, though passing references of the objects made coding seem easier. I also added information to the registry such as player name, current saved game and the current directory that things were being saved to. I also got started on a basic AI which would try and work out which ship was the biggest threat to it, the small fighter close by or the bigger battleship that was sitting further away. The biggest improvement over the Java version was the use of 2d graphics, this was crudely done as it was hard to get items to behave as I wished them to. </p>
				</div>
			</div>			
		</div>
		<?php include 'css/templates/footer.html' ?>
		<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
		<script src="scripts/main.js"></script>
	</body>
</html>