<?php
  ob_start();
  session_start();
  if(isset($_SESSION['faculty_hash']))
    {
      header("Location: faculty_login.php");
    }
    elseif(!isset($_SESSION['faculty_hash']))
    {
      session_unset();
      session_destroy();
      header("Location: ../home.php");
    }
    exit;
    ob_flush();
?>