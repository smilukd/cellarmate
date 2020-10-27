<?php
session_start();

//stuck here, need to find a way to pass the beer id to the drink.php so I can purge the correct one.


if((isset($_POST['view']) || isset($_POST['remove'])) || isset($_POST['purgeView']) && isset($_SESSION['USER']))
{
	if(isset($_SESSION['aboutToRemove']))
	{
		unset($_SESSION['aboutToRemove']);
	}
		
	if(isset($_POST['view']))
	{
		$id = $_POST['view'];
		$reason = "edit";	//yes, this value and the value for remove, below, seem backwards. It Is. its just a hacky work around right now.
	}
	elseif(isset($_POST['remove']))
	{
		$id = $_POST['remove'];
		$reason = "view";
	}
	elseif(isset($_POST['purgeView']))
	{
		$id = $_POST['purgeView'];
		$reason = "purge";
	}
	
	include('connect.php');
	$query = $db->prepare("SELECT USERS_BARCODE, USERS_UNIQUE_BEER_ID, USERS_BEER_NAME, USERS_BEER_ABV, USERS_BEER_CONTAINER_SIZE, USERS_BEER_IBU, USERS_BEER_IMAGE, USERS_BEER_NOTES, USERS_BEER_STYLE, USERS_BEER_VINTAGE, USERS_BREWERY_NAME, USERS_PURCHASE_PLACE, USERS_PURCHASE_PRICE, USERS_PURCHASE_DATE, USERS_BEER_DESCRIPTION FROM users_beer WHERE USERS_UNIQUE_BEER_ID = $id;");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetch();
		
}
else
{
	header('location: ../index.php');
}

if($result)
{
	$_SESSION['aboutToRemove'] = $result;
	$_SESSION['aboutToRemove']['removalMethod'] = $reason;
	
	if(isset($_POST['purgeView']))
	{
		header('location: ../delete.php');
	}
	else
	{
		header('location: ../drink.php');
	}
	
}
else
{
	$result = "Something went wrong";
}


?>