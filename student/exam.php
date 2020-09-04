<?php
    ob_start();
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
    if(!isset($_SESSION['student_course']) or !isset($_SESSION['student_id_by_course']))
    {
        header("Location: logout.php");
    }
    if(isset($_SESSION['exam_id']))
    {
        unset($_SESSION['exam_id']);
    }
    ob_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_student.php' ?>
    <div class="container">
        <form class="form" action="exam.php" method="POST">
            <h1 class="display-4">My Exams</h1>
            <?php
                $sql="select
                    tbl_exam.exam_id,
                tbl_exam_student.exam_student_id,
                tbl_exam.exam_date_create,
                tbl_exam.exam_date_start,
                tbl_exam.exam_start_time,
                tbl_exam.exam_total_time,
                tbl_exam.exam_total_marks,
                tbl_exam.exam_passing_marks,
                tbl_exam.faculty_by_subject_id,
                tbl_student_by_course.student_id,
                tbl_student_by_course.sem_id,
                tbl_student_by_course.student_div,
                tbl_exam_student.obtained_marks,
                tbl_exam_student.exam_start_time as s_start_time,
                tbl_exam_student.exam_end_time as s_end_time,
                tbl_subject.subject_name
                from
                ((tbl_exam_student join tbl_exam on tbl_exam_student.exam_id=tbl_exam.exam_id)
                join tbl_student_by_course on tbl_exam_student.student_by_course_id=tbl_student_by_course.student_by_course_id) 
                join tbl_faculty_subject on tbl_exam.faculty_by_subject_id=tbl_faculty_subject.faculty_by_subject_id
                join tbl_subject on tbl_faculty_subject.subject_code=tbl_subject.subject_code
                where tbl_exam_student.student_by_course_id='$_SESSION[student_id_by_course]';";

                $exams=array();
                $count=0;
                $result = $con->query($sql);
                if ($result->num_rows > 0)
                {
                    echo "<div class='table-responsive-sm'>
                            <table class='table table-striped table-bordered table-hover'>
                            <tr>
                            <th>Subject</th>
                            <th>Date of Start</th>
                            <th>Start Time</th>
                            <th>Total Time</th>
                            <th>Total Marks</th>
                            <th>Passing Marks</th>
                            <th>Obtained Marks</th>
                            <th>Your Exam Start Time</th>
                            <th>Your Exam End Time</th>
                            <th>Action</th>
                            </tr>
                            ";
                    while($row = $result->fetch_assoc())
                    {
                        $time = date("G:i:s");
                        echo "<tr><td>" . $row["subject_name"]. "</td><td>" . $row["exam_date_start"]. "</td><td>" . $row["exam_start_time"]. "</td><td>" . $row["exam_total_time"]. "</td><td>" . $row["exam_total_marks"]. "</td><td>" . $row["exam_passing_marks"]. "</td><td>" . $row["obtained_marks"]. "</td><td>" . $row["s_start_time"]. "</td><td>" . $row["s_end_time"]. "</td>";
                        $exams[$count]=$row['exam_id'];
                        $count++;
                        if($row["exam_date_start"]<date('Y-m-d') or !empty($row['obtained_marks']))
                        {
                            echo "<td><input class='btn btn-outline-primary' type='submit' name=btn_show_$row[exam_id] value='Show Exam'></td>";
                        }
                        else if($row["exam_date_start"]>date('Y-m-d'))
                        {
                            echo "<td><input class='btn btn-outline-primary' type='submit' value='Start Exam' disabled></td>";
                        }
                        else if($row["exam_date_start"]==date('Y-m-d'))
                        {
                            $time3 = strtotime($row['exam_start_time']) + strtotime($row['exam_total_time']) - strtotime('00:00:00');
                            $exam_finesh_time = date('H:i:s', $time3);
                            if($row['exam_start_time']>$time)
                            {
                                echo "<td><input class='btn btn-outline-primary' type='submit' value='Start Soon' disabled></td>";
                            }
                            else if($row['exam_start_time']<=$time)
                            {
                                if($exam_finesh_time>$time)
                                {
                                    echo "<td><input class='btn btn-outline-primary' type='submit' name=btn_start_$row[exam_id] value='Start Exam'></td>";
                                }
                                elseif($exam_finesh_time<$time)
                                {
                                    echo "<td><input class='btn btn-outline-primary' type='submit' name=btn_show_$row[exam_id] value='Show Exam'></td>";
                                }
                            }
                        }

                        echo "</tr>";
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
            foreach ($exams as $students_exams)
            {
                if(isset($_POST['btn_start_'.$students_exams]))
                {
                    $_SESSION['exam_id']=$students_exams;
                    header("location: examining.php");
                }
                else if(isset($_POST['btn_show_'.$students_exams]))
                {
                    $_SESSION['exam_id']=$students_exams;
                    header("Location: show_exam.php");
                    //will show exam Result using student -->exam id
                }
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>