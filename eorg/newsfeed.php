<?php
require('model/dbconn.php');

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Newsbit</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="UTF-8">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Expanded:400,600,700" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Stylesheets -->

  <link href="css/bootstrap.css" rel="stylesheet">

  <link href="css/styles.css" rel="stylesheet">


</head>
<body>

  <header>

    <div class="bg-191">
      <div class="container">
        <div class="oflow-hidden color-ash font-9 text-sm-center ptb-sm-5">

          <ul class="float-left float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-10">
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-bitcoin"></i></a></li>
          </ul>
          <ul class="float-right float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-5">
            <li><a href="/"><span class="fa fa-globe"></span> NEWSFEED</a></li>
            <li><a href="security-checkpoint"><span class="fa fa-user-circle"></span> LOGIN</a></li>
          </ul>
        </div><!-- top-menu -->
      </div><!-- container -->
    </div><!-- bg-191 -->


    <div class="container">
      <!--a class="logo" href="/"><img src="img/brand-logo.png" alt="Logo"></a-->
      <h3 class="logo" href="#"><?php echo date('F Y'); ?></h3>
      <a class="right-area src-btn" href="#" >
        <i class="active src-icn ion-search"></i>
        <i class="close-icn ion-close"></i>
      </a>
      <div class="src-form">
        <form>
          <input type="text" placeholder="Search here">
          <button type="submit"><i class="ion-search"></i></a></button>
        </form>
      </div><!-- src-form -->

      <a class="menu-nav-icon" data-menu="#main-menu" href="#"><i class="ion-navicon"></i></a>

      <ul class="main-menu" id="main-menu">

      </ul>
      <div class="clearfix"></div>
    </div><!-- container -->
  </header>


  <div class="container">
    <div class="h-600x h-sm-auto">
      <div class="h-2-3 h-sm-auto oflow-hidden">
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
            $course_code = $row['course_code'];
            $cyear = $row['cyear'];
            $event_description = $row['event_description'];
            $respondent = '';


            $newd = new DateTime($event_date);
            $finald = $newd->format("F j, Y");


            if($course_code == "0" && $cyear == "0" ){
              $respondent = "To all EVSU Student";
            }elseif($course_code != "0" && $cyear != "0"){
              $respondent = 'To all '.$cyear.' - '.$course_code;
            }
            else{
              $str = 'To all '.$cyear.$course_code;
              $respondent = str_replace("0","",$str);
            }
            ?>

            <div class="pb-5 pr-5 pr-sm-0 float-sm-none  w-sm-100 h-100 h-sm-300x" style="background:url(img/events/<?php echo $event_image; ?>)">
              <a class="pos-relative h-100 dplay-block" href="#">
                <div class="img-bg bg-1 bg-grad-layer-6"></div>
                <div class="abs-blr color-white p-20 bg-sm-color-7" >
                  <h2><b><?php echo $event_name ?></b> </h2>

                  <ul class="list-li-mr-20">
                    <li><span><?php echo  $finald;?></span> </li><br>
                    <li><span>Attendance starts at: <?php echo $login_time; ?></span> </li><br>
                    <li><?php echo $respondent; ?></li><br>
                  </ul>
                </div><!--abs-blr -->
              </a><!-- pos-relative -->
            </div><!-- w-1-3 -->

          <?php }
        } ?>
      </div><!-- h-2-3 -->



      <div class="h-1-3 oflow-hidden">
        <?php
        $getEvents = "SELECT * FROM tbl_events WHERE event_date > DATE_FORMAT(NOW(), '%Y/%m/%d') OR event_date = DATE_FORMAT(NOW(), '%Y/%m/%d') ORDER BY event_date asc";
        $result = OpenConn()->query($getEvents);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $event_name = $row['event_name'];
            $event_th = $row['event_cover'];
            $event_date = $row['event_date'];
            $login_time = date('h:i A', strtotime($row['login_time']));
            $logout_time = $row['logout_time'];
            $course_code = $row['course_code'];
            $cyear = $row['cyear'];
            $event_description = $row['event_description'];
            $respondent = '';

            if($course_code == "0" && $cyear == "0" ){
              $respondent = "To all EVSU Student";
            }elseif($course_code != "0" && $cyear != "0"){
              $respondent = 'To all '.$cyear.' - '.$course_code;
            }
            else{
              $str = 'To all '.$cyear.$course_code.' Studentds';
              $respondent = str_replace("0","",$str);
            }

            ?>
            <div class="pr-5 pr-sm-0 pt-5 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x" style="margin-left:0px;">
              <a class="pos-relative h-100 dplay-block" href="#" style="background-image:url('img/events/<?php echo $event_th; ?>">

                <div class="img-bg bg-4 bg-grad-layer-6"></div>

                <div class="abs-blr color-white p-20 bg-sm-color-7" >
                  <h4 class="mb-10 mb-sm-5"><b>2017 Market Performance: Crypto vs.Stock</b></h4>
                  <ul class="list-li-mr-20">
                    <li>Jan 25, 2018</li>
                    <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
                    <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
                  </ul>
                </div><!--abs-blr -->
              </a><!-- pos-relative -->
            </div><!-- w-1-3 -->

            <div class="pr-5 pr-sm-0 pt-5 float-left float-sm-none pos-relative w-1-3 w-sm-100 h-100 h-sm-300x" style="margin-left:0px;">
              <a class="pos-relative h-100 dplay-block" href="#" style="background-image:url('img/events/<?php echo $event_th; ?>">

                <div class="img-bg bg-4 bg-grad-layer-6"></div>

                <div class="abs-blr color-white p-20 bg-sm-color-7" >
                  <h4 class="mb-10 mb-sm-5"><b>2017 Market Performance: Crypto vs.Stock</b></h4>
                  <ul class="list-li-mr-20">
                    <li>Jan 25, 2018</li>
                    <li><i class="color-primary mr-5 font-12 ion-ios-bolt"></i>30,190</li>
                    <li><i class="color-primary mr-5 font-12 ion-chatbubbles"></i>30</li>
                  </ul>
                </div><!--abs-blr -->
              </a><!-- pos-relative -->
            </div><!-- w-1-3 -->





            <div class="modal fade" id="descmodal<?php echo $id ?>" tabindex="-1" role="dialog" style="overflow-y: hidden !important;">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $event_name; ?></h5>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col-md-12">
                        <img src="img/events/<?php echo $event_th;?>" alt="">
                      </div>
                      <div class="col-md-12">
                        <br>
                        <p><?php echo $event_description; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>




            <?php
          }
        }
        ?>













      </div><!-- h-2-3 -->
    </div><!-- h-100vh -->
  </div><!-- container -->


  <section>
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-12">
          <h4 class="p-title"><b>UPCOMING EVENTS</b></h4>
          <div class="row">



          </div><!-- row -->
        </div><!-- col-md-9 -->

        <div class="d-none d-md-block d-lg-none col-md-3"></div>


      </div><!-- row -->
    </div><!-- container -->
  </section>


  <footer class="bg-191 color-ccc">

    <div class="container">
      <div class="pt-50 pb-20 pos-relative">
        <div class="abs-tblr pt-50 z--1 text-center">
          <div class="h-80 pos-relative"><img class="opacty-1 h-100 w-auto" src="images/map.png" alt=""></div>
        </div>
        <div class="row">

          <div class="col-sm-4">
            <div class="mb-30">
              <a href="#"><img src="images/logo-white.png"></a>
              <p class="mtb-20 color-ccc">Bit coin is an open-source, peer-to-peer, digital decentralized cryptocurrency.
                Powered by blockchain technology, its defining characteristic is</p>
                <p class="color-ash"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ion-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
              </div><!-- mb-30 -->
            </div><!-- col-md-4 -->

            <div class="col-sm-4">
              <div class="mb-30">
                <h5 class="color-primary mb-20"><b>MOST POPULAR</b></h5>
                <div class="mb-20">
                  <a class="color-white" href="#"><b>Its Make or Break Time for Bitcoin</b></a>
                  <h6 class="mt-10">Jan 25, 2018</h6>
                </div>
                <div class="brdr-ash-1 opacty-2 mr-30"></div>
                <div class="mt-20">
                  <a class="color-white" href="#"><b>Bitcoin's roller coster ride is not over</b></a>
                  <h6 class="mt-10">Jan 25, 2018</h6>
                </div>
              </div><!-- mb-30 -->
            </div><!-- col-md-4 -->

            <div class="col-sm-4">
              <div class="mb-30">
                <h5 class="color-primary mb-20"><b>MOST POPULAR</b></h5>
                <div class="mb-20">
                  <a class="color-white" href="#"><b>Its Make or Break Time for Bitcoin</b></a>
                  <h6 class="mt-10">Jan 25, 2018</h6>
                </div>
                <div class="brdr-ash-1 opacty-2 mr-30"></div>
                <div class="mt-20">
                  <a class="color-white" href="#"><b>Bitcoin's roller coster ride is not over</b></a>
                  <h6 class="mt-10">Jan 25, 2018</h6>
                </div>
              </div><!-- mb-30 -->
            </div><!-- col-md-4 -->

          </div><!-- row -->
        </div><!-- ptb-50 -->

        <div class="brdr-ash-1 opacty-2"></div>

        <div class="oflow-hidden color-ash font-9 text-sm-center ptb-sm-5">

          <ul class="float-left float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-10">
            <li><a class="pl-0 pl-sm-10" href="#">Terms & Conditions</a></li>
            <li><a href="#">Privacy policy</a></li>
            <li><a href="#">Jobs advertising</a></li>
            <li><a href="#">Contact us</a></li>
          </ul>
          <ul class="float-right float-sm-none list-a-plr-10 list-a-plr-sm-5 list-a-ptb-15 list-a-ptb-sm-5">
            <li><a class="pl-0 pl-sm-10" href="#"><i class="ion-social-facebook"></i></a></li>
            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
            <li><a href="#"><i class="ion-social-google"></i></a></li>
            <li><a href="#"><i class="ion-social-instagram"></i></a></li>
            <li><a href="#"><i class="ion-social-bitcoin"></i></a></li>
          </ul>

        </div><!-- oflow-hidden -->
      </div><!-- container -->
    </footer>

    <!-- SCIPTS -->

    <script src="vendor/jquery/jquery.min.js"></script>

    <script src="js/tether.min.js"></script>

    <script src="js/bootstrap.js"></script>

    <script src="js/scripts.js"></script>

  </body>
  </html>
