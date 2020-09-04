<?php
  ob_start();
  session_start();
  if(isset($_SESSION['director_hash']))
    {
      header("Location: director_login.php");
    }
    elseif(!isset($_SESSION['director_hash']))
    {
      session_unset();
      session_destroy();
      header("Location: ../home.php");
    }
    exit;
    ob_flush();
?>