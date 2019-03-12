<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();

?>

<script src="vendor/jquery/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $('#logs').addClass('nav-item active')
});
</script>


<iframe src="http://localhost:8012/evsu/evsu-attendance/attendance-logs.php" style="width:100%; height:auto; border:0px;">

</iframe>






  <!-- /.container-fluid -->
