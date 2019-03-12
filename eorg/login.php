<?php
session_start();

if (isset($_SESSION['user']) && isset($_SESSION['role']) ) {
  header('location: dashboard');
}else{

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
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>

    <title>EOrg - Security Checkpoint</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>


  </head>

  <style media="screen">
  body {
  position: absolute;
  top: 0; bottom: 0; left: 0; right: 0;
  height: 100%;
  }
  body:before {
    content: "";
    position: absolute;
    background: url(img/evsu.jpg);
    background-size: cover;
    z-index: -1; /* Keep the background behind the content */
    height: 20%; width: 20%; /* Using Glen Maddern's trick /via @mente */

    /* don't forget to use the prefixes you need */
    transform: scale(5);
    transform-origin: top left;
    -webkit-filter: blur(5px);
    filter: blur(2px);
  }
  </style>


  <body class="bg-dark">
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header" style="text-align:center;">
          <img src="img/evsu_logo.png" width="200px;" class="img-responsive" alt="">
          <br><br>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%;border-radius:0px; position:absolute;; text-align:center; top:15%; ">
          <div style="display:none; margin:0px auto; width:300px; border-radius:0px;" id="submit-alert" class=""></div>
        </div>
        <div class="card-body">
          <form>
            <div class="form-group">
                <input type="text" id="user" class="form-control" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input type="password" id="pass" class="form-control" placeholder="Password" required="required">
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>
            <button type="button" id="login" class="btn btn-primary btn-block">Login</button>
          </form>
          <div class="text-center">
            <br>
            <!--a class="d-block small mt-3" href="register.html">Register an Account</a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a-->
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <script type="text/javascript">




    $(document).ready(function(){

      $('#login').on('click',function(){


        if ($('#user').val() == "" || $('#pass').val() == "") {

          $("#submit-alert").removeClass("alert alert-success");
          $("#submit-alert").addClass("alert alert-warning");
          $('#submit-alert').html("Empty Username or Password.");
          setTimeout(function () {
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(2000)
            .fadeOut(500);
          }, 0);

        }else{
          var data = {
            "user" : $('#user').val(),
            "pass" : $('#pass').val(),
            "login": 'login'
          }
          data = $(this).serialize() + "&" + $.param(data);

          $.ajax({
            type: 'POST',
            url: 'model/auth.php',
            dataType : 'json',
            data: data,
            success: function (data) {
              if (data == "Student") {
                location.href = "student-profile";
              }else if(data == "Administrator" || data == "Teacher" || data == "Organizer"){
                location.href = "dashboard";
              }
              else{

                $("#submit-alert").removeClass("alert alert-success");
                $("#submit-alert").addClass("alert alert-warning");
                $('#submit-alert').html("Incorrect Username or Password!");
                setTimeout(function () {
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);

              }
            }
          });
        }
      });

    });



    </script>

  </body>

</html>
