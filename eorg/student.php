<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();
$currentsession = $_SESSION['idno'];
?>


<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#students').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#addStudent" class="btn btn-primary">Add Student</button>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-child"></span> Students</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" border='1' cellpadding='1'>
            <thead>
              <tr>
                <th>ID No.</th>
                <th>Name</th>
                <th>Academic Year</th>
                <th>Course</th>
                <th>Section</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($_SESSION['role'] == "Administrator"){
                $getStudents = "SELECT DISTINCT
                ts.id AS tsid,
                ts.student_no AS tss,
                ts.first_name AS tsf,
                ts.middle_name AS tsm,
                ts.last_name AS tsl,
                ts.cyear AS tsa,
                tc.course_code AS tscode,
                tc.course_desc as tsdesc,
                ts.section AS tsec,
                ts.caddress AS tscad,
                ts.birthday AS tsb,
                ts.phone AS tsp,
                ts.email AS tsem,
                ts.college AS tscol,
                ts.department AS tdept,
                ts.scholarship AS tschol

                FROM
                tbl_students AS ts

                LEFT JOIN tbl_course as tc
                ON ts.course_code = tc.course_code";

              }else{
                $sessionuserid = $_SESSION['idno'];
                $getStudents = "SELECT DISTINCT
                ts.id AS tsid,
                ts.student_no AS tss,
                ts.first_name AS tsf,
                ts.middle_name AS tsm,
                ts.last_name AS tsl,
                ts.cyear AS tsa,

                ts.college AS tscol,
                ts.department AS tdept,
                ts.scholarship AS tschol,


                ts.course_code AS tscode,
                tc.course_desc AS tsdesc,
                ts.section AS tsec,
                ts.caddress AS tscad,
                ts.birthday AS tsb,
                ts.phone AS tsp,
                ts.email AS tsem
                FROM
                tbl_students AS ts


                INNER JOIN tbl_advisory AS tcs1
                ON tcs1.course_code = ts.course_code

                INNER JOIN tbl_advisory as tcs2
                ON tcs2.section = ts.section


                INNER JOIN tbl_course AS tc
                ON ts.course_code = tc.course_code


                WHERE
                tcs1.teacher_no =  '$sessionuserid'";
              }

              $resultstudent = OpenConn()->query($getStudents);

              if ($resultstudent->num_rows > 0) {
                while ($row = $resultstudent->fetch_assoc()) {
                  $id = $row['tsid'];
                  $student_no = $row['tss'];
                  $first_name = $row['tsf'];
                  $middle_name = $row['tsm'];
                  $last_name = $row['tsl'];

                  $cyear = $row['tsa'];

                  $college = $row['tscol'];
                  $department = $row['tdept'];
                  $scholarship = $row['tschol'];


                  $course_code = $row['tscode'];
                  $course_desc = $row['tsdesc'];

                  $section = $row['tsec'];

                  $caddress = $row['tscad'];
                  $birthday = $row['tsb'];
                  $phone = $row['tsp'];
                  $email = $row['tsem'];
                  $coninfo =$email." | ".$phone;

                  $fullname = $first_name.' '.$last_name;
                  ?>
                  <tr>
                    <td><?php echo $student_no; ?></td>
                    <td><a href="#" title="<?php echo $coninfo; ?>" style="text-decoration:none;"><?php echo $fullname; ?></a> </td>
                    <td><?php echo $cyear; ?></td>
                    <td><a href="#" style="text-decoration:none;" title="<?php echo $course_desc; ?>"><?php echo $course_code; ?></a> </td>
                    <td><?php echo $section; ?></td>
                    <td>
                      <button type="button" data-toggle="modal" data-target="#updatestudentmodal<?php echo $id; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
                    </td>
                  </tr>

                  <div id="updatestudentmodal<?php echo $id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>Student Information</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
                          <div style="display:none; margin:0px auto; width:450px;" id="submit-alert<?php echo $id; ?>" class=""></div>
                        </div>

                        <div class="modal-body">
                          <form action="model/student.php" method="post">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                Student ID No.
                                <input type="text" required id="idnumber<?php echo $id;?>" name="idnumber" value="<?php echo $student_no;?>" class="form-control">
                              </div>
                              <div class="form-group col-md-6">
                                College
                                <input type="list" list="CollegeList" value="<?php echo $college; ?>" name="college" id="college<?php echo $id;?>" value="" class="form-control">
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-4">
                                First Name
                                <input type="text" name="firstname" class="form-control" value="<?php echo $first_name; ?>" id="firstname<?php echo $id;?>" required>
                              </div>
                              <div class="form-group col-md-4">
                                Middle Name
                                <input type="text" name="middlename" value="<?php echo $middle_name; ?>" class="form-control" id="middlename<?php echo $id;?>" required>
                              </div>
                              <div class="form-group col-md-4">
                                Last Name
                                <input type="text" name="lastname" value="<?php echo $last_name; ?>" class="form-control" id="lastname<?php echo $id;?>" required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="col-md-4">
                                Year
                                <select name="cyear" id="cyear<?php echo $id;?>" class="form-control">
                                  <option value="<?php echo $cyear; ?>"><?php echo $cyear; ?></option>
                                  <option value="">-</option>

                                  <?php
                                  if ($_SESSION['role'] == "Administrator") {
                                    ?>
                                    <option value="<?php echo "First Year"; ?>"><?php echo "First Year"; ?></option>
                                    <option value="<?php echo "Second Year"; ?>"><?php echo "Second Year"; ?></option>
                                    <option value="<?php echo "Third Year"; ?>"><?php echo "Third Year"; ?></option>
                                    <option value="<?php echo "Fourth Year"; ?>"><?php echo "Fourth Year"; ?></option>
                                    <option value="<?php echo "Fifth Year"; ?>"><?php echo "Fifth Year"; ?></option>
                                    <?php

                                  }else{
                                    $getOwnYear = " SELECT DISTINCT course_year FROM tbl_advisory WHERE teacher_no = '$currentsession' ";
                                    $resultown = OpenConn()->query($getOwnYear);
                                    if ($resultown->num_rows > 0) {
                                      while ($row = $resultown->fetch_assoc()) {
                                        $course_year = $row['course_year'];
                                        ?>
                                        <option value="<?php echo $course_year; ?>"><?php echo $course_year; ?></option>
                                        <?php
                                      }
                                    }
                                  }
                                  ?>
                                </select>
                                <!--input type="list" list="YearList" name="cyear" id="cyear<?php echo $id;?>" value="<?php echo $cyear ?>" class="form-control"-->

                              </div>
                              <div class="form-group col-md-4">
                                Course
                                <!--input type="list" list="CourseList" name="course" id="course<?php //echo $id;?>" value="<?php //echo $course_code ?>" class="form-control"-->
                                <?php
                                if ($_SESSION['role'] == "Administrator") {
                                  ?>
                                  <input type="list" list="CourseList1" name="course" id="course<?php echo $id;?>" value="<?php echo $course_code; ?>" class="form-control">
                                  <datalist class="" id="CourseList1">
                                    <?php
                                    $getOwnCourse = "SELECT DISTINCT tcs.course_code AS tc,tcs.course_desc AS tdes FROM tbl_course as tcs";
                                    $resultcourse = OpenConn()->query($getOwnCourse);

                                    if ($resultcourse->num_rows > 0) {
                                      while ($row = $resultcourse->fetch_assoc()) {
                                        $course_code = $row['tc'];
                                        $course_desc = $row['tdes'];
                                        ?>
                                        <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                                        <?php
                                      }
                                    }
                                    ?>
                                  </datalist>
                                  <?php
                                }else{
                                  ?>
                                  <select name="course" id="course<?php echo $id;?>" class="form-control">
                                    <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                                    <option value="">-</option>
                                    <?php
                                    $getOwnCourse = "SELECT DISTINCT
                                        ta.course_code AS tcd,
                                        course_desc AS tdsc
                                    FROM
                                        tbl_advisory AS ta
                                    INNER JOIN tbl_course AS tc
                                    ON
                                        ta.course_code = tc.course_code
                                    WHERE
                                        ta.teacher_no = '$currentsession'";
                                    $resultcourse = OpenConn()->query($getOwnCourse);
                                    if ($resultcourse->num_rows > 0) {
                                      while ($row = $resultcourse->fetch_assoc()) {
                                        $course_code = $row['tcd'];
                                        $course_desc = $row['tdsc'];
                                        ?>
                                        <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                                        <?php
                                      }
                                    }
                                    ?>
                                  </select>
                                  <?php
                                }
                                ?>
                              </div>

                              <div class="form-group col-md-4">
                                Section
                                <!--input type="text" name="section" class="form-control" id="section<?php //echo $id;?>" value="<?php //echo $section ?>" required-->
                                <!--select name="section" class="form-control" id="section" required-->
                                  <?php
                                  if ($_SESSION['role'] == "Administrator")
                                  {
                                  ?>
                                  <input type="text" name="section" id="section<?php echo $id;?>" value="<?php echo $section ?>" class="form-control" id="section" required>
                                  <?php
                                  }
                                  else if($_SESSION['role'] == "Teacher")
                                  {
                                  ?>
                                  <select name="section" class="form-control" id="section<?php echo $id;?>" required>
                                    <option value="<?php echo $section ?>"><?php echo $section ?></option>
                                    <option value="">-</option>
                                  <?php
                                  $getOwnSection = " SELECT DISTINCT section FROM tbl_advisory WHERE teacher_no = '$currentsession' ";
                                  $resultsection = OpenConn()->query($getOwnSection);
                                  if ($resultsection->num_rows > 0) {
                                    while ($row = $resultsection->fetch_assoc()) {
                                      $section = $row['section'];
                                      ?>
                                      <option value="<?php echo $section; ?>"><?php echo $section; ?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                  </select>
                                  <?php
                                }
                                  ?>
                                <!--/select-->
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                Department
                                <input type="list" list="DepartmentList" value="<?php echo $department; ?>" required id="department<?php echo $id;?>" name="department" class="form-control">
                              </div>
                              <div class="form-group col-md-3">
                                Birthdate
                                <input type="date" name="bdate" value="<?php echo $birthday; ?>" class="form-control" id="bdate<?php echo $id;?>" required>
                              </div>
                              <div class="form-group col-md-3">
                                Contact
                                <input type="text" name="contact" class="form-control" value="<?php echo $phone; ?>" id="contact<?php echo $id;?>" required>
                              </div>
                            </div>




                            <div class="form-row">
                              <div class="form-group col-md-6">
                                Email
                                <input type="text" name="emailadd" value="<?php echo $email; ?>" class="form-control" id="emailadd<?php echo $id;?>" required>
                              </div>
                              <div class="form-group col-md-6">
                                Scholarship
                                <input type="list" list="ScholarshipList" value="<?php echo $scholarship; ?>" class="form-control" id="scholarship<?php echo $id;?>" required>
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-12">
                                Address
                                <input type="text" name="address" value="<?php echo $caddress; ?>" class="form-control" id="address<?php echo $id;?>" required>
                              </div>
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" name="refid" id="refid<?php echo $id; ?>" value="<?php echo $student_no; ?>">
                          <button type="button" class="btn btn-success" name="updatestudent" id="updatestudent<?php echo $id;?>"><span class="fa fa-sync"></span> </button>
                          <button type="button" class="btn btn-danger" name="deletestudent" id="deletestudent<?php echo $id;?>"><span class="fa fa-trash"></span> </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script type="text/javascript">

                  //Remove student
                  $('#deletestudent<?php echo $id;?>').on('click', function(){
                    var data = {
                      "refid" : $('#refid<?php echo $id; ?>').val(),

                      "deletestudent" : "deletestudent"
                    };
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/student.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        if (data=="deleted") {
                          setTimeout(function () {
                            $('#submit-alert<?php echo $id;?>').removeClass('alert alert-success');
                            $("#submit-alert<?php echo $id;?>").addClass("alert alert-warning");

                            $('#submit-alert<?php echo $id;?>').html("Student removed successfully.");
                            $('#submit-alert<?php echo $id;?>')
                            //.hide()
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "students";
                          }, 2000);
                        }
                      }
                    });
                  });




                  //Update student
                  $('#updatestudent<?php echo $id;?>').on('click', function(){
                    if($('#idnumber<?php echo $id;?>').val() == "" ||
                    $('#firstname<?php echo $id;?>').val() == "" ||
                    $('#lastname<?php echo $id;?>').val() == "" ||
                    $('#cyear<?php echo $id;?>').val() == "" ||
                    $('#course<?php echo $id;?>').val() == "" ||
                    $('#section<?php echo $id;?>').val() == "" ||
                    $('#emailadd<?php echo $id;?>').val() == "" ||
                    $('#contact<?php echo $id;?>').val() == "" ||

                    $('#college<?php echo $id;?>').val() == "" ||
                    $('#department<?php echo $id;?>').val() == "" ||

                    $('#bdate<?php echo $id;?>').val() == "" ||
                    $('#address<?php echo $id;?>').val() == ""){
                      setTimeout(function () {
                        $('#submit-alert<?php echo $id;?>').removeClass('alert alert-success');
                        $("#submit-alert<?php echo $id;?>").addClass("alert alert-warning");

                        $('#submit-alert<?php echo $id;?>').html("Please fill all required fields!");
                        $('#submit-alert<?php echo $id;?>')
                        //.hide()
                        .fadeIn(500)
                        .delay(2000)
                        .fadeOut(500);
                      }, 0);
                    }else{
                      var data = {
                        "refid" : $('#refid<?php echo $id; ?>').val(),

                        "idnumber" : $('#idnumber<?php echo $id;?>').val(),
                        "firstname" : $('#firstname<?php echo $id;?>').val(),
                        "middlename" : $('#middlename<?php echo $id;?>').val(),
                        "lastname" : $('#lastname<?php echo $id;?>').val(),
                        "cyear" : $('#cyear<?php echo $id;?>').val(),
                        "course" : $('#course<?php echo $id;?>').val(),
                        "section" : $('#section<?php echo $id;?>').val(),

                        "scholarship" : $('#scholarship<?php echo $id;?>').val(),
                        "college" : $('#college<?php echo $id;?>').val(),
                        "department" : $('#department<?php echo $id;?>').val(),

                        "emailadd" : $('#emailadd<?php echo $id;?>').val(),
                        "contact" : $('#contact<?php echo $id;?>').val(),
                        "bdate" : $('#bdate<?php echo $id;?>').val(),
                        "address" : $('#address<?php echo $id;?>').val(),

                        "updatestudent" : "updatestudent"
                      };
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/student.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                          if(data == 'updated'){
                            setTimeout(function () {
                              $('#submit-alert<?php echo $id;?>').removeClass('alert alert-warning');
                              $("#submit-alert<?php echo $id;?>").addClass("alert alert-success");

                              $('#submit-alert<?php echo $id;?>').html("Student updated successfully.");
                              $('#submit-alert<?php echo $id;?>')
                              //.hide()
                              .fadeIn(500)
                              .delay(2000)
                              .fadeOut(500);
                            }, 0);

                            setTimeout(function () {
                              location.href = "students";
                            }, 2000);

                          }
                        }

                      });
                    }
                  });
                  </script>

                  <?php
                }
              }
              ?>
            </tbody>
            <tfoot>
              <!--tr>
              <th>ID No.</th>
              <th>Name</th>
              <th>Academic Year</th>
              <th>Course</th>
              <th>Section</th>
              <th>Actions</th>
            </tr-->
          </tfoot>
        </table>
      </div>
    </div>

    <div class="card-footer small text-muted"><button type="button" onclick="PrintData()" class="btn btn-success"><span class="fa fa-print"></span> Print Student List</button> </div>
    <script type="text/javascript">

    /*$(document).ready(function() {

    $('#disablethis :input').attr("disabled","disabled");

    $('#dataTable tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
  } );

  // DataTable
  var table = $('#dataTable').DataTable();

  // Apply the search
  table.columns().every( function () {
  var that = this;

  $( 'input', this.footer() ).on( 'keyup change', function () {
  if ( that.search() !== this.value ) {
  that
  .search( this.value )
  .draw();
}
} );
} );
} );*/

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


