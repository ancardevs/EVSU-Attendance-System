<?php
require('layout/user-header.php');
?>

<div id="wrapper">
  <!-- Sidebar -->
  <ul class="sidebar navbar-nav">
    <li class="nav-item" id="dashboard">
      <div class="" style="text-align:center;">
        <a href="#" data-toggle="modal" data-target="#studentAvatar"><img src="img/profiles/<?php echo $img; ?>"style="border-radius: 50%;width:100%;height:auto; padding:10px;" id="profile-img-tag" /></a>
        <h4 style="color:white;"><?php echo $studname; ?></h4>
      </div>
    </li>

    <!-- Modal -->
    <div class="modal fade" id="studentAvatar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <form class="" action="model/student.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Image</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img id="blah" accept=".jpg, .jpeg, .png" required src="img/profiles/<?php echo $img; ?>" style="width:100%;height:auto;border:1px solid;" alt="your image" />
              <br>
              <br>
              <input type='file' name="avatarimg" id="imgInp" />

              <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
              <script type="text/javascript">
              function readURL(input) {

                if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                  }

                  reader.readAsDataURL(input.files[0]);
                }
              }

              $("#imgInp").change(function() {
                readURL(this);
              });
              </script>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="avatarid" value="<?php echo $_SESSION['idno']; ?>">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="addavatar" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  </ul>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="js/custom.js"></script>

  <script>
  $(document).ready(function(){
    $('#events').addClass('nav-item active')
  });
  </script>

  <div id="content-wrapper">

    <div class="modal fade" id="promptmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 id="prompt"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>


    <div class="container-fluid">
      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <div style="float:left;">
            <h4>Change Password </h4>
          </div>
          <div style="float:right;">
            <h4><span class="fa fa-user"></span> <?php echo $_SESSION['role']; ?></h4>
          </div>
        </div>
        <div class="card-body">

          <div class="container">
            <div class="row">

              <div class="col-md-2"></div>
              <div class="col-md-4">
                <div class="d-flex justify-content-center h-100">
                  <div class="image_outer_container">
                    <div class="green_icon"></div>
                    <div class="image_inner_container">
                      <img src="img/lock-icon.png" style="max-width:200px; max-height:200px;">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:absolute;; top:-25%; ">
                    <div style="display:none; width:92%;" id="change-alert" class=""></div>
                  </div>
                  New Password
                  <input type="password" id="pass1" class="form-control" name="" value="">
                </div>
                <input type="hidden" name="" id="authno" value="<?php echo $_SESSION['idno']; ?>">
                <div class="form-group">
                  Confirm Password
                  <input type="password" id="pass2" class="form-control" name="" value="">
                </div>
                <div class="form-group">
                  <button type="button" id="changepass"  style="width:100%;" class="btn btn-primary" name="button">Continue</button>
                </div>
              </div>
              <div class="col-md-2"></div>
            </div>
          </div>

        </div>
        <div class="card-footer small text-muted">DataTables v1.10.18</div>
      </div>
    </div>



    <div class="container-fluid">
      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <div style="float:left;">
            <h4>My Current Profile</h4>
          </div>
          <div style="float:right;">
            <h4><span class="fa fa-info-circle"></span> Information</h4>
          </div>
        </div>
        <div class="card-body">

          <div class="container">
            <div class="row">

              <div class="card col-md-12" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">Update Information</h5>
                  <hr>


                  <?php
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

                  INNER JOIN tbl_course as tc
                  ON ts.course_code = tc.course_code
                  WHERE ts.student_no = '$studid'";


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




                      <!-- Modal content-->



                      <div class="modal-body">

                        <form action="model/student.php" method="post">
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              Student ID No.
                              <input type="text" required id="idnumber<?php echo $id;?>" name="idnumber" value="<?php echo $student_no;?>" class="form-control">
                            </div>
                            <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
                              <div style="display:none;  width:450px; right:50%; left:18%;"  id="submit-alert<?php echo $id; ?>" class=""></div>
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
                              <input type="list" list="YearList" name="cyear" id="cyear<?php echo $id;?>" value="<?php echo $cyear ?>" class="form-control">

                            </div>
                            <div class="form-group col-md-4">
                              Course
                              <input type="list" list="CourseList" name="course" id="course<?php echo $id;?>" value="<?php echo $course_code ?>" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                              Section
                              <input type="text" name="section" class="form-control" id="section<?php echo $id;?>" value="<?php echo $section ?>" required>
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
                              <input type="list" name="scholarship" list="ScholarshipList" value="<?php echo $scholarship; ?>" class="form-control" id="scholarship<?php echo $id;?>" required>
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
                      </div>


                      <script type="text/javascript">



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
                                  location.href = "student-settings";
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

                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="card-footer small text-muted">DataTables v1.10.18</div>
      </div>
    </div>

  </div>
</div>





<script type="text/javascript">





//Change Pass
$('#changepass').on('click',function(){

  if ($('#pass1').val() == "" || $('#pass2').val() == "") {

    setTimeout(function () {
      $("#change-alert").addClass("alert alert-danger");
      $('#change-alert').html("Incomplete data..!");
      $('#change-alert')
      //.hide()
      .fadeIn(500)
      .delay(3000)
      .fadeOut(500);
    }, 0);


  }else if ($('#pass1').val() != $('#pass2').val()) {
    setTimeout(function () {
      $("#change-alert").addClass("alert alert-danger");
      $('#change-alert').html("Password not matched .!");
      $('#change-alert')
      //.hide()
      .fadeIn(500)
      .delay(3000)
      .fadeOut(500);
    }, 0);


  }else{

    var data = {
      "idnumber" : $('#authno').val(),
      "pass" : $('#pass2').val(),
      "changepass": 'changepass'
    }
    data = $(this).serialize() + "&" + $.param(data);

    $.ajax({
      type: 'POST',
      url: 'model/auth.php',
      dataType : 'json',
      data: data,
      success: function (data) {
        if (data == "changed") {
          endsession();
          setTimeout(function () {
            $("#change-alert").addClass("alert alert-success");
            $('#change-alert').html("You will be logged-out within 3 seconds.");
            $('#change-alert')
            //.hide()
            .fadeIn(500)
            .delay(5000)
            .fadeOut(500);
          }, 0);

          setTimeout(function () {
            location.href = "/";
          }, 3000);
        }
      }
    });
  }
});


function endsession(){
  var data = {
    "logout": 'logout'
  }
  data = $(this).serialize() + "&" + $.param(data);

  $.ajax({
    type: 'POST',
    url: 'model/auth.php',
    dataType : 'json',
    data: data,
    success: function (data) {
      if (data == "loggedout") {
        //location.href = "http://localhost/projects/eorg/";
      }
    }
  });
}



</script>
<!-- /.container-fluid -->
<?php require('layout/user-footer.php'); ?>
