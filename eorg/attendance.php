<?php
  require('layout/header.php');
  date_default_timezone_set('Asia/Manila');
?>


<script src="vendor/jquery/jquery.min.js"></script>

<script>
$(document).ready(function() {
  $('#attendance').addClass('nav-item active')
});

$(window).on('load',function(){
    $('#ScannerModal').modal('show');
});
</script>

<style media="screen">
  img{
    -webkit-transition: -webkit-transform .8s ease-in-out;
    transition: transform .8s ease-in-out;
  }
  img:hover{
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }

</style>
<div class="" style="text-align:center;margin:0 auto; ">
  <div class="container" style="margin-top:60%;">
      <img data-toggle="modal" style="cursor:pointer;" data-target="#ScannerModal" src="img/sp-scan.png" alt="" width="200px">
  </div>
  <br>
  <span><b style="color:#9e2b2b;display:block;">Click to Start QR Code Scanner</b> </span>
</div>
<div class="modal fade" id="ScannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="body" style="min-height:100%;">
        <iframe src="http://localhost:8012/evsu/evsu-attendance/attendance.php" style="width:100%; height:660px; border:0px;">
          Apache and MySQL is not running.
        </iframe>
        <div class="footer" style="padding:5px; float:right; margin-top:-10px;">
          <a href="http://localhost/evsu/evsu-attendance/attendance.php" target="_blank" class="btn btn-primary">Open in New Tab</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal" name="button">Close</button>
        </div>
      </div>
  </div>

</div>




<?php require('layout/footer.php');?>
