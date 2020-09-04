<?php
	session_start();
	require '../globle/database.php';
	if(!isset($_SESSION['admin_hash']))
    {
      header("Location: admin_login.php");
    }
    $result=mysqli_query($con,"select admin_hash from tbl_admin where admin_hash='$_SESSION[admin_hash]'") or die(mysql_error());
    $row = mysqli_fetch_array($result);
    if(!is_array($row))
    {
        header("Location: logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Manage semester</title>
	<?php require_once '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
	<?php require_once 'nav_admin.php' ?>
	<div class="container">
		<form class="form" action="sem.php" method="POST">
			<h1 class="display-4">semester</h1>
			<div class="form-group">
				<label for="semister">Semester Name</label>
				<select class="form-control" name="semester" id="semester">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>
			</div>
			<div class="form-group">
				<label for="sem_year">Semester Year</label>
				<select class="form-control" name="sem_year" id="sem_year">
					<option>2018</option>
					<option>2019</option>
					<option>2020</option>
					<option>2021</option>
					<option>2022</option>
					<option>2023</option>
					<option>2024</option>
					<option>2025</option>
					<option>2026</option>
					<option>2027</option>
				</select>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_add_sem" class="btn btn-outline-primary btn-block">Add Sem</button>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_update_sem" class="btn btn-outline-primary btn-block">Increment student's Sem</button>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_decrement_sem" class="btn btn-outline-primary btn-block">Decrement student's Sem</button>
			</div>
		</form>
		<?php
			if (isset($_POST['btn_add_sem']))
			{
				$sname=$_POST['semester'];
				$syear=$_POST['sem_year'];
				$result=mysqli_query($con,"insert into tbl_sem (semester,sem_year) values('$sname','$syear')") or die(mysqli_error());
			}
			if(isset($_POST['btn_update_sem']))
			{
				mysqli_query($con,"update tbl_student_by_course set sem_id=sem_id+1") or die("Semester update error");
			}
			if(isset($_POST['btn_decrement_sem']))
			{
				mysqli_query($con,"update tbl_student_by_course set sem_id=sem_id-1") or die("Semester decrement error");
			}
		?>
		<?php
			$sql = "SELECT semester,sem_year FROM tbl_sem";
			$result = $con->query($sql);
			if ($result->num_rows > 0)
			{
			    echo "<div class='table-responsive-sm'>
						<table class='table table-striped table-bordered table-hover'>
						<tr>
						<th>semester</th>
						<th>semester Year</th>
						</tr>
						";
			    while($row = $result->fetch_assoc())
			    {
			        echo "<tr><td>" . $row["semester"]. "</td><td>" . $row["sem_year"]. "</td></tr>";
			    }
			    echo "</table></div>";
			}
			else
			{
			    echo "0 results";
			}
		?>
	</div>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>