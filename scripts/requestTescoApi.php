<?php 
	include "../../inc/dbinfo.inc";
	include "tescoApi.php";
	require_once '../vendor/autoload.php';
	if (isset($_POST)) {
		
		$id_token = $_POST["idtoken"];
		$client = new Google_Client(["client_id" => CLIENT_ID2]);
		$payload = $client->verifyIdToken($id_token);
		$userid = "";
		if ($payload){
			$userid = $payload["sub"];
			echo (getTescoApi($_POST["pan"]));
			} else {
			
			echo "Incorect ID Token";
			return;
		}
	}
	else
	{
		echo "No Post Data";
	}
?>