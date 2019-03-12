<?php
require('dbconn.php');

session_start();
$currentsession = $_SESSION['idno'];

if (isset($_POST['addaccount'])) {

  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $user = mysqli_real_escape_string(OpenConn(),$_POST['user']);
  $pass = mysqli_real_escape_string(OpenConn(),$_POST['pass']);
  $role = mysqli_real_escape_string(OpenConn(),$_POST['role']);
  $remarks = mysqli_real_escape_string(OpenConn(),$_POST['remarks']);

  $department = mysqli_real_escape_string(OpenConn(),$_POST['department']);


  $checkacc = "SELECT id,user FROM tbl_credentials WHERE id_no = '$idnumber' OR user = '$user' ";
  $checkresult = OpenConn()->query($checkacc);

  if(mysqli_num_rows($checkresult) > 0){

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Created an Account - Account Exist','$idnumber','Failed') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    echo json_encode(array('exist'));
  }else{

    $addacc = "INSERT INTO tbl_credentials(id_no, user,pass,user_type,remarks)
    VALUES('$idnumber','$user','$pass','$role','$remarks')";
    OpenConn()->query($addacc);


    $adddept = "INSERT INTO tbl_department(id_no, department)
    VALUES('$idnumber','$department')";
    OpenConn()->query($adddept);

    //Tract Activity
    $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
    VALUES('$currentsession','Created an Account','$idnumber','Successfull') ";
    OpenConn()->query($trackactivity);
    //Tract Activity

    echo json_encode(array('saved'));
  }
}


if (isset($_POST['updateacc'])) {

  $refid = mysqli_real_escape_string(OpenConn(),$_POST['ref']);
  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $user = mysqli_real_escape_string(OpenConn(),$_POST['user']);
  $pass = mysqli_real_escape_string(OpenConn(),$_POST['pass']);
  $role = mysqli_real_escape_string(OpenConn(),$_POST['role']);
  $remarks = mysqli_real_escape_string(OpenConn(),$_POST['remarks']);
  $department = mysqli_real_escape_string(OpenConn(),$_POST['department']);


  $updateacc = "UPDATE tbl_credentials SET id_no = '$idnumber', user = '$user',pass = '$pass',user_type = '$role',
  remarks = '$remarks' WHERE id_no = '$refid'";
  OpenConn()->query($updateacc);

  $updatedept = "UPDATE tbl_department SET id_no ='$idnumber', department ='$department' WHERE id_no ='$refid'";
  OpenConn()->query($updatedept);

  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Updated the Account','$idnumber','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity

  echo json_encode(array('updated'));

}



if (isset($_POST['deleteacc'])) {

  $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);

  $deleteacc = "DELETE FROM tbl_credentials WHERE id_no = '$idnumber'";
  OpenConn()->query($deleteacc);


  $deletedept = "DELETE FROM tbl_department WHERE id_no = '$idnumber'";
  OpenConn()->query($deletedept);


  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','Deleted the Account','$idnumber','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity



  echo json_encode(array('deleted'));
}



?>
