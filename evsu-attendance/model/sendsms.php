<?php
require('dbconn.php');
require('PhpSerial.php');

error_reporting(0);

session_start();
$currentsession = $_SESSION['idno'];

if (isset($_POST['deletesms'])) {

  $smsid = mysqli_real_escape_string(OpenConn(),$_POST['smsid']);

  //Tract Activity
  $removesms = "DELETE FROM tbl_sms WHERE id = '$smsid'";
  OpenConn()->query($removesms);
  //Tract Activity

  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Remove SMS sent item','Failed to record reference','Failed') ";
  OpenConn()->query($trackactivity);
  //Tract Activity

  echo json_encode(array('removed'));
}



if (isset($_POST['sendsmsnotif'])) {

  $studenid = 'ID number not registered.';
  $stcontact = 'Phone number not registered.';

  $smscontent = mysqli_real_escape_string(OpenConn(),$_POST['smscontent']);
  $grecepients = mysqli_real_escape_string(OpenConn(),$_POST['grecepients']);


  //check if grecepients is a number else search contacts from database
  if (is_numeric($grecepients)) {

    $serial = new phpSerial;
    $serial->deviceSet($comport);


    if ($serial->deviceOpen()) {
      $serial->confBaudRate(115200);
      sendtoIndividual($grecepients,$currentsession,$smscontent);
      echo json_encode(array('sent'));
    }else{
      echo json_encode(array('nomodem'));
    }

    sleep(7);
    $read=$serial->readPort();
    $serial->deviceClose();

    return;
  }

  //If Not a numnber
  else {
    if ($grecepients == 'Scholar Students')
    {
      $getreceiver = "SELECT DISTINCT phone, student_no FROM tbl_students
      WHERE scholarship is not null";
    }
    elseif($grecepients == 'All')
    {
      $getreceiver = "SELECT DISTINCT phone, student_no FROM tbl_students";
    }
    else
    {
      $getreceiver = "SELECT DISTINCT phone, student_no FROM tbl_students
      WHERE course_code = '$grecepients'";
    }

    $rresult = OpenConn()->query($getreceiver);

    if ($rresult->num_rows > 0) {


      $serial = new phpSerial;
      $serial->deviceSet($comport);


      if ($serial->deviceOpen()) {
        $serial->confBaudRate(115200);
        while ($row = $rresult->fetch_assoc()) {

          $stcontact = $row['phone'];
          $studenid = $row['student_no'];
          sendtoGroup($stcontact,$smscontent,$studenid,$currentsession);
        }
        echo json_encode(array('sent'));
      }else{
        echo json_encode(array($comport));
      }

      sleep(7);
      $read=$serial->readPort();
      $serial->deviceClose();

      return;

    }
    else
    {
      echo json_encode(array('empty'));
    }


  }
}








function sendtoGroup($stcontact,$smscontent,$studenid,$currentsession){






  // To write into
  $serial->sendMessage("AT+CMGF=1\n\r");
  $serial->sendMessage("AT+cmgs=\"".$stcontact."\"\n\r");
  $serial->sendMessage("".$smscontent." \n\r");
  $serial->sendMessage(chr(26));

  //wait for modem to send message


  //End SMS Code here


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









function sendtoIndividual($grecepients,$currentsession,$smscontent){

  $serial->sendMessage("AT+CMGF=1\n\r");
  $serial->sendMessage("AT+cmgs=\"".$grecepients."\"\n\r");
  $serial->sendMessage("".$smscontent." \n\r");
  $serial->sendMessage(chr(26));











  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Send SMS Notification','$grecepients','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity

  //Tract Activity
  $recordsms = "INSERT INTO tbl_sms (sender,receiver,phone,msg,remarks)
  VALUES('$currentsession','Failed to record recievers name ','$grecepients','$smscontent','Successfull') ";
  OpenConn()->query($recordsms);
  //Tract Activity


}


?>
