<?php
	session_start();
	unset($_SESSION['director_hash']);
	session_unset();
	//session_destroy();
	header("Location: director_login.php");
	exit;
?>