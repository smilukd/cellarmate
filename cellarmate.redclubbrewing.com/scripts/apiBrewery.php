<?php
//session_start();

if(isset($_SESSION['id']))
{
	$beerID = $_SESSION['id'];
	$service_url = "https://api.brewerydb.com/v2/beer/";
	$service_url.=$beerID;
	$service_url.= "/breweries?key=59a62c5db7fbcbce7bd278756f886a11&format=json";
		

		//echo $service_url;
	$curl = curl_init($service_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) 
	{
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Additional info: ' . var_export($info));
	}
	curl_close($curl);
	$decoded = json_decode($curl_response);
	if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
	
		die('error occured: ' . $decoded->response->errormessage);
		
	}
	
	
	$_SESSION['brewery'] = $decoded;
	
}

?>
