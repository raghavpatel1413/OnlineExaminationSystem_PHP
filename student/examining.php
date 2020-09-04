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
    if($_SESSION['exam_id']=="")
    {
        header("Location: exam.php");
    }
    $ctime=date('H:i', strtotime(date('h:i:sa')));
    $query=mysqli_query($con,"update tbl_exam_student set exam_start_time='$ctime' where student_by_course_id='$_SESSION[student_id_by_course]' and exam_id=$_SESSION[exam_id]") or die(mysql_error());
    $query=mysqli_query($con,"select exam_start_time,exam_total_time from tbl_exam where exam_id=$_SESSION[exam_id]") or die("Error While Get Exam Time");
    $row=mysqli_fetch_array($query);
    $time3 = strtotime($row['exam_start_time']) + strtotime($row['exam_total_time']) - strtotime('00:00:00');
    $exam_finesh_time = date('H:i:s', $time3);
    
    //$exam_remain_time= date('H:i:s', strtotime($exam_finesh_time) - strtotime($ctime) - strtotime('00:00:00'));
        $start_t = new DateTime($exam_finesh_time);
        $current_t = new DateTime($ctime);
        $difference = $start_t ->diff($current_t );
        $exam_remain_time = $difference ->format('%H:%I:%S');

ob_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <title>OES - Student Exam List</title>
    <?php require '../globle/bootstrap.php' ?>
    <style>
        body { 
    background-color:#fafafa;}
        .timer-time {
        line-height:1em;
        font-size: 6em;
    }

    .timer-container {
      height: 1em;
      overflow: hidden;
      position: relative;
    }

    .timer-box {
      height: 1em;
      margin: auto;
      position: relative;
    }

    .timer-box > span {
      position: relative;
    }

    .footer {
      width: 100%;
      height: 60px;
    }

    .footer .container {

    }
    </style>
</head>
<script>
    function showHint(str) {
        if (str.length == 0) { 
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "../globle/suggestions.php?q=" + str, true);
            xmlhttp.send();
        }
    }
    var rft='<?php echo $exam_remain_time;?>';
    rft = rft.split(':');
    rftemp =(+rft[0]) * 60 * 60 + (+rft[1]) * 60 + (+rft[2]);
    rftemp=rftemp * 1000;
    setTimeout(function(){
        $('#btn_finish_exam').click();
    }, rftemp);
    window.onload = function () {
        onStartTimer();
    }
