<?php
session_start();
if(isset($_POST['barcode']))
	{
	unset($_SESSION['fromSearch']);
	unset($_SESSION['names']);
	unset($_SESSION['IDs']);
	unset($_SESSION['insertedBeer']);
	$upc = $_POST['barcode'];

			
	//this code compliments of
	//https://support.ladesk.com/061754-How-to-make-REST-calls-in-PHP	
		
	$service_url = "https://api.brewerydb.com/v2/search/upc?code=";
	$service_url.=$upc;
	$service_url.= "&key=59a62c5db7fbcbce7bd278756f886a11&format=json";
		
	$curl = curl_init($service_url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) 
	{
		$info = curl_getinfo($curl);
		curl_close($curl);
		die('error occured during curl exec. Aditional info: ' . var_export($info));
	}
	curl_close($curl);
	$decoded = json_decode($curl_response);
	if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
	
		die('error occured: ' . $decoded->response->errormessage);
		
	}
	$_SESSION['apiBeer']['results'] = $decoded;
	$_SESSION['apiBeer']['barcode'] = $upc;
		
	header('location: ../addbeer.php?upc='.$upc);
			
	
}






?>