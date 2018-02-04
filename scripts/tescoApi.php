<?php 
	
	function getTescoApi($output)
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://dev.tescolabs.com/product/?gtin={$output}&tpnb={string}&tpnc={string}&catid={string}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		
		
		$headers = array();
		$headers[] = "Ocp-Apim-Subscription-Key: b775ff6e5f284518851939473019dd7a";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
		return $result;
		
	}
?>