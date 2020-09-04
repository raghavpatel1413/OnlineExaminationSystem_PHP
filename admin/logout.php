<?php
	session_start();
	unset($_SESSION['admin_hash']);
	session_unset();
	//session_destroy();
	header("Location: admin_login.php");
	exit;
?>