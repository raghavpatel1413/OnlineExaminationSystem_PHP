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
    if(isset($_SESSION['department_id']))
    {
        unset($_SESSION['department_id']);
    }
    ob_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OES - Manage Department</title>
    <?php require '../globle/bootstrap.php' ?>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_admin.php' ?>
    <div class="container">
        <form class="form" action="department.php" method="POST">
            <h1 class="display-4">Department</h1>
            <div class="form-group">
                <label for="txb_department_name">Department Name</label>
                <input class="form-control" type="text" id="txb_department_name" name="txb_department_name" required>
            </div>
            <div class="form-group">
                <label for="txa_department_details">Department Details</label>
                <textarea class="form-control" rows="5" id="txa_department_details" name="txa_department_details" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_add_department" class="btn btn-outline-primary btn-block">Add Department</button>
            </div>
        </form>
        <?php
            if (isset($_POST['btn_add_department']))
            {
                $vali=mysqli_query($con,"select department_id from tbl_department where department_name='$_POST[txb_department_name]'");
                $valirow=mysqli_num_rows($vali);
                if($valirow==0)
                {
                    $dname=$_POST['txb_department_name'];
                    $ddetails=$_POST['txa_department_details'];
                    mysqli_query($con,"insert into tbl_department (department_name,department_details) values('$dname','$ddetails')") or die(mysqli_error());
                }
                else
                {
                    echo "<script> alert('Department Already Exist');</script>";
                }
            }
        ?>
        <form class="form" align="center" action="department.php" method="POST">
            <?php
                $dept_id=array();
                $count=0;
                $sql = "SELECT department_id,department_name, department_details FROM tbl_department";
                $result = $con->query($sql);

                if ($result->num_rows > 0)
                {
                    echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                            <tr>
                            <th>Department Name</th>
                            <th>Department Details</th>
                            <th>Action</th>
                            </tr>
                            ";
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr><td>" . $row["department_name"]. "</td><td>" . $row["department_details"]. "</td><td><input class='btn btn-outline-primary' type='submit' name=btn_select_$row[department_id] value='Select'></td></tr>";
                        $dept_id[$count]=$row['department_id'];
                        $count++;
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
            foreach ($dept_id as $btn)
            {
                if(isset($_POST['btn_select_'.$btn]))
                {
                    $_SESSION['department_id']=$btn;
                    header("Location: course.php");
                }
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php';?>
</body>
</html>