<?php
	session_start();

	//print_r($_SESSION);

	if(isset($_POST['drinkConfirm']))
	{
		include('connect.php');
		try
		{
			$id = $_POST['drinkConfirm'];
			$query = $db->prepare("UPDATE users_beer SET USERS_CHECK_OUT_DATE = CURRENT_TIMESTAMP, USERS_BEER_REMOVAL_REASON = 'Drank' WHERE USERS_UNIQUE_BEER_ID = ?;");
			$query->execute(array($id));
			$query = $db->prepare("UPDATE user SET USER_CONSUMED_BEERS = USER_CONSUMED_BEERS + 1 WHERE USER_ID = ?;");
			$query->execute(array($_SESSION['USER']['id']));
			
			
			unset($_SESSION['removal']);
			unset($_SESSION['aboutToRemove']);
			
			header('location: ../cellar.php');
			
			
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
		
	
	}
	
	elseif(isset($_POST['purgeConfirm']))
	{
		include('connect.php');
		try
		{
			$id = $_POST['purgeConfirm'];
			$reason = $_POST['reason'];
			$query = $db->prepare("UPDATE users_beer SET USERS_CHECK_OUT_DATE = CURRENT_TIMESTAMP, USERS_BEER_REMOVAL_REASON = ? WHERE USERS_UNIQUE_BEER_ID = ?;");
			$query->execute(array($reason, $id));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
		
		$beerName = $_SESSION['removal'][0]['USERS_BEER_NAME'];
		$_SESSION['PURGED'] = $beerName;
		header('location: ../cellar.php');
	}
	else
	{
		//unauthorized access. Send them away!
		header('location: ../index.php');
	}





?>