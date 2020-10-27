<?php
	
	print_r($_POST);
include('connect.php');

if(isset($_POST['confirmedDelete']))
{
	$reason = $_POST['deleteReason'];
	$id = $_POST['confirmedDelete'];
}
elseif(isset($_POST['purgeRemove']))
{
	$reason = $_POST['deleteReason'];
	$id = $_POST['purgeRemove'];
}

try
{
	$query = $db->prepare("UPDATE users_beer SET USERS_CHECK_OUT_DATE = CURRENT_TIMESTAMP, USERS_BEER_REMOVAL_REASON = ? WHERE USERS_UNIQUE_BEER_ID = ?;");
	$query->execute(array($reason, $id));
	header('location: ../cellar.php');
}
catch(PDOException $e)
{
	echo $e->getMessage();
}


?>