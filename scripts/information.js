var informationJson = '';

window.onbeforeunload = function() {
  localStorage.removeItem("detailedItem");
}
$('document').ready(function()
{
	informationJson = JSON.parse(localStorage.getItem("detailedItem"));
	console.log(informationJson.products[0]);
	var productInformation = informationJson.products[0];
	$('#productName').text(productInformation.description);
	$('#productBrand').text(productInformation.brand);
	
	iterKeyValue(productInformation.productCharacteristics,"productCharacteristics");
	iterKeyValue(productInformation.qtyContents,"qtyContents");
	
	pkgDimensions(productInformation);
	calcNutrition(productInformation)
	ingredients(productInformation);
	
});

function pkgDimensions(productInformation)
{
	if (productInformation.hasOwnProperty("pkgDimensions"))
	{
		$('#productCharacteristicsCol').removeClass("col-md-6");
		$('#qtyContentsCol').removeClass("col-md-6");
		
		$('#productCharacteristicsCol').addClass("col-md-4");
		$('#qtyContentsCol').addClass("col-md-4");
		
		$(`<div class="col-md-4">
		<h3>Package Dimensions</h3>
		<ul id="pkgDimensions" class="informationList"></ul>
		</div>`).appendTo("#productInformation");
		iterKeyValue(productInformation.pkgDimensions[0],"pkgDimensions");
		
	}
}

function calcNutrition(productInformation)
{
	if (productInformation.hasOwnProperty("calcNutrition"))
	{
		$('#nutritionInformation > h4').remove();
		
		$('<table id="nutrionalInformationTable" class="table"><tr><th>Name</th><th>Value Per 100</th><th>Value Per Serving</th></tr></table>').appendTo('#nutritionInformation');
		$('<h4> Serving Size: ' + productInformation.calcNutrition.perServingHeader.substr(0,productInformation.calcNutrition.perServingHeader.indexOf(' ')) + '</h4>').appendTo('#nutritionInformation');
		
		
		var nutrients = productInformation.calcNutrition.calcNutrients
		for (var i = 0; i < nutrients.length; i++)
		{
			var item = nutrients[i];
			var htmlText = "<tr>";
			htmlText += "<td>" + item.name + "</td><td>" + item.valuePer100 +"</td><td>" + item.valuePerServing + "</td>";
			htmlText += "</tr>";
			$('#nutrionalInformationTable').append(htmlText);
		}
	}
}

function ingredients(productInformation)
{
	if (productInformation.hasOwnProperty("ingredients"))
	{
		$('#ingredients > h4').remove();
		var htmlText = '<ul class="informationList">'
		
		for (var ingredient in productInformation.ingredients)
		{	
			console.log(productInformation.ingredients[ingredient]);
			htmlText += '<li>' + productInformation.ingredients[ingredient] + '</li>';
		}
		
		htmlText += '</ul>'
		
		$('#ingredients').append(htmlText);
	}
}

function iterKeyValue (object, htmlId)
{
	for (const [key, val] of Object.entries(object))
	{
		$('#' + htmlId).append('<li>' + key + ' : ' + val + '</li>');
	}
}