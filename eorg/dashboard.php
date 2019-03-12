<?php

require('layout/header.php');

//----------------------------------------
$eventquery = "SELECT * FROM tbl_events";
$eventresult = OpenConn()->query($eventquery);
$eventcount = mysqli_num_rows($eventresult);
//----------------------------------------


//----------------------------------------
$coursequery = "SELECT * FROM tbl_course";
$courseresult = OpenConn()->query($coursequery);
$coursecount = mysqli_num_rows($courseresult);
//----------------------------------------


//----------------------------------------
$insquery = "SELECT * FROM tbl_teacher";
$insresult = OpenConn()->query($insquery);
$inscount = mysqli_num_rows($insresult);
//----------------------------------------


//----------------------------------------
$studquery = "SELECT * FROM tbl_students";
$studresult = OpenConn()->query($studquery);
$studcount = mysqli_num_rows($studresult);
//----------------------------------------




// echo $_SESSION['role'];


?>

<script src="vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $('#dashboard').addClass('nav-item active')
});



</script>


<div id="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->


    <!-- Icon Cards-->
    <div class="row">
      <div <?php echo $events ?> class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-primary o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-calendar"></i>
            </div>
            <div class="mr-5"><b><?php echo $eventcount; ?></b> Events</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="events">
            <span class="float-left">View Details</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
      <div <?php echo $display ?> class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-warning o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-graduation-cap"></i>
            </div>
            <div class="mr-5"><b><?php echo $coursecount; ?></b> Courses</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="courses">
            <span class="float-left">View Details</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
      <div <?php echo $display ?> class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-success o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-chalkboard-teacher"></i>
            </div>
            <div class="mr-5"><b><?php echo $inscount; ?></b> Instructors</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="instructors">
            <span class="float-left">View Details</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>
      <div <?php echo $hidestudent; ?> class="col-xl-3 col-sm-6 mb-3">
        <div class="card text-white bg-danger o-hidden h-100">
          <div class="card-body">
            <div class="card-body-icon">
              <i class="fas fa-fw fa-child"></i>
            </div>
            <div class="mr-5"><b><?php echo $studcount; ?></b> Students</div>
          </div>
          <a class="card-footer text-white clearfix small z-1" href="students">
            <span class="float-left">View Details</span>
            <span class="float-right">
              <i class="fas fa-angle-right"></i>
            </span>
          </a>
        </div>
      </div>



    </div>













    <div class="row">
      <div class="col-md-12">
        <!--Carousel Wrapper-->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <?php
            $getEvents = "SELECT * FROM tbl_events WHERE event_date = DATE_FORMAT(NOW(), '%Y/%m/%d') ORDER BY event_date desc";
            $result = OpenConn()->query($getEvents);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $row['id']; ?>"></li>
              <?php }
            }
            ?>
          </ol>
          <div class="carousel-inner">



            <div class="carousel-item active">
              <img style="" class="d-block w-100" src="img/newscover.png" style="width:50%;" alt="First slide">
              <div class="carousel-caption d-none d-md-block">
                <h5 style="text-transform:normal;">Keep Updated to the University Events</h5>
                <p>The Trusted University Event Newsfeed</p>
              </div>
            </div>


            <?php
            $getEvents = "SELECT * FROM tbl_events WHERE event_date = DATE_FORMAT(NOW(), '%Y/%m/%d') ORDER BY event_date desc";
            $result = OpenConn()->query($getEvents);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $event_name = $row['event_name'];
                $event_image = $row['event_cover'];
                $event_date = $row['event_date'];
                $login_time = date('h:i A', strtotime($row['login_time']));
                $logout_time = $row['logout_time'];

                $event_description = $row['event_description'];

                ?>

                <div class="carousel-item">
                  <img  src="img/events/<?php echo $event_image; ?>" >
                  <div class="carousel-caption d-none d-md-block" style="background-color:black; opacity:0.7; color:white;">
                    <h5><?php echo $event_name ?></h5>
                    <p><?php echo $event_date.' | Attendance starts at: ' .$login_time; ?></p>
                  </div>
                </div>


              <?php }
            } ?>

          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <!--/.Carousel Wrapper-->
      </div>

    </div>






    <!-- Area Chart Example-->

    <!-- DataTables Example -->
  </div>
  <!-- /.container-fluid -->

  <?php require('layout/footer.php'); ?>
