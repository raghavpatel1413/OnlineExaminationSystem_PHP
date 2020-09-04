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
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Student Dashboard</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_student.php' ?>
    <div class="container">
        <h1 class="display-4">Student Dashboard</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-mortar-board" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(tbl_exam.exam_id) from tbl_exam join tbl_exam_student on tbl_exam.exam_id=tbl_exam_student.exam_id where student_by_course_id ='$_SESSION[student_id_by_course]' ") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Exam <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>