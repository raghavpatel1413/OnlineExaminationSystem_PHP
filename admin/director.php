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
    <title>OES - Manage Director</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <form class="form" action="director.php" method="POST">
            <h1 class="display-4">Director</h1>
            <div class="form-group">
                <label for="txb_director_name">Director Name</label>
                <input class="form-control" type="text" id="txb_director_name" name="txb_director_name" required>
            </div>
            <div class="form-group">
                <label for="txb_director_email">Director Email</label>
                <input class="form-control" type="text" id="txb_director_email" name="txb_director_email" required>
            </div>
            <div class="form-group">
                <label for="txb_director_cno">Director Contact No</label>
                <input class="form-control" type="text" id="txb_director_cno" name="txb_director_cno" required>
            </div>
            <div class="form-group">
                <label for="txa_director_address">Director Address</label>
                <textarea class="form-control" rows="5" id="txa_director_address" name="txa_director_address" required></textarea>
            </div>
            <div class="form-group">
                <label for="director_gender">Director Gender</label>
                <label class="radio-inline">
                    <input type="radio" id="director_gender" value="male" name="director_gender" checked> Male 
                </label>
                <label class="radio-inline">
                    <input type="radio" value="female" name="director_gender"> Female 
                </label>
            </div>
            <div class="form-group">
                <label for="director_dob">Director Date of Birth</label>
                <input type="date" class="form-control" id="director_dob" name="director_dob" required>
            </div>
            <div class="form-group">
				<label for="sel_dept">Director Departmet</label>
	            <?php
		            $sql=mysqli_query($con,"SELECT department_id,department_name FROM tbl_department");
					if(mysqli_num_rows($sql))
					{
						$select='<select class="form-control" id="sel_dept" name="sel_dept">';
						while($rs=mysqli_fetch_array($sql))
						{
						    $select.='<option value="'.$rs['department_id'].'">'.$rs['department_name'].'</option>';
						}
					}
					$select.='</select>';
					echo $select;
				?>
			</div>
            <div class="form-group">
                <button type="submit" name="btn_add_director" class="btn btn-outline-primary btn-block">Add director</button>
            </div>
        </form>
        <?php
            if (isset($_POST['btn_add_director']))
            {
                $vali=mysqli_query($con,"select director_id from tbl_director where director_email='$_POST[txb_director_email]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
                    $dname=$_POST['txb_director_name'];
                    $email=$_POST['txb_director_email'];
                    $dcno=$_POST['txb_director_cno'];
                    $daddress=$_POST['txa_director_address'];
                    $dgender=$_POST['director_gender'];
                    $ddob=date('Ymd',strtotime($_POST['director_dob']));
                    $hash=md5($email);
                    $ddept=$_POST['sel_dept'];
                    require_once '../globle/mail.php';
                    $result=mysqli_query($con,"insert into tbl_director (director_name,director_email,director_cno,director_address,director_gender,director_dob,director_login_pwd,director_hash,department_id) values ('$dname','$email','$dcno','$daddress','$dgender','$ddob','$pwdhash','$hash','$ddept')") or die(mysqli_error());
                }
                else
                {
                    echo "<script> alert('Director Already Exist');</script>";
                }
            }
        ?>
        <?php
            $sql = "SELECT tbl_director.director_name,tbl_director.director_email,tbl_director.director_cno,tbl_director.director_address,tbl_director.director_gender,tbl_director.director_dob,tbl_department.department_name FROM tbl_director join tbl_department on tbl_director.department_id=tbl_department.department_id";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
            {
                echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                        <tr>
                        <th>Director Name</th>
                        <th>Director Email</th>
                        <th>Director contact</th>
                        <th>Director Address</th>
                        <th>Director Gender</th>
                        <th>Director Date of Birth</th>
                        <th>Department</th>
                        </tr>
                        ";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr><td>" . $row["director_name"]. "</td><td>" . $row["director_email"]. "</td><td>" . $row["director_cno"]. "</td><td>" . $row["director_address"]. "</td><td>" . $row["director_gender"]. "</td><td>" . $row["director_dob"]. "</td><td>" . $row["department_name"]. "</td></tr>";
                }
                echo "</table>";
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