<!--MODAL-->
<div id="addStudent" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4>Student Information</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
        <div style="display:none; margin:0px auto; width:450px;" id="submit-alert" class=""></div>
      </div>

      <div class="modal-body">

        <form action="model/student.php" method="post">
          <div class="form-row">
            <div class="form-group col-md-6">
              Student ID No.
              <input type="text" required name="idnumber" id="idnumber" class="form-control">
            </div>
            <div class="form-group col-md-6">
              College
              <input type="list" list="CollegeList" name="college" id="college" value="" class="form-control">
              <datalist class="" id="CollegeList">
                <?php
                $getCourses = "SELECT DISTINCT college FROM tbl_course";
                $result = OpenConn()->query($getCourses);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $college = $row['college'];
                    ?>
                    <option value="<?php echo $college; ?>"><?php echo $college; ?></option>
                    <?php
                  }
                }
                ?>
              </datalist>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              First Name
              <input type="text" name="firstname" class="form-control" id="firstname" required>
            </div>
            <div class="form-group col-md-4">
              Middle Name
              <input type="text" name="middlename" class="form-control" id="middlename" required>
            </div>
            <div class="form-group col-md-4">
              Last Name
              <input type="text" name="lastname" class="form-control" id="lastname" required>
            </div>
          </div>




          <div class="form-row">
            <div class="form-group col-md-4">
              Year
              <select name="cyear" id="cyear" value="" class="form-control">
                <?php
                if ($_SESSION['role'] == "Administrator") {
                  ?>
                  <option value="<?php echo "First Year"; ?>"><?php echo "First Year"; ?></option>
                  <option value="<?php echo "Second Year"; ?>"><?php echo "Second Year"; ?></option>
                  <option value="<?php echo "Third Year"; ?>"><?php echo "Third Year"; ?></option>
                  <option value="<?php echo "Fourth Year"; ?>"><?php echo "Fourth Year"; ?></option>
                  <option value="<?php echo "Fifth Year"; ?>"><?php echo "Fifth Year"; ?></option>
                  <?php

                }else{
                  $getOwnYear = " SELECT DISTINCT course_year FROM tbl_advisory WHERE teacher_no = '$currentsession' ";
                  $resultown = OpenConn()->query($getOwnYear);
                  if ($resultown->num_rows > 0) {
                    while ($row = $resultown->fetch_assoc()) {
                      $course_year = $row['course_year'];
                      ?>
                      <option value="<?php echo $course_year; ?>"><?php echo $course_year; ?></option>
                      <?php
                    }
                  }
                }
                ?>
              </select>

            </div>
            <div class="form-group col-md-4">
              Course
              <?php
              if ($_SESSION['role'] == "Administrator") {
                ?>
                <input type="list" list="CourseList" name="course" id="course" value="" class="form-control">
                <datalist class="" id="CourseList">
                  <?php
                  $getOwnCourse = "SELECT DISTINCT tcs.course_code AS tc,tcs.course_desc AS tdes FROM tbl_course as tcs";
                  $resultcourse = OpenConn()->query($getOwnCourse);

                  if ($resultcourse->num_rows > 0) {
                    while ($row = $resultcourse->fetch_assoc()) {
                      $course_code = $row['tc'];
                      $course_desc = $row['tdes'];
                      ?>
                      <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                      <?php
                    }
                  }
                  ?>
                </datalist>
                <?php
              }elseif($_SESSION['role'] == "Teacher"){
                ?>
                <select name="course" id="course" value="" class="form-control">
                  <?php
                  $getOwnCourse = "SELECT DISTINCT
                      ta.id AS tid,
                      ta.course_code AS tcd,
                      course_desc AS tdsc
                  FROM
                      tbl_advisory AS ta
                  INNER JOIN tbl_course AS tc
                  ON
                      ta.course_code = tc.course_code
                  WHERE
                      ta.teacher_no = '$currentsession' GROUP BY ta.course_code";
                  $resultcourse = OpenConn()->query($getOwnCourse);
                  if ($resultcourse->num_rows > 0) {
                    while ($row = $resultcourse->fetch_assoc()) {
                      $id = $row['tid'];
                      $course_code = $row['tcd'];
                      $course_desc = $row['tdsc'];
                      ?>
                      <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <?php
              }
              ?>
            </div>

            <div class="form-group col-md-4">
              Section
              <!--select name="section" class="form-control" id="section" required-->
                <?php
                if ($_SESSION['role'] == "Administrator")
                {
                ?>
                <input type="text" name="section" class="form-control" id="section" required>
                <?php
                }
                else if($_SESSION['role'] == "Teacher")
                {
                ?>
                <select name="section" class="form-control" id="section" required>
                <?php
                $getOwnSection = " SELECT DISTINCT section FROM tbl_advisory WHERE teacher_no = '$currentsession' ";
                $resultsection = OpenConn()->query($getOwnSection);
                if ($resultsection->num_rows > 0) {
                  while ($row = $resultsection->fetch_assoc()) {
                    $section = $row['section'];
                    ?>
                    <option value="<?php echo $section; ?>"><?php echo $section; ?></option>
                    <?php
                  }
                }
                ?>
                </select>
                <?php
              }
                ?>
              <!--/select-->

            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              Department
              <input type="list" list="DepartmentList" required id="department" name="department" class="form-control">
              <datalist class="" id="DepartmentList">
                <?php
                $getCourse = "SELECT id,college,department,course_code,course_desc FROM tbl_course GROUP BY department";
                $result = OpenConn()->query($getCourse);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $college = $row['college'];
                    $department = $row['department'];
                    $course_code = $row['course_code'];
                    $course_name = $row['course_desc'];
                    ?>
                    <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
                    <?php
                  }
                }
                ?>
              </datalist>
            </div>
            <div class="form-group col-md-3">
              Birthdate
              <input type="date" name="bdate" class="form-control" id="bdate" required>
            </div>
            <div class="form-group col-md-3">
              Contact
              <input type="text" name="contact" class="form-control" id="contact" required>
            </div>
          </div>


          <div class="form-row">
            <div class="form-group col-md-6">
              Email
              <input type="text" name="emailadd" class="form-control" id="emailadd" required>
            </div>
            <div class="form-group col-md-6">
              Scholarship
              <input type="list" id="shit" list="ScholarshipList" class="form-control" value=""  required>
              <datalist class="" id="ScholarshipList">
                <?php
                $getGrant = "SELECT DISTINCT grant_code,grant_desc FROM tbl_scholarship";
                $resultgrant = OpenConn()->query($getGrant);

                if ($resultgrant->num_rows > 0) {
                  while ($row = $resultgrant->fetch_assoc()) {
                    $grant_code = $row['grant_code'];
                    $grant_desc = $row['grant_desc'];
                    ?>
                    <option value="<?php echo $grant_code; ?>"><?php echo $grant_desc; ?></option>
                    <?php
                  }
                }
                ?>
              </datalist>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              Address
              <input type="text" name="addresshit" class="form-control" id="addresshit" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div style="display:none; z-index:9999; top:10%; left:10%; position:fixed; margin:0 auto;text-align:center; margin-top:10px; width:400px;" id="success-alert" class="alert alert-success">Command completed successfully !</div>

          <button type="button" class="btn btn-success" name="addstudent" id="addstudent">Add Student</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

        </div>
      </div>
    </form>


  </div>
