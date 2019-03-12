<?php require('model/dbconn.php');


session_start();

if (!isset($_SESSION['user'])) {
  header('location: security-checkpoint');
}else if($_SESSION['role'] == "Teacher" || $_SESSION['role'] == "Administrator"){
  header('location: dashboard');
}else{

  $studid = $_SESSION['idno'];

  $getimg = "SELECT avatar,first_name,last_name,cyear,course_code,section FROM tbl_students WHERE student_no = '$studid' ";

  $resultimg = OpenConn()->query($getimg);

  if ($resultimg->num_rows > 0) {
    while ($row = $resultimg->fetch_assoc()) {
      $img = $row['avatar'];
      $studname = $row['first_name']." ".$row['last_name'];

      $cyear = $row['cyear'];
      $course_code = $row['course_code'];
      $section = $row['section'];
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>My Profile</title>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">


</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="student-profile">Student Dashboard</a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-child"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <div class="input-group-append">
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">


      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" target="_blank" href="/"><span class="fa fa-globe"></span> Newsfeed</a>
          <a class="dropdown-item" href="student-settings"><span class="fa fa-cog"></span> Settings</a>

          <!--a class="dropdown-item" href="#">Activity Log</a-->
          <div class="dropdown-divider"></div>
          <button class="dropdown-item" href="#"  data-toggle="modal" data-target="#logoutModal"> <span class="fa fa-arrow-right"></span> Logout</button>
        </div>
      </li>
    </ul>
  </nav>
