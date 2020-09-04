<?php
  ob_start();
	session_start();
	if(isset($_SESSION['admin_hash']))
    {
      header("Location: admin_login.php");
    }
    elseif(!isset($_SESSION['admin_hash']))
    {
      session_unset();
      session_destroy();
      header("Location: ../home.php");
    }
    exit;
    ob_flush();
?>