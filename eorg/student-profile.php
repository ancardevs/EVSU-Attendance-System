  <?php
  require('layout/user-header.php');
  ?>


  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item" id="dashboard">
        <div class="" style="text-align:center;">
          <a href="#"><img src="img/profiles/<?php echo $img; ?>" style="border-radius: 50%;width:100%;height:auto; padding:10px;" /></a>
          <h4 style="color:white;"><?php echo $studname; ?></h4>
        </div>
      </li>
    </ul>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/custom.js"></script>

    <script>
    $(document).ready(function(){
      $('#events').addClass('nav-item active')
    });
  </script>

  <div id="content-wrapper">

    <div class="container-fluid">
      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <div style="float:left;">
            <h4>Events Attended</h4>
          </div>
          <div style="float:right;">
            <h4><span class="fa fa-calendar"></span> Events</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Event No.</th>
                  <th>Date</th>
                  <th>Login</th>
                  <th>Logout</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $getlogged = "SELECT
                    te.event_no AS eno,
                    te.event_name AS ten,
                    DATE_FORMAT(te.event_date, '%Y/%m/%d') AS edate,
                    ta.ontime_in AS tin,
                    ta.ontime_out AS tout,
                    ts.student_no AS tss,
                    ts.cyear AS ayear,
                    ts.course_code AS scourse,
                    ts.first_name AS tsf,
                    ts.last_name AS tsl
                FROM
                    tbl_students AS ts
                INNER JOIN tbl_attendance AS ta
                ON
                    ts.student_no = ta.student_no
                INNER JOIN tbl_events AS te
                ON
                    ta.event_no = te.event_no

                WHERE ta.student_no = '$studid'
                ORDER BY
                    NOW()
                DESC
                ";

                $result = OpenConn()->query($getlogged);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $eventno = $row['eno'];
                    $eventname = $row['ten'];
                    $eventdate = $row['edate'];


                    $timein = date('h:i A', strtotime($row['tin']));
                    $timeout = date('h:i A', strtotime($row['tout']));
                    $student_no = $row['tss'];
                    $first_name = $row['tsf'];
                    $last_name = $row['tsl'];
                    $acadyear = $row['ayear'];
                    $course = $row['scourse'];

                    $fullname = $first_name.' '.$last_name;
                    ?>
                    <tr>
                      <td><span style="cursor:pointer; color:blue;" title="<?php echo $eventname; ?>"><?php echo $eventno; ?></span></td>
                      <td><?php echo $eventdate; ?></td>
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
        <div class="card-footer small text-muted"><button type="button" onclick="PrintData()" class="btn btn-success"><span class="fa fa-print"></span> Print</button></div>
        <script type="text/javascript">
          function  PrintData(){

            $("#printdiv").css("display", "block");
            var divToPrint=document.getElementById("printdiv");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
            $("#printdiv").css("display", "none");
          }
        </script>
      </div>
    </div>
  </div>

</div>

<div class="" id="printdiv" style="display:none;">
  <h2><?php echo $studname; ?></h2>
  <span>Year: <b><?php echo $cyear;?></b></span><br>
  <span>Course: <b><?php echo $course_code;?></b></span><br>
  <span>Section: <b><?php echo $section;?></b></span><br>


  <br>
  <br>
  <table class="table table-bordered" id="" width="100%" cellspacing="0" style="table-layout: fixed; width: 100%;  text-align:center;" border='1' cellpadding='1'>
    <thead>
      <tr>
        <th>Event No.</th>
        <th>Event Name.</th>
        <th>Date</th>
        <th>Start</th>
        <th>End</th>
        <th>Login</th>
        <th>Logout</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $getlogged = "SELECT
          te.event_no AS eno,
          te.event_name AS ten,
          te.login_time as litime,
          te.logout_time as lotime,
          DATE_FORMAT(te.event_date, '%Y/%m/%d') AS edate,
          ta.ontime_in AS tin,
          ta.ontime_out AS tout,
          ts.student_no AS tss,
          ts.cyear AS ayear,
          ts.course_code AS scourse,
          ts.first_name AS tsf,
          ts.last_name AS tsl
      FROM
          tbl_students AS ts
      INNER JOIN tbl_attendance AS ta
      ON
          ts.student_no = ta.student_no
      INNER JOIN tbl_events AS te
      ON
          ta.event_no = te.event_no

      WHERE ta.student_no = '$studid'
      ORDER BY
          NOW()
      DESC
      ";

      $result = OpenConn()->query($getlogged);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $eventno = $row['eno'];
          $eventname = $row['ten'];
          $eventdate = $row['edate'];

          $logintime =  date('h:i A', strtotime($row['litime']));
          $logouttime = date('h:i A', strtotime($row['lotime']));


          $timein = date('h:i A', strtotime($row['tin']));
          $timeout = date('h:i A', strtotime($row['tout']));
          $student_no = $row['tss'];
          $first_name = $row['tsf'];
          $last_name = $row['tsl'];
          $acadyear = $row['ayear'];
          $course = $row['scourse'];

          $fullname = $first_name.' '.$last_name;
          ?>
          <tr>
            <td style="width: 15% ;"><?php echo $eventno; ?></td>
            <td style="width: 15% ;"><?php echo $eventname; ?></td>
            <td style="width: 15% ;"><?php echo $eventdate; ?></td>
            <td style="width: 12% ;"><?php echo $logintime; ?></td>
            <td style="width: 12% ;"><?php echo $logouttime; ?></td>
            <td style="width: 12% ;"><?php echo $timein; ?></td>
            <td style="width: 12% ;"><?php echo $timeout; ?></td>
          </tr>

          <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>

</div>

<?php require('layout/user-footer.php'); ?>
