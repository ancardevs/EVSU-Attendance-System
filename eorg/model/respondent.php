  <?php
  require('dbconn.php');

  session_start();
  $currentsession = $_SESSION['idno'];

  if (isset($_POST['addnewresp'])) {

    $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

    $rawerespondent = $_POST['eventresp'];
    $erespondent = json_decode($rawerespondent,true);

    foreach ($erespondent as $key) {
      extract($key);
      $ccourse = $key['mycourse'];
      $cyear = $key['myyear'];

      $resp = $cyear." - ".$ccourse;

      if ($ccourse=="" || $cyear=="") {
        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added a Respondent Failed - Incomplete Data','$refid','Failed') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

      }else{
        $addresp = "INSERT INTO tbl_respondent(event_no,course_code,course_year) VALUES('$refid','$ccourse','$cyear')";
        OpenConn()->query($addresp);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added a Respondent: $resp','$refid','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity
      }
    }
    echo json_encode(array('saved'));
  }



  if (isset($_POST['deleterespondent'])) {
    $eventid = mysqli_real_escape_string(OpenConn(),$_POST['eventid']);
    $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

    $cyear = mysqli_real_escape_string(OpenConn(),$_POST['cyear']);
    $ccode = mysqli_real_escape_string(OpenConn(),$_POST['ccode']);

    $resp = $cyear." - ".$ccode;

    $deleteres = "DELETE FROM tbl_respondent WHERE id = '$refid'";
    OpenConn()->query($deleteres);

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Removed Respondent: $resp','$eventid','Successfull') ";
    OpenConn()->query($trackactivity);
    //Tract Activity
    echo json_encode(array('deleted'));
  }


  if (isset($_POST['updaterespondent'])) {
    $eventid = mysqli_real_escape_string(OpenConn(),$_POST['eventid']);
    $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

    $cyear = mysqli_real_escape_string(OpenConn(),$_POST['cyear']);
    $ccode = mysqli_real_escape_string(OpenConn(),$_POST['ccode']);

    $adv = $cyear." - ".$ccode;

    $updatead = "UPDATE tbl_respondent SET course_year = '$cyear',course_code = '$ccode' WHERE id = '$refid'";
    OpenConn()->query($updatead);

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Update the Respondent: $adv ','$eventid','Successfull') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    echo json_encode(array('updated'));
  }




  ?>
