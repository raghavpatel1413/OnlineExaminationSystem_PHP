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
        header("Location:logout.php");
    }
    ob_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OES - Manage Faculty</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <form class="form" action="faculty.php" method="POST">
            <h1 class="display-4">Faculty</h1>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_faculty_fname">Faculty First Name</label>
                        <input class="form-control" type="text" id="txb_faculty_fname" name="txb_faculty_fname" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_faculty_mname">Faculty Middle Name</label>
                        <input class="form-control" type="text" id="txb_faculty_mname" name="txb_faculty_mname" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_faculty_lname">Faculty Last Name</label>
                        <input class="form-control" type="text" id="txb_faculty_lname" name="txb_faculty_lname" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="txb_faculty_email">Faculty Email</label>
                <input class="form-control" type="text" id="txb_faculty_email" name="txb_faculty_email" required>
            </div>
            <div class="form-group">
                <label for="txb_faculty_cno">Faculty Contact No</label>
                <input class="form-control" type="text" id="txb_faculty_cno" name="txb_faculty_cno" required>
            </div>
            <div class="form-group">
                <label for="faculty_gender">Faculty Gender</label>
                <label class="radio-inline">
                    <input type="radio" id="faculty_gender" value="male" name="faculty_gender" checked> Male 
                </label>
                <label class="radio-inline">
                    <input type="radio" value="female" name="faculty_gender"> Female 
                </label>
            </div>
            <div class="form-group">
                <label for="faculty_dob">Faculty Date of Birth</label>
                <input type="date" class="form-control" id="faculty_dob" name="faculty_dob" required>
            </div>
            <div class="form-group">
                <label for="txa_faculty_address">Faculty Address</label>
                <textarea class="form-control" rows="5" id="txa_faculty_address" name="txa_faculty_address" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_add_faculty" class="btn btn-outline-primary btn-block">Add Faculty</button>
            </div>
        </form>
        <?php
            if (isset($_POST['btn_add_faculty']))
            {
                $vali=mysqli_query($con,"select faculty_id from tbl_faculty where faculty_email='$_POST[txb_faculty_email]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
                    $ffname=$_POST['txb_faculty_fname'];
                    $fmname=$_POST['txb_faculty_mname'];
                    $flname=$_POST['txb_faculty_lname'];
                    $email=$_POST['txb_faculty_email'];
                    $fcno=$_POST['txb_faculty_cno'];
                    $fgender=$_POST['faculty_gender'];
                    $fdob=date('Ymd',strtotime($_POST['faculty_dob']));
                    $faddress=$_POST['txa_faculty_address'];
                    $hash=md5($email);
                    require_once '../globle/mail.php';
                    $fid=0;
                    mysqli_query($con,"insert into tbl_faculty (faculty_fname,faculty_mname,faculty_lname,faculty_email,faculty_cno,faculty_gender,faculty_dob,faculty_address,faculty_login_pwd,faculty_hash) values('$ffname','$fmname','$flname','$email','$fcno','$fgender','$fdob','$faddress','$pwdhash','$hash')") or die(mysqli_error());
                }
                else
                {
                    echo "<script> alert('Faculty Already Exist');</script>";
                }
            }
        ?>
        <form class="form" action="faculty.php" method="POST">
            <?php
            $faculty_id=array();
            $count=0;
            $sql = "SELECT tbl_faculty.faculty_id,tbl_faculty.faculty_fname,tbl_faculty.faculty_mname,tbl_faculty.faculty_lname,tbl_faculty.faculty_email,tbl_faculty.faculty_cno,tbl_faculty.faculty_gender,tbl_faculty.faculty_dob,tbl_faculty.faculty_address FROM tbl_faculty";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
            {
                echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                        <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>contact</th>
                        <th>Gender</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Action</th>
                        </tr>
                        ";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr><td>" . $row["faculty_fname"]. "</td><td>" . $row["faculty_mname"]. "</td><td>" . $row["faculty_lname"]. "</td><td>" . $row["faculty_email"]. "</td><td>" . $row["faculty_cno"]. "</td><td>" . $row["faculty_gender"]. "</td><td>" . $row["faculty_dob"]. "</td><td>" . $row["faculty_address"]. "</td><td><input class='btn btn-outline-primary' type='submit' name=btn_select_$row[faculty_id] value='Manage Subject'></td></tr>";
                        $faculty_id[$count]=$row['faculty_id'];
                        $count++;
                }
                echo "</table>";
            }
            else
            {
                echo "0 results";
            }
            ?>
            <?php
                foreach ($faculty_id as $btn)
                {
                    if(isset($_POST['btn_select_'.$btn]))
                    {
                        $_SESSION['faculty_id_for_sub']=$btn;
                        header("Location:manage_faculty_subjects.php");
                    }
                }
            ?>
        </form>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>