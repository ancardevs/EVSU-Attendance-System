<?php


require('dbconn.php');

$currentsession = "";

if (isset($_POST['login'])) {
  $user = mysqli_real_escape_string(OpenConn(),$_POST['user']);
  $pass = mysqli_real_escape_string(OpenConn(),$_POST['pass']);


  $checkuser = "SELECT id,user,id_no,pass,user_type
  FROM tbl_credentials

  WHERE user = '$user' AND pass = '$pass' AND remarks = 'Enabled'";
  $checkuserresult = OpenConn()->query($checkuser);

  if(mysqli_num_rows($checkuserresult) > 0){
    while ($row = $checkuserresult->fetch_assoc()) {
      $id = $row['id'];
      $user = $row['user'];
      $idno = $row['id_no'];
      $pass = $row['pass'];
      $usertype = $row['user_type'];

      session_start();

      $_SESSION['user'] = $id;
      $_SESSION['role'] = $usertype;
      $_SESSION['idno'] = $idno;

      $currentsession = $idno;
      //Tract Activity
      $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
      VALUES('$idno','Login to an Account','$idno','Successfull') ";
      OpenConn()->query($trackactivity);
      //Tract Activity
      echo json_encode(array($usertype));
    }
  }else{
    echo json_encode(array('nouser'));
  }
}




if (isset($_POST['changepass'])) {

  $idno = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);
  $pass = mysqli_real_escape_string(OpenConn(),$_POST['pass']);

  $changepass = "UPDATE tbl_credentials SET pass = '$pass' WHERE id_no = '$idno'";
  OpenConn()->query($changepass);


  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$idno','Change an Account Password','$idno','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity

  echo json_encode(array('changed'));

}




if (isset($_POST['logout'])) {

  session_start();
  $currentsession = $_SESSION['idno'];

  //Tract Activity
  $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
  VALUES('$currentsession','End Session','$currentsession','Successfull') ";
  OpenConn()->query($trackactivity);
  //Tract Activity

  session_destroy();
  echo json_encode(array('loggedout'));

}else{

}


?>
