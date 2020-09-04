<?php
	session_start();
	require '../globle/database.php';
	if(!isset($_SESSION['faculty_hash']))
    {
      header("Location: faculty_login.php");
    }
    $result=mysqli_query($con,"select faculty_hash from tbl_faculty where faculty_hash='$_SESSION[faculty_hash]'") or die(mysql_error());
    $row = mysqli_fetch_array($result);
    if(!is_array($row))
    {
        header("Location: logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Faculty Change Password</title>
	<?php require_once '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
	<?php require_once 'nav_faculty.php' ?>
	<div class="container">
		<form class="form" action="change_password.php" method="POST">
			<h1 class="display-4">Change Password</h1>
			<div class="form-group">
				<label for="txt_OldPassword">Faculty Old Password</label>
				<input type="password" class="form-control" name="txt_OldPassword" id="txt_OldPassword" placeholder="Enter Your Password" required>
			</div>
			<div class="form-group">
				<label for="txt_FacultyPassword">Faculty Password</label>
				<input type="password" class="form-control" name="txt_FacultyPassword" id="txt_FacultyPassword" placeholder="Enter Your Password" required>
			</div>
			<div class="form-group">
				<label for="txt_conform_FacultyPassword">Conform Faculty Password</label>
				<input type="password" class="form-control" name="txt_conform_FacultyPassword" id="txt_conform_FacultyPassword" placeholder="Conform Your Password" required>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_change_password" class="btn btn-outline-primary btn-block">Change Password</button>
			</div>
			<?php
				if(isset($_POST['btn_change_password']))
				{
					if($_POST['txt_FacultyPassword']==$_POST['txt_conform_FacultyPassword'])
					{
						$old_pwd=sha1(md5($_POST['txt_OldPassword']));
						$pwd_temp=sha1(md5($_POST['txt_conform_FacultyPassword']));
						mysqli_query($con,"update tbl_faculty set faculty_login_pwd='$pwd_temp' where faculty_hash='$_SESSION[faculty_hash]' and faculty_login_pwd='$old_pwd'") or die("Password Update Error");	
					}
					else
					{
						echo "Password are not match";
					}
				}
			?>
		</form>
	</div>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>