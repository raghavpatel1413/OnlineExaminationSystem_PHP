<?php
  ob_start();
  session_start();
  if(isset($_SESSION['student_hash']))
    {
      header("Location: student_login.php");
    }
    elseif(!isset($_SESSION['student_hash']))
    {
      session_unset();
      session_destroy();
      header("Location: ../home.php");
    }
    exit;
    ob_flush();
?>