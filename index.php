<?php
	session_start();
	if(isset($_SESSION['admin_hash']))
    {
      header("Location: admin/admin_login.php");
    }
    elseif(isset($_SESSION['director_hash']))
    {
      header("Location: director/direcotr_login.php");
    }
    elseif(isset($_SESSION['faculty_hash']))
    {
      header("Location: faculty/faculty_login.php");
    }
    elseif(isset($_SESSION['student_hash']))
    {
      header("Location: student/student_login.php");
    }
    elseif(!isset($_SESSION['admin_hash']) or !isset($_SESSION['director_hash']) or !isset($_SESSION['faculty_hash']) or !isset($_SESSION['student_hash']))
    {
      session_unset();
      session_destroy();
      header("Location: home.php");
    }
    exit;
?>