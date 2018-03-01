<?php
	include "../../inc/dbinfo.inc";
	include "tescoApi.php";
	require_once '../vendor/autoload.php';
	if (isset($_POST["idtoken"]) || !empty($_POST)) {
		
		$id_token = $_POST["idtoken"];
		$client = new Google_Client(["client_id" => CLIENT_ID2]);
		$payload = $client->verifyIdToken($id_token);
		if ($payload){
			$userid = $payload["sub"];
			
			if($_POST["type"] == "getAll")
			{
				getSqlInformation($userid);
			}
			else if ($_POST["type"] == "Add")
			{
				addToItem($userid,$_POST["pan"]);
			}
			else if ($_POST["type"] == "Subtract")
			{
				removeFromItem($userid,$_POST["pan"]);
			}
			else if ($_POST["type"] == "addItem")
			{
				addNewItem($userid,$_POST["pan"],$_POST["purchaseDate"],$_POST["expiryDate"],$_POST["amount"]);
			}
			
		} 
		else 
		{
			
			echo "Incorect ID Token";
			header("Location: ../index.php");
		}
	}
	else
	{
		header("Location: ../index.php");
	}
	
	function getSqlInformation($userid)
	{
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
		if (mysqli_connect_errno()) echo "Failed to Connect to MySql: " . mysql_connect_error();
		$database = mysqli_select_db($connection, DB_DATABASE);
		
		if ($stmt = mysqli_prepare($connection, "SELECT Pan,Amount,purchaseDate,expiryDate FROM Stock WHERE idToken =?"))
		{
			mysqli_stmt_bind_param($stmt,"s",$userid);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			
			echo '<table id="displayInvetoryTable" class="table table-hover">';
			echo '<tr>';
			
			while ($property = mysqli_fetch_field($result))
			{
				echo "<th>{$property->name}</th>";
			}
			echo '<th>Name</th>';
			echo '</tr>';
			
			while ($row = mysqli_fetch_array($result,MYSQL_NUM))
			{
				echo '<tr class="rowHover">';
				foreach ($row as $r)
				{
					echo "<td>{$r}</td>";
				}
				$tescoResult = getTescoApi($row[0]);
				$decodedJson = json_decode($tescoResult);		
				
				if (isset($decodedJson->products{0}) )
				{
					$description = $decodedJson->products{0}->description;
					echo "<td>{$description}</td>";
				}
				else
				{					
					echo "<td></td>";
				}
				echo '<td style="display:none">
				<button type="button" class="btn btn-default btn-sm" onClick="increaseAmmount(this)">
				<span class="glyphicon glyphicon-plus"></span> Plus
				</button>
				<button type="button" class="btn btn-default btn-sm" onClick="decreaseAmmount(this)">
				<span class="glyphicon glyphicon-minus"></span> Minus
				</button>
				<button type="button" class="btn btn-default btn-sm" onClick="showMoreInformation(this)">
				<span class="glyphicon glyphicon-list-alt"></span> List-alt
				</button>
				</td>';
				
				echo '</tr>';
			}
			
			echo '</table>';
		}
	}
	
	function addToItem($userId,$pan)
	{
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
		if (mysqli_connect_errno()) echo "Failed to Connect to MySql: " . mysql_connect_error();
		$database = mysqli_select_db($connection, DB_DATABASE);
		
		if ($stmt = mysqli_prepare($connection, "UPDATE Stock SET Amount = Amount + 1 WHERE idToken=? AND Pan=?"))
		{
			mysqli_stmt_bind_param($stmt,"ss",$userId, $pan);
			mysqli_execute($stmt);
		}
		getSpecificAmount($userId,$pan,$connection);
	}
	
	function removeFromItem($userId,$pan)
	{
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
		if (mysqli_connect_errno()) echo "Failed to Connect to MySql: " . mysql_connect_error();
		$database = mysqli_select_db($connection, DB_DATABASE);
		
		if ($stmt = mysqli_prepare($connection, "SELECT Amount FROM Stock WHERE idToken=? AND Pan=?"))
		{
			mysqli_stmt_bind_param($stmt,"ss",$userId, $pan);
			mysqli_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$row = mysqli_fetch_array($result,MYSQL_NUM);
			if ($row[0] - 1 < 0)
			{
				if ($subtractUpdate = mysqli_prepare($connection, "UPDATE Stock SET Amount = 0 WHERE idtoken=? AND Pan=?"))
				{
					mysqli_stmt_bind_param($subtractUpdate,"ss",$userId, $pan);
					mysqli_execute($subtractUpdate);
				}
			}
			else
			{
				if ($subtractUpdate = mysqli_prepare($connection, "UPDATE Stock SET Amount = Amount - 1 WHERE idtoken=? AND Pan=?"))
				{
					mysqli_stmt_bind_param($subtractUpdate,"ss",$userId, $pan);
					mysqli_execute($subtractUpdate);
				}
				
			}
			getSpecificAmount($userId,$pan, $connection);
			
		}
	}
	
	function getSpecificAmount($userId,$pan, $connection)
	{
		if ($resultQuery = mysqli_prepare($connection, "SELECT Amount FROM Stock WHERE idToken=? AND Pan=?"))
		{
			mysqli_stmt_bind_param($resultQuery,"ss",$userId, $pan);
			mysqli_execute($resultQuery);
			$result = mysqli_stmt_get_result($resultQuery);
			while ($row = mysqli_fetch_array($result,MYSQL_NUM))
			{
				echo ($row[0]);
			}
			
		}
	}
	
	
	
	
	function addNewItem($userid,$pan,$purchaseDate,$expiryDate,$amount)
	{
		$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
		if (mysqli_connect_errno()) echo "Failed to Connect to MySql: " . mysql_connect_error();
		$database = mysqli_select_db($connection, DB_DATABASE);
		
 		if ($stmt = mysqli_prepare($connection, 'INSERT INTO Stock (Pan,Amount,purchaseDate,expiryDate,idToken) VALUES(?,?,?,?,?)'))
		{
			mysqli_stmt_bind_param($stmt,"sisss",$pan,$amount,$purchaseDate,$expiryDate,$userid);
			mysqli_stmt_execute($stmt);
		}
		/* $sql = "INSERT INTO Stock (Pan,Amount,purchaseDate,expiryDate,idToken) VALUES({$pan}, {$amount}, STR_TO_DATE('{$purchaseDate}','%Y/%m/%d'),STR_TO_DATE('{$expiryDate}','%Y/%m/%d') , {$userid}) on duplicate key update Amount = {$amount} + Amount" or die(mysqli_error($connection));         
		mysqli_query($connection,$sql); */
		$tescoResult = getTescoApi($pan);
		$decodedJson = json_decode($tescoResult);		
		
		echo '<tr class="rowHover">';
		echo "<td>{$pan}</td><td>{$amount}</td><td>{$purchaseDate}</td><td>{$expiryDate}</td>";
		
		if (isset($decodedJson->products{0}) )
		{
			$description = $decodedJson->products{0}->description;
			echo "<td>{$description}</td>";
		}
		else
		{					
			echo "<td></td>";
		}
		echo '<td style="display:none">
		<button type="button" class="btn btn-default btn-sm" onClick="increaseAmmount(this)">
		<span class="glyphicon glyphicon-plus"></span> Plus
		</button>
		<button type="button" class="btn btn-default btn-sm" onClick="decreaseAmmount(this)">
		<span class="glyphicon glyphicon-minus"></span> Minus
		</button>
		<button type="button" class="btn btn-default btn-sm" onClick="showMoreInformation(this)">
		<span class="glyphicon glyphicon-list-alt"></span> List-alt
		</button>
		</td>';
		echo '</tr>';
	}
?>	