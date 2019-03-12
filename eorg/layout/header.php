<?php require('model/dbconn.php');


session_start();


if (!isset($_SESSION['user'])) {
  header('location: security-checkpoint');
}
else if($_SESSION['role'] == "Administrator" || $_SESSION['role'] == "Teacher" || $_SESSION['role'] == "Organizer" ){
  if ($_SESSION['role'] == "Teacher") {
    $display = 'style="display:none;"';
    $utility = 'style="display:none;"';
    $events = 'style="display:none;"';
    $hidestudent = 'style="display:block;"';
    $hideinfo = 'style="display:block;"';

    $hidesms = 'style="display:none;"';
    $hidemail = 'style="display:none;"';
   }

   elseif($_SESSION['role'] == "Administrator"){
      $display = 'style="display:block;"';
      $events = 'style="display:block;"';
      $utility = 'style="display:block;"';
      $hidestudent = 'style="display:block;"';
      $hideinfo = 'style="display:none;"';

      $hidesms = 'style="display:block;"';
      $hidemail = 'style="display:block;"';
   }



   elseif($_SESSION['role'] == "Organizer"){
     $display = 'style="display:none;"';
     $utility = 'style="display:none;"';
     $events = 'style="display:block;"';
     $hidestudent = 'style="display:none;"';
    $hideinfo = 'style="display:none;"';

      $hidesms = 'style="display:block;"';
      $hidemail = 'style="display:block;"';
   }

}else if($_SESSION['role'] == "Student"){
  header('location: student-profile');
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

  <title>EOrg - <?php echo $_SESSION['role']; ?></title>
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

    <a class="navbar-brand mr-1" href="#">Event Organizer</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
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
          <a class="dropdown-item" href="/" target="_blank"><span class="fas fa-fw fa-globe"></span> Newsfeed</a>
          <a class="dropdown-item" href="settings"><span class="fa fa-cog"></span> Settings</a>
          <!--a class="dropdown-item" href="#">Activity Log</a-->
          <div class="dropdown-divider"></div>
          <button class="dropdown-item" href="#"  data-toggle="modal" data-target="#logoutModal"> <span class="fa fa-arrow-right"></span> Logout</button>
        </div>
      </li>
    </ul>
  </nav>
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item" id="dashboard">
        <a class="nav-link" href="dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li <?php echo $display ?> class="nav-item" id="courses">
        <a class="nav-link"href="courses">
          <i class="fas fa-fw fa-graduation-cap"></i>
          <span>Courses</span></a>
        </li>
        <li <?php echo $events ?> class="nav-item" id="events">
          <a class="nav-link" href="events">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Events</span></a>
          </li>
          <li <?php echo $display ?> class="nav-item" id="instructors">
            <a class="nav-link" href="instructors">
              <i class="fas fa-fw fa-chalkboard-teacher"></i>
              <span>Instructors</span></a>
            </li>
            <li <?php echo $hidestudent; ?> class="nav-item" id="students">
              <a class="nav-link" href="students">
                <i class="fas fa-fw fa-child"></i>
                <span>Students</span></a>
              </li>
              <li <?php echo $display; ?> class="nav-item" id="scholarship">
                <a class="nav-link" href="scholarships">
                  <i class="fas fa-fw fa-university "></i>
                  <span>Scholarship</span></a>
                </li>
              <li  class="nav-item" id="attendance">
                <a class="nav-link" href="attendance">
                  <i class="fas fa-fw fa-calendar-check"></i>
                  <span>Attendance</span></a>
                </li>
                <li class="nav-item" id="logs">
                  <a class="nav-link" href="attendance-logs">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>Attendance Logs</span></a>
                  </li>
                  <li <?php echo $display; ?> class="nav-item" id="accounts">
                    <a class="nav-link" href="accounts">
                      <i class="fas fa-fw fa-lock"></i>
                      <span>Accounts</span></a>
                    </li>
                    <li <?php echo $hidemail; ?> class="nav-item" id="mails">
                      <a class="nav-link" href="mails">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>Mails</span></a>
                      </li>
                    <li <?php echo $hidesms; ?> class="nav-item" id="sms">
                      <a class="nav-link" href="sms">
                        <i class="fas fa-fw fa-mobile-alt"></i>
                        <span>SMS</span></a>
                      </li>

                  <!--li class="nav-item" id="utility">
                    <a class="nav-link" href="utility.php">
                      <i class="fas fa-fw fa-cog"></i>
                      <span>Utility</span></a>
                    </li-->
                  </ul>
