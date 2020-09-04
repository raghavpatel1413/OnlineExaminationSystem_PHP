<?php
	session_start();
	unset($_SESSION['student_hash']);
	session_unset();
	//session_destroy();
	header("Location: student_login.php");
	exit;
?>