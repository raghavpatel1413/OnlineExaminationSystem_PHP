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
        header("Location: logout.php");
    }
    ob_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OES - Admin Dashboard</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <h1 class="display-4">Admin Dashboard</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(department_id) from tbl_department") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Department <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-bank" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(course_id) from tbl_course") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Course <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-bank" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(subject_code) from tbl_subject") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Subject <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(unit_id) from tbl_unit") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Unit <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(director_id) from tbl_director") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Director <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(faculty_id) from tbl_faculty") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Faculty <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(student_id) from tbl_student") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Student <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-mortar-board" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(exam_id) from tbl_exam") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Exam <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php' ?>
</body>
</html>