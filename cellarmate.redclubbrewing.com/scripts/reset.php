<?php
session_start();
	unset($_SESSION['Multi']);
	unset($_SESSION['MultiBeerNames']);
	unset($_SESSION['apiBeer']);
	header('location: ../addbeer.php');
	

?>