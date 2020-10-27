<?php

include('connect.php');
if(isset($_POST['user']))
{
	$username = $_POST['user'];
	
	$query = $db->query("SELECT USER_ID FROM USER WHERE USER_USERNAME = '".$username."';");
	$query->setFetchMode(PDO::FETCH_ASSOC);

	$result = $query->fetch();

	if(!$result)
	{
		echo "<span style='color:green;' class='fa fa-check'>Username OK</span>";
	}
	else
	{
		echo "<span style='color:red;' class='fa fa-thumbs-down'>Choose a new username</span>";
	}

}
else
{
	echo "<span class='red'>Please enter a username</span>";
}





?>