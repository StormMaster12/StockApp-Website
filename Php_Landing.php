<?php
	include "../inc/dbinfo.inc";
	include "scripts/tescoApi.php";
	require_once "vendor/autoload.php";
	//    require_once "HTTP/Request2.php";
    
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    
    if (mysqli_connect_errno()) echo "Failed to Connect to MySql: " . mysql_connect_error();
    
    $database = mysqli_select_db($connection, DB_DATABASE);
    
    if (isset($_POST)) {
		
		$id_token = $_POST["idToken"];
		$client = new Google_Client(["client_id" => CLIENT_ID]);
		$payload = $client->verifyIdToken($id_token);
		$userid = "";
		if ($payload){
			$userid = $payload["sub"];
			} else {
			
			echo "Incorect ID Token";
			http_response_code(401);
			return;
			
		}
		//echo $userid;
		
		$request_Type = $_POST['requestType'];
		$table = $_POST['tableName'];
		
		$table = "Stock";
		
		VerifyTable($connection, DB_DATABASE,$table);
        
		if ($request_Type == "getAll") {
			$result = mysqli_query($connection, "SELECT Pan, amount, expiryDate, Name FROM Stock WHERE idToken = {$userid}") or die (mysqli_error($connection));
			iterSqlResults($result);
			return;                                 
		}
		elseif ($request_Type == "getSpecific") {
			$id = (int)$_POST["Pan"];          
			$sql = "SELECT Pan, expiryDate, amount FROM {$table} WHERE Pan = {$id} and idToken = {$userid}";
			$result = mysqli_query($connection, $sql) or die (mysqli_error($connection));
			iterSqlResults($result);
			return;
		}
		elseif ($request_Type == "addNew") {
			$Pan = $_POST['Pan'];
			$Amount = $_POST['Amount'];
			$boolRemoveItem = $_POST['boolRemoveItem'];
			$strexpiryDate = $_POST['expiryDate'];
			//	  $expiryDate = date("Y-m-d", strtotime($strexpiryDate));
			//	  echo $expiryDate;
			//	  echo $strexpiryDate;
			
			$symbol = "+"; 	
			if ($boolRemoveItem == "True")
			{
				$symbol = "-";
			}
			else
			{
				$symbol = "+";
			}	
			var_dump ($strexpiryDate);
			//var_dump ($expiryDate); 
			$sql = "INSERT INTO Stock (Pan, Amount,expiryDate, idToken, strExpiryDate) VALUES ({$Pan}, {$Amount}, STR_TO_DATE('{$strexpiryDate}','%Y/%m/%d'), {$userid}, {$strexpiryDate}) on duplicate key update Amount = {$Amount} {$symbol} Amount" or die(mysqli_error($connection));         
			mysqli_query($connection,$sql);
			mysqli_query($connection, "SHOW WARNINGS");
			$query = mysqli_query($connection, "SELECT Pan, expiryDate, amount FROM Stock WHERE Pan = {$Pan} and idToken = {$userid}") or die (mysqli_error($connection));
			iterSqlResults($query);
			return;
		}
		elseif ($request_Type == "removeSpecific"){
			$Pan = $_POST['Pan'];
			mysqli_query($connection, "DELETE FROM {$table} WHERE Pan={$Pan}") or die (mysqli_error($connection));
			$json["Flags"] = "removed";
			echo "[" . json_encode($json) . "]";
		}
	}
	else {
		echo "No Post Data Sent";
	}
	
	function VerifyTable($connection, $dbName,$table)
    {
		if(!tableExists($table,$dbName,$connection)) {
			echo "Error Tablle:" .$table . " Does Not Exisit";
		}
	}
	
    function tableExists($table,$dbName,$connection)
	{
		$t = mysqli_real_escape_string($connection, $table);
		$d = mysqli_real_escape_string($connection, $dbName);
		$checkTable = mysqli_query($connection,
		"SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t'
		AND TABLE_SCHEMA = '$d'");
		if (mysqli_num_rows($checkTable) > 0) return true;
		
		return false;
	}
	function iterSqlResults($result){
		$output = "[";
		while ($r = mysqli_fetch_assoc($result)){
			$apiString = getTescoApi($r["Pan"]);
			$json = json_decode($apiString, true);
			$json["Amount"] = $r["amount"];
			$json["expiryDate"] = $r["expiryDate"];
			$json["Flags"] = array("dataReturned"=>"true");
			$output .= json_encode($json) . ",";
		}
		$output .= "]";
		echo $output;
	}
?>

