<?php
	ob_start();
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
    if(!isset($_SESSION['department_id']))
    {
    	header("Location: department.php");
    }
    if(isset($_SESSION['course_id']))
    {
    	unset($_SESSION['course_id']);
    }
    ob_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Manage Course</title>
	<?php require_once '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
	<?php require_once 'nav_admin.php' ?>
	<div class="container">
		<form class="form" action="course.php" method="POST">
			<h1 class="display-4">Course</h1>
			<div class="form-group">
				<label for="txb_course_name">Course Name</label>
				<input class="form-control" type="text" id="txb_course_name" name="txb_course_name" required>
			</div>
			<div class="form-group">
				<label for="txa_course_details">Course Details</label>
				<textarea class="form-control" rows="5" id="txa_course_details" name="txa_course_details" required></textarea>
			</div>
			<div class="form-group">
				<label for="sel_sem">Total Sem</label>
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
			<div class="form-group">
				<button type="submit" name="btn_add_course" class="btn btn-outline-primary btn-block">Add Course</button>
			</div>
		</form>
		<?php
			if (isset($_POST['btn_add_course']))
			{
				$vali=mysqli_query($con,"select course_name from tbl_course where course_name='$_POST[txb_course_name]' and department_id='$_SESSION[department_id]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
					$cname=$_POST['txb_course_name'];
					$cdetails=$_POST['txa_course_details'];
					$csem=0;
					$csem=$_POST['sel_sem'];
					mysqli_query($con,"insert into tbl_course (course_name,course_details,course_total_sem,department_id)values('$cname','$cdetails','$csem','$_SESSION[department_id]')") or die(mysqli_error());
				}
				else
                {
                    echo "<script> alert('Course Already Exist');</script>";
                }
			}
		?>
		<form class="form" align="center" action="course.php" method="POST">
		<?php
			$cou_id=array();
            $count=0;
			$sql = "SELECT tbl_course.course_id,tbl_course.course_name,tbl_course.course_details,tbl_course.course_total_sem,tbl_department.department_name FROM tbl_course join tbl_department on tbl_course.department_id=tbl_department.department_id where tbl_course.department_id='$_SESSION[department_id]'";
			$result = $con->query($sql);
			if ($result->num_rows > 0)
			{
			    echo "<div class='table-responsive-sm'>
						<table class='table table-striped table-bordered table-hover'>
						<tr>
						<th>Course Name</th>
						<th>Course Details</th>
						<th>Totel Sem</th>
						<th>Department</th>
						<th>Action</th>
						</tr>
						";
			    while($row = $result->fetch_assoc())
			    {
			        echo "<tr><td>" . $row["course_name"]. "</td><td>" . $row["course_details"]. "</td><td>" . $row["course_total_sem"]. "</td><td>" . $row["department_name"]. "</td><td><input class='btn btn-outline-primary' type='submit' name=btn_select_$row[course_id] value='Select'></td></tr>";
			        $cou_id[$count]=$row['course_id'];
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
            foreach ($cou_id as $btn)
            {
                if(isset($_POST['btn_select_'.$btn]))
                {
                    $_SESSION['course_id']=$btn;
                    header("Location: subject.php");
                }
            }
        ?>
	</div>
	<?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>