</div>
<!--modal-->



<script type="text/javascript">

//Addning student

$("#addstudent").on("click", function(){
  if($('#idnumber').val() == "" ||
  $('#firstname').val() == "" ||
  $('#lastname').val() == "" ||
  $('#cyear').val() == "" ||
  $('#course').val() == "" ||
  $('#college').val() == "" ||
  $('#department').val() == "" ||
  $('#section').val() == "" ||
  $('#emailadd').val() == "" ||
  $('#contact').val() == "" ||
  $('#bdate').val() == "" ||
  $('#addresshit').val() == ""){
    setTimeout(function () {
      $('#submit-alert').removeClass('alert alert-success');
      $("#submit-alert").addClass("alert alert-warning");

      $('#submit-alert').html("Please fill all required fields!");
      $('#submit-alert')
      //.hide()
      .fadeIn(500)
      .delay(2000)
      .fadeOut(500);
    }, 0);
  }else{
    $('#addstudent').prop('disabled', true);
    $("#addstudent").html('Saving Information...');

    var data = {
      "idnumber" : $('#idnumber').val(),
      "firstname" : $('#firstname').val(),
      "middlename" : $('#middlename').val(),
      "lastname" : $('#lastname').val(),

      "college" : $('#college').val(),
      "scholarship" : $('#shit').val(),
      "department" : $('#department').val(),


      "cyear" : $('#cyear').val(),
      "course" : $('#course').val(),
      "section" : $('#section').val(),
      "emailadd" : $('#emailadd').val(),
      "contact" : $('#contact').val(),
      "bdate" : $('#bdate').val(),
      "address" : $('#addresshit').val(),

      "addstudent" : "addstudent"
    };
    data = $(this).serialize() + "&" + $.param(data);

    $.ajax({
      type: 'POST',
      url: 'model/student.php',
      dataType : 'json',
      data: data,
      success: function (data) {
        if(data == 'exist'){
          $('#addstudent').prop('disabled', false);
          $("#addstudent").html('Add Student');
          setTimeout(function () {
            $('#submit-alert').removeClass('alert alert-success');
            $('#submit-alert').addClass('alert alert-warning');

            $('#submit-alert').html("Data existed in the database.");
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(2000)
            .fadeOut(500);
          }, 0);
        }else if(data == 'mailerr'){
          $('#addstudent').prop('disabled', false);
          $("#addstudent").html('Add Student');
          setTimeout(function () {
            $('#submit-alert').removeClass('alert alert-success');
            $("#submit-alert").addClass("alert alert-warning");

            $('#submit-alert').html("Data are saved. <br>Warning: No internet connection, Mail failed to send.");
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(5000)
            .fadeOut(500);
          }, 0);

          setTimeout(function () {
            location.href = "students";
          }, 2000);

        }else{
          $('#addstudent').prop('disabled', false);
          $("#addstudent").html('Add Student');

          setTimeout(function () {
            $('#submit-alert').removeClass('alert alert-warning');
            $("#submit-alert").addClass("alert alert-success");

            $('#submit-alert').html("Student inserted successfully! Mail sent.");
            $('#submit-alert')
            //.hide()
            .fadeIn(500)
            .delay(2000)
            .fadeOut(500);
          }, 0);

          setTimeout(function () {
            location.href = "students";
          }, 2000);
        }

      }
    });
  }
});


