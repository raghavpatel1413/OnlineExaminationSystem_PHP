<?php
	ob_start();
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
        header("Location:logout.php");
    }
    if(!isset($_SESSION['faculty_course_subject']) or !isset($_SESSION['faculty_by_subject_id']))
    {
        header("Location: logout.php");
    }
    if(isset($_SESSION['unit_id']))
    {
        unset($_SESSION['unit_id']);
    }
    ob_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>OES - Manage Unit</title>
	<?php require_once '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
	<?php require_once 'nav_faculty.php' ?>
	<div class="container">
		<form class="form" action="unit.php" method="POST">
			<h1 class="display-4">Unit</h1>
			<div class="form-group">
				<label for="txb_unit_index">Unit Index</label>
				<input class="form-control" type="text" id="txb_unit_index" name="txb_unit_index" required>
			</div>
			<div class="form-group">
				<label for="txb_unit_name">Unit Name</label>
				<input class="form-control" type="text" id="txb_unit_name" name="txb_unit_name" required>
			</div>
			<div class="form-group">
				<label for="txa_unit_details">Unit Details</label>
				<textarea class="form-control" rows="5" id="txa_unit_details" name="txa_unit_details" required></textarea>
			</div>
			<div class="form-group">
				<button type="submit" name="btn_add_unit" class="btn btn-outline-primary btn-block">Add Unit</button>
			</div>
		</form>
		<?php
			if (isset($_POST['btn_add_unit']))
			{
				$vali=mysqli_query($con,"select unit_id from tbl_unit where unit_index='$_POST[txb_unit_index]' and subject_code='$_SESSION[faculty_course_subject]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
					$uindex=$_POST['txb_unit_index'];
					$uname=$_POST['txb_unit_name'];
					$udetails=$_POST['txa_unit_details'];
					$result=mysqli_query($con,"insert into tbl_unit (unit_index,unit_name,unit_details,subject_code) values('$uindex','$uname','$udetails','$_SESSION[faculty_course_subject]')") or die(mysqli_error());
				}
				else
                {
                    echo "<script> alert('Unit index Already Exist');</script>";
                }
			}
		?>
		<form class="form" action="unit.php" method="POST">
		<?php
			$unit_id=array();
            $count=0;
			$sql = "SELECT unit_id,unit_index,unit_name,unit_details,subject_code FROM tbl_unit where subject_code='$_SESSION[faculty_course_subject]'";
			$result = $con->query($sql);
			if ($result->num_rows > 0)
			{
			    echo "<div class='table-responsive-sm'>
						<table class='table table-striped table-bordered table-hover'>
						<tr>
						<th>Unit index</th>
						<th>Unit Name</th>
						<th>Unit Details</th>
						<th>Subject Code</th>
						<th>Action</th>
						</tr>
						";
			    while($row = $result->fetch_assoc())
			    {
			        echo "<tr><td>" . $row["unit_index"]. "</td><td>" . $row["unit_name"]. "</td><td>" . $row["unit_details"]. "</td><td>" . $row["subject_code"]. "</td><td><input class='btn btn-outline-primary' type='submit' name=btn_select_$row[unit_id] value='Select'>&nbsp;<input class='btn btn-outline-danger' type='submit' name=btn_delete_$row[unit_id] value='Delete'></td></tr>";
			        $unit_id[$count]=$row['unit_id'];
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
            foreach ($unit_id as $btn)
            {
                if(isset($_POST['btn_select_'.$btn]))
                {
                    $_SESSION['unit_id']=$btn;
                    header("Location: questions.php");
                }
                if(isset($_POST['btn_delete_'.$btn]))
                {
                	$query1=mysqli_query($con,"select question_id from tbl_question where unit_id=$btn") or die("Error While delete Query 1");
                	while ($row1=mysqli_fetch_array($query1))
                	{
                		$query2=mysqli_query($con,"select equestion_id from tbl_exam_question where question_id='$row1[question_id]'") or die("Error While delete Query 2");
                		while ($row2=mysqli_fetch_array($query2))
                		{
                			mysqli_query($con,"delete from tbl_equestion_inputed where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 3");
                			mysqli_query($con,"delete from tbl_equestion_attempted where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 4");
                			mysqli_query($con,"delete from tbl_exam_question where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 5");
                		}
                		mysqli_query($con,"delete from tbl_option where question_id='$row1[question_id]'") or die("Error While delete Query 6");
                		mysqli_query($con,"delete from tbl_question where question_id='$row1[question_id]'") or die("Error While delete Query 7");
                	}
                	mysqli_query($con,"delete from tbl_unit where unit_id='$btn'") or die("Error While delete Query 8");
                }
            }
        ?>
	</div>
	<?php $con->close(); require_once 'footer.php';?>
</body>
</html>