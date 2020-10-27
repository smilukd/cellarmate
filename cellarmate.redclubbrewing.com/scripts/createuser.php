<?php

include('connect.php');


if(isset($_POST['submitRegistration']))
{
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	
	//check if the user set a location, else make it NULL
	if(isset($_POST['location']))
	{
		$location = $_POST['location'];
	}
	else
	{
		$location = NULL;
	}
	$cellarName = $_POST['cellarName'];
	$username = $_POST['username'];
	$password = hash('sha512',$_POST['password']);
	
	
	if(isset($_FILES))
	{
		$filename = $_FILES['file']['name'];
		$allowedExts = array("gif","jpeg","jpg","png");
											
		//using explode() to separarate file name and extension 
		$temp = explode (".", $_FILES["file"]["name"]);

		//the end() func returns the last element of the array. First part = file name, last part = extension
		$extension = end($temp); //grabs the extension

		// checking file type extensions
		if((($_FILES["file"]["type"] == "image/gif")
		   || ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png")
			&& in_array($extension, $allowedExts)))
		{
			//check if there is an error
			if($_FILES["file"]["error"]>0)
			{
//do I need an echo? where am I echoing to?
				echo "Return code: " .$_FILES["file"]["error"] . "<br>";
			}

			//checsk if the specific file already exists in teh directory
			elseif( file_exists("../userImages/" . $_FILES["file"]["name"]))
			{
//do I need an echo? where am I echoing to?
				echo $_FILES["file"]["name"] . "Image upload already exists";
			}

			//on passing validations the file is moved from tem plocations to the directory
			else
			{
				//the move_upload_file() func moves the file to the new location
				move_uploaded_file($_FILES["file"]["tmp_name"],"../userImages/".$_FILES["file"]["name"]);
			}
		}
	}
	else
	{
		//set the filename to NULL if the user did not attach a file to the submit
		$filename=NULL;
	}
	
	//get the value of the is cellar visible radio button
	if($_POST['public'] = "yes")
	{
		//user opted into being public
		$public = 1;
	}
	else
	{
		$public=0;
	}
	/*
	try
	{
		
		//all of the data needed to complete a user in the USER table is complete
		$query = $db->prepare("INSERT INTO USER (USER_USERNAME, USER_PASSWORD, USER_EMAIL, USER_FIRST_NAME, USER_LAST_NAME, USER_LOCATION, USER_CELLAR_NAME, USER_PROFILE_PICTURE, USER_CELLAR_VISIBLE) VALUES (?,?,?,?,?,?,?,?,?);");
		$query->execute([$username, $password, $email, $firstName, $lastName, $location, $cellarName, $filename, $public]);
		
		//query the database to get the user ID of the just entered user so we can create a cellar for them
		$query = $db->prepare("SELECT USER_ID FROM USER WHERE USER_USERNAME = ?;");
		$query->execute([$username]);
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
	
		$userID = $query->fetch();
		
		//create the cellar for the user
		$query = $db->prepare("INSERT INTO CELLAR (CELLAR_USER_ID, CELLAR_UNIQUE_BEER_ID) VALUES (?,?);");
		$query->execute([$userID, 0]);
//left off here, finish this part

		
	}
	catch(PDOException $exception)
	{
		echo "User Insert ".$exception->getMessage();
	}
	*/
	
	//send the user to their cellar.
	//header("location: usercellar.php");
	
}
else
{
	echo "post not set";
}



?>