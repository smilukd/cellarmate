<?php
session_start();
//print_r($_POST);
if(isset($_POST['searchSubmit']))
{
	$beerID = $_POST['beerChoice'];
	//echo $beerID;
	if($beerID != "other")
	{
		$service_url = "https://api.brewerydb.com/v2/beer/";
		$service_url.=$beerID;
		$service_url.= "?key=59a62c5db7fbcbce7bd278756f886a11&format=json";


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


		$_SESSION['apiBeer']['results'] = $decoded;
		$_SESSION['apiBeer']['fromSearch'] = true;
		
		unset($_SESSION['MultiBeerNames']);
		header('location: ../addbeer.php?upc='.$_POST['searchSubmit']);
	}
	
}
else
{
	echo "huh, im down here";
}

?>
