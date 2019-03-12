<?php require('layout/header.php');

date_default_timezone_set('Asia/Manila');


?>
<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

<script>
$(document).ready(function() {
  $('#attendance').addClass('nav-item active')
});
</script>

<div id="content-wrapper">
  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3" id="scanner">
      <div class="card-header">

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

            <div style="overflow-y:scroll; height:350px; " id="scans">
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

      <div class="card-footer small text-muted">
        <button type="button" title="Expand" id="expand" class="btn btn-primary" style="border-radius:0px;" name="button"><span class="fa fa-expand"></span> </button>
        <a href="attendance" title="Shrink" id="shrink" class="btn btn-warning" style="border-radius:0px;" name="button"><span class="fa fa-compress"></span> </a>


        <script type="text/javascript">

        $('#expand').click(function() {
          $('#scanner').css({
            position:'absolute', //or fixed depending on needs
            top: $(window).scrollTop(), // top pos based on scoll pos
            left: 0,
            height: '100%',
            width: '100%'
          });

          $('#preview').css({
            top: $(window).scrollTop(), // top pos based on scoll pos
            left: 0,
            height: '100%',
            width: '100%'
          });


          $('#preview-container').css({
            top: $(window).scrollTop(), // top pos based on scoll pos
            left: 0,
            height: '100%',
            width: '100%'
          });

          $('#scans').css({
            top: $(window).scrollTop(), // top pos based on scoll pos
            left: 0,
            height: '530px',
            width: '100%'
          });


        });

        </script>
      </div>
    </div>
  </div>
</div>


<!--MODAL ALERT-->
<div class="modal fade" id="success-alert" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-body" style="text-align:center;">
        <h3 id="submit-alert"></h3>
      </div>
    </div>
  </div>
</div>






<script type="text/javascript" src="js/app.js"></script>

<script type="text/javascript">



let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), refractoryPeriod: 2000 });


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
    $('#submit-alert').html("Empty or No Event Selected !").css('color', '#a80000');
    $('#success-alert').modal('show');
    $("#submit-alert").shake(4,7,1000);
    setTimeout(function(){$('#success-alert').modal('hide')},3000);
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
          $('#submit-alert').html("You have successfully logged in.").css('color', '#155b24');
          $('#success-alert').modal('show');
          setTimeout(function(){$('#success-alert').modal('hide')},3000);
        }
        //End




        // If time out is successfull
        else if(data == 'timeout'){
          $('#submit-alert').html("You have successfully logged out.").css('color', '#155b24');
          $('#success-alert').modal('show');
          setTimeout(function(){$('#success-alert').modal('hide')},3000);
        }
        //End





        // If attendace is complete
        else if(data == 'exceed'){
          $('#submit-alert').html("You have completed this Events attendace.").css('color', '#aa670e');
          $('#success-alert').modal('show');
          setTimeout(function(){$('#success-alert').modal('hide')},3000);
        }
        //End


        // If not a student
        else if(data == 'notastudent'){
          $('#submit-alert').html("Your ID was not verified as an University Student. Please try again.").css('color', '#991515');
          $('#success-alert').modal('show');
          $("#submit-alert").shake(4,7,1000);
          setTimeout(function(){$('#success-alert').modal('hide')},8000);
        }
        //End


        //If not a respondent
        else{
          $("#submit-alert").removeClass("alert alert-success");
          $("#submit-alert").addClass("alert alert-warning");
          $('#submit-alert').html("You are not an Event respondent.").css('color', '#991515');
          $('#success-alert').modal('show');
          $("#submit-alert").shake(4,7,1000);
          setTimeout(function(){$('#success-alert').modal('hide')},3000);
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




<?php require('layout/footer.php');?>
