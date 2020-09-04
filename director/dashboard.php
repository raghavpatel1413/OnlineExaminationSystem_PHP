<?php
    session_start();
    require '../globle/database.php';
    if(!isset($_SESSION['director_hash']))
    {
      header("Location: director_login.php");
    }
    $result=mysqli_query($con,"select director_hash from tbl_director where director_hash='$_SESSION[director_hash]'") or die(mysql_error());
    $row = mysqli_fetch_array($result);
    if(!is_array($row))
    {
        header("Location: logout.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Director Dashboard</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_director.php' ?>
    <div class="container">
        <h1 class="display-4">Director Dashboard</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select tbl_department.department_name from tbl_department join tbl_director on tbl_department.department_id=tbl_director.department_id where tbl_director.director_hash='$_SESSION[director_hash]'") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Your Department <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="jumbotron">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    <?php
                        $Tempq=mysqli_query($con,"select count(tbl_course.course_id) from tbl_course join tbl_director on tbl_course.department_id=tbl_director.department_id where tbl_director.director_hash='$_SESSION[director_hash]'") or die("Dashboard value getting error");
                        $row=mysqli_fetch_array($Tempq);
                    ?>
                    <h1>Total Course Under you <?php echo "<br>".$row[0] ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>