<?php
require('dbconn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';


session_start();
$currentsession = $_SESSION['idno'];

if (isset($_POST['sendmailnotif'])) {

    $mailcontent = mysqli_real_escape_string(OpenConn(),$_POST['mailcontent']);

    $getreceiver = "SELECT email,student_no FROM tbl_students";
    $rresult = OpenConn()->query($getreceiver);

    if ($rresult->num_rows > 0) {
      while ($row = $rresult->fetch_assoc()) {

        $stmail = $row['email'];
        $studenid = $row['student_no'];
        sendtoEmail($stmail,$mailcontent,$studenid,$currentsession);
      }
    }

    echo json_encode(array('sent'));

  }


  function sendtoEmail($stmail,$mailcontent,$studenid,$currentsession){
      header('Content-Type: application/json');
      $mail = new PHPMailer(true);
      try {
          //Server settings
          //$mail->SMTPDebug = 2;
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = "vallejennyruth08@gmail.com";
          $mail->Password = "missruthyruth";
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
          );


          //Recipients
          $mail->setFrom("vallejennyruth08@gmail.com", 'EVSU Event Organizer');
          $mail->addAddress($stmail);
          $mail->addReplyTo("vallejennyruth08@gmail.com", 'EVSU Event Organizer');


           //Content
           $mail->isHTML(true);
           $mail->Subject = 'EVSU Event Organizer';
           $mailbody = $mailcontent;

           $mail->Body = $mailbody;
           $mail->send();

           //Tract Activity
           $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
           VALUES('$currentsession','Send Email Notification','$studenid','Successfull') ";
           OpenConn()->query($trackactivity);
           //Tract Activity

           //Tract Activity
           $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
           VALUES('$currentsession','$studenid','$stmail','$mailbody','Successfull') ";
           OpenConn()->query($recordmail);
           //Tract Activity


      } catch (Exception $e) {

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Send Email Notification - No Internet Connection','$studenid','Failed') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        //Tract Activity
        $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
        VALUES('$currentsession','$studenid','$stmail','$mailbody','Failed') ";
        OpenConn()->query($recordmail);
        //Tract Activity

        echo json_encode(array('mailerr'));
        //echo json_encode(array($e));

      }
    }



 ?>
