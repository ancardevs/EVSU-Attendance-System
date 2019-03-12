<?php
require('model/dbconn.php');

session_start();

$registered = "";

if (isset($_GET['registered'])) {
  $registered = $_GET['registered'];

  if ($registered == "true") {
    $_SESSION['isregistered'] = "true";
  }else{
    $_SESSION['isregistered'] = "false";
  }
}


?>
<!DOCTYPE html>
<html>
<head>
  <title>EVSU - Events</title>


  <!----->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description:" content="EVSU Events is the official University Organizer platdform of Eastern Visayas State University. Keep updated and read more about the latest events and stuff!">
  <meta name="keywords" content="evsuevents,EVSU Events, events, evsu, eastern visayas state university events, evsu university, tacloban city, university">
  <meta name="author" content="Jerwen Reloz">

  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="EVSU- Events">
  <meta itemprop="description" content="EVSU Events is the official University Organizer platdform of Eastern Visayas State University. Keep updated and read more about the latest events and stuff!">
  <meta itemprop="image" content="http://evsuevents.epizy.com/img/favicon.png">
  <!----->

  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" charset="utf-8"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" charset="utf-8"></script>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"></head>

  <body id="top" style="font-family: 'Ubuntu', sans-serif;">
    <style>

    html {
      overflow: scroll;
      overflow-x: hidden;
    }
    body {
      padding-top: 55px;
    }
    ::-webkit-scrollbar {
      width: 0px;  /* remove scrollbar space */
      background: transparent;  /* optional: just make scrollbar invisible */
    }
    /* optional: show position indicator in red */
    ::-webkit-scrollbar-thumb {
      background: #FF0000;
    }

    </style>



    <div class="modal fade" id="easyreg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Easy Registration will expire soon...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div style="color:indianred; font-size:20px;" id="newcountdown"></div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <div style="z-index: 9999999; text-align:center; position: fixed; top:10%;display:none; left: 0;right: 0;height: auto; width: 70%; margin:0 auto;" id="submit-alert" class="form-control"></div>
              </div>
            </div>
            <div class="">

              <form action="model/student.php" method="post">


                <div class="form-row">
                  <div class="form-group col-md-6">
                    Student ID No.
                    <input type="text" required name="idnumber" id="idnumber" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    College
                    <input type="list" list="CollegeList" name="college" id="college" value="" class="form-control">
                    <datalist class="" id="CollegeList">
                      <?php
                      $getCourses = "SELECT DISTINCT college FROM tbl_course";
                      $result = OpenConn()->query($getCourses);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $college = $row['college'];
                          ?>
                          <option value="<?php echo $college; ?>"><?php echo $college; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </datalist>
                  </div>
                </div>



                <div class="form-row">

                  <div class="form-group col-md-4">
                    First Name
                    <input type="text" name="firstname" class="form-control" id="firstname" required>
                  </div>
                  <div class="form-group col-md-4">
                    Middle Name
                    <input type="text" name="middlename" class="form-control" id="middlename" required>
                  </div>
                  <div class="form-group col-md-4">
                    Last Name
                    <input type="text" name="lastname" class="form-control" id="lastname" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="col-md-4">
                    Year
                    <select name="cyear" id="cyear" value="" class="form-control">
                      <option value="First Year">First Year</option>
                      <option value="Second Year">Second Year</option>
                      <option value="Third Year">Third Year</option>
                      <option value="Fourth Year">Fourth Year</option>
                      <option value="Fifth Year">Fifth Year</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">

                    Course
                    <input type="list" list="CourseList" name="course" id="course" value="" class="form-control">
                    <datalist class="" id="CourseList">
                      <?php
                      $getCourses = "SELECT DISTINCT id, course_code,course_desc FROM tbl_course";
                      $result = OpenConn()->query($getCourses);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $id = $row['id'];
                          $course_code = $row['course_code'];
                          $course_desc = $row['course_desc'];
                          ?>
                          <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </datalist>

                  </div>

                  <div class="form-group col-md-4">
                    Section
                    <input type="text" name="section" class="form-control" id="section" required>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    Department
                    <input type="list" list="DepartmentList" required id="department" name="department" class="form-control">
                    <datalist class="" id="DepartmentList">
                      <?php
                      $getCourse = "SELECT id,college,department,course_code,course_desc FROM tbl_course GROUP BY department";
                      $result = OpenConn()->query($getCourse);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $college = $row['college'];
                          $department = $row['department'];
                          $course_code = $row['course_code'];
                          $course_name = $row['course_desc'];
                          ?>
                          <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </datalist>
                  </div>
                  <div class="form-group col-md-3">
                    Birthdate
                    <input type="date" name="bdate" class="form-control" id="bdate" required>
                  </div>
                  <div class="form-group col-md-3">
                    Contact
                    <input type="text" name="contact" class="form-control" id="contact" required>
                  </div>
                </div>


                <div class="form-row">
                  <div class="form-group col-md-6">
                    Email
                    <input type="text" name="emailadd" class="form-control" id="emailadd" required>
                  </div>
                  <div class="form-group col-md-6">
                    Scholarship
                    <input type="list" name="scholarship" list="ScholarshipList" class="form-control" value="" id="scholarship" required>
                    <datalist class="" id="ScholarshipList">
                      <?php
                      $getGrant = "SELECT DISTINCT id, grant_code,grant_desc FROM tbl_scholarship";
                      $resultgrant = OpenConn()->query($getGrant);

                      if ($resultgrant->num_rows > 0) {
                        while ($row = $resultgrant->fetch_assoc()) {
                          $id = $row['id'];
                          $grant_code = $row['grant_code'];
                          $grant_desc = $row['grant_desc'];
                          ?>
                          <option value="<?php echo $grant_code; ?>"><?php echo $grant_desc; ?></option>
                          <?php
                        }
                      }
                      ?>
                    </datalist>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    Address
                    <input type="text" name="address" class="form-control" id="address" required>
                  </div>
                </div>
                <br>

                <div class="modal-footer">
                  <div style="display:none; z-index:9999; top:10%; left:10%; position:fixed; margin:0 auto;text-align:center; margin-top:10px; width:400px;" id="success-alert" class="alert alert-success">Command completed successfully !</div>
                  <button type="button" class="btn btn-primary" name="addstudent" id="addstudent">Register My Information</button>
                  <style media="screen">
                  .btn{
                    border-style: none !important;
                  }
                  .btn:hover{
                    background-color: #3ca7c9 !important;
                    border-style: none !important;
                    color:white !important;
                  }
                  </style>
                </div>
              </form>
            </div>

          </div>

        </div>
      </div>
    </div>



    <script>

    $("#addstudent").on("click", function(){
      if($('#idnumber').val() == "" ||
      $('#firstname').val() == "" ||
      $('#lastname').val() == "" ||
      $('#cyear').val() == "" ||
      $('#course').val() == "" ||
      $('#college').val() == "" ||
      $('#department').val() == "" ||
      $('#section').val() == "" ||
      $('#emailadd').val() == "" ||
      $('#contact').val() == "" ||
      $('#bdate').val() == "" ||
      $('#address').val() == ""){
        setTimeout(function () {
          $('#submit-alert').removeClass('alert alert-success');
          $("#submit-alert").addClass("alert alert-warning");

          $('#submit-alert').html("Please fill all required fields!");
          $('#submit-alert')
          //.hide()
          .fadeIn(500)
          .delay(2000)
          .fadeOut(500);
        }, 0);
      }else{
        $('#addstudent').prop('disabled', true);
        $("#addstudent").html('Saving Information...');

        var data = {
          "idnumber" : $('#idnumber').val(),
          "firstname" : $('#firstname').val(),
          "middlename" : $('#middlename').val(),
          "lastname" : $('#lastname').val(),

          "college" : $('#college').val(),
          "scholarship" : $('#scholarship').val(),
          "department" : $('#department').val(),


          "cyear" : $('#cyear').val(),
          "course" : $('#course').val(),
          "section" : $('#section').val(),
          "emailadd" : $('#emailadd').val(),
          "contact" : $('#contact').val(),
          "bdate" : $('#bdate').val(),
          "address" : $('#address').val(),

          "addstudent" : "addstudent"
        };
        data = $(this).serialize() + "&" + $.param(data);

        $.ajax({
          type: 'POST',
          url: 'model/easyregister.php',
          dataType : 'json',
          data: data,
          success: function (data) {
            if(data == 'exist'){
              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');
              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-success');
                $('#submit-alert').addClass('alert alert-warning');

                $('#submit-alert').html("Data existed in the database.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(2000)
                .fadeOut(500);
              }, 0);
            }else if(data == 'mailerr'){
              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');
              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-success');
                $("#submit-alert").addClass("alert alert-warning");

                $('#submit-alert').html("Data are saved. <br>Warning: No internet connection, Mail failed to send.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(5000)
                .fadeOut(500);
              }, 0);

              setTimeout(function () {
                location.href = "newsfeed?registered=true";
              }, 2000);

            }else{

              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');

              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-warning');
                $("#submit-alert").addClass("alert alert-success");

                $('#submit-alert').html("Your Information are inserted successfully! Mail sent.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(3000)
                .fadeOut(500);
              }, 0);

              setTimeout(function () {
                location.href = "newsfeed?registered=true";
              }, 2000);
            }

          }
        });
      }
    });



    </script>




    <style media="screen">
    .nav {
      margin: 0 auto;
      padding: 10px;
      width: 75%;
      height: 1.74em;
     }
    </style>

    <header class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
      <a class="navbar-brand" href="#">EVSU Events Newsfeed</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">

        </ul>
        <span class="navbar-text">
          <a href="security-checkpoint" class="" style="text-decoration:none;"><span class="fa fa-user"></span> Sign in</a>
        </span>
      </div>
    </header>


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
            <h1 style="font-family: 'Ubuntu', sans-serif;">Keep Updated to the University Events</h1>
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

            $event_venue = $row['event_venue'];

            $event_date = $row['event_date'];
            $login_time = date('h:i A', strtotime($row['login_time']));
            $logout_time = $row['logout_time'];
            $event_description = $row['event_description'];
            ?>

            <div class="carousel-item">
              <img  src="img/events/<?php echo $event_image; ?>" style="width:100%;height:auto;" >
              <div class="carousel-caption d-none d-md-block" style="background-color:black; opacity:0.7; color:white;">
                <h5><?php echo $event_name ?></h5>
                <p><?php echo $event_date.' | Attendance starts at: ' .$login_time; ?></p>
                <span>&copy; <?php echo $event_venue; ?></span>
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

















    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->


    <div class="col-md-12" style="background:white;">
      <br><br>


    </div>

    <section id="team" class="pb-5">
      <div class="container">
        <div class="" style="color:black;text-align:center;">
          <h5 class="section-title h1" style="font-family: 'Ubuntu', sans-serif;">Upcoming Events</h5>
          <span class="fa fa-arrow-right"> </span>
        </div>
        <div class="row">

          <!----------------------------------------------------------------------------------->
          <?php
          $getEvents = "SELECT DISTINCT
          te.id AS event_id,
          te.event_name AS event_name,
          te.event_venue AS event_venue,
          te.event_cover AS event_cover,
          te.event_date AS event_date,
          te.login_time AS login_time,
          te.logout_time AS logout_time,
          te.event_description AS event_description

          FROM
          tbl_events as te
          INNER JOIN tbl_respondent as tr
          ON te.event_no = tr.event_no
          WHERE
          te.event_date > DATE_FORMAT(NOW(), '%Y/%m/%d') OR event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')
          ORDER BY
          te.event_date ASC";
          $result = OpenConn()->query($getEvents);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $id = $row['event_id'];
              $event_name = $row['event_name'];
              $event_venue = $row['event_venue'];
              $event_th = $row['event_cover'];
              $event_date = $row['event_date'];
              $login_time = date('h:i A', strtotime($row['login_time']));
              $logout_time = $row['logout_time'];

              $event_description = $row['event_description'];
              $respondent = '';

              $newd = new DateTime($event_date);
              $finald = $newd->format("F j, Y");
              $resyear = "";
              ?>

              <div class="col-md-4">
                <br>
                <!--article class="bgded overlay" style="padding:20px;height:300px; background-size: cover;background-image:url('img/events/<?php //echo $event_th; ?>');"-->
                <article class="well" style="padding:20px;height:auto; background-color:#4e4e4e; color:white;">
                  <div class="txtwrap" style="height:auto;">
                    <img src="img/events/<?php echo $event_th; ?>" style="width:100%;height:0 auto;" alt="<?php echo $event_th; ?>">
                    <hr>
                    <h4 class="" style="color:#ffffff; font-family: 'Ubuntu', sans-serif;"><?php echo $event_name; ?></h4>
                    <span><?php echo $finald; ?></span>
                    <br>
                    <span>Attendance starts at: <?php echo $login_time; ?></span><br>
                    <span>&copy; <?php echo $event_venue; ?></span>
                    <br><br>

                    <?php
                    $getreps = "SELECT
                    tr.event_no AS eventn,
                    tr.course_code AS course_code,
                    tr.course_year AS course_year
                    FROM tbl_respondent as tr
                    WHERE tr.event_no = '$id' ";

                    $resultres = OpenConn()->query($getreps);

                    if ($result->num_rows > 0) {
                      while ($rowx = $resultres->fetch_assoc()) {
                        $rescode = $rowx['course_code'];
                        $resyear = $rowx['course_year'];

                        $respondents = $rescode." - ".$resyear;
                        ?>
                        <span>FUCK <?php echo $respondents; ?><br> </span>
                        <?php
                      }
                    }else{
                      ?>
                      <span>SHIT<br> </span>
                      <?php
                    }

                    ?>
                    <div class="">
                      <span><?php echo $resyear; ?></span>
                      <button type="button" data-toggle="modal" data-target="#descmodal<?php echo $id ?>" class="btn btn-primary" style="border-radius:0px; text-transform: none !important;">Read more &raquo;</button>
                    </div>
                  </div>
                </article>
              </div>


              <div class="modal fade" id="descmodal<?php echo $id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">EVSU - <?php echo $event_name;?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="col-md-12">
                        <img src="img/events/<?php echo $event_th;?>" alt="" style="width:100%;height:auto;">
                      </div>
                      <div class="col-md-12" style="color:black;">
                        <br>
                        <p><?php echo $event_description; ?></p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <?php
            }
          }
          ?>
          <br><br><br><br>


        </div>
      </div>
    </section>



    <!-- Team -->
    <section id="team" class="pb-5" style="background-blend-mode: screen multiply;background-color: #414481;">
      <br><br>
      <div class="container">
        <div class="" style="color:black;text-align:center;">
          <br>
          <h5 class="section-title h1" style="font-family: 'Ubuntu', sans-serif; color:white;">Developers</h5>
        </div>
        <br><br>

        <div class="row">
          <!-- Team member -->
          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
              <div class="mainflip">
                <div class="frontside">
                  <div class="card">
                    <div class="card-body text-center">
                      <p><img class=" img-fluid" src="img/dev1.jpg" style="border-radius:50%; width:150px;" alt="card image"></p>
                      <h4 class="card-title">Jenny Ruth Valle</h4>
                      <p class="card-text">
                        <a href="mailto:jamjuanite@gmail.com" style="text-decoration:none;">vallejennyruth08@gmail.com</a>
                      </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
              <div class="mainflip">
                <div class="frontside">
                  <div class="card">
                    <div class="card-body text-center">
                      <p><img class=" img-fluid" src="img/dev2.jpg" style="border-radius:50%; width:150px;" alt="card image"></p>
                      <h4 class="card-title">Jam Juanite</h4>
                      <p class="card-text">
                        <a href="mailto:jamjuanite@gmail.com" style="text-decoration:none;">jamjuanite@gmail.com</a>
                      </p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
              <div class="mainflip">
                <div class="frontside">
                  <div class="card">
                    <div class="card-body text-center">
                      <p><img class=" img-fluid" src="img/dev3.jpg" style="border-radius:50%; width:150px;" alt="card image"></p>
                      <h4 class="card-title">Dan Barry Realino</h4>
                      <p class="card-text">
                        <a href="mailto:danrealino@gmail.com" style="text-decoration:none;">danrealino@gmail.com</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./Team member -->

        </div>
      </div>
      <br><br><br>
    </section>

    <script type="text/javascript">

    function showmymodal() {

      setTimeout(function() {
        $('#easyreg').modal('show');
      }, 1000); // milliseconds

    }

    $(window).on('load',function(){

      CountDownTimer('03/31/2019 5:00 PM', 'newcountdown');

      function CountDownTimer(dt, id)
      {
        var end = new Date(dt);

        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var timer;

        function showRemaining() {
          var now = new Date();
          var distance = end - now;
          if (distance < 0) {

            clearInterval(timer);
            document.getElementById(id).innerHTML = 'EXPIRED!';
            return;
          }else if ($("#isregistered").val() == "true") {
            return;
          }else{
            showmymodal();
            clearInterval(timer);
          }
          var days = Math.floor(distance / _day);
          var hours = Math.floor((distance % _day) / _hour);
          var minutes = Math.floor((distance % _hour) / _minute);
          var seconds = Math.floor((distance % _minute) / _second);

          document.getElementById(id).innerHTML = days + 'days ';
          document.getElementById(id).innerHTML += hours + 'hrs ';
          document.getElementById(id).innerHTML += minutes + 'mins ';
          document.getElementById(id).innerHTML += seconds + 'secs';
        }

        timer = setInterval(showRemaining, 1000);
      }
    });




    </script>

    <style media="screen">
    .map-container{
      overflow:hidden;
      position:relative;
      height:0;
    }
    .map-container iframe{
      left:0;
      top:0;
      height:100%;
      width:100%;
      position:absolute;
    }
    </style>


    <!--Main layout-->
    <main class=" m-0 p-0">
      <div class="container-fluid m-0 p-0">

        <!--Google map-->
        <div id="map-container" class="z-depth-1-half map-container" style="height: 500px">
          <iframe width="600" height="450" frameborder="0" style="border:0"
                  src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJjZikQbnZBzMR15tLzADf1uw&key="
                  allowfullscreen></iframe>
        </iframe>
      </div>

    </div>
  </main>
  <!--Main layout-->





  <!-- Footer -->
  <footer class="page-footer font-small unique-color-dark">
    <br><br>
    <div style="background-color: #ffffff;">
      <div class="container">
          <div class="" style="text-align:center;">
            <a title="Facebook" href="#"><span style="margin:5px; color:#3b5998; font-size:30px;" class="fa fa-facebook-square"></span></a>
            <a title="Twitter" href="#"><span style="margin:5px; color:#1da1f2; font-size:30px;" class="fa fa-twitter-square"></span></a>
            <a title="Instagram" href="#"><span style="margin:5px; color:#F77737; font-size:30px;" class="fa fa-instagram"></span></a>
            <a title="Google" href="#"><span style="margin:5px; color:#d34836; font-size:30px;" class="fa fa-google-plus-square"></span></a>
          </div>
      </div>
    </div>

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">
      <!-- Grid row -->
      <div class="row mt-3">

        <div class="col-md-4">
          <h6 class="text-uppercase font-weight-bold">EVSU - Tacloban City</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p style="text-align:left !important;">
            The Eastern Visayas State University is a public university in the Philippines and the
            oldest higher educational institution in the Eastern Visayas region. And this page
            is the official Events Newsfeed of the University.
          </p>
        </div>

        <div class="col-md-4" >
          <h6 class="text-uppercase font-weight-bold">Usefull Links</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p style="text-align:left !important;"><a style="text-decoration:none;" href="http://www.evsu.edu.ph/">Eastern Visayas State University - Official</a></li></p>
            <p style="text-align:left !important;"><a style="text-decoration:none;" href="https://en.wikipedia.org/wiki/Eastern_Visayas_State_University">EVSU - Wikipedia</a></p>
            <p style="text-align:left !important;"><a style="text-decoration:none;" href="https://www.finduniversity.ph/universities/eastern-visayas-state-university/">EVSU - Find University</a></p>
        </div>

        <div class="col-md-4" >
          <h6 class="text-uppercase font-weight-bold">Contact</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p style="text-align:left !important;"><i class="fa fa-home mr-3"></i> Salazar St, Downtown, Tacloban City, Leyte</p>
            <p style="text-align:left !important;"><i class="fa fa-envelope mr-3"></i><a href="mailto:evsucalendar@gmail.com" style="text-decoration:none;">evsucalendar@gmail.com</a> </p>
            <p style="text-align:left !important;"><i class="fa fa-phone mr-3"></i> +6395-5138-6695</p>
        </div>

      </div>
    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">
      <hr>

      © 2019 Copyright -
      <a href="https://evsuevents.epizy.com"> EVSU Events Newsfeed</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->







</body>
</html>
