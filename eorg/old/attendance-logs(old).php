<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();

?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#logs').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <h4>Recently Logged Students</h4>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-clock"></span> Logs</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Event No.</th>
                <th>Date</th>
                <th>ID No.</th>
                <th>Login</th>
                <th>Logout</th>
              </tr>
            </thead>
            <tbody>
              <?php
              date_default_timezone_set('Asia/Manila');
              $getlogged = "SELECT
              	te.event_no as eno,
                  te.event_name as ten,
                  DATE_FORMAT(te.event_date, '%Y/%m/%d') as edate,
                  ta.ontime_in as tin,
                  ta.ontime_out as tout,
                  ts.student_no AS tss,
                  ts.cyear as ayear,
                  ts.course_code as scourse,
                  ts.first_name AS tsf,
                  ts.last_name AS tsl
              FROM
                  tbl_students AS ts
              INNER JOIN tbl_attendance AS ta
              ON
                  ts.student_no = ta.student_no
              INNER JOIN tbl_events as te
              ON ta.event_no = te.event_no
              ORDER BY NOW() desc
              ";

              $result = OpenConn()->query($getlogged);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $eventno = $row['eno'];
                  $eventname = $row['ten'];
                  $eventdate = $row['edate'];

                  $tishit = $row['tin'];
                  $toshit = $row['tout'];

                  $timein = date('h:i A', strtotime($tishit));

                  //$timeout = $row['tout'];
                  $student_no = $row['tss'];
                  $first_name = $row['tsf'];
                  $last_name = $row['tsl'];
                  $acadyear = $row['ayear'];
                  $course = $row['scourse'];

                  $fullname = $first_name.' '.$last_name;

                  if ($toshit == "") {
                    $timeout = "00:00:00";
                  }else{
                    $timeout = date('h:i A', strtotime($toshit));
                  }


                  ?>
                  <tr>
                    <td><span style="cursor:pointer; color:blue;" title="<?php echo $eventname; ?>"><?php echo $eventno; ?></span></td>
                    <td><?php echo $eventdate; ?></td>
                    <td><span style="cursor:pointer; color:blue;" title="<?php echo $fullname.' | '.$acadyear.' | '.$course; ?>"><?php echo $student_no; ?></span></td>
                    <td><?php echo $timein; ?></td>
                    <td><?php echo $timeout; ?></td>

                  </tr>

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




  <script type="text/javascript">
  //Addning student


  </script>
  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
