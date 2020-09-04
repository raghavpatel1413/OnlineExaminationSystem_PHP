<?php
	session_start();
	require_once '../globle/database.php';
	if( isset($_SESSION['director_hash'])!="" )
	{
		header("Location: dashboard.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Director Login</title>
	<?php require_once '../globle/bootstrap.php' ?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body oncontextmenu="return false">
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	  <!-- Brand -->
		<a class="navbar-brand" href="../home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
		    <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" href="forgot_password.php">Forgot Password</a>
		      </li>
		    </ul>
		</div>
	</nav>
	<div class="container">
		<form class="form form-horizontal" action="director_login.php" method="POST">
			<h1 class="display-4">Director</h1>
			<div class="form-group">
				<label for="txt_DirectorEmail">Director Email</label>
				<input type="Email" class="form-control" name="txt_DirectorEmail" id="txt_DirectorEmail" placeholder="Enter Your Email id" required oninvalid="this.setCustomValidity('Please Enter valid email')">
			</div>
			<div class="form-group">
				<label for="txt_DirectorPassword">Director Password</label>
				<input type="password" class="form-control" name="txt_DirectorPassword" id="txt_DirectorPassword" placeholder="Enter Your Password" required>
			</div>
			<div class="g-recaptcha form-group" data-sitekey="6Ld-U0MUAAAAAI76RhubsdXKvAe66SAQZU6fZcKI"></div>
			<div class="form-group">
				<button type="submit" name="btn_submit" class="btn btn-outline-primary btn-block">Login</button>
			</div>
		</form>
	</div>
	<?php
		if (isset($_POST['btn_submit']))
		{
			echo "<br>";
			$secretKey="6Ld-U0MUAAAAACZhjc5z8kAQyTU02b4l-NQ0Up1f";
			$responseKey=$_POST['g-recaptcha-response'];
			$userIP=$_SERVER['REMOTE_ADDR'];
			$url="https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
			$response=file_get_contents($url);
			$response=json_decode($response);
			if($response->success)
			{
				$email=mysqli_real_escape_string($con,stripslashes($_POST['txt_DirectorEmail']));
				$password=mysqli_real_escape_string($con,stripslashes(sha1(md5($_POST['txt_DirectorPassword']))));
				$result=mysqli_query($con,"select director_hash from tbl_director where director_email='$email' and director_login_pwd='$password'") or die(mysql_error());
				$row  = mysqli_fetch_array($result);
				if(is_array($row))
				{
					if($row['director_hash']==md5($email))
					{
						$_SESSION['director_hash']=md5($email);
						echo "<div class='container alert alert-success alert-dismissable fade show' role='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Login Success</strong></div>";
						header("Location: dashboard.php");
					}
					else
					{
						echo "<div class='container alert alert-danger	 alert-dismissable fade show' role='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Login Fail. Please Enter Proper details</strong></div>";
					}
				}
				else
				{
					echo "<div class='container alert alert-danger	 alert-dismissable fade show' role='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Login Fail. Please Enter Proper details</strong></div>";
				}
			}
			else
			{
				echo "<div class='container alert alert-danger	 alert-dismissable fade show' role='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Captcha Fail. Please Try Again Captcha</strong></div>";
			}
		}
	?>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>