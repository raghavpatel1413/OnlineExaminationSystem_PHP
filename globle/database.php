<?php
	date_default_timezone_set("Asia/Calcutta");
	$host = 'localhost';
	$user = 'root';
	$pass = "";
	$db = 'online_examination_system';
	$con = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
?>