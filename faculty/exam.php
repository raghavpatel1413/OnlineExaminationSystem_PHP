<?php
    ob_start();
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
    ob_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Faculty Manage Exam</title>
    <?php require '../globle/bootstrap.php' ?>
    <script>
        $(document).ready(function(){
            $("#time_exam_total_time").change(function(){
                var st= this.st;
                st = $("#time_exam_start_time").val();
                et = $("#time_exam_total_time").val();
                
                var st=st.split(':');
                var et=et.split(':');
                
                var extra=0;
                var sesh=0;
                var hour=0;
                var minute=0;
                if((parseInt(st[1])+parseInt(et[1]))>=60)
                {
                    extra=1;
                    minute=parseInt(st[1])+parseInt(et[1])-60;
                }
                else if((parseInt(st[1])+parseInt(et[1]))<60)
                {
                    minute=parseInt(st[1])+parseInt(et[1]);
                }
                if(extra != 0)
                {
                    hour=parseInt(st[0])+parseInt(et[0])+1;
                }
                else if(extra == 0)
                {
                    hour=parseInt(st[0])+parseInt(et[0]);
                }
                if(hour <=23 || (hour == 24 && minute == 0))
                {
                    alert(Total Exam time is"  "+hour+"   "+minute);
                }
                else
                {
                    $("#time_exam_total_time").val(null);
                    alert("Different between Start time and End time is 24:00");
                }
            });
            $("#time_exam_start_time").change(function(){
                $("#time_exam_total_time").val(null);
            });
        });
    </script>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_faculty.php' ?>
    <div class="container">
        <form class="form" action="exam.php" method="POST">
            <h1 class="display-4">Exam</h1>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="date_exam_start_date">Exam Start Date</label>
                        <input type="date" class="form-control" id="date_exam_start_date" name="date_exam_start_date" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="time_exam_start_time">Exam Start Time</label>
                        <input type="time" class="form-control" id="time_exam_start_time" name="time_exam_start_time" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="time_exam_total_time">Exam Total Time</label>
                        <input type="time" class="form-control timepicker" id="time_exam_total_time" name="time_exam_total_time" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_exam_total_marks">Exam Total Marks</label>
                        <input type="text" class="form-control" id="txb_exam_total_marks" name="txb_exam_total_marks" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="txb_exam_passing_marks">Exam Passing Marks</label>
                        <input type="text" class="form-control" id="txb_exam_passing_marks" name="txb_exam_passing_marks" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="sel_div">Student Divison</label>
                        <select class="form-control" name="sel_div" id="sel_div">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                        </select>
                    </div>
                </div>
            </div>
            <?php
                $que=array();
                $count=0;
                $sql="select question_id,question_desc,question_level,question_marks,question_type from tbl_question where subject_code='$_SESSION[faculty_course_subject]'";
                $result = $con->query($sql);
                if ($result->num_rows > 0)
                {
                    echo "<div class='table-responsive-sm'>
                            <table class='table table-striped table-bordered table-hover'>
                            <tr>
                            <th>Select</th>
                            <th>Question</th>
                            <th>Question Level</th>
                            <th>Question Mark</th>
                            <th>Question Type</th>
                            </tr>
                            ";
                    while($row = $result->fetch_assoc())
                    {
                        $string="";
                        if($row['question_level']==1)
                        {
                            $string="Easy";
                        }
                        elseif ($row['question_level']==2)
                        {
                            $string="Medium";
                        }
                        elseif ($row['question_level']==3)
                        {
                            $string="Hard";
                        }
                        if($row['question_type']==1)
                        {
                            $type="MCQ's";
                        }
                        elseif ($row['question_type']==2)
                        {
                            $type="Filling Blank";
                        }

                        $que[$count]=$row['question_id'];
                        $count++;
                        echo "<tr><td><input type='checkbox' name=chb_$row[question_id]></td><td>" . $row["question_desc"]. "</td><td>" . $string. "</td><td>" . $row["question_marks"]. "</td><td>" . $type. "</td></tr>";
                    }
                    echo "</table></div>";
                }
                else
                {
                    echo "0 results";
                }
            ?>
            

            <div class="form-group">
                <button type="submit" name="btn_add_exam" class="btn btn-outline-primary btn-block">Add Exam</button>
            </div>
        </form>
        <?php
            if(isset($_POST['btn_add_exam']))
            {
                $ecreate_date=date('Y-m-d');
                $estart_date=date('Ymd',strtotime($_POST['date_exam_start_date']));
                $estart_time=date('H:i:s',strtotime($_POST['time_exam_start_time']));
                $etotal_time=date('H:i:s',strtotime($_POST['time_exam_total_time']));
                $etotal_marks=$_POST['txb_exam_total_marks'];
                $epassing_marks=$_POST['txb_exam_passing_marks'];
                $div=$_POST['sel_div'];

                $query=mysqli_query($con,"insert into tbl_exam (exam_date_create,exam_date_start,exam_start_time,exam_total_time,exam_total_marks,exam_passing_marks,faculty_by_subject_id) values('$ecreate_date','$estart_date','$estart_time','$etotal_time','$etotal_marks','$epassing_marks','$_SESSION[faculty_by_subject_id]')");
                $exam_id=mysqli_insert_id($con);
                $query2=mysqli_query($con,"select tbl_student_by_course.student_by_course_id from tbl_student_by_course join tbl_subject on tbl_student_by_course.course_id=tbl_subject.course_id and tbl_student_by_course.sem_id=tbl_subject.sem_id where tbl_subject.subject_code='$_SESSION[faculty_course_subject]' and student_div='$div'") or die(mysql_error());
                if(mysqli_num_rows($query2))
                {
                    while($rs=mysqli_fetch_array($query2))
                    {
                        $query3=mysqli_query($con,"insert into tbl_exam_student (exam_id,student_by_course_id) values ('$exam_id','$rs[student_by_course_id]')") or die(mysql_error());
                    }
                }
                //$query3=mysqli_query($con,"insert into tbl_exam_student (exam_id,student_by_course_id) values ('mysql_insert_id()',)");

                foreach ($que as $selectes_que)
                {
                    if(isset($_POST['chb_'.$selectes_que]))
                    {
                        $query4=mysqli_query($con,"insert into tbl_exam_question(exam_id,question_id) values('$exam_id','$selectes_que')");
                    }
                }
            }
        ?>
        <form class="form" action="exam.php" method="POST" >
        <?php
            $sql = "SELECT exam_id,exam_date_create,exam_date_start,exam_start_time,exam_total_time,exam_total_marks,exam_passing_marks FROM tbl_exam where faculty_by_subject_id='$_SESSION[faculty_by_subject_id]'";
            $result = $con->query($sql);
            if ($result->num_rows > 0)
            {
                $exam_id=array();
                $count=0;
                echo "<div class='table-responsive-sm'>
                        <table class='table table-striped table-bordered table-hover'>
                        <tr>
                        <th>Date of Create</th>
                        <th>Date of Start</th>
                        <th>Start Time</th>
                        <th>Total Time</th>
                        <th>Total Marks</th>
                        <th>Passing Marks</th>
                        <th>Action</th>
                        </tr>
                        ";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr><td>" . $row["exam_date_create"]. "</td><td>" . $row["exam_date_start"]. "</td><td>" . $row["exam_start_time"]. "</td><td>" . $row["exam_total_time"]. "</td><td>" . $row["exam_total_marks"]. "</td><td>" . $row["exam_passing_marks"]. "</td><td><input class='btn btn-outline-danger' type='submit' name=btn_delete_$row[exam_id] value='Delete'>&nbsp;<input class='btn btn-outline-primary' type='submit' name=btn_select_$row[exam_id] value='Show'></tr>";
                    $exam_id[$count]=$row['exam_id'];
                    $count++;
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
            foreach ($exam_id as $btn)
            {
                if(isset($_POST['btn_delete_'.$btn]))
                {
                    mysqli_query($con,"delete from tbl_equestion_attempted where equestion_id in (select equestion_id from tbl_exam_question where exam_id=$btn)") or die("Error While delete Query 1");
                    mysqli_query($con,"delete from tbl_equestion_inputed where equestion_id in (select equestion_id from tbl_exam_question where exam_id=$btn)") or die("Error While delete Query 2");
                    mysqli_query($con,"delete from tbl_exam_question where exam_id=$btn") or die("Error While delete Query 3");
                    mysqli_query($con,"delete from tbl_exam_student where exam_id=$btn") or die("Error While delete Query 4");
                    mysqli_query($con,"delete from tbl_exam where exam_id=$btn") or die("Error While delete Query 5");
                }
                if(isset($_POST['btn_select_'.$btn]))
                {
                    $_SESSION['exam_show_id']=$btn;
                    header("Location:show_exam_result.php");
                }
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>