</script>






<div class="" id="printdiv" style="display:none;">
  <h2>All Students</h2>

  <br>
  <br>
  <table class="table table-bordered" width="100%" cellspacing="0" style="table-layout: fixed; width: 100%;  text-align:center;" border='1' cellpadding='1'>
    <thead>
      <tr>
        <th>ID No.</th>
        <th>Name</th>
        <th>College</th>
        <th>Year</th>
        <th>Course</th>
        <th>Section</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($_SESSION['role'] == "Administrator"){
        $getStudents = "SELECT DISTINCT
        ts.id AS tsid,
        ts.student_no AS tss,
        ts.first_name AS tsf,
        ts.middle_name AS tsm,
        ts.last_name AS tsl,
        ts.cyear AS tsa,
        tc.course_code AS tscode,
        tc.course_desc as tsdesc,
        ts.section AS tsec,
        ts.caddress AS tscad,
        ts.birthday AS tsb,
        ts.phone AS tsp,
        ts.email AS tsem,
        ts.college AS tscols


        FROM
        tbl_students AS ts

        INNER JOIN tbl_course as tc
        ON ts.course_code = tc.course_code";

      }else{
        $sessionuserid = $_SESSION['idno'];
        $getStudents = "SELECT DISTINCT
        ts.id AS tsid,
        ts.student_no AS tss,
        ts.first_name AS tsf,
        ts.middle_name AS tsm,
        ts.last_name AS tsl,
        ts.cyear AS tsa,

        ts.college AS tscol,
        ts.department AS tdept,
        ts.scholarship AS tschol,


        ts.course_code AS tscode,
        tc.course_desc AS tsdesc,
        ts.section AS tsec,
        ts.caddress AS tscad,
        ts.birthday AS tsb,
        ts.phone AS tsp,
        ts.email AS tsem
        FROM
        tbl_students AS ts


        INNER JOIN tbl_advisory AS tcs1
        ON tcs1.course_code = ts.course_code

        INNER JOIN tbl_advisory as tcs2
        ON tcs2.section = ts.section


        INNER JOIN tbl_course AS tc
        ON ts.course_code = tc.course_code


        WHERE
        tcs1.teacher_no =  '$sessionuserid'";
      }

      $resultstudent = OpenConn()->query($getStudents);

      if ($resultstudent->num_rows > 0) {
        while ($row = $resultstudent->fetch_assoc()) {
          $id = $row['tsid'];
          $student_no = $row['tss'];
          $first_name = $row['tsf'];
          $middle_name = $row['tsm'];
          $last_name = $row['tsl'];
          $cyear = $row['tsa'];
          $course_code = $row['tscode'];
          $course_desc = $row['tsdesc'];
          $section = $row['tsec'];
          $caddress = $row['tscad'];
          $birthday = $row['tsb'];
          $phone = $row['tsp'];
          $email = $row['tsem'];
          $college = $row['tscol'];
          $coninfo =$email." | ".$phone;

          $fullname = $first_name.' '.$last_name;
          ?>
          <tr>
            <td><span style="color:blue;"><?php echo $student_no; ?></span> </td>
            <td><?php echo $fullname; ?></td>
            <td><?php echo $college; ?></td>
            <td><?php echo $cyear; ?></td>
            <td><?php echo $course_code; ?></td>
            <td><?php echo $section; ?></td>
          </tr>

          <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>
<!-- /.container-fluid -->
<?php require('layout/footer.php'); ?>
