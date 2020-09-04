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
    if(!isset($_SESSION['course_id']) or !isset($_SESSION['department_id']))
    {
    	header("Location: course.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Manage Subject</title>
	<?php require_once '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
	<?php require_once 'nav_admin.php' ?>
	<div class="container">
		<form class="form" action="subject.php" method="POST">
			<h1 class="display-4">Subject</h1>
			<div class="form-group">
				<label for="txb_subject_code">Subject Code</label>
				<input class="form-control" type="text" id="txb_subject_code" name="txb_subject_code" required>
			</div>
			<div class="form-group">
				<label for="txb_subject_name">Subject Name</label>
				<input class="form-control" type="text" id="txb_subject_name" name="txb_subject_name" required>
			</div>
			<div class="form-group">
				<label for="txa_subject_details">Subject Details</label>
				<textarea class="form-control" rows="5" id="txa_subject_details" name="txa_subject_details" required></textarea>
			</div>
			<div class="form-group">
				<label for="total_unit">Subject Total Unit</label>
				<select class="form-control" name="total_unit" id="total_unit">
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
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="sel_sem">Subject Sem</label>
						<select class="form-control" name="sel_sem" id="sel_sem">
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
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label for="sel_year">Subject Year</label>
						<select class="form-control" name="sel_year" id="sel_year">
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
				</div>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_add_subject" class="btn btn-outline-primary btn-block">Add Subject</button>
			</div>
		</form>
		<?php
			if (isset($_POST['btn_add_subject']))
			{
				$vali=mysqli_query($con,"select subject_code from tbl_subject where subject_code='$_POST[txb_subject_code]' and course_id='$_SESSION[course_id]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
					$scode=$_POST['txb_subject_code'];
					$sname=$_POST['txb_subject_name'];
					$sdetails=$_POST['txa_subject_details'];
					$totalunit=$_POST['total_unit'];
					$ssem=$_POST['sel_sem'];
					$syear=$_POST['sel_year'];
					$ssem_id=0;
					$getsem=mysqli_query($con,"select sem_id from tbl_sem where semester='$ssem' and sem_year='$syear'") or die(mysqli_error());
					$row  = mysqli_fetch_array($getsem);
					if(is_array($row))
					{
						$ssem_id=$row['sem_id'];
					}
					$result=mysqli_query($con,"insert into tbl_subject values('$scode','$sname','$sdetails','$totalunit','$_SESSION[course_id]','$ssem_id')") or die(mysqli_error());
				}
				else
                {
                    echo "<script> alert('Subject Already Exist');</script>";
                }
			}
		?>
		<form class="form" action="subject.php" method="POST">
		<?php
			$subject_code=array();
            $count=0;
			$sql = "SELECT * FROM tbl_subject join tbl_course on tbl_subject.course_id=tbl_course.course_id join tbl_sem on tbl_subject.sem_id=tbl_sem.sem_id where tbl_subject.course_id='$_SESSION[course_id]'";
			$result = $con->query($sql);
			if ($result->num_rows > 0)
			{
			    echo "<div class='table-responsive-sm'>
						<table class='table table-striped table-bordered table-hover'>
						<tr>
						<th>Subject Code</th>
						<th>Subject Name</th>
						<th>Subject Details</th>
						<th>Total Unit</th>
						<th>Course</th>
						<th>Sem</th>
						<th>Action</th>
						</tr>
						";
			    while($row = $result->fetch_assoc())
			    {
			        echo "<tr><td>" . $row["subject_code"]. "</td><td>" . $row["subject_name"]. "</td><td>" . $row["subject_details"]. "</td><td>" . $row["total_unit"]. "</td><td>" . $row["course_name"]. "</td><td>" . $row["semester"]." of ".$row["sem_year"]. "</td><td><input class='btn btn-outline-danger' type='submit' name=btn_delete_$row[subject_code] value='Delete'></td></tr>";
			        $subject_code[$count]=$row['subject_code'];
                    $count++;
			    }
			    echo "</table></div>";
			}
			else
			{
			    echo "0 results";
			}
		?>
		</form>
		<?php
            foreach ($subject_code as $btn)
            {
                if(isset($_POST['btn_delete_'.$btn]))
                {
                	// Raghav Will Be Hear.
                }
            }
        ?>
	</div>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>