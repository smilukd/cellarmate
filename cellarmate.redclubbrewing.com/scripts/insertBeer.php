<?php
session_start();

	if(isset($_POST['submitBeer']))
	{
		
		//user is entering a new beer
		
		
		include('connect.php');
		$userID = $_SESSION['ID'];
		$beerName = $_POST['beerName'];
		$breweryName = $_POST['breweryName'];
		if(isset($_POST['ibu']))
		{
			$ibu = $_POST['ibu'];
		}
		if(isset($_POST['abv']))
		{
			$abv = $_POST['abv'];
		}
		$description = $_POST['description'];
		if(isset($_POST['style']))
		{
			$style = $_POST['style'];
		}
		if(isset($_SESSION['image']))
		{
			$image = $_SESSION['image'];
		}
		if(isset($_POST['beerType']))
		{
			//assigning a barcode to 
			if($_POST['beerType'] == "commercial")
			{
				$barcode = 20000000000000+(int)$userID;
			}
			elseif($_POST['beerType'] == "homebrew")
			{
				$barcode = 10000000000000+(int)$userID;
			}
		}
		else
		{
			$barcode = $_SESSION['barcode'];
			//print_r($_SESSION);
		}
		
		$isCommercial = $_SESSION['commercial'];
		$quantity = $_POST['beerQuantity'];
		$purDate = NULL; //$_POST['purchaseDate']; set to null now until I make all the entered dates fit date time format
		$purPlace = $_POST['purchasePlace'];
		$purPrice = $_POST['purchasePrice'];
		$vintage = $_POST['beerVintage'];
		$notes = $_POST['notes'];
		$container = $_POST['containerSize'];
		

		
		
		for($i=0; $i<$quantity; $i++)
		{
			
			try
			{
				$query = $db->prepare("SELECT CELLAR_UNIQUE_BEER_ID FROM cellar WHERE CELLAR_USER_ID = ?;");
				$query->execute(array($userID));
				$query->setFetchMode(PDO::FETCH_ASSOC);

				$result = $query->fetch();
				
				if($result)
				{
					$query = $db->prepare("INSERT INTO users_beer (USERS_BARCODE, USERS_BEER_NAME, USERS_BEER_ABV, USERS_BEER_CONTAINER_SIZE, USERS_BEER_IBU, USERS_BEER_IMAGE, USERS_BEER_NOTES, USERS_BEER_STYLE, USERS_BEER_VINTAGE, USERS_BREWERY_NAME, USERS_BEER_USER_ID, USERS_PURCHASE_PLACE, USERS_PURCHASE_PRICE, USERS_PURCHASE_DATE, USERS_BEER_DESCRIPTION) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$query->execute(array($barcode, $beerName, $abv, $container, $ibu, $image, $notes, $style, $vintage, $breweryName, $userID, $purPlace, $purPrice, $purDate, $description));

					//get the ID of the last item inserted into the array
					//we will use this to add the beer to the user cellar
					$lastInsertedId = $db->lastInsertId();

					$query = $db->prepare("INSERT INTO cellar (CELLAR_USER_ID, CELLAR_UNIQUE_BEER_ID) VALUES (?,?);");
					if($query->execute(array($userID, $lastInsertedId)))
					{
						/* DO I want this here any more considering Ive implemented a less overall destructive way of handling session deletion?
						session_destroy();
						session_start();
						*/
						$_SESSION['insertedBeer'] = $beerName;
						//print_r($_SESSION);
						header('location: ../addbeer.php');
					}
					else
					{
						echo "<h1>Something went wrong!</h1>";
					}
				}
				else
				{
					//there was no user found in the cellar with that user_id, so this is their first insert
					//lets create a cellar for them.
					$query = $db->prepare("INSERT INTO cellar (CELLAR_USER_ID) VALUES (?);");
					$query->execute(array($userID));
					
					
					$lastInsertedId = $db->lastInsertId();
					
					//now lets add their beer to the cellar
					$query = $db->prepare("INSERT INTO users_beer (USERS_BARCODE, USERS_BEER_NAME, USERS_BEER_ABV, USERS_BEER_CONTAINER_SIZE, USERS_BEER_IBU, USERS_BEER_IMAGE, USERS_BEER_NOTES, USERS_BEER_STYLE, USERS_BEER_VINTAGE, USERS_BREWERY_NAME, USERS_BEER_USER_ID, USERS_PURCHASE_PLACE, USERS_PURCHASE_PRICE, USERS_PURCHASE_DATE, USERS_BEER_DESCRIPTION) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$query->execute(array($barcode, $beerName, $abv, $container, $ibu, $image, $notes, $style, $vintage, $breweryName, $userID, $purPlace, $purPrice, $purDate, $description));			
					
					$_SESSION['insertedBeer'] = $beerName;
					header('location: ../addbeer.php');
					
				}
				
				
				
				
			}
			catch(PDOException $error)
			{
				echo "Failed to insert. ".$error->getMessage();
			}
				
		}
		
		
			
		

	}
	elseif(isset($_POST['updateBeer']))
	{
//left off here, fix the place the variables get their data from.
		include('connect.php');
		//print_r($_POST);
		$userID = $_SESSION['ID'];
		$uniqueBeerId = $_POST['updateBeer'];
		$beerName = $_POST['beerName'];
		$breweryName = $_POST['breweryName'];
		//$barcode = $_POST['barcode'];
		if(isset($_POST['ibu']))
		{
			$ibu = $_POST['ibu'];
		}
		if(isset($_POST['abv']))
		{
			$abv = $_POST['abv'];
		}
		$description = $_POST['description'];
		if(isset($_POST['style']))
		{
			$style = $_POST['style'];
		}
		
		
		
		//$isCommercial = $_SESSION['commercial'];
		//$quantity = $_POST['beerQuantity'];
		$purDate = NULL; //$_POST['purchaseDate']; set to null now until I make all the entered dates fit date time format
		$purPlace = $_POST['purchasePlace'];
		$purPrice = $_POST['purchasePrice'];
		$vintage = $_POST['beerVintage'];
		$notes = $_POST['notes'];
		$container = $_POST['containerSize'];
		
		try
		{
			$query = $db->prepare("UPDATE users_beer SET USERS_BEER_NAME = ?, USERS_BREWERY_NAME = ?, USERS_BEER_IBU = ?, USERS_BEER_ABV = ?, USERS_BEER_DESCRIPTION = ?, USERS_BEER_STYLE = ?, USERS_PURCHASE_PLACE = ?, USERS_PURCHASE_PRICE = ?, USERS_BEER_VINTAGE = ?, USERS_BEER_NOTES = ?, USERS_BEER_CONTAINER_SIZE = ? WHERE USERS_UNIQUE_BEER_ID = ?;");
			
			$query->execute(array($beerName, $breweryName, $ibu, $abv, $description, $style, $purPlace, $purPrice, $vintage, $notes, $container, $uniqueBeerId));
			
			$_SESSION['updatedBeer'] = "success";
			header('location: ../drink.php');
		}
		catch(PDOException $error)
		{
			echo "Failed to insert. ".$error->getMessage();
		}
		
		
	}
	else
	{
		echo "huh";
	}


?>