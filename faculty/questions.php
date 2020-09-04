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
    if(!isset($_SESSION['unit_id']))
    {
        header("Location: unit.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Manage Question</title>
    <?php require '../globle/bootstrap.php' ?>
    <script>
        $(document).ready(function()
        {
            $("#fill_blanks_div").hide();
            $('#sel_question_type').on('change', function() {
                if ( this.value == '1')
                {
                    $("#fill_blanks_div").hide();
                    $("#appendtextfield").show();
                }
                else  if ( this.value == '2')
                {
                    $("#appendtextfield").hide();
                    $("#fill_blanks_div").show();
                }
            });
        });
    </script>
</head>
<body oncontextmenu="return false">
    <?php require_once 'nav_faculty.php' ?>
    <div class="container">
        <form class="form" action="questions.php" method="POST">
            <h1 class="display-4">Question</h1>
            <div class="form-group">
                <label for="txa_question_desc">Question Description</label>
                <textarea class="form-control" rows="5" id="txa_question_desc" name="txa_question_desc" required></textarea>
            </div>
            <div class="row" id="appendtextfield">
                <div class="col-sm-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">A</span>
                        </div>
                    <input type="text" class="form-control" name="option_A" placeholder="Option A" aria-describedby="basic-addon1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" name="option_check_A" aria-label="Checkbox for following text input">
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group mb-3">
                        <input type="button" id="addtextfield" value="Add More Option" class="btn btn-outline-primary btn-block">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group mb-3">
                        <input type="button" id="removetextfield" value="Remove Option" class="btn btn-outline-warning btn-block">
                    </div>
                </div>
            </div>
            <div class="input-group mb-3" id="fill_blanks_div">
                <div class="input-group-prepend">
                    <span class="input-group-text">Answer</span>
                </div>
                <input type="text" name="txb_fill_answer" class="form-control" placeholder="Enter answer hear" aria-label="Answer">
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="sel_question_level">Question Level</label>
                        <select class="form-control" name="sel_question_level" id="sel_question_level">
                            <option value="1">Easy</option>
                            <option value="2">Medium</option>
                            <option value="3">Heard</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="txb_question_marks">Question Marks</label>
                        <input class="form-control" type="text" id="txb_question_marks" name="txb_question_marks" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="sel_question_type">Question Type</label>
                        <select class="form-control" name="sel_question_type" id="sel_question_type">
                            <option value="1">MCQ's</option>
                            <option value="2">Fill Blank</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_add_question" class="btn btn-outline-primary btn-block">Add Question</button>
            </div>
            <input type="hidden" name="total_option" id="total_option" value="1">
        </form>
        <?php
            if (isset($_POST['btn_add_question']))
            {
                $qdescruption=$_POST['txa_question_desc'];
                $qlevel=$_POST['sel_question_level'];
                $qmarks=$_POST['txb_question_marks'];
                $qtype=$_POST['sel_question_type'];
                $result=mysqli_query($con,"insert into tbl_question (question_desc,question_level,question_marks,question_type,subject_code,unit_id) values('$qdescruption','$qlevel','$qmarks','$qtype','$_SESSION[faculty_course_subject]','$_SESSION[unit_id]')") or die(mysqli_error());
                $query=mysqli_query($con,"select question_id from tbl_question where question_desc='$qdescruption'");
                $row=mysqli_fetch_array($query);
                if(is_array($row))
                {
                    $question_id=$row['question_id'];
                }
                if ($_POST['sel_question_type']==1)
                {
                    for($i=65;$i<65+$_POST['total_option'];$i++)
                    {
                        $temp_option='option_'.chr($i);
                        $ans_true=0;
                        if(isset($_POST['option_check_'.chr($i)]))
                        {
                            $ans_true=1;
                        }
                        mysqli_query($con,"insert into tbl_option (option_desc,option_correct,question_id) values('$_POST[$temp_option]','$ans_true','$question_id')") or die(mysqli_error());
                    }
                }
                elseif ($_POST['sel_question_type']==2)
                {
                    mysqli_query($con,"insert into tbl_option (option_desc,option_correct,question_id) values('$_POST[txb_fill_answer]','1','$question_id')") or die(mysqli_error());
                }
            }
        ?>
        <form class="form" action="questions.php" method="POST">
            <?php
                $question_id=array();
                $count=0;
                $sql = "SELECT question_id,question_desc,question_level,question_marks,question_type FROM tbl_question join tbl_faculty_subject on tbl_question.subject_code=tbl_faculty_subject.subject_code where tbl_faculty_subject.faculty_by_subject_id='$_SESSION[faculty_by_subject_id]' and tbl_question.unit_id='$_SESSION[unit_id]'";
                $result = $con->query($sql);
                if ($result->num_rows > 0)
                {
                    echo "  <table class='table table-responsive-sm table-striped table-bordered table-hover'>
                            <tr>
                            <th>Question Description</th>
                            <th>Question Level</th>
                            <th>Question Marks</th>
                            <th>Question Type</th>
                            <th>Action</th>
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
                            $string="Heard";
                        }
                        if($row['question_type']==1)
                        {
                            $type="MCQ's";
                        }
                        elseif ($row['question_type']==2)
                        {
                            $type="Filling Blank";
                        }
                        echo "<tr><td>" . $row["question_desc"]. "</td><td>" . $string. "</td><td>" . $row["question_marks"]. "</td><td>" . $type. "</td><td><input class='btn btn-outline-danger' type='submit' name=btn_delete_$row[question_id] value='Delete'></td></tr>";
                        $question_id[$count]=$row['question_id'];
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
            foreach ($question_id as $btn)
            {
                if(isset($_POST['btn_delete_'.$btn]))
                {
                    $query2=mysqli_query($con,"select equestion_id from tbl_exam_question where question_id='$btn'") or die("Error While delete Query 2");
                    while ($row2=mysqli_fetch_array($query2))
                    {
                        mysqli_query($con,"delete from tbl_equestion_inputed where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 3");
                        mysqli_query($con,"delete from tbl_equestion_attempted where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 4");
                        mysqli_query($con,"delete from tbl_exam_question where equestion_id='$row2[equestion_id]'") or die("Error While delete Query 5");
                    }
                    mysqli_query($con,"delete from tbl_option where question_id='$btn'") or die("Error While delete Query 6");
                    mysqli_query($con,"delete from tbl_question where question_id='$btn'") or die("Error While delete Query 7");
                }
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
<script>
    var i=65;
    $('#addtextfield').click(function(){
        if(i<90)
        {
            i++;
            document.getElementById('total_option').value=i-64;
            //var textfield = '<div class="col-sm-6"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">A</span></div><input type="text" name="option_" class="form-control" placeholder="Option A" aria-describedby="basic-addon1"></div></div>';
            var textfield = '<div class="col-sm-6"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">'+String.fromCharCode(i)+'</span></div><input type="text" name="option_'+String.fromCharCode(i)+'" id="option_'+String.fromCharCode(i)+'" class="form-control" placeholder="Option '+String.fromCharCode(i)+'" required aria-describedby="basic-addon1"><div class="input-group-prepend"><div class="input-group-text"><input type="checkbox" name="option_check_'+String.fromCharCode(i)+'" aria-label="Checkbox for following text input"></div></div></div></div>';
            $(this).parent().parent().before(textfield);   
        }
        else
        {
            alert("No more options available");
        }
    });
    $('#removetextfield').click(function(){
        if(i<66)
        {
            alert("Must requre one option");
        }
        else
        {
            $("#option_"+String.fromCharCode(i)).parent().parent().remove();
            i--;
            document.getElementById('total_option').value=i-64;
        }
    });
</script>
</html>