</script>
<body oncontextmenu="return false">
    <?php require_once 'nav_student.php' ?>
    <div class="container">
        <form class="form" action="examining.php" id='examiingform' method="POST">
            <h1 class="display-4">Live Exam</h1>
            <div class="timer-time timer-container">
                <div class="timer-time-set timer-box" id="currentTime">
                    <span id="hoursValue">00</span>
                    <span>:</span>
                    <span id="minutesValue">00</span>
                    <span>:</span>
                    <span id="secondsValue">00</span>
                </div>
                <div class="timer-time-set timer-box" id="nextTime">
                    <span id="hoursNext">00</span>
                    <span>:</span>
                    <span id="minutesNext">00</span>
                    <span>:</span>
                    <span id="secondsNext">00</span>
                </div>
            </div>
            <?php
                $questions=array();
                $total_questions=0;
                $result=mysqli_query($con,"select faculty_by_subject_id,tbl_exam_student.exam_student_id from tbl_exam join tbl_exam_student on tbl_exam.exam_id=tbl_exam_student.exam_id where tbl_exam.exam_id='$_SESSION[exam_id]' and tbl_exam_student.student_by_course_id='$_SESSION[student_id_by_course]'") or die(mysql_error());
                $row  = mysqli_fetch_array($result);
                if(is_array($row))
                {
                    $exam_student_id=$row['exam_student_id'];
                    $query=mysqli_query($con,"select tbl_exam_question.equestion_id,tbl_question.question_id,tbl_question.question_desc,tbl_question.question_type from tbl_question join tbl_exam_question on tbl_exam_question.question_id=tbl_question.question_id where tbl_exam_question.exam_id='$_SESSION[exam_id]'") or die(mysql_error());
                    if(mysqli_num_rows($query))
                    {
                        $tq=0;
                        while($row2=mysqli_fetch_array($query))
                        {
                            $tq++;
                            echo "<div id=$tq>";
                                $questions[$total_questions]=$row2['equestion_id'];
                                $total_questions++;
                                echo "<div class='form-group'>";
                                echo "<label for=question_$row2[question_id]>Question</label>";
                                echo "<textarea class='form-control' rows='5' id=question_$row2[question_id] name=question_$row2[question_id] disabled>$row2[question_desc]</textarea>";
                                echo "</div>";
                                if($row2['question_type']==1)
                                {
                                    echo "<div class='form-group'>";
                                        $query2=mysqli_query($con,"select option_id,option_desc from tbl_option join tbl_question on tbl_option.question_id=tbl_question.question_id join tbl_exam_question on tbl_exam_question.question_id=tbl_question.question_id where tbl_question.question_id='$row2[question_id]' and tbl_exam_question.equestion_id='$row2[equestion_id]'") or die(mysql_error());
                                        echo "<div class='row'>";
                                        $i=65;
                                        while($row = mysqli_fetch_array($query2))
                                        {
                                            echo "<div class='col-sm-6'><div class=input-group mb-3><div class=input-group-prepend><span class=input-group-text>".chr($i)."</span></div><input type=text class=form-control value='$row[option_desc]' aria-describedby=basic-addon1 disabled><div class=input-group-prepend><div class=input-group-text><input type=radio name=radio_$row2[equestion_id] value=$row[option_id]></div></div></div></div>";
                                            $i++;
                                        }
                                        echo "</div>";
                                    echo "</div>";
                                }
                                elseif ($row2['question_type']==2)
                                {
                                    echo "<div class='row'>";
                                        echo "<div class='col col-sm-8 col-md-8 col-lg-8'>";
                                            echo "<div class='form-group'>";
                                            echo "<div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'>Answer</span></div><input type='text' name=answer_$row2[equestion_id] class='form-control' onkeyup='showHint(this.value)' aria-label='Answer'></div>";
                                            echo "</div>";
                                        echo "</div>";
                                        echo "<div class='col col-sm-4 col-md-4 col-lg-4'>";
                                            echo "<label class='label label-success' id='txtHint'></label>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            echo "</div>";
                        }
                        echo "<script>
                            $(document).ready(function(){
                                var tq= '$tq';
                                var point=1;
                                var executed=0;
                                if(executed==0)
                                {
                                    for(i=1;i<=tq;i++)
                                    {
                                        $('#'+i).hide();
                                    }
                                    executed=1;
                                }

                                $('#'+point).show();
                                
                                $('#btn_pre').click(function(){
                                    if(point>1)
                                    {
                                        var temp=point;
                                        point=point-1;
                                        $('#'+temp).hide();
                                        $('#'+point).show();
                                    }
                                });

                                $('#btn_nxt').click(function(){
                                    if(point<tq)
                                    {
                                        var temp=point;
                                        point=point+1;
                                        $('#'+temp).hide();
                                        $('#'+point).show();
                                    }
                                });
                            });
                        </script>";
                    }
                    else
                    {
                        echo "No questions";
                    }
                }
                else
                {
                    header("Location: exam.php");
                }
            ?>
            <div class="btn-group container" role="group">
                <input type="button" id="btn_pre" class="btn btn-outline-success float-left" value="Previous">
                <input type="submit" class="btn btn-outline-danger btn-block" id="btn_finish_exam" value="Finish exam" name="btn_finish_exam">
                <input type="button" id="btn_nxt" class="btn btn-outline-success float-right" value="Next">
            </div>
        </form>
        <?php
            if(isset($_POST['btn_finish_exam']))
            {
                $obtained_marks=0;
                foreach ($questions as $que)
                {
                    $id="radio_".$que;
                    //echo "Question id ",$que," Selected Value ",$_POST[$id];
                    if(isset($_POST[$id]))
                    {
                        $right=0;
                        $query_temp=mysqli_query($con,"select tbl_option.option_id,tbl_question.question_marks from tbl_option join tbl_question on tbl_option.question_id=tbl_question.question_id where tbl_option.option_correct=1 and tbl_option.question_id=(select tbl_exam_question.question_id from tbl_exam_question where tbl_exam_question.equestion_id='$que')") or die("Verification Error");
                        $row=mysqli_fetch_array($query_temp);
                        if(is_array($row))
                        {
                            if($row['option_id']==$_POST[$id])
                            {
                                $obtained_marks=$obtained_marks+$row['question_marks'];
                                $right=1;
                            }
                        }
                        $query5=mysqli_query($con,"insert into tbl_equestion_attempted (equestion_id,option_id,exam_student_id,isright)values('$que','$_POST[$id]','$exam_student_id','$right')") or die(mysql_error());
                    }
                    elseif(isset($_POST["answer_".$que]))
                    {
                        $right=0;
                        $query_temp=mysqli_query($con,"select tbl_option.option_desc,tbl_question.question_marks from tbl_option join tbl_question on tbl_option.question_id=tbl_question.question_id where tbl_option.option_correct=1 and tbl_option.question_id=(select tbl_exam_question.question_id from tbl_exam_question where tbl_exam_question.equestion_id='$que')")or die("Verification Error");
                        $row=mysqli_fetch_array($query_temp);
                        if(is_array($row))
                        {
                            if($row['option_desc']==$_POST['answer_'.$que])
                            {
                                $obtained_marks=$obtained_marks+$row['question_marks'];
                                $right=1;
                            }
                        }
                        $temp=$_POST['answer_'.$que];
                        $query5=mysqli_query($con,"insert into tbl_equestion_inputed (equestion_id,answer_desc,exam_student_id,isright)values('$que','$temp','$exam_student_id','$right')") or die(mysql_error());
                    }
                }
                $ctime=date('H:i', strtotime(date('h:i:sa')));
                $query=mysqli_query($con,"update tbl_exam_student set exam_end_time='$ctime', obtained_marks='$obtained_marks' where student_by_course_id='$_SESSION[student_id_by_course]' and exam_id=$_SESSION[exam_id]") or die(mysql_error());
                unset($_SESSION['exam_id']);
                header("Location: exam.php");
            }
        ?>
    </div>
    <?php $con->close(); require_once 'footer.php'; ?>
</body>
</html>
<script>
var gHours = 0;
var gMinutes = 0;
var gSeconds = 0;
var remainingTime;
var countdownHandle;
$(document).ready(function() 
{
  StartOESTimer();
});
function StartOESTimer(){
  stopTimer();

  gHours = rft[0];
  gMinutes = rft[1];
  gSeconds = rft[2];

  resetTimer();
}

function onStartTimer(){
  stopTimer();
  startTimer();
};

function startTimer() {
  countdownHandle=setInterval(function() {
    decrementTimer();
  },1000);
}

function onStopTimer(){
  stopTimer();
};

function stopTimer() {
  //clearInterval(countdownHandle);
}

function resetTimer(){

  remainingTime = (gHours*60*60*1000)+
  (gMinutes*60*1000)+
  (gSeconds*1000);
  renderTimer();
}

function renderTimer(){

  var deltaTime=remainingTime;

  var hoursValue=Math.floor(deltaTime/(1000*60*60));
  deltaTime=deltaTime%(1000*60*60);

  var minutesValue=Math.floor(deltaTime/(1000*60));
  deltaTime=deltaTime%(1000*60);

  var secondsValue=Math.floor(deltaTime/(1000));

  animateTime(hoursValue, minutesValue, secondsValue);
};


function animateTime(remainingHours, remainingMinutes, remainingSeconds) {

  // position
  $('#hoursValue').css('top', '0em');
  $('#minutesValue').css('top', '0em');
  $('#secondsValue').css('top', '0em');

  $('#hoursNext').css('top', '0em');
  $('#minutesNext').css('top', '0em');
  $('#secondsNext').css('top', '0em');

  var oldHoursString = $('#hoursNext').text();
  var oldMinutesString = $('#minutesNext').text();
  var oldSecondsString = $('#secondsNext').text();

  var hoursString = formatTime(remainingHours);
  var minutesString = formatTime(remainingMinutes);
  var secondsString = formatTime(remainingSeconds);

  $('#hoursValue').text(oldHoursString);
  $('#minutesValue').text(oldMinutesString);
  $('#secondsValue').text(oldSecondsString);

  $('#hoursNext').text(hoursString);
  $('#minutesNext').text(minutesString);
  $('#secondsNext').text(secondsString);

  // set and animate
  if(oldHoursString !== hoursString) {
    $('#hoursValue').animate({top: '-=1em'});
    $('#hoursNext').animate({top: '-=1em'});
  }

  if(oldMinutesString !== minutesString) {
    $('#minutesValue').animate({top: '-=1em'});
    $('#minutesNext').animate({top: '-=1em'});
  }

  if(oldSecondsString !== secondsString) {
    $('#secondsValue').animate({top: '-=1em'});
    $('#secondsNext').animate({top: '-=1em'});
  }
}


function formatTime(intergerValue){

  return intergerValue > 9 ? intergerValue.toString():'0'+intergerValue.toString();

}

function decrementTimer()
{

  remainingTime-=(1*1000);

  if(remainingTime<1000)
  {
    onStopTimer();
  }

  renderTimer();
}

</script>