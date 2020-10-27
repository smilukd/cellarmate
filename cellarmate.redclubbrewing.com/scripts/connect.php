<?php
$db_host = 'localhost';
$db_user = 'redclubb_cellarmate';
$db_pass = "cellarmateDunwoody2017";
$db_database = 'redclubb_cellar';

$db = new PDO('mysql:host='.$db_host.';
							dbname='.$db_database,
			 				$db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>