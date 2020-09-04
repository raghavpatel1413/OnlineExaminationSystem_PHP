<?php
	session_start();
	require '../globle/database.php';
	if(isset($_SESSION['director_hash']))
    {
    	header("Location: change_password.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Director Forgot Password</title>
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
		        <a class="nav-link" href="director_login.php">Director Login</a>
		      </li>
		    </ul>
		</div>
	</nav>
	<div class="container">
		<form class="form" action="forgot_password.php" method="POST">
			<h1 class="display-4">Forgot Password</h1>
			<div class="form-group">
				<label for="txb_DirectorEmail">Director Email Id</label>
				<input type="email" class="form-control" name="txb_DirectorEmail" id="txb_DirectorEmail" placeholder="Enter Director Email Id" required oninvalid="this.setCustomValidity('Please Enter valid email')">
			</div>
			<div class="g-recaptcha form-group" data-sitekey="6Ld-U0MUAAAAAI76RhubsdXKvAe66SAQZU6fZcKI"></div>
			<div class="form-group">
				<button type="submit" name="btn_request_password" class="btn btn-outline-primary btn-block">Request Password</button>
			</div>
			<?php
				if(isset($_POST['btn_request_password']))
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
						$email=$_POST['txb_DirectorEmail'];
						$hash=md5($email);
						require_once '../globle/reset_mail.php';
						mysqli_query($con,"update tbl_director set director_login_pwd='$pwdhash' where director_hash='$hash'") or die("Error To reset password");
					}
					else
					{
						echo "<div class='container alert alert-danger	 alert-dismissable fade show' role='alert'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Captcha Fail. Please Try Again Captcha</strong></div>";
					}
				}
			?>
		</form>
	</div>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>