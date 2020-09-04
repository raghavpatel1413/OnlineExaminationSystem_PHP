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
    if(!isset($_SESSION['faculty_course_subject']) or !isset($_SESSION['faculty_by_subject_id']))
    {
        header("Location: logout.php");
    }
    if(!isset($_SESSION['exam_show_id']))
    {
        header("Location:exam.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Faculty Show Exam result</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_faculty.php' ?>
    <div class="container">
        <form class="form" action="show_exam_result.php" method="POST">
            <h1 class="display-4">Exam result of students</h1>
            <?php
                $query1=mysqli_query($con,"select exam_passing_marks from tbl_exam where exam_id='$_SESSION[exam_show_id]'") or die("Error query 1");
                $rowtemp=mysqli_fetch_array($query1);
                $query2="select tbl_student.student_enroll_no,tbl_exam_student.obtained_marks,tbl_exam_student.exam_start_time,tbl_exam_student.exam_end_time from tbl_student join tbl_student_by_course on tbl_student.student_id=tbl_student_by_course.student_id join tbl_exam_student on tbl_student_by_course.student_by_course_id=tbl_exam_student.student_by_course_id where tbl_exam_student.exam_id='$_SESSION[exam_show_id]' ";
                $result = $con->query($query2);
                if ($result->num_rows > 0)
                {
                    $exam_id=array();
                    $count=0;
                    echo "<div class='table-responsive-sm'>
                            <table class='table table-striped table-bordered table-hover'>
                            <tr>
                            <th>Student Enrollment no</th>
                            <th>Obtained Marks</th>
                            <th>Exam Start Time</th>
                            <th>Exam finish Time</th>
                            <th>Status</th>
                            </tr>
                            ";
                    while($row = $result->fetch_assoc())
                    {
                        $ispass="Fail";
                        if($row['obtained_marks']>=$rowtemp['exam_passing_marks'])
                        {
                            $ispass="Pass";
                        }
                        echo "<tr><td>" . $row["student_enroll_no"]. "</td><td>" . $row["obtained_marks"]. "</td><td>" . $row["exam_start_time"]. "</td><td>" . $row["exam_end_time"]. "</td><td>$ispass</td></tr>";
                    }
                    echo "</table></div>";
                }
                else
                {
                    echo "0 results";
                }
            ?>
        </form>
    </div>
    <?php $con->close(); require_once 'footer.php'; $_SESSION['exam_show_id']="" ?>
</body>
</html>