<?php
//LOGIN script


if(isset($_POST['Login']))
{
	session_start();
	include('connect.php');
	$username = $_POST['username'];
	$password = hash('sha512',$_POST['password']);
	
	
	$query = $db->prepare("SELECT USER_ID, USER_FIRST_NAME, USER_LAST_NAME, USER_CELLAR_NAME, USER_ROLE, USER_PROFILE_PICTURE, USER_USERNAME FROM user WHERE USER_USERNAME = ? AND USER_PASSWORD = ?;");
	$query->execute(array($username, $password));
	$query->setFetchMode(PDO::FETCH_ASSOC);

	$result = $query->fetch();
	
	if($result)
	{
		//a mathcing user is found, set the user info in to the session ['USER']
		$_SESSION['USER']['id'] = $result['USER_ID'];
		$_SESSION['USER']['firstName'] = $result['USER_FIRST_NAME'];
		$_SESSION['USER']['lastName'] = $result['USER_LAST_NAME'];
		$_SESSION['USER']['cellarName'] = $result['USER_CELLAR_NAME'];
		$_SESSION['USER']['image'] = $result['USER_PROFILE_PICTURE'];
		$_SESSION['USER']['role'] = $result['USER_ROLE'];
		$_SESSION['USER']['username'] = $result['USER_USERNAME'];
		
		if($result['USER_ROLE'] == 'user')
		{
			//user is of user ROLE
			header('location: ../cellar.php');
		}
		elseif($result['USER_ROLE'] == 'admin')
		{
			//user is of admin type
			//explicit checking of admin type to prevent backdooring
			header('location: ../admin.php');
		}
		
		if(isset($_SESSION['fail']))
		{
			unset($_SESSION['fail']);
		}
	}
	else
	{
		//login failed. prompt user to try again
		$_SESSION['fail'] = true;
		header('location: ../login.php');
	}
	
}
else
{
	//user tried to access this page, bypassing the login page
	header('location: ../index.php');
}


?>