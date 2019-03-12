<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();

?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="css/setting.css">


<div id="content-wrapper">

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
      <div class="card-footer small text-muted">Change Password Card - Evsu Event Organizer v1.0.0.0</div>
    </div>
  </div>
















  <div <?php echo $utility ?> class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <h4>User Session Tracker</h4>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-history"></span> Session Logs</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Account No.</th>
                <th>Activity</th>
                <th>Reference</th>
                <th>Date &amp; Time</th>
                <th>Remarks</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $gettracker = "SELECT
                  tt.first_name as ttfname,
                  tt.last_name as ttlname,
                  ts.first_name as tsfname,
                  ts.last_name as tslname,
                  st.id,
                  st.id_no,
                  st.activity,
                  st.reference,
                  st.performed_on,
                  st.remarks
              FROM tbl_sessiontracker AS st

              LEFT JOIN tbl_teacher AS tt
              ON st.id_no = tt.teacher_no

              LEFT JOIN tbl_students AS ts
              ON st.id_no = ts.student_no

              ORDER BY
                  st.id
              DESC";

              $trackerresult = OpenConn()->query($gettracker);

              if ($trackerresult->num_rows > 0) {
                while ($row = $trackerresult->fetch_assoc()) {
                  $id = $row['id'];

                  $accid = "";
                  $taccname = $row['ttfname'].' '.$row['ttlname'];
                  $saccname = $row['tsfname'].' '.$row['tslname'];



                  $id_no = $row['id_no'];
                  $activity = $row['activity'];
                  $reference = $row['reference'];
                  $performed_on = $row['performed_on'];
                  $remarks = $row['remarks'];

                  if ($row['ttfname'] == "") {
                    $accid = $row['tsfname'].' '.$row['tslname'];
                  }else{
                    $accid = $row['ttfname'].' '.$row['ttlname'];
                  }

                  //$timein = ;

                  ?>
                  <tr>
                    <td><a href="#" title="<?php echo $accid; ?>"><?php echo $id_no ?></a> </td>
                    <td><?php echo $activity; ?></td>
                    <td><?php echo $reference; ?></td>
                    <td><?php echo date('M. d, Y - h:i A', strtotime($row['performed_on'])); ?></td>
                    <td><?php echo $remarks; ?></td>

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




















    <div <?php echo $hideinfo; ?> class="container-fluid">
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

                  <tbody>
                    <?php


                    $getteacher1 = "SELECT DISTINCT
                        tt.id AS id,
                        tt.college AS college,
                        tt.teacher_no AS teacher_no,
                        tt.first_name AS first_name,
                        tt.middle_name AS middle_name,
                        tt.last_name AS last_name,
                        tt.caddress AS caddress,
                        tt.phone AS phone,
                        tt.email AS email

                    FROM tbl_teacher as tt

                    ";
                    $result1 = OpenConn()->query($getteacher1);
                    if ($result1->num_rows > 0) {
                      while ($row = $result1->fetch_assoc()) {
                        $id = $row['id'];
                        $college = $row['college'];
                        $instructor_no = $row['teacher_no'];
                        $first_name = $row['first_name'];
                        $middle_name = $row['middle_name'];
                        $last_name = $row['last_name'];
                        $caddress = $row['caddress'];
                        $phone = $row['phone'];
                        $email = $row['email'];
                        $fullname = $first_name.' '.$last_name;

                        ?>

                            <!-- Modal content-->



                              <div class="modal-body">
                                <div class="form-group col-md-12">
                                  <div style="z-index: 9999999; text-align:center; position: absolute; top:10%; display:none; left: 0;right: 0;height: auto; width: 100%; margin:0 auto;" id="submit-alert<?php echo $id;?>" class="form-control"></div>
                                </div>

                                <form action="model/student.php" method="post">
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      Instructor ID No.
                                      <input type="text" value="<?php echo $instructor_no; ?>" required name="idnumber" id="idnumber<?php echo $id;?>" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                      College
                                      <input type="list" list="collegeList" name="college" value="<?php echo $college; ?>" class="form-control" id="college<?php echo $id;?>">
                                      <datalist class="" id="collegeList">
                                        <?php
                                        $getCourse = "SELECT college,course_code,course_desc FROM tbl_course GROUP BY college";
                                        $result = OpenConn()->query($getCourse);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $college = $row['college'];
                                                $course_code = $row['course_code'];
                                                $course_name = $row['course_desc'];
                                                ?>
                                                <option value="<?php echo $college; ?>"><?php echo $college; ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-4">
                                      First Name
                                      <input type="text" name="firstname" value="<?php echo $first_name; ?>" class="form-control" id="firstname<?php echo $id;?>" required>
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
                                    <div class="form-group col-md-6">
                                      Email
                                      <input type="text" name="emailadd" value="<?php echo $email; ?>" class="form-control" id="emailadd<?php echo $id;?>" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                      Contact
                                      <input type="text" name="contact" value="<?php echo $phone; ?>" class="form-control" id="contact<?php echo $id;?>" required>
                                    </div>
                                  </div>

                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      Address
                                      <input type="text" name="address" value="<?php echo $caddress; ?>" class="form-control" id="address<?php echo $id;?>" required>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <a href="advisory.php?instructorid=<?php echo $instructor_no; ?>&instructorname=<?php echo $fullname ?>&role=instructor" style="border-radius:0px;" class="btn btn-primary" id="viewAdvisory" ><span class="fa fa-list"></span> View Advisory Information</a>

                                    </div>
                                  </div>


                                </form>
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" value="<?php echo $instructor_no;?>" name="" id="ref<?php echo $id;?>">
                                <button type="button" class="btn btn-success" name="updateinstructor" id="updateinstructor<?php echo $id;?>"><span class="fa fa-sync"></span> </button>

                              </div>



                        <script type="text/javascript">

                        //Update Instructor
                        $('#updateinstructor<?php echo $id;?>').on('click',function(){

                          if($('#idnumber<?php echo $id;?>').val() == "" ||
                          $('#firstname<?php echo $id;?>').val() == "" ||
                          $('#lastname<?php echo $id;?>').val() == "" ||
                          $('#emailadd<?php echo $id;?>').val() == "" ||
                          $('#college<?php echo $id;?>').val() == "" ||
                          $('#section<?php echo $id;?>').val() == "" ||
                          $('#contact<?php echo $id;?>').val() == "" ||
                          $('#department<?php echo $id;?>').val() == "" ||
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

                            setTimeout(function () {
                              location.href = "instructors";
                            }, 2000);

                          }else{

                            $('#updateinstructor<?php echo $id ?>').prop('disabled', true);
                            $("#updateinstructor<?php echo $id ?>").html('<span class="fa fa-sync"></span> Updating Instructor...');

                            var data = {
                              "idnumber" : $('#idnumber<?php echo $id;?>').val(),
                              "firstname" : $('#firstname<?php echo $id;?>').val(),
                              "middlename" : $('#middlename<?php echo $id;?>').val(),
                              "lastname" : $('#lastname<?php echo $id;?>').val(),
                              "emailadd" : $('#emailadd<?php echo $id;?>').val(),
                              "contact" : $('#contact<?php echo $id;?>').val(),
                              "college" : $('#college<?php echo $id;?>').val(),
                              "address" : $('#address<?php echo $id;?>').val(),
                              "refid" : $('#ref<?php echo $id;?>').val(),
                              "department" : $('#department<?php echo $id;?>').val(),
                              "updateinstructor" : "updateinstructor"
                            };

                            data = $(this).serialize() + "&" + $.param(data);

                            $.ajax({
                              type: 'POST',
                              url: 'model/instructor.php',
                              dataType : 'json',
                              data: data,
                              success: function (data) {
                                if(data == 'updated'){

                                  $('#updateinstructor<?php echo $id ?>').prop('disabled', false);
                                  $("#updateinstructor<?php echo $id ?>").html('<span class="fa fa-sync"></span>');

                                  setTimeout(function () {
                                    $("#submit-alert<?php echo $id ?>").removeClass("alert alert-warning");
                                    $("#submit-alert<?php echo $id ?>").addClass("alert alert-success");
                                    $('#submit-alert<?php echo $id ?>').html("Data updated successfully.");
                                    $('#submit-alert<?php echo $id ?>')
                                    //.hide()
                                    .fadeIn(500)
                                    .delay(2000)
                                    .fadeOut(500);
                                  }, 0);

                                  setTimeout(function () {
                                    location.href = "settings";
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
        <div class="card-footer small text-muted">Logged User Information Card - Evsu Event Organizer v1.0.0.0</div>
      </div>
    </div>










    <div <?php echo "style='display:none;'"//$utility; ?> class="container-fluid">
      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <div style="float:left;">
            <h4>Mentainance and Utility </h4>
          </div>
          <div style="float:right;">
            <h4><span class="fa fa-wrench"></span> Data Clean Up</h4>
          </div>
        </div>
        <div class="card-body">

          <div class="container">
            <div class="row">

              <div class="card col-md-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">Remove Records</h5>
                  <hr>
                  <div class="form-group">
                    Select Table
                    <select class="form-control" name="">
                      <option value="">Attendances</option>
                      <option value="">Courses</option>
                      <option value="">Events</option>
                      <option value="">Instructors</option>
                      <option value="">Students</option>
                    </select>
                  </div>
                  <div class="form-group">
                    Date From
                    <input type="date" class="form-control" name="" value="">
                  </div>
                  <div class="form-group">
                    Date To
                    <input type="date" class="form-control" name="" value="">
                  </div>
                  <br>
                  <div class="form-group">
                    <button type="button" style="width:100%;" class="btn btn-primary" name="button">Continue</button>
                  </div>
                </div>
              </div>

              <div class="col-md-1"></div>
              <div class="card col-md-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">Truncate Database Tables</h5>
                  <hr>
                  <p class="card-text">Truncating Database Tables will result in data lost and sometimes impossible to be restored.
                    Please contact your System Admininstrator before continuing. If you are the System Admininstrator,
                    you can proceed without cautions.</p>
                    <br><br>
                    <div class="form-group">
                      <button type="button" data-toggle="modal" data-target="#truncatetables" style="width:100%;" class="btn btn-primary" name="button">Continue</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer small text-muted">Mentainance and Utility - Evsu Event Organizer v1.0.0.0</div>
        </div>
      </div>




























































    <!--MODAL ALERT-->
    <div class="modal fade" id="successmodal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Clean-up Successfull</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!--div class="modal-footer">
      <button type="button" class="btn btn-primary">Save changes</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div-->
    </div>
  </div>
  </div>



    <!--MODAL ALERT-->
    <div class="modal fade" id="truncatetblbydate">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!--div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div-->
      <div class="modal-body" style="text-align:center;">
        Truncate Table ?
      </div>
      <!--div class="modal-footer">
      <button type="button" class="btn btn-primary">Save changes</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div-->
    </div>
  </div>
  </div>





<!--MODAL ALERT-->
<div class="modal fade" id="truncatetables">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--div class="modal-header">
      <h5 class="modal-title">Modal title</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div-->
  <div class="modal-body">
    <h3>Truncate Database Tables ?</h3>
    <span>This will clean the following records:</span>
    <br>
    <li>All Sections</li>
    <li>All Attendances</li>
    <li>All Courses</li>
    <li>All Events</li>
    <li>All Stufdents</li>
    <br>
    <span>But will not remove the following:</span>
    <li>Login Credentials</li>
    <li>Registred Instructors</li>



  </div>
  <div class="modal-footer">
    <form class="" action="model/utility.php" method="post">
      <button type="button" id="cleantables" class="btn btn-primary">Continue</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
</div>
</div>




</div>





<script type="text/javascript">



$('#cleantables').on('click',function(){
  $.ajax({
    type: 'POST',
    url: 'model/utility.php',
    dataType : 'json',
    data: {clean:"cleantables"},
    success: function (data) {
      if(data == 'cleaned'){
        $('#truncatetables').modal('hide');
        $('#successmodal').modal('show');

      }
    }
  });
})











$('#updateinstructor').on('click',function(){
  if($('#idnumber').val() == "" ||
  $('#firstname').val() == "" ||
  $('#lastname').val() == "" ||
  $('#emailadd').val() == "" ||
  $('#section').val() == "" ||
  $('#contact').val() == "" ||
  $('#department').val() == "" ||
  $('#address').val() == ""){

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

    var data = {
      "idnumber" : $('#idnumber').val(),
      "firstname" : $('#firstname').val(),
      "middlename" : $('#middlename').val(),
      "lastname" : $('#lastname').val(),
      "emailadd" : $('#emailadd').val(),
      "contact" : $('#contact').val(),
      "address" : $('#address').val(),
      "department" : $('#department').val(),
      "refid" : $('#ref').val(),
      "updateinstructor" : "updateinstructor"
    };

    data = $(this).serialize() + "&" + $.param(data);

    $.ajax({
      type: 'POST',
      url: 'model/instructor.php',
      dataType : 'json',
      data: data,
      success: function (data) {
        if(data == 'updated'){
          setTimeout(function () {
            $("#submit-alert").removeClass("alert alert-warning");
            $("#submit-alert").addClass("alert alert-success");
            $('#submit-alert').html("Data updated successfully.");
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

})




//Change Pass
$('#changepass').on('click',function(){

  if ($('#pass1').val() == "" || $('#pass2').val() == "") {

    setTimeout(function () {
      $("#change-alert").addClass("alert alert-danger");
      $('#change-alert').html("Incomplete data.! ");
      $('#change-alert')
      //.hide()
      .fadeIn(500)
      .delay(3000)
      .fadeOut(500);
    }, 0);


  }else if ($('#pass1').val() != $('#pass2').val()) {

    setTimeout(function () {
      $("#change-alert").addClass("alert alert-danger");
      $('#change-alert').html("Password not matched! ");
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
<?php require('layout/footer.php'); ?>
