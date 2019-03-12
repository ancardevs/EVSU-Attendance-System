<?php   require('model/dbconn.php'); ?>

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
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <script src="js/demo/datatables-demo.js"></script>

  </head>
  <body>
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

  </body>
</html>
