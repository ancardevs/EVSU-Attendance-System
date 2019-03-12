<?php
require('dbconn.php');

session_start();
$currentsession = $_SESSION['idno'];

if (isset($_POST['sendsmsnotif'])) {

    $smscontent = mysqli_real_escape_string(OpenConn(),$_POST['smscontent']);

    $getreceiver = "SELECT phone,student_no FROM tbl_students";
    $rresult = OpenConn()->query($getreceiver);

    if ($rresult->num_rows > 0) {
      while ($row = $rresult->fetch_assoc()) {

        $stcontact = $row['phone'];
        $studenid = $row['student_no'];
        sendtoContact($stcontact,$smscontent,$studenid,$currentsession);
      }
      echo json_encode(array('sent'));

    }else{
      echo json_encode(array('failed'));

    }
  }


  function sendtoContact($stcontact,$smscontent,$studenid,$currentsession){

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Send SMS Notification','$studenid','Successfull') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    //Tract Activity
    $recordsms = "INSERT INTO tbl_sms (sender,receiver,phone,msg,remarks)
    VALUES('$currentsession','$studenid','$stcontact','$smscontent','Successfull') ";
    OpenConn()->query($recordsms);
    //Tract Activity

  }



 ?>
