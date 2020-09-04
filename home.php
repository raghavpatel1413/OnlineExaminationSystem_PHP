<?php
	ob_start();
	session_start();
	require_once 'globle/database.php';	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home -Online Examination System (OES)</title>
	<?php require_once 'globle/bootstrap.php' ?>
	<link rel="manifest" href="manifest-android.json">

	<link rel="apple-touch-icon" href="globle/icon.png">
	<link rel="apple-touch-startup-image" href="globle/icon.png">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default" />
	<meta name="apple-mobile-web-app-title" content="Online Examination System">

</head>
<body oncontextmenu="return false">
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a class="navbar-brand" href="home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
			<ul class="navbar-nav">
			<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Select User</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="admin/admin_login.php">Admin</a>
				<a class="dropdown-item" href="director/director_login.php">Director</a>
				<a class="dropdown-item" href="faculty/faculty_login.php">Faculty</a>
				<a class="dropdown-item" href="student/student_login.php">Student</a>
			</div>
			</li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<form class="form" action="home.php" method="POST">
			<h1 class="display-4">Home</h1>
			<div class="container-fluid">
				<div class="card-deck">
					<div class="card">
						<img class="card-img-top" src="https://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="Admin Image">
						<div class="card-body">
							<h5 class="card-title">Admin</h5>
							<p class="card-text">Manage Deparment, Course, Subject and Users</p>
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-outline-info btn-block" value="Admin" name="btn_admin">
						</div>
					</div>
					<div class="card">
						<img class="card-img-top" src="https://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="Director Image">
						<div class="card-body">
							<h5 class="card-title">Director</h5>
							<p class="card-text">Report of Department</p>
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-outline-info btn-block" value="Director" name="btn_direcotr">
						</div>
					</div>

					<div class="card">
						<img class="card-img-top" src="https://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="Faculty Image">
						<div class="card-body">
							<h5 class="card-title">Faculty</h5>
							<p class="card-text">Manage Unit and Exams</p>
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-outline-info btn-block" value="Faculty" name="btn_faculty">
						</div>
					</div>
					  
					<div class="card">
						<img class="card-img-top" src="https://icons.iconarchive.com/icons/paomedia/small-n-flat/512/user-male-icon.png" alt="Student Image">
						<div class="card-body">
							<h5 class="card-title">Student</h5>
							<p class="card-text">Exam and Reports</p>
						</div>
						<div class="card-footer">
							<input type="submit" class="btn btn-outline-info btn-block" value="Student" name="btn_student">
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
			if(isset($_POST['btn_admin']))
			{
				header("Location: admin/admin_login.php");
			}
			elseif(isset($_POST['btn_direcotr']))
			{
				header("Location: director/director_login.php");
			}
			elseif(isset($_POST['btn_faculty']))
			{
				header("Location: faculty/faculty_login.php");
			}
			elseif(isset($_POST['btn_student']))
			{
				header("Location: student/student_login.php");
			}
		?>
	</div>
	<footer class="bg-dark text-white mt-4">
	    <div class="col-md-3">Uka Tarsadia University @<script>var year = new Date();document.write(year.getFullYear());</script></div>
	</footer>
	<?php $con->close(); ob_flush(); ?>
</body>
</html>