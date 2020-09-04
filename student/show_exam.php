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
    if(!isset($_SESSION['student_course']) or !isset($_SESSION['student_id_by_course']))
    {
        header("Location: logout.php");
    }
    if($_SESSION['exam_id']=="")
    {
        header("Location: exam.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Student Show Exam</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_student.php' ?>
    <div class="container">
        <form class="form" action="show_exam.php" method="POST">
            <h1 class="display-4">Previous Exam</h1>
            <?php
                $result0=mysqli_query($con,"select faculty_by_subject_id,tbl_exam_student.exam_student_id from tbl_exam join tbl_exam_student on tbl_exam.exam_id=tbl_exam_student.exam_id where tbl_exam.exam_id='$_SESSION[exam_id]' and tbl_exam_student.student_by_course_id='$_SESSION[student_id_by_course]'") or die(mysql_error());
                $row0  = mysqli_fetch_array($result0);
                if(is_array($row0))
                {
                    $query=mysqli_query($con,"select tbl_exam_question.equestion_id,tbl_question.question_id,tbl_question.question_desc,tbl_question.question_level,tbl_question.question_marks,tbl_question.question_type from tbl_exam_question join tbl_question on tbl_exam_question.question_id=tbl_question.question_id where tbl_exam_question.exam_id='$_SESSION[exam_id]'");
                    if(mysqli_num_rows($query))
                    {
                        while ($row1=mysqli_fetch_array($query))
                        {
                            echo "<div class='form-group'>";
                            echo "<label for=question_$row1[question_id]>Question</label>";
                            echo "<textarea class='form-control' rows='5' id=question_$row1[question_id] name=question_$row1[question_id] disabled>$row1[question_desc]</textarea>";
                            echo "</div>";
                            echo "<div class='row'>";
                                echo "<div class='col col-sm-3'>";
                                    echo "<h4>Answer</h4>";
                                echo "</div>";
                                echo "<div class='col col-sm-9'>";
                                    if($row1['question_type']==1)
                                    {
                                        $selected=mysqli_query($con,"select option_id,isright from tbl_equestion_attempted where equestion_id=$row1[equestion_id]") or die("Erorr ar selected query");
                                        $row2=mysqli_fetch_array($selected);
                                        if($row2['isright']==1)
                                        {
                                            $get_option=mysqli_query($con,"select option_desc from tbl_option where option_id='$row2[option_id]' and option_correct=1 ") or die("Error while get option details");
                                            $row3=mysqli_fetch_array($get_option);
                                            echo "<div class='alert alert-success' role='alert'>$row3[option_desc]</div>";
                                        }
                                        elseif($row2['isright']==0)
                                        {
                                            $get_option=mysqli_query($con,"select option_desc from tbl_option where option_id='$row2[option_id]'") or die("Error while get option details");
                                            $row3=mysqli_fetch_array($get_option);
                                            echo "<div class='alert alert-danger' role='alert'>$row3[option_desc]</div>";
                                        }
                                    }
                                    elseif($row1['question_type']==2)
                                    {
                                        $selected=mysqli_query($con,"select answer_desc,isright from tbl_equestion_inputed where equestion_id=$row1[equestion_id]") or die("Erorr ar selected query");
                                        $row2=mysqli_fetch_array($selected);
                                        if($row2['isright']==1)
                                        {
                                            echo "<div class='alert alert-success' role='alert'>$row2[answer_desc]</div>";
                                        }
                                        elseif($row2['isright']==0)
                                        {
                                            echo "<div class='alert alert-danger' role='alert'>$row2[answer_desc]</div>";
                                        }
                                    }
                                echo "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "No Questions";
                    }
                }
                else
                {
                    echo "You are not given this exam";
                }
                unset($_SESSION['exam_id']);
            ?>
        </form>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>