<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();

?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#accounts').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#addAccount" class="btn btn-primary">Add Account</button>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-lock"></span> Accounts</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <!--th>ID No.</th-->
                <th>Username</th>
                <th>Role</th>
                <!--th>College</th-->
                <th>Remarks</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $getaccounts = "SELECT COALESCE
              (
                CONCAT(tts.first_name,' ',tts.last_name),CONCAT(ttt.first_name ,' ', ttt.last_name)
              ) AS fullname,

              tc.id AS id,
              tc.id_no AS id_no,
              tc.user AS usern,
              tc.pass AS pass,
              tc.user_type AS user_type,
              tc.remarks AS remarks,
              ttd.college AS college
          FROM
              tbl_credentials AS tc
          LEFT JOIN tbl_college AS ttd
          ON
              tc.id_no = ttd.id_no
          LEFT JOIN tbl_students AS tts
          ON
              tc.id_no = tts.student_no
          LEFT JOIN tbl_teacher AS ttt
          ON
              tc.id_no = ttt.teacher_no
          WHERE tc.user_type != 'Administrator'
              ";

              $result = OpenConn()->query($getaccounts);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $userid = $row['id_no'];
                  $user = $row['fullname'];
                  $pass = $row['pass'];
                  $role = $row['user_type'];
                  $college = $row['college'];
                  $remarks = $row['remarks'];


                  ?>
                  <tr>
                    <!--td><?php //echo $userid; ?></td-->
                    <td><a href="#" title="<?php echo $user; ?>"> <?php echo $userid; ?></a></td>
                    <td><?php echo $role; ?></td>
                    <!--td><?php echo $college; ?></td-->
                    <td><?php echo $remarks; ?></td>
                    <td>
                      <button type="button" data-toggle="modal" data-target="#updateuser<?php echo $id; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
                    </td>
                  </tr>

                  <div id="updateuser<?php echo $id;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-md">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>Account Information</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
                          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert<?php echo $id;?>" class=""></div>
                        </div>

                        <div class="modal-body">

                          <form action="model/student.php" method="post">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                ID Number
                                <input Disabled type="text" value="<?php echo $userid; ?>" required name="idnumber" id="idnumber<?php echo $id;?>" class="form-control">
                              </div>
                              <div class="form-group col-md-6">
                                Role
                                <?php if ($role != "Student"): ?>
                                  <select name="role" id="role<?php echo $id;?>" class="form-control">
                                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                                    <option value="">--</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Organizer">Organizer</option>
                                  </select>
                                <?php else: ?>
                                  <select name="role" id="role<?php echo $id;?>" disabled class="form-control">
                                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                                    <option value="">--</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Organizer">Organizer</option>
                                  </select>
                                <?php endif; ?>



                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                Username
                                <input type="text" value="<?php echo $user; ?>" required name="user" id="user<?php echo $id;?>" class="form-control">
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                Password
                                <input type="password" value="<?php echo $pass; ?>" required name="pass" id="pass<?php echo $id;?>" class="form-control">
                              </div>
                            </div>

                            <div class="form-row">
                              <div class="form-group col-md-6">
                                College
                                <?php
                                  if ($role == "Student") {
                                    ?>
                                    <input type="text" name="college" value="Not Available" class="form-control" id="college<?php echo $id;?>" disabled>
                                    <?php
                                  }else{
                                    ?>
                                    <input type="list" list="collegeList" name="college" value="<?php echo $college; ?>" class="form-control" id="college<?php echo $id;?>">
                                    <?php
                                  }
                                 ?>
                              </div>
                              <div class="form-group col-md-6">
                                Remarks
                                <select name="remarks" id="remarks<?php echo $id ?>" class="form-control">
                                  <option value="<?php echo $remarks ?>"><?php echo $remarks ?></option>
                                  <option value="">-</option>
                                  <option value="Enabled">Enabled</option>
                                  <option value="Disabled">Disabled</option>
                                </select>
                              </div>
                            </div>
                          </form>
                        </div>


                        <div class="modal-footer">
                          <input type="hidden" value="<?php echo $userid;?>" name="" id="ref<?php echo $id;?>">
                          <button type="button" class="btn btn-success" name="updateacc" id="updateacc<?php echo $id;?>"><span class="fa fa-sync"></span> </button>
                          <button type="button" class="btn btn-danger" id="deleteacc<?php echo $id;?>"><span class="fa fa-trash"></span> </button>
                        </div>

                      </div>

                    </div>
                  </div>


                  <script type="text/javascript">

                  //Update Instructor
                  $('#updateacc<?php echo $id;?>').on('click',function(){
                    if($('#idnumber<?php echo $id;?>').val() == "" ||
                    $('#user<?php echo $id;?>').val() == "" ||
                    $('#pass<?php echo $id;?>').val() == "" ||
                    $('#role<?php echo $id;?>').val() == "" ||
                    $('#college<?php echo $id;?>').val() == "" ||
                    $('#remarks<?php echo $id;?>').val() == "")
                    {
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
                        "idnumber" : $('#idnumber<?php echo $id;?>').val(),
                        "ref" : $('#ref<?php echo $id;?>').val(),
                        "user" : $('#user<?php echo $id;?>').val(),
                        "pass" : $('#pass<?php echo $id;?>').val(),
                        "role" : $('#role<?php echo $id;?>').val(),
                        "college" : $('#college<?php echo $id;?>').val(),
                        "remarks" : $('#remarks<?php echo $id;?>').val(),

                        "updateacc" : "updateacc"
                      };

                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/account.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                          if(data == 'updated'){
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
                              location.href = "accounts";
                            }, 2000);
                          }
                        }
                      });
                    }

                  });




                  //Delete Instructor
                  $('#deleteacc<?php echo $id;?>').on('click',function(){
                    var data = {
                      "idnumber" : $('#idnumber<?php echo $id ?>').val(),
                      "deleteacc": 'deleteacc'
                    }
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/account.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        setTimeout(function () {
                          $("#submit-alert<?php echo $id; ?>").addClass("alert alert-warning");
                          $('#submit-alert<?php echo $id; ?>').html("Account Removed successfully!");
                          $('#submit-alert<?php echo $id; ?>')
                          //.hide()
                          .fadeIn(500)
                          .delay(2000)
                          .fadeOut(500);
                        }, 0);

                        setTimeout(function () {
                          location.href = "accounts";
                        }, 2000);

                      }
                    })

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

  <div id="addAccount" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>Account Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
        </div>

        <div class="modal-body">

          <form action="model/student.php" method="post">
            <div class="form-row">
              <div class="form-group col-md-6">
                ID Number
                <input type="text" value="" required name="idnumber" id="idnumber" class="form-control">
              </div>

              <div class="form-group col-md-6">
                Role
                <select name="role" id="role" class="form-control">
                  <option value="Administrator">Administrator</option>
                  <option value="Organizer">Organizer</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                Username
                <input type="text" value="" required name="user" id="user" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                Password
                <input type="password" value="" required name="pass" id="pass" class="form-control">
              </div>
            </div>

            <div class="form-row">

              <div class="form-group col-md-6">
                College
                <input type="list" class="form-control" list="collegeList" name="college" id="college">

                <datalist class="" id="collegeList">
                  <option value=""></option>
                  <?php
                  $getCourse = "SELECT id,college,course_code,course_desc FROM tbl_course GROUP BY college";
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
                </datalist>

              </div>



              <div class="form-group col-md-6">
                Remarks
                <select name="remarks" id="remarks" class="form-control">
                  <option value="Enabled">Enabled</option>
                  <option value="Disabled">Disabled</option>
                </select>
              </div>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <div style="display:none; z-index:9999; top:10%; left:10%; position:fixed; margin:0 auto;text-align:center; margin-top:10px; width:400px;" id="success-alert" class="alert alert-success">Command completed successfully !</div>

          <button type="button" class="btn btn-success" name="addaccount" id="addaccount">Add Account</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

        </div>
      </div>

    </div>
  </div>


  <script type="text/javascript">
  //Adding Instructor
  $("#addaccount").on('click', function () {


    if
    (
    $('#idnumber').val() == "" ||
    $('#user').val() == "" ||
    $('#pass').val() == "" ||
    $('#role').val() == "" ||
    $('#college').val() == "" ||
    $('#remarks').val() == ""
    ){
      setTimeout(function () {
        $('#submit-alert').removeClass('alert alert-danger');
        $('#submit-alert').removeClass('alert alert-warning');
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
        "user" : $('#user').val(),
        "pass" : $('#pass').val(),
        "role" : $('#role').val(),
        "remarks" : $('#remarks').val(),
        "college" : $('#college').val(),

        "addaccount" : "addaccount"
      };

      data = $(this).serialize() + "&" + $.param(data);

      $.ajax({
        type: 'POST',
        url: 'model/account.php',
        dataType : 'json',
        data: data,
        success: function (data) {
          if(data == 'exist'){
            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-success");
              $("#submit-alert").addClass("alert alert-danger");
              $('#submit-alert').html("Data existed in the database or Username is unavailable.");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(2000)
              .fadeOut(500);
            }, 0);
          }

          else{
            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-danger");
              $("#submit-alert").addClass("alert alert-success");
              $('#submit-alert').html("Command completed successfully!");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(2000)
              .fadeOut(500);
            }, 0);

            setTimeout(function () {
              location.href = "accounts";
            }, 2000);


          }
        }
      });
    }
  });

  </script>

  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
