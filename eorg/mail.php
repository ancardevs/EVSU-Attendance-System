<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#mails').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#sendMail" class="btn btn-primary">Send Mail</button>
        </div>
        <div style="float:right;">
          <h4><span class="fa fa-envelope"></span> Mails</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Sender</th>
                <th>Receivers Name</th>
                <th>Email</th>
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
                $getEvents = "SELECT tm.id as id,
                  tm.sender AS sender,


                  ts.student_no as stid,
                  ts.first_name AS fname,
                  ts.last_name AS lname,


                  ts.course_code AS ccode,
                  tm.receiver AS receiver,
                  tm.email AS email,
                  tm.msg AS msg,
                  tm.datesent AS datesent,
                  tm.remarks AS remarks
                FROM tbl_mails as tm

                LEFT JOIN tbl_students as ts
                ON tm.email = ts.email

              
                ORDER BY tm.id DESC
                ";



              $result = OpenConn()->query($getEvents);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $sender = $row['sender'];
                  $receiver = $row['receiver'];
                  $email = $row['email'];
                  $msg = $row['msg'];
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $ccode = $row['ccode'];
                  $studentid = $row['stid'];
                  $datesent = $row['datesent'];
                  $remarks = $row['remarks'];

                  $accid = "";

                  if ($row['fname'] == "") {
                    $studentid = "<span style='color:red;'>Unknown</span>";
                  }else{
                    $accid = $row['fname'].' '.$row['lname'];
                  }


                  ?>
                  <tr>
                    <td>
                      <?php echo $sender; ?>
                    </td>
                    <td>
                      <a style="text-decoration:none;" href="#" title="<?php echo $accid." - ".$ccode; ?>"><?php echo $studentid; ?></a>
                    </td>
                    <td>
                      <?php echo $email; ?>
                    </td>
                    <td>
                      <a style="text-decoration:none;" href="#" data-toggle="modal" data-target="#viewmail<?php echo $id;?>" name="viewmsg" id="viewmsg<?php echo $id;?>" >Read Mail</a>
                    </td>
                    <td>
                      <?php echo $datesent; ?>
                    </td>
                    <td>
                      <?php echo $remarks; ?>
                    </td>
                    <td>
                      <input type="hidden" name="" id="mailid<?php echo $id; ?>" value="<?php echo $id; ?>">
                      <!--button type="button" title="Resend" class="btn btn-primary" id="resendmail<?php //echo $id;?>"><span class="fa fa-sync"></span></button-->
                      <button type="button" title="Delete" class="btn btn-danger" id="removemail<?php echo $id;?>"><span class="fa fa-trash"></span></button>
                    </td>
                  </tr>


                  <!---MODAL----->
                  <div id="viewmail<?php echo $id;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>Mail Content</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" >
                            <span style="padding:20px;"><?php echo $msg; ?></span>
                        </div>
                        <div class="modal-footer">

                        </div>



                      </div>
                    </div>
                  </div>


                  <script type="text/javascript">

                    $('#removemail<?php echo $id;?>').on('click',function(){
                      var data = {
                        "mailid" : $('#mailid<?php echo $id; ?>').val(),
                        "deletemail": 'deletemail'
                      }
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/sendmail.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                            if(data == 'removed'){

                                setTimeout(function () {
                                  $("#submit-alert-sms").addClass("alert alert-success");
                                  $('#submit-alert-sms').html("Email removed successfully!");
                                  $('#submit-alert-sms')
                                  //.hide()
                                  .fadeIn(500)
                                  .delay(2000)
                                  .fadeOut(500);
                                }, 0);

                                setTimeout(function () {
                                  location.href = "mails";
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
  <div id="sendMail" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>New Mail</h4>
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
              <input name="" id="grecepients" list="cgroup" value="" class="form-control">

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
            <textarea name="name" rows="8" id="mailcontent" class="form-control" cols="80"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="sendemail" id="sendemail"><span class="fa fa-paper-plane"></span> Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>

    </div>
  </div>
  <!--MODALS-->
</div>







  <script>


  $("#sendemail").click(function () {

    var isOnline = window.navigator.onLine;


    if (isOnline) {

      if ($('#mailcontent').val() == "" || $('#grecepients').val() == "") {
          setTimeout(function () {
            $("#submit-alert").removeClass("alert alert-success");
            $("#submit-alert").addClass("alert alert-warning");
            $('#submit-alert').html("No receiver or Mail content is empty!");
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(2000)
            .fadeOut(500);
          }, 0);

      }else{
        $('#sendemail').prop('disabled', true);
        $("#sendemail").html('<span class="fa fa-paper-plane"></span> Sending email...');

        var data = {
          "mailcontent" : $('#mailcontent').val(),
          "grecepients" : $('#grecepients').val(),

          "sendmailnotif": 'sendmailnotif'
        }
        data = $(this).serialize() + "&" + $.param(data);

        $.ajax({
          type: 'POST',
          url: 'model/sendmail.php',
          dataType : 'json',
          data: data,
          success: function (data) {
              if(data == 'sent'){
                $('#sendemail').prop('disabled', false);
                $("#sendemail").html('<span class="fa fa-paper-plane"></span> Send');

                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-warning");
                  $("#submit-alert").addClass("alert alert-success");
                  $('#submit-alert').html("Mail sent successfully!");
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);

                setTimeout(function () {
                  location.href = "mails";
                }, 2000);
              }else if (data == "empty") {
                $('#sendemail').prop('disabled', false);
                $("#sendemail").html('<span class="fa fa-paper-plane"></span> Send');
                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-success");
                  $("#submit-alert").addClass("alert alert-warning");
                  $('#submit-alert').html("No recepient was found!");
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);
              }else{
                setTimeout(function () {
                  $('#sendemail').prop('disabled', false);
                  $("#sendemail").html('<span class="fa fa-paper-plane"></span> Send');

                  $("#submit-alert").removeClass("alert alert-success");
                  $("#submit-alert").addClass("alert alert-warning");
                  $('#submit-alert').html("Mail failed  to deliver!");
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







    } else {


      setTimeout(function () {
        $("#submit-alert").removeClass("alert alert-success");
        $("#submit-alert").addClass("alert alert-warning");
        $('#submit-alert').html("Please check your Internet Connection!");
        $('#submit-alert')
        //.hide()
        .fadeIn(500)
        .delay(2000)
        .fadeOut(500);
      }, 0);




    }











  });









  </script>



  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
