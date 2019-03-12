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
  <link rel="stylesheet" href="css/custom-modal.css">
  <link href="css/layout.css" rel="stylesheet" type="text/css" media="all">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"></head>

  <body id="top" style="font-family: 'Ubuntu', sans-serif;">
    <style>
    html {
    overflow: scroll;
    overflow-x: hidden;
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



<!-- The Modal -->
    <input type="hidden" id="isregistered"  name="" value="<?php echo $registered; ?>">
    <div id="myModal" style="color:black; z-index:999999999;" class="c-modal">
      <!-- Modal content -->
      <div class="modal-content" style="background:white;">

        <div class="" style="float:right;">
        <span style="color:black;"><b>EVSU - Events Organizer</b><span class="close">&times;</span></span>
        </div>
        <hr>
        <h4 style="color:black;">Easy Registration will expired soon...</h4>
        <div class="form-row">
          <div class="form-group col-md-12">
            <div style="z-index: 9999999; text-align:center; position: absolute; top:10%;display:none; left: 0;right: 0;height: auto; width: 100%; margin:0 auto;" id="submit-alert" class="form-control"></div>
          </div>
        </div>
        <div style="color:indianred; font-size:20px;" id="newcountdown"></div>
        <br>
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
      <div style="width:100%;height:30px; background:;"></div>
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






    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper row0 navbar-fixed-top">
      <div id="topbar" class="hoc clear navbar-fixed-top">
        <div class="fl_left">
          <ul>
            <li>
            </li>
          </ul>
        </div>
        <div class="fl_right">
          <ul>
            <li><a style="" href="newsfeed"title="Newsfeed"><i class="fa fa-lg fa-globe"></i>Events Newsfeed </a></li>
            <li><a style="" href="security-checkpoint"title="Login"><i class="fa fa-lg fa-user-circle"></i>Login</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="wrapper row2">
      <nav id="mainav" class="hoc clear">
        <!-- ################################################################################################ -->

        <!-- ################################################################################################ -->
      </nav>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->

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
              <img  src="img/events/<?php echo $event_image; ?>" >
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
  <div class="" style="color:black;text-align:center;">
    <h6 class="heading font-x3" style="font-family: 'Ubuntu', sans-serif;">Upcoming Events</h6>
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
          <article class="bgded overlay" style="padding:20px;height:450px;">
            <div class="txtwrap" style="height:250px;">
              <img src="img/events/<?php echo $event_th; ?>" style="width:100%;height:0 auto;" alt="<?php echo $event_th; ?>">
              <hr>
              <h6 class="" style="color:#ffffff; font-family: 'Ubuntu', sans-serif;"><?php echo $event_name; ?></h6>
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

                <footer style=""><button type="button" id="edesc<?php echo $id ?>" class="btn btn-primary" style="border-radius:0px; text-transform: none !important;">Read more &raquo;</button></footer>
              </div>
            </div>
          </article>
        </div>



        <div id="descmodal<?php echo $id ?>" style="color:black; z-index:999999999;" class="c-modal">
          <!-- Modal content -->
          <div class="modal-content" style="background:white;">

            <div class="" style="float:right;">
              <span style="color:black;" id="closedesc<?php echo $id ?>" ><b>EVSU - <?php echo $event_name;?></b><span class="close">&times;</span></span>
            </div>
            <hr>

            <div class="form-row">
              <div class="col-md-12">
                <img src="img/events/<?php echo $event_th;?>" alt="">
              </div>
              <div class="col-md-12" style="color:black;">
                <br>
                <p><?php echo $event_description; ?></p>
              </div>
            </div>

          </div>
        </div>
        <?php
      }
    }
    ?>
  </div>
  <br><br><br><br>

