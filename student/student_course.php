<?php
    session_start();
    require '../globle/database.php';
    if(!isset($_SESSION['student_hash']))
    {
      header("Location: student_login.php");
    }
    $result=mysqli_query($con,"select student_hash from tbl_student where student_hash='$_SESSION[student_hash]'") or die(mysql_error());
    $row = mysqli_fetch_array($result);
    if(!is_array($row))
    {
        header("Location: logout.php");
    }
    if(isset($_SESSION['student_course']) and isset($_SESSION['student_id_by_course']))
    {
        header("Location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Student Choose Course</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_student.php' ?>
    <div class="container">
        <form class="form" action="student_course.php" method="POST">
            <h1 class="display-4">Select Course</h1>
            <div class="form-group">
                <label for="sel_course">Select Course</label>
                <?php
                    $sql=mysqli_query($con,"SELECT tbl_course.course_id,tbl_course.course_name,tbl_student_by_course.student_by_course_id from tbl_course join tbl_student_by_course on tbl_course.course_id=tbl_student_by_course.course_id where tbl_student_by_course.student_id in(select student_id from tbl_student where student_hash='$_SESSION[student_hash]')");
                    if(mysqli_num_rows($sql))
                    {
                        $select='<select class="form-control" id="sel_course" name="sel_course">';
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
                <button type="submit" name="btn_select_course" class="btn btn-outline-primary btn-block">Select Course</button>
            </div>
        </form>
    </div>
    <?php
        if (isset($_POST['btn_select_course']))
        {
            $scourse=$_POST['sel_course'];
            $_SESSION['student_course']=$scourse;
            $sql=mysqli_query($con,"select student_by_course_id from tbl_student_by_course where course_id='$scourse' and student_id=(select student_id from tbl_student where student_hash='$_SESSION[student_hash]')") or die(mysql_error());
            $row=mysqli_fetch_array($sql);
				if(is_array($row))
				{
                    $_SESSION['student_id_by_course']=$row['student_by_course_id'];
                }
            header("Location: dashboard.php");
        }
    ?>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>