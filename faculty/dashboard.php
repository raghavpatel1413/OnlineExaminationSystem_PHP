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
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Faculty Dashboard</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_faculty.php' ?>
    <div class="container">
        <h1 class="display-4">Faculty Dashboard</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(tbl_exam.exam_id) from tbl_exam where faculty_by_subject_id='$_SESSION[faculty_by_subject_id]'") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total exam by subject <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php' ?>
</body>
</html>