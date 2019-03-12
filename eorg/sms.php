<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();

$sessionuserid = $_SESSION['idno'];
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#sms').addClass('nav-item active')
});
</script>


    <!-- DataTables Example -->



<iframe style="width:100%; padding:5px; height:calc(100vh - 50px); border:0px;" src="http://localhost:8012/evsu/evsu-attendance/sms.php?idno=<?php echo $sessionuserid; ?>"></iframe>'



  <!-- /.container-fluid -->
<?php require('layout/footer.php'); ?>