</div>











































































    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper bgded overlay" style="background-image:url('img/devcover.jpg');">
      <section class="hoc container clear">
        <!-- ################################################################################################ -->
        <div class="sectiontitle center">
          <h3 class="heading font-x3" style="font-family: 'Ubuntu', sans-serif;">Developers</h3>
        </div>
        <ul class="nospace group center">
          <li class="one_third first">
            <article>
                <img src="img/dev1.jpg" class="img-responsive" style="width:100px; border-radius:50%" alt="">
              <br><br>
              <h6 class="heading font-x2" style="font-family: 'Ubuntu', sans-serif;">Jenny Ruth Valle</h6>
              <span>BSINT STUDENT <br>vallejennyruth08@gmail.com</span>
              <footer></footer>
            </article>
          </li>
          <li class="one_third">
            <article>
                <img src="img/dev2.jpg" class="img-responsive" style="width:100px; border-radius:50%" alt="">
              <br><br>
              <h6 class="heading font-x2" style="font-family: 'Ubuntu', sans-serif;">Jam Juanite</h6>
              <span>BSINT STUDENT <br>jamjuanite@gmail.com </span>
              <footer></footer>
            </article>
          </li>
          <li class="one_third">
            <article>
                <img src="img/dev3.jpg" class="img-responsive" style="width:100px; border-radius:50%" alt="">
              <br><br>
              <h6 class="heading font-x2" style="font-family: 'Ubuntu', sans-serif;">Dan Barry Realino</h6>
              <span>BSINT STUDENT <br>jamrealino@gmail.com</span>
              <footer></footer>
            </article>
          </li>
        </ul>
        <!-- ################################################################################################ -->
      </section>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->

    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->


    <div class="wrapper row4">
      <br><br><br>
      <div class="sectiontitle center" style="margin-bottom:-10px;">
        <h1 class="heading font-x3" style="font-family: 'Ubuntu', sans-serif;">EASTERN VISAYAS STATE UNIVERSITY</h1>
      </div>
      <footer id="footer" class="hoc clear">
        <div class=" first">
          <ul class="nospace btmspace-30 linklist contact">
            <li><i class="fa fa-map-marker"></i>
              <address>
                Salazar St, Downtown, Tacloban City, Leyte
              </address>
            </li>
            <li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
            <li><i class="fa fa-envelope-o"></i> <a href="mailto:evsuevents@gmail.com">evsucalendar@gmail.com</a> </li>
          </ul>
          <ul class="faico clear">
            <li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="faicon-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
          </ul>
        </div>

        <!-- ################################################################################################ -->
      </footer>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <div class="wrapper row5">
      <div id="copyright" class="hoc clear">
        <!-- ################################################################################################ -->
        <p class="fl_left">Copyright &copy; 2019 - All Rights Reserved - <a href="#">EVSU Events Organizer</a></p>
        <!-- ################################################################################################ -->
      </div>
    </div>
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <!-- ################################################################################################ -->
    <a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
    <!-- JAVASCRIPTS -->
    <script src="js/jquery.backtotop.js"></script>
    <script src="js/jquery.mobilemenu.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>


    <script type="text/javascript">

    var modaldesc = document.getElementById('descmodal<?php echo $id ?>');
    var span1 = document.getElementById("closedesc<?php echo $id ?>");

    $('#edesc<?php echo $id ?>').on('click',function(){

      setTimeout(function () {
      $('#descmodal<?php echo $id ?>')
      //.hide()
      .fadeIn(500)
      .delay(100);
    }, 500);

    });


    span1.onclick = function() {
      modaldesc.style.display = "none";
    }


    // Get the modal
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];

    function showmymodal() {

      setTimeout(function () {

        $('#myModal')
        //.hide()
        .fadeIn(1000)
        .delay(100000);
      }, 1000);
    }

    span.onclick = function() {
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal || event.target == modaldesc) {
        modal.style.display = "none";
        modaldesc.style.display = "none";
      }
    }


    $(window).on('load',function(){

      CountDownTimer('02/31/2019 5:00 PM', 'newcountdown');

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













  </body>
  </html>
