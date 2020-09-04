<?php
	session_start();
	unset($_SESSION['faculty_hash']);
	session_unset();
	//session_destroy();
	header("Location: faculty_login.php");
	exit;
?>