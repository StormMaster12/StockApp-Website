var pageDict = {index: "main", about: "about",videos:'videos'};
var tooltipTimeout;

$(document).ready(function(){
	navbarActiveSet();
	console.log("Document Ready");
	
	var delay=1000, setTimeoutConst;
	
	$('#resultsTable').on("mouseenter","tr",function()
	{
		var elem = $(this)
		setTimeoutConst = setTimeout(function(){
			//do something
			elem.find('td:last').stop().fadeIn();
		}, delay)
		
	});
	
	$('#resultsTable').on("mouseleave","tr",function()
	{
		clearTimeout(setTimeoutConst );
		$(this).find('td:last').stop().fadeOut();
	});	
});	



function onSuccess(googleUser) {
	console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
	$('#login > div').remove();
	$('#login').append('<a id="signout" href="#" onclick="signOut();">Sign out</a>');
	
	var id_token = googleUser.getAuthResponse().id_token;
	
	localStorage.setItem("id_token",id_token);
	
	executeXMLHttpRequest('type=getAll',"phpresponse","./scripts/getdbInformation.php");	
}
function onFailure(error) {
	console.log(error);
}
function renderButton() {
	gapi.signin2.render('my-signin2', {
		'scope': 'profile email',
		'width': 240,
		'height': 50,
		'longtitle': true,
		'theme': 'dark',
		'onsuccess': onSuccess,
		'onfailure': onFailure
	});
}
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
		localStorage.removeItem('id_token');
		
		console.log('User signed out.');
		$('#login > a').remove();
		$('#login').append('<div id="my-signin2"></div>');
		$('#resultsTable').empty();
		$('#resultsTable').append("<h3>You Have Signed Out</h3> <br> <p>It looks like you have not signed into an google account, please sign in to see your inventory</p>")
		
		
		renderButton();
	});
}

function executeXMLHttpRequest(args,returnFunction, url)
{
	args += '&idtoken=' + localStorage.getItem("id_token");
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			window[returnFunction](this.responseText,args);
		}
	}
	
	xhr.open('POST',url);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send(args);
}

function phpresponse(responseText,args)
{
	$('#resultsTable > p').remove()
	$('#resultsTable').append(responseText);
	$('#resultsTable').append("<button id='newItem' onclick='newItem()'>Add New Item</button>")
}

function updateRow(responseText,args)
{
	var pan ="";
	var splitArgs = args.split("&");
	for (var i in splitArgs)
	{
		if (splitArgs[i].indexOf("pan") >=0)
		{
			pan = splitArgs[i].split("=")[1];
			console.log(pan);
			break;
		}
	}
	
	var e = $('#resultsTable td').filter(function(){
		return $(this).text() == pan;
	});
	
	e.next().text(responseText);
}

function responseShowMoreInformation(responseText,args)
{
	localStorage.setItem("detailedItem",responseText);
	document.location.href = "information.php"
}

function navbarActiveSet() {
	var path = window.location.pathname;
	console.log(path);
	var page = path.split("/").pop();
	page = page.replace(".php","");
	
	if(page == "")
	{
		page = "index";
	}
	
	console.log(page);
	$("#navbar>ul>li.active").removeClass("active");
	$('#'+pageDict[page]).addClass("active");
	
}

/* $(document).on("mouseenter","tr",function()
	{
	$(this).find('td:last').stop().fadeIn();
	});
	
	$(document).on("mouseleave","tr",function()
	{
	$(this).find('td:last').stop().fadeOut();
	});
*/
function increaseAmmount(buttonElement)
{
	var tdValue = $(buttonElement.parentNode.parentNode).find('td:first').text();
	console.log(tdValue);
	var args = 'type=Add&pan=' + tdValue;
	executeXMLHttpRequest(args,"updateRow","./scripts/getdbInformation.php");
}

