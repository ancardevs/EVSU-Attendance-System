<?php
    require('dbconn.php');

    session_start();
    $currentsession = $_SESSION['idno'];

  if (isset($_POST['newadvisory'])) {

    $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

    $rawcoursec = $_POST['coursesec'];
    $coursec = json_decode($rawcoursec,true);

    foreach ($coursec as $key) {
      extract($key);

        $course = $key['mycourse'];
        $section = $key['mysection'];
        $myear = $key['myyear'];

        $newad = $course." - ".$section." - ".$myear;


        if ($course == "" || $section == "" ||$myear == "" ) {
          //Tract Activity
          $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
          VALUES('$currentsession','Added an Advisory: Failed - Incomplete Information','$idnumber','Failed') ";
          OpenConn()->query($trackactivity);
          //Tract Activity
        }else{
          $sbmitcs = "INSERT INTO tbl_advisory(teacher_no,course_year,course_code,section,remarks)
          VALUES('$idnumber','$myear','$course','$section','Active') ";
          OpenConn()->query($sbmitcs);

          //Tract Activity
          $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
          VALUES('$currentsession','Added an Advisory: $newad ','$idnumber','Successfull') ";
          OpenConn()->query($trackactivity);
          //Tract Activity
        }
    }

    echo json_encode(array('saved'));
  }



    if (isset($_POST['deleteadvisory'])) {
        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
        $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

        $cyear = mysqli_real_escape_string(OpenConn(),$_POST['cyear']);
        $ccode = mysqli_real_escape_string(OpenConn(),$_POST['ccode']);
        $csection = mysqli_real_escape_string(OpenConn(),$_POST['csection']);

        $adv = $cyear." - ".$ccode." - ".$csection;



        $deletead = "DELETE FROM tbl_advisory WHERE id = '$refid'";
        OpenConn()->query($deletead);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Removed an Advisory: $adv ','$idnumber','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        echo json_encode(array('deleted'));
    }




    if (isset($_POST['updateadvisory'])) {
      $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
      $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

      $cyear = mysqli_real_escape_string(OpenConn(),$_POST['cyear']);
      $ccode = mysqli_real_escape_string(OpenConn(),$_POST['ccode']);
      $csection = mysqli_real_escape_string(OpenConn(),$_POST['csection']);

      $adv = $cyear." - ".$ccode." - ".$csection;



      $updatead = "UPDATE tbl_advisory SET course_year = '$cyear',course_code = '$ccode', section = '$csection' WHERE id = '$refid'";
      OpenConn()->query($updatead);

      //Tract Activity
      $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
      VALUES('$currentsession','Update an Advisory: $adv ','$idnumber','Successfull') ";
      OpenConn()->query($trackactivity);
      //Tract Activity

      echo json_encode(array('updated'));
    }




?>
