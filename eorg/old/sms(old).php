<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#sms').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#sendSMS" class="btn btn-primary">Send SMS</button>
        </div>
        <div style="float:right;">
          <h4><span class="fa fa-mobile-alt"></span> SMS</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>

              <tr>
                <th>Sender</th>
                <th>Receiver</th>
                <th>Number</th>
                <th>Message</th>
                <th>Date Sent</th>
                <th>Remarks</th>
                <th>Action</th>
              </tr>
            </thead>

            <div style="text-align:center; z-index:9999; width: 100%;position:fixed; ">
              <div style="display:block; margin:0 auto;  left: -190px; width:400px;" id="submit-alert-sms" class=""></div>
            </div>

            <tbody>
              <?php
                $sessionuserid = $_SESSION['idno'];
                $getSMS = "SELECT DISTINCT
                    tms.id AS id,
                    tms.sender AS sender,
                    ts.first_name AS fname,
                    ts.last_name AS lname,
                    ts.course_code AS ccode,
                    tms.receiver AS receiver,
                    tms.phone AS phone,
                    tms.msg AS msg,
                    tms.datesent AS datesent,
                    tms.remarks AS remarks
                FROM
                    tbl_sms AS tms
                LEFT JOIN tbl_students AS ts
                ON
                    tms.receiver = ts.student_no
                GROUP BY
                    tms.id
                DESC
                ";


              $result = OpenConn()->query($getSMS);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $sender = $row['sender'];
                  $receiver = $row['receiver'];
                  $phone = $row['phone'];
                  $msg = $row['msg'];
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $ccode = $row['ccode'];

                  $datesent = $row['datesent'];
                  $remarks = $row['remarks'];

                  ?>
                  <tr>
                    <td>
                      <?php echo $sender; ?>
                    </td>
                    <td>
                      <a style="text-decoration:none;" href="#" title="<?php echo $fname." ".$lname." - ".$ccode; ?>"><?php echo $receiver; ?></a>
                    </td>
                    <td>
                      <?php echo $phone; ?>
                    </td>
                    <td>
                      <a style="text-decoration:none;" href="#" data-toggle="modal" data-target="#viewmail<?php echo $id;?>" name="viewmsg" id="viewmsg<?php echo $id;?>" >Read SMS</a>
                    </td>
                    <td>
                      <?php echo $datesent; ?>
                    </td>
                    <td>
                      <?php echo $remarks; ?>
                    </td>
                    <td>
                      <input type="hidden" name="" id="smsid<?php echo $id; ?>" value="<?php echo $id; ?>">
                      <!--button type="button" title="Resend" class="btn btn-primary" id="resendsms<?php //echo $id;?>"><span class="fa fa-sync"></span></button-->
                      <button type="button" title="Delete" class="btn btn-danger" id="removesms<?php echo $id;?>"><span class="fa fa-trash"></span></button>
                    </td>
                  </tr>


                  <!---MODAL----->
                  <div id="viewmail<?php echo $id;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>SMS Content</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" >
                            <span style="padding:20px;"><?php echo $msg; ?></span>
                            <hr>
                        </div>


                      </div>
                    </div>
                  </div>


                  <script type="text/javascript">

                    $('#removesms<?php echo $id;?>').on('click',function(){
                      var data = {
                        "smsid" : $('#smsid<?php echo $id; ?>').val(),
                        "deletesms": 'deletesms'
                      }
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/sendsms.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                            if(data == 'removed'){

                                setTimeout(function () {
                                  $("#submit-alert-sms").addClass("alert alert-success");
                                  $('#submit-alert-sms').html("SMS removed successfully!");
                                  $('#submit-alert-sms')
                                  //.hide()
                                  .fadeIn(500)
                                  .delay(2000)
                                  .fadeOut(500);
                                }, 0);

                                setTimeout(function () {
                                  location.href = "sms";
                                }, 2000);
                              }
                          }
                        });
                    });

                  </script>


                  <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer small text-muted">DataTables v1.10.18</div>
    </div>
  </div>







  <!----MODALS---->
  <div id="sendSMS" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>New SMS</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
        </div>
        <div class="modal-body">

          <div class="form-row">
            <b>Note:</b> <br> <i style="color:indianred;">Contact groups are automatically genereted by the system. Disregard &nbsp; when sending to indivual recepient.</i>
          </div>

          <hr>
          <div class="form-row">
              Recepients
              <input name="" type="list" id="grecepients" list="cgroup" value="" class="form-control">

            <datalist class="" id="cgroup">
            <option value="All">All Students</option>

              <?php
              $getCourses = "SELECT
                  tc.id AS tid,
                  ts.course_code AS tcc,
                  tc.course_desc AS tcd

              FROM
                  tbl_students AS ts
              LEFT JOIN tbl_course AS tc
              ON
                  tc.course_code = ts.course_code GROUP BY ts.course_code";
              $result = OpenConn()->query($getCourses);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['tid'];
                  $course_code = $row['tcc'];
                  $course_desc = $row['tcd'];
                  ?>
                  <option value="<?php echo $course_code; ?>"> <?php echo $course_desc; ?> Students</option>
                  <?php
                }
              }
               ?>
               <option value="Scholar Students">All Scholar Students</option>

            </datalist>

          </div>
          <br>



          <div class="form-row">
            Content
            <textarea name="name" rows="8" id="smscontent" class="form-control" cols="80"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="sendsms" id="sendsms"><span class="fa fa-arrow-right"></span> Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>

    </div>
  </div>
  <!--MODALS-->