function decreaseAmmount(buttonElement)
{
	var tdValue = $(buttonElement.parentNode.parentNode).find('td:first').text();
	console.log(tdValue);
	var args = 'type=Subtract&pan=' + tdValue;
	executeXMLHttpRequest(args,"updateRow","./scripts/getdbInformation.php");
}

function showMoreInformation(buttonElement)

{
	var tdValue = $(buttonElement.parentNode.parentNode).find('td:first').text();
	console.log(tdValue);
	var args = 'type=getSpecific&pan=' + tdValue;
	executeXMLHttpRequest(args,"responseShowMoreInformation","./scripts/requestTescoApi.php");
}

function newItem()
{
	console.log("newItem");
	$('#resultsTable').append(`<form action='JavaScript:formSubmit()' class='resultsTableCSS' id="addItemForm"> 
	<div class='form-group'>
	<label for="fPan">Pan:</label>
	<input type='text' id="formPan" name='fPan' class="form-control" required>
	</div>
	<div class='form-group'>
	<label for='fPDate'>Purchase Date:</label>
	<input type='date' name='fPDate' id="formPDate" class="form-control" required>
	</div> 
	<div class='form-group'>
	<label for='fEDate'>Expiry Date:</label>
	<input type='date' name='fEDate' id="formEDate" class="form-control" required>
	</div>
	<div class='form-group'>
	<label for='fAmount'>Amount:</label>
	<input type='number' name='fAmount' id="formAmount" class="form-control" required> 
	</div>
	<button type='submit' class='btn btn-primary' id="formButtonSubmit">Submit</button>
	</form>`)
	
	$('#newItem').fadeOut();
}

function formSubmit()
{
	var pan = $('#formPan').val();
	console.log(pan);
	var args = 'type=getSpecific&pan=' + pan;
	executeXMLHttpRequest(args,"responseShowName","./scripts/requestTescoApi.php");
}

$.fn.scrollView = function () {
    return this.each(function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top
		}, 1000);
	});
}

function responseShowName(responseText,args)
{
	var okButtonText = "";
	var cancelButtonText = "";
	var hFourText = "";
	
	if (responseText !="")
	{
		var informationJson = JSON.parse(responseText);
		var productInformation = informationJson.products[0];
		
		okButtonText = "Is This The Correct Name? Click To confirm";
		cancelButtonText ="Incorrect Name Cancel?";
		hFourText = productInformation.description;
	}
	else 
	{
		okButtonText = "Would you still like to add this item?";
		cancelButtonText ="Cancel";
		hFourText = "Unfortuantly Tescos Do not have a record of this item";
	}
	
	$('#formButtonSubmit').attr("disabled",true);
	$('#resultsTable').append("<h4 id='formName'>" + hFourText + "</h4>");
	$('#resultsTable').append("<button onclick='addFormToDatabase()' class='addItemButton btn btn-primary' id='okButton'>"+okButtonText+"</button>");
	$('#resultsTable').append("<button onclick='canceladdFormToDatabase()' class='addItemButton btn btn-primary' id='cancelButton'>"+ cancelButtonText +"</button>")
	
	$('#formName').scrollView();
}

function addFormToDatabase() 
{
	var pan = $('#formPan').val();
	var expiryDate = $('#formEDate').val();
	var purchaseDate = $('#formPDate').val();
	var amount = $('#formAmount').val();
	
	var args = `type=addItem&pan=${pan}&purchaseDate=${purchaseDate}&expiryDate=${expiryDate}&amount=${amount}`
	console.log(args);
	executeXMLHttpRequest(args,"responseAddItem","./scripts/getdbInformation.php");
}

function responseAddItem(responseText,args)
{
	//console.log(responseText);
	console.log(args);
	$('#displayInvetoryTable').append(responseText);
	canceladdFormToDatabase();
}

function canceladdFormToDatabase()
{
	$('#addItemForm').remove();
	$('#formName').remove();
	$('#okButton').remove();
	$('#cancelButton').remove();
	$('#newItem').fadeIn();
}