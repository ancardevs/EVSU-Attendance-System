<?php require('model/dbconn.php'); ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>

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

  <script src="vendor/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>


</head>
<body>

  <style media="screen">
  #DivScanner{
    position: absolute;
    left: 0;
    width: 100%;
    padding: 5px;

  }

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

  <div class="DivScanner" id="DivScanner">
    <!-- DataTables Example -->
    <div class="card mb-3" id="scanner">
      <div class="card-header">
        <div class="" style="text-align:center;">
          <h4><span id="alert-msg">Please Scan your QR Code...</span> </h4>
        </div>
        <hr>
        <select class="form-control" id="refid" style=" border-radius:0px; float:right;" name="">
          <?php

          $getEvents = "SELECT
          te.event_no AS teventno,
          te.event_name AS tname,
          te.event_date AS tdate
          FROM
          tbl_events AS te
          WHERE
          te.event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')
          ";

          $result = OpenConn()->query($getEvents);


          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $event_no = $row['teventno'];
              $event_date = $row['tdate'];
              $event_name = $row['tname'];
              ?>
              <option value="<?php echo $event_no;  ?>">
                <?php  echo $event_no ." | ". $event_name  ." | ". $event_date;?>
              </option>
              <?php
            }
          }else{
            echo "HIT";
          }
          ?>
        </select>
      </div>

      <a href="https://github.com/schmich/instascan"></a>
      <div id="app">
        <div class="sidebar-cam">
          <section class="cameras">
            <h2>Cameras</h2>
            <ul>
              <li v-if="cameras.length === 0" class="empty">No cameras found</li>
              <li v-for="camera in cameras">
                <span v-if="camera.id == activeCameraId" :title="formatName(camera.name)" class="active">
                  {{ formatName(camera.name) }}
                </span>
                <span v-if="camera.id != activeCameraId" :title="formatName(camera.name)">
                  <a @click.stop="selectCamera(camera)">{{ formatName(camera.name) }}</a>
                </span>
              </li>
            </ul>
          </section>
          <section class="scans">
            <h2>Scans</h2>

            <div style="overflow-y:scroll;height: calc(65vh - 50px); " id="scans">
              <ul v-if="scans.length === 0">
                <li class="empty">No scans yet</li>
              </ul>
              <form action="model/attendance.php" method="post">
                <transition-group name="scans" tag="ul" id="Ids">
                  <li style="display:block;" v-for="scan in scans" class="Ids" :id="scan.content" :key="scan.date" :title="scan.content">{{ scan.content }}</li>
                </transition-group>
              </form>
            </div>
          </section>
        </div>
        <div class="preview-container" id="preview-container">
          <video id="preview"></video>
        </div>
      </div>
    </div>
  </div>







  <script type="text/javascript" src="js/app.js"></script>

  <script type="text/javascript">



  let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), refractoryPeriod: 6000 });


  scanner.addListener('scan', function (content) {
    console.log(content);


    jQuery.fn.shake = function shake(intShakes, intDistance, intDuration) {
      this.each(function() {
        $(this).css("position","relative");
        for (var x=1; x<=intShakes; x++) {
          $(this).animate({left:(intDistance*-1)}, (((intDuration/intShakes)/4)))
          .animate({left:intDistance}, ((intDuration/intShakes)/2))
          .animate({left:0}, (((intDuration/intShakes)/4)));
        }
      });
      return this;
    };



    if( !$('#refid').val() ){
      $('#alert-msg').html("Empty or No Event Selected !").css('color', '#a87e00');
      $('#alert-msg').show();
      $("#alert-msg").shake(4,7,1000);
      setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);
    }else{

      var data = {
        "attendace" : "attendace",
        "eventno": $("#refid :selected").val(),
        "idnumber": content
      };

      data = $(this).serialize() + "&" + $.param(data);

      $.ajax({
        type: 'POST',
        url: 'model/attendance.php',
        dataType : 'json',
        data: data,
        success: function(data) {





          // If time in is successfull
          if(data == 'timein'){
            $('#alert-msg').html("You have successfully logged in.").css('color', '#0c691b');
            $('#alert-msg').show();
            setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);

          }
          //End




          // If time out is successfull
          else if(data == 'timeout'){
            $('#alert-msg').html("You have successfully logged out.").css('color', '#0c691b');
            $('#alert-msg').show();
            setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);


          }
          //End





          // If attendace is complete
          else if(data == 'exceed'){

            $('#alert-msg').html("You have completed this Events attendace.").css('color', '#a80000');
            $('#alert-msg').show();
            $("#alert-msg").shake(4,7,1000);
            setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);

          }
          //End


          // If not a student
          else if(data == 'notastudent'){

            $('#alert-msg').html("Your ID was not verified as an University Student, Please try again.").css('color', '#a87400');
            $('#alert-msg').show();
            $("#alert-msg").shake(4,7,1000);
            setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);


          }
          //End


          //If not a respondent
          else{
            $('#alert-msg').html("You are not an Event respondent.").css('color', '#a80000');
            $('#alert-msg').show();
            $("#alert-msg").shake(4,7,1000);
            setTimeout(function(){$('#alert-msg').html('Please Scan your QR Code...')},4000);


          }
          //End
        }
      }); //End Ajax call





    } //End If

  });


  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('No cameras found.');
    }
  }).catch(function (e) {
    console.error(e);
  });


  </script>

</body>
</html>
