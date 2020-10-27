<?php
if(isset($_SESSION['USER']))
{
	include('connect.php');

	$barcode = $_SESSION['barcode'];

	$query = $db->prepare("SELECT USERS_BARCODE, USERS_BEER_ABV, USERS_BEER_CONTAINER_SIZE, USERS_BEER_DESCRIPTION, USERS_BEER_IBU, USERS_BEER_IMAGE, USERS_BEER_NAME, USERS_BEER_STYLE, USERS_BEER_VINTAGE, USERS_BREWERY_NAME FROM users_beer WHERE USERS_BARCODE = ?;");
	$query->execute(array($barcode));
	$query->setFetchMode(PDO::FETCH_ASSOC);

	$result = $query->fetchALL();
	
	//send results to session so it can be passed back to addbeer.php
	$_SESSION['DBSCAN'] = $result;
	/*
	print_r($_SESSION);
	
	echo "<br><br>";
	
	if($result)
	{
		echo "has results";
	}
	else
	{
		echo "has no results";
	}
	//print_r($result);
	
	*/
	
	
}
else
{
	//non logged in user trying to access, send them away
	header('location: ../index.php');
}


?>