</div>







  <script>




  $("#sendsms").click(function () {


      if ($('#smscontent').val() == "" || $('#grecepients').val() == "") {
          setTimeout(function () {
            $("#submit-alert").removeClass("alert alert-success");
            $("#submit-alert").addClass("alert alert-warning");
            $('#submit-alert').html("No receiver or SMS content is empty!");
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(2000)
            .fadeOut(500);
          }, 0);

      }else if (  $.isNumeric($('#grecepients').val()) &&  $('#grecepients').val().length != 11) {
        setTimeout(function () {
          $("#submit-alert").removeClass("alert alert-success");
          $("#submit-alert").addClass("alert alert-warning");
          $('#submit-alert').html("Invalid Phone Number!");
          $('#submit-alert')
          //.hide()
          .fadeIn(500)
          .delay(2000)
          .fadeOut(500);
        }, 0);

      }else{
        $('#sendsms').prop('disabled', true);
        $("#sendsms").html('<span class="fa fa-arrow-right"></span> Sending SMS...');

        var data = {
          "smscontent" : $('#smscontent').val(),
          "grecepients" : $('#grecepients').val(),
          "sendsmsnotif": 'sendsmsnotif'
        }
        data = $(this).serialize() + "&" + $.param(data);

        $.ajax({
          type: 'POST',
          url: 'model/sendsms.php',
          dataType : 'json',
          data: data,
          success: function (data) {
              if(data == 'sent'){
                $('#sendsms').prop('disabled', false);
                $("#sendsms").html('<span class="fa fa-arrow-right"></span> Send');

                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-warning");
                  $("#submit-alert").addClass("alert alert-success");
                  $('#submit-alert').html("SMS sent successfully!");
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);

                setTimeout(function () {
                  location.href = "sms";
                }, 2000);
              }else if(data == 'empty'){
                $('#sendsms').prop('disabled', false);
                $("#sendsms").html('<span class="fa fa-arrow-right"></span> Send');
                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-success");
                  $("#submit-alert").addClass("alert alert-warning");
                  $('#submit-alert').html("No recepient was found !");
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);

              }else{
                $('#sendsms').prop('disabled', false);
                $("#sendsms").html('<span class="fa fa-arrow-right"></span> Send');
                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-success");
                  $("#submit-alert").addClass("alert alert-warning");
                  $('#submit-alert').html("SMS failed  to deliver!");
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









  </script>



  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
