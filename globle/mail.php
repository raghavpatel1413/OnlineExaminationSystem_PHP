<?php
    $pwd=mt_rand();
    $pwdhash=sha1(md5($pwd));
    require_once "../PHPMailer/class.phpmailer.php";
    require_once "../PHPMailer/class.smtp.php";
    $mail=new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure="tls";
    $mail->Host="smtp.gmail.com";
    $mail->SMTPAuth=true;
    $mail->Username="raghavpatel1413@gmail.com";
    $mail->Password="Parshottamdas.Manguma.google@1413";
    $mail->Port=587;
    $mail->From="raghavpatel1413@gmail.com";
    $mail->FromName="Online Examination System";
    $mail->AddAddress("$email");
    $mail->IsHTML(true);
    $mail->Subject="New Password from OES";
    $mail->Body="welcome to Online Examination System. Your Password is $pwd . Please change it into strong Password";
    if(!$mail->send())
    {
    echo "Message Coud not be send";
    }
?>