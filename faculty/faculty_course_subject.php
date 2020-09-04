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
        header("Location:logout.php");
    }
    /*if(isset($_SESSION['faculty_course_subject']) and isset($_SESSION['faculty_by_subject_id']))
    {
        header("Location: dashboard.php");
    }*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Faculty Select Course And Subject</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_faculty.php' ?>
    <div class="container">
        <form class="form" action="faculty_course_subject.php" method="POST">
            <h1 class="display-4">Select Subject</h1>
            <div class="form-group">
                <label for="sel_faculty_subject">Select Course And Subject</label>
                <?php
                    $sql=mysqli_query($con,"select tbl_faculty_subject.faculty_by_subject_id,tbl_faculty_subject.subject_code,tbl_subject.course_id,tbl_subject.subject_name,tbl_subject.sem_id,tbl_course.course_name,tbl_department.department_name from tbl_subject join tbl_faculty_subject on tbl_subject.subject_code=tbl_faculty_subject.subject_code join tbl_course on tbl_subject.course_id=tbl_course.course_id join tbl_department on tbl_course.department_id=tbl_department.department_id where tbl_faculty_subject.faculty_id in (select faculty_id from tbl_faculty where faculty_hash='$_SESSION[faculty_hash]')");
                    if(mysqli_num_rows($sql))
                    {
                        $select='<select class="form-control" id="sel_faculty_subject" name="sel_faculty_subject">';
                        while($rs=mysqli_fetch_array($sql))
                        {
                            $select.='<option value="'.$rs['subject_code'].'">'."$rs[department_name] --> $rs[course_name] --> $rs[subject_name]".'</option>';
                        }
                    }
                    $select.='</select>';
                    echo $select;
                ?>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_select_course_subject" class="btn btn-outline-primary btn-block">Select Course And Subject</button>
            </div>
        </form>
    </div>
    <?php
        if (isset($_POST['btn_select_course_subject']))
        {
            $fsubject_code=$_POST['sel_faculty_subject'];
            $_SESSION['faculty_course_subject']=$fsubject_code;
            $result=mysqli_query($con,"select faculty_by_subject_id from tbl_faculty_subject where subject_code=$fsubject_code and faculty_id=(select faculty_id from tbl_faculty where faculty_hash='$_SESSION[faculty_hash]')");
            $row  = mysqli_fetch_array($result);
            if(is_array($row))
            {
                $_SESSION['faculty_by_subject_id']=$row['faculty_by_subject_id'];
            }
            else
            {
                header("Location: logout.php");
            }
            header("Location: dashboard.php");
        }
    ?>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>