<?php

require('dbconn.php');
require('resize-image.class.php');
include "phpqrcode/qrlib.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


if (isset($_POST['addstudent'])) {

    $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

    $currentsession = $idnumber;

    $firstname = mysqli_real_escape_string(OpenConn(),$_POST['firstname']);
    $middlename = mysqli_real_escape_string(OpenConn(),$_POST['middlename']);

    $lastname = mysqli_real_escape_string(OpenConn(),$_POST['lastname']);

    $college = mysqli_real_escape_string(OpenConn(),$_POST['college']);
    $scholarship = mysqli_real_escape_string(OpenConn(),$_POST['scholarship']);
    $department = mysqli_real_escape_string(OpenConn(),$_POST['department']);


    $cyear = mysqli_real_escape_string(OpenConn(),$_POST['cyear']);


    $course = mysqli_real_escape_string(OpenConn(),$_POST['course']);
    $section = mysqli_real_escape_string(OpenConn(),$_POST['section']);
    $emailadd = mysqli_real_escape_string(OpenConn(),$_POST['emailadd']);
    $contact = mysqli_real_escape_string(OpenConn(),$_POST['contact']);
    $bdate = mysqli_real_escape_string(OpenConn(),$_POST['bdate']);
    $address = mysqli_real_escape_string(OpenConn(),$_POST['address']);

    $checkstudent = "SELECT id FROM tbl_students WHERE student_no = '$idnumber'";
    $checkresult = OpenConn()->query($checkstudent);

    if(mysqli_num_rows($checkresult) > 0){

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Add Student - Id No. Exist.','$idnumber','Failed') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        echo json_encode(array('exist'));

    }else{

        $addacc = "INSERT INTO
        tbl_credentials(id_no,
        user,
        pass,
        user_type)
        VALUES('$idnumber','$idnumber','12345','Student')";
        OpenConn()->query($addacc);


        $adddept = "INSERT INTO
        tbl_college(id_no,
        department)
        VALUES('$idnumber','$course')";
        OpenConn()->query($adddept);


        $addstudent = "INSERT INTO
        tbl_students(
        student_no,
        first_name,
        middle_name,
        last_name,
        avatar,
        cyear,
        course_code,

        college,
        department,
        scholarship,

        section,
        caddress,
        birthday,
        phone,
        email)
        VALUES(
        '$idnumber',
        '$firstname',
        '$middlename',
        '$lastname',
        'default.png',
        '$cyear',
        '$course',

        '$college',
        '$department',
        '$scholarship',


        '$section',
        '$address',
        '$bdate',
        '$contact',
        '$emailadd')";
        OpenConn()->query($addstudent);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added a Student','$idnumber','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        generateQR($idnumber,$emailadd,$currentsession,$firstname,$lastname);


    }
}

function generateQR($idnumber,$emailadd,$currentsession,$firstname,$lastname){
    $fullname = $firstname.' '.$lastname;
    $tempDir = '../img/qrcodes/';

    $smail = $emailadd;
    $codeContents = $idnumber;

    $fileName = $idnumber.'.png';

    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = $tempDir.$fileName;

    // generating
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Generates QR Code','$idnumber','Failed') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

    } else {
      //Tract Activity
      $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
      VALUES('$currentsession','Generates QR Code','$idnumber','Successfull') ";
      OpenConn()->query($trackactivity);
      //Tract Activity
    }

    sendtoEmail($smail,$idnumber,$currentsession,$fullname);
}




function sendtoEmail($smail,$idnumber,$currentsession,$fullname){

    header('Content-Type: application/json');
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vallejennyruth08@gmail.com';
        $mail->Password = 'missruthyruth';
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
        $mail->setFrom('vallejennyruth08@gmail.com', 'EVSU Event Organizer');
        $mail->addAddress($smail);
        $mail->addReplyTo('vallejennyruth08@gmail.com', 'EVSU Event Organizer');

        //Attachments
        $img_path ='../img/qrcodes/'.$idnumber.'.png';
        $mail->addAttachment($img_path);

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
            Good day '.$fullname.'!<br><br> This is to inform that your Account and QR Code has been successfully generated.
            Download the attached image and used it as an attendance identification.
            If you accidentally removed this mail, you can visit <a href="https://www.qr-code-generator.com">https://www.qr-code-generator.com<a>
            and <i style="color:firebrick;">note to select as </i><b>Text</b> then generate a new QR code using your School ID Number.
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
        VALUES('$currentsession','Send Email Notification - On easy registration.','$idnumber','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity


        //Tract Activity
        $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
        VALUES('$currentsession','$idnumber','$smail','$mailbody','Successfull') ";
        OpenConn()->query($recordmail);
        //Tract Activity


        echo json_encode(array('saved'));

    } catch (Exception $e) {

      //Tract Activity
      $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
      VALUES('$currentsession','Send Email Notification - On easy registration.','$idnumber','Failed') ";
      OpenConn()->query($trackactivity);
      //Tract Activity

      //Tract Activity
      $recordmail = "INSERT INTO tbl_mails (sender,receiver,email,msg,remarks)
      VALUES('$currentsession','$idnumber','$smail','$mailbody','Failed') ";
      OpenConn()->query($recordmail);
      //Tract Activity

      echo json_encode(array('mailerr'));
      //echo json_encode(array($e));

    }

}


















 ?>
