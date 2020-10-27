<?php
session_start();

unset($_SESSION);
session_destroy();
if(!isset($_SESSION['USER']))
{
	
	header('location: ../index.php');
}


?>