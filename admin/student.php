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
        header("Location:logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OES - Manage Student</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <form class="form" action="student.php" method="POST">
            <h1 class="display-4">Student</h1>
            <div class="form-group">
                <label for="txb_student_enroll">Student Enroll No</label>
                <input class="form-control" type="text" id="txb_student_enroll" name="txb_student_enroll" required>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_student_fname">First Name</label>
                        <input class="form-control" type="text" id="txb_student_fname" name="txb_student_fname" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_student_mname">Middle Name</label>
                        <input class="form-control" type="text" id="txb_student_mname" name="txb_student_mname" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_student_lname">Last Name</label>
                        <input class="form-control" type="text" id="txb_student_lname" name="txb_student_lname" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="student_gender">Student Gender</label>
                <label class="radio-inline">
                    <input type="radio" id="student_gender" value="male" name="student_gender" checked> Male 
                </label>
                <label class="radio-inline">
                    <input type="radio" value="female" name="student_gender"> Female 
                </label>
            </div>
            <div class="form-group">
                <label for="student_dob">Student Date of Birth</label>
                <input type="date" class="form-control" id="student_dob" name="student_dob" required>
            </div>
            <div class="form-group">
                <label for="txb_student_email">Student Email</label>
                <input class="form-control" type="email" id="txb_student_email" name="txb_student_email" required oninvalid="this.setCustomValidity('Please Enter valid email')">
            </div>  
            <div class="form-group">
                <label for="txa_student_address">Student Address</label>
                <textarea class="form-control" rows="5" id="txa_student_address" name="txa_student_address" required></textarea>
            </div>
            <div class="form-group">
            <label for="sel_dept">Department</label>
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
            <label for="sel_cou">Course</label>
                <?php
                    $sql=mysqli_query($con,"SELECT course_id,course_name FROM tbl_course");
                    if(mysqli_num_rows($sql))
                    {
                        $select='<select class="form-control" id="sel_cou" name="sel_cou">';
                        while($rs=mysqli_fetch_array($sql))
                        {
                            $select.='<option value="'.$rs['course_id'].'">'.$rs['course_name'].'</option>';
                        }
                    }
                    $select.='</select>';
                    echo $select;
                ?>
            </div>
            <div class="form-group">
                <label for="sel_div">Student Div</label>
                <select class="form-control" name="sel_div" id="sel_div">
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                    <option>F</option>
                    <option>G</option>
                    <option>H</option>
                    <option>I</option>
                    <option>J</option>
                </select>
            </div>
            <div class="form-group">
            <label for="sel_sem">Semester</label>
                <?php
                    $sql=mysqli_query($con,"SELECT sem_id,semester,sem_year FROM tbl_sem");
                    if(mysqli_num_rows($sql))
                    {
                        $strtemp="";
                        $select='<select class="form-control" id="sel_sem" name="sel_sem">';
                        while($rs=mysqli_fetch_array($sql))
                        {
                            $strtemp=$rs['sem_id']." --> ".$rs['sem_year'];
                            $select.='<option value="'.$rs['semester'].'">'.$strtemp.'</option>';
                        }
                    }
                    $select.='</select>';
                    echo $select;
                ?>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_add_student" class="btn btn-outline-primary btn-block">Add Student</button>
            </div>
        </form>
        <?php
            if (isset($_POST['btn_add_student']))
            {
                $vali=mysqli_query($con,"select student_id from tbl_student where student_email='$_POST[txb_student_email]' or student_enroll_no='$_POST[txb_student_enroll]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
                    $senroll=$_POST['txb_student_enroll'];
                    $sfname=$_POST['txb_student_fname'];
                    $smname=$_POST['txb_student_mname'];
                    $slname=$_POST['txb_student_lname'];
                    $sgender=$_POST['student_gender'];
                    $sdob=date('Ymd',strtotime($_POST['student_dob']));
                    $email=$_POST['txb_student_email'];
                    $saddress=$_POST['txa_student_address'];
                    $dept=$_POST['sel_dept'];
                    require_once '../globle/mail.php';
                    $hash=md5($email);
                    $sid=0;
                    $ssem_id=$_POST['sel_sem'];
                    $scourse=$_POST['sel_cou'];
                    $sdiv=$_POST['sel_div'];
                    $result=mysqli_query($con,"insert into tbl_student (student_enroll_no,student_fname,student_mname,student_lname,student_gender,student_dob,student_email,student_address,student_login_pwd,student_hash) values('$senroll','$sfname','$smname','$slname','$sgender','$sdob','$email','$saddress','$pwdhash','$hash')") or die(mysqli_error());
                    $result2=mysqli_query($con,"select student_id from tbl_student where student_hash='$hash'") or die(mysqli_error());
                    $row2 = mysqli_fetch_array($result2);
                    if(is_array($row2))
                    {
                        $sid=$row2['student_id'];
                    }
                    $result3=mysqli_query($con,"insert into tbl_student_by_course (course_id,student_id,sem_id,student_div) values('$scourse','$sid','$ssem_id','$sdiv')") or die(mysqli_error());
                }
                else
                {
                    echo "<script> alert('Student Already Exist');</script>";
                }
            }
        ?>
        <?php
            $sql = "SELECT tbl_student.student_enroll_no,tbl_student.student_fname,tbl_student.student_mname,tbl_student.student_lname,tbl_student.student_gender,tbl_student.student_dob,tbl_student.student_email,tbl_student.student_address,tbl_sem.semester,tbl_sem.sem_year,tbl_course.course_name FROM (((tbl_student_by_course join tbl_sem on tbl_student_by_course.sem_id=tbl_sem.sem_id) join tbl_course on tbl_student_by_course.course_id=tbl_course.course_id) join tbl_student on tbl_student_by_course.student_id=tbl_student.student_id)";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
            {
                echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                        <tr>
                        <th>Student Enroll</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Student Gender</th>
                        <th>Student DOB</th>
                        <th>Student Email</th>
                        <th>Student Address</th>
                        <th>Student Semester</th>
                        <th>Student Sem Year</th>
                        <th>Student Course Name</th>
                        </tr>
                        ";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr><td>" . $row["student_enroll_no"]. "</td><td>" . $row["student_fname"]. "</td><td>" . $row["student_mname"]. "</td><td>" . $row["student_lname"]. "</td><td>" . $row["student_gender"]. "</td><td>" . $row["student_dob"]. "</td><td>" . $row["student_email"]. "</td><td>" . $row["student_address"]. "</td><td>" . $row["semester"]. "</td><td>" . $row["sem_year"]. "</td><td>" . $row["course_name"]. "</td></tr>";
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