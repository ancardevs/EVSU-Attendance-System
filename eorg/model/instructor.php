<?php
require('dbconn.php');


 require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
$currentsession = $_SESSION['idno'];




if (isset($_POST['deleteinstructor'])) {

  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $deleteinstructor = "DELETE FROM tbl_teacher WHERE teacher_no = '$idnumber'";
  OpenConn()->query($deleteinstructor);

  $deleteinstructor = "DELETE FROM tbl_advisory WHERE teacher_no = '$idnumber'";
  OpenConn()->query($deleteinstructor);

  $deletedept = "DELETE FROM tbl_college WHERE id_no = '$idnumber'";
  OpenConn()->query($deletedept);

  $deletecred = "DELETE FROM tbl_credentials WHERE id_no = '$idnumber'";
  OpenConn()->query($deletecred);

  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Deletede Instructor Information','$idnumber','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity


  echo json_encode(array('deleted'));
}

if (isset($_POST['updateinstructor'])) {

  $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $firstname = mysqli_real_escape_string(OpenConn(),$_POST['firstname']);
  $middlename = mysqli_real_escape_string(OpenConn(),$_POST['middlename']);
  $lastname = mysqli_real_escape_string(OpenConn(),$_POST['lastname']);
  $emailadd = mysqli_real_escape_string(OpenConn(),$_POST['emailadd']);
  $contact = mysqli_real_escape_string(OpenConn(),$_POST['contact']);
  $address = mysqli_real_escape_string(OpenConn(),$_POST['address']);
  $college = mysqli_real_escape_string(OpenConn(),$_POST['college']);



  $updateinstructor = "UPDATE tbl_teacher SET college = '$college', teacher_no = '$idnumber', first_name = '$firstname',middle_name = '$middlename',last_name = '$lastname',
  phone = '$contact', caddress = '$address',email = '$emailadd' WHERE teacher_no = '$refid'";
  OpenConn()->query($updateinstructor);

  $updatecollege = "UPDATE tbl_college SET id_no = '$idnumber', college = '$college' WHERE id_no = '$refid'";
  OpenConn()->query($updatecollege);

  $updateacc = "UPDATE tbl_credentials SET id_no = '$idnumber', user = '$idnumber' WHERE id_no = '$refid' ";
  OpenConn()->query($updateacc);

  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Updated Instructor Information','$idnumber','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity


  echo json_encode(array('updated'));

}




if (isset($_POST['addinstructor'])) {

  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $firstname = mysqli_real_escape_string(OpenConn(),$_POST['firstname']);
  $middlename = mysqli_real_escape_string(OpenConn(),$_POST['middlename']);
  $lastname = mysqli_real_escape_string(OpenConn(),$_POST['lastname']);
  $emailadd = mysqli_real_escape_string(OpenConn(),$_POST['emailadd']);
  $contact = mysqli_real_escape_string(OpenConn(),$_POST['contact']);
  $college = mysqli_real_escape_string(OpenConn(),$_POST['college']);
  $address = mysqli_real_escape_string(OpenConn(),$_POST['address']);
  $rawcoursec = $_POST['coursesec'];
  $coursec = json_decode($rawcoursec,true);

  $checkinstructor = "SELECT id FROM tbl_teacher WHERE teacher_no = '$idnumber'";
  $checkresult = OpenConn()->query($checkinstructor);

  if(mysqli_num_rows($checkresult) > 0){

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Added an Instructor Information - Information Existed','$idnumber','Failed') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    echo json_encode(array('exist'));

  }else{

    foreach ($coursec as $key) {
      extract($key);
      $course = $key['mycourse'];
      $section = $key['mysection'];
      $myear = $key['myyear'];

      $adv =$myear." - ".$course." - ".$section;

      if ($course=="" || $section=="" || $myear=="") {

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added Instructor Advisory: Failed - Incomplete Information','$idnumber','Failed') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

      }else{
        $sbmitcs = "INSERT INTO tbl_advisory(teacher_no,course_year,course_code,section,remarks)
        VALUES('$idnumber','$myear','$course','$section','Active') ";
        OpenConn()->query($sbmitcs);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added Instructor Advisory: $adv','$idnumber','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity
      }


    }


    $addinstructor = "INSERT INTO tbl_teacher(teacher_no, first_name,middle_name,last_name,phone,caddress,email,college)
    VALUES('$idnumber','$firstname','$middlename','$lastname','$contact','$address','$emailadd','$college')";
    OpenConn()->query($addinstructor);

    $addtouser = "INSERT INTO tbl_credentials(id_no, user, pass,user_type, remarks)
    VALUES('$idnumber','$idnumber','12345','Teacher','Enabled')";
    OpenConn()->query($addtouser);

    $addtodepartment = "INSERT INTO tbl_college(id_no, college, remarks)
    VALUES('$idnumber','$college','Active')";
    OpenConn()->query($addtodepartment);


    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Added Instructor Information','$idnumber','Successfull') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    sendtoEmail($emailadd,$idnumber,$currentsession,$firstname,$lastname);
  }
}




function sendtoEmail($emailadd,$idnumber,$currentsession,$firstname,$lastname){
  $tname = $firstname.' '.$lastname;
    header('Content-Type: application/json');
    $mail = new PHPMailer(true);
    try {
        //Server settings
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'evsucalendar@gmail.com';
        $mail->Password = '3vsU@6m41L:';
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
        $mail->setFrom('evsucalendar@gmail.com', 'EVSU Event Organizer');
        $mail->addAddress($emailadd);
        $mail->addReplyTo('evsucalendar@gmail.com', 'EVSU Event Organizer');


        //Content
        $mail->isHTML(true);
        $mail->Subject = 'EVSU Event Organizer';
        $mailbody = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>
            <div>
            <p>
            Good day '.$tname.'!<br><br> This is to inform that your account has successfully created by our System.
            <br>
            </p>
            <br>
            <p>
            To login, visit <a href="http://evsuevents.epizy.com">http://evsuevents.epizy.com<a> and use the following credentials:
            <br>
            <br>
            Username: <i style="color:blue">Your ID Number</i>.<br>
            Password: <i style="color:blue">12345</i>.<br>
            <br>
            <br>
            You can change it in your dashboard.
            </p>
            Thank you.<br>
            Eastern Visayas State University - Event Organizer
            </div>
        </body>
        </html>
        ';

        $mail->Body = $mailbody;
        $mail->send();


        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Send Email Notification','$idnumber','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity


        //Tract Activity
        $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
        VALUES('$currentsession','$idnumber','$emailadd','$mailbody','Successfull') ";
        OpenConn()->query($recordmail);
        //Tract Activity


        echo json_encode(array('saved'));

    } catch (Exception $e) {

      //Tract Activity
      $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
      VALUES('$currentsession','$idnumber','$emailadd','$mailbody','Failed') ";
      OpenConn()->query($recordmail);
      //Tract Activity

      echo json_encode(array('mailerr'));
      //echo json_encode(array($e));

    }

}


?>
