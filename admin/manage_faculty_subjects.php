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
        header("Location:logout.php");
    }
    if(!isset($_SESSION['faculty_id_for_sub']))
    {
        header("Location:faculty.php");
    }
    ob_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OES - Manage Faculty Subjects</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <form class="form" action="manage_faculty_subjects.php" method="POST">
            <h1 class="display-4">Manage Faculty Subjects</h1>

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
                <label for="sel_sub">Subject</label>
                <?php
                    $sql=mysqli_query($con,"SELECT subject_code,subject_name FROM tbl_subject");
                    if(mysqli_num_rows($sql))
                    {
                        $select='<select class="form-control" id="sel_sub" name="sel_sub">';
                        while($rs=mysqli_fetch_array($sql))
                        {
                            $select.='<option value="'.$rs['subject_code'].'">'.$rs['subject_name'].'</option>';
                        }
                    }
                    $select.='</select>';
                    echo $select;
                ?>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_add_subject" class="btn btn-outline-primary btn-block">Add Subject</button>
            </div>
            <?php
                $sql="select tbl_subject.subject_code,tbl_subject.subject_name,tbl_subject.subject_details from tbl_subject join tbl_faculty_subject on tbl_subject.subject_code=tbl_faculty_subject.subject_code where tbl_faculty_subject.faculty_id='$_SESSION[faculty_id_for_sub]'";
                $result = $con->query($sql);
                if ($result->num_rows > 0)
                {
                    echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                            <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Subject Details</th>
                            </tr>
                            ";
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr><td>" . $row["subject_code"]. "</td><td>" . $row["subject_name"]. "</td><td>" . $row["subject_details"]. "</td></tr>";
                    }
                    echo "</table>";
                }
                else
                {
                    echo "0 results";
                }
            ?>
        </form>
        <?php
            if(isset($_POST['btn_add_subject']))
            {
                $subid=$_POST['sel_sub'];
                $fid=$_SESSION['faculty_id_for_sub'];
                $result3=mysqli_query($con,"insert into tbl_faculty_subject (faculty_id,subject_code) values('$fid','$subid')") or die(mysqli_error());
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>