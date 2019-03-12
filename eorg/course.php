<?php
require('layout/header.php');
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>
<!--script src="js/dtablerefresher.js"></script-->

<script>
$(document).ready(function(){
  $('#courses').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#addCourse" class="btn btn-primary">Add Course</button>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-graduation-cap"></span> Courses</h4>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>College</th>
                <th>Department</th>
                <th>Code</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //$getdata -> getcourses();
              $getCourses = "SELECT DISTINCT id,college,department, course_code,course_desc FROM tbl_course ORDER BY id DESC";
              $result = OpenConn()->query($getCourses);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $college = $row['college'];
                  $department = $row['department'];
                  $coursecode = $row['course_code'];
                  $coursedesc = $row['course_desc'];
                  $college = $row['college'];
                  $department = $row['department'];
                  ?>
                  <tr>
                    <td><?php echo $college; ?></td>
                    <td><?php echo $department; ?></td>
                    <td><?php echo $coursecode; ?></td>
                    <td><?php echo $coursedesc; ?></td>
                    <td>
                      <button type="button" data-toggle="modal" data-target="#updatecode<?php echo $id; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
                    </td>
                  </tr>

                  <div id="updatecode<?php echo $id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>Course Information</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:15%; ">
                          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert<?php echo $id; ?>"></div>
                        </div>
                        <div class="modal-body">
                          <form action="model/course.php" method="post">
                            <div class="form-group">
                              College
                              <input type="list" value="<?php echo $college; ?>" required list="collegeList" id="ccollege<?php echo $id; ?>" name="ccollege" class="form-control">
                            </div>
                            <div class="form-group">
                              Department
                              <input type="list" value="<?php echo $department; ?>" list="DepartmentList" required id="department<?php echo $id; ?>" name="department" class="form-control">
                            </div>
                            <div class="form-group">
                              Course Code
                              <input type="text" id="course<?php echo $id; ?>" value="<?php echo $coursecode; ?>" required name="coursecode" class="form-control">
                            </div>
                            <div class="form-group">
                              Course Description
                              <input type="text" id="desc<?php echo $id; ?>" value="<?php echo $coursedesc; ?>" required name="coursedesc" class="form-control">
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" value="<?php echo $id;?>" id="refid<?php echo $id;?>">
                          <button type="button" class="btn btn-success" name="updatecourse" id="updatecourse<?php echo $id; ?>"><span class="fa fa-sync"></span> </button>
                          <button type="button" class="btn btn-danger" id="deletecourse<?php echo $id; ?>"><span class="fa fa-trash"></span></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>

                  //Update Course
                  $("#updatecourse<?php echo $id;?>").on("click", function(){
                    $('#updatecourse<?php echo $id;?>').prop('disabled', true);
                    $("#updatecourse<?php echo $id;?>").html('<span class="fa fa-sync"></span> Updating...');
                    var data = {
                      "refid" : $('#refid<?php echo $id; ?>').val(),

                      "coursecode" : $('#course<?php echo $id; ?>').val(),
                      "coursedesc" : $('#desc<?php echo $id; ?>').val(),

                      "ccollege" : $('#ccollege<?php echo $id; ?>').val(),
                      "department" : $('#department<?php echo $id; ?>').val(),
                      "updatecourse" : "updatecourse"
                    };
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/course.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        if(data == 'updated'){
                          $('#updatecourse<?php echo $id;?>').prop('disabled', false);
                          $("#updatecourse<?php echo $id;?>").html('<span class="fa fa-sync"></span>');
                          setTimeout(function () {
                            $("#submit-alert<?php echo $id; ?>").removeClass("alert alert-warning");
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-success");
                            $('#submit-alert<?php echo $id; ?>').html("Course updated succesfully.");
                            $('#submit-alert<?php echo $id; ?>')
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "courses";
                          }, 2000);

                        }
                      }
                    });
                  });



                  //delete course
                  $("#deletecourse<?php echo $id; ?>").on("click", function(){
                    $('#updatecourse<?php echo $id;?>').prop('disabled', true);
                    $("#updatecourse<?php echo $id;?>").html('<span class="fa fa-trash"></span> Deleting...');
                    var data = {
                      "refid" : $('#refid<?php echo $id; ?>').val(),
                      "coursecode" : $('#course<?php echo $id; ?>').val(),
                      "deletecourse" : "deletecourse"
                    };
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/course.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        if(data == 'deleted'){

                          setTimeout(function () {
                            $('#updatecourse<?php echo $id;?>').prop('disabled', false);
                            $("#updatecourse<?php echo $id;?>").html('<span class="fa fa-trash"></span>');
                            $("#submit-alert<?php echo $id; ?>").removeClass("alert alert-success");
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-warning");
                            $('#submit-alert<?php echo $id; ?>').html("Data succesfully removed.");
                            $('#submit-alert<?php echo $id; ?>')
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "courses";
                          }, 2000);
                        }
                      }
                    });
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







  <!-----MODALS------->
  <div id="addCourse" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>Course Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:15%; ">
          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
        </div>
        <div class="modal-body">
          <form action="model/course.php" method="post">
            <div class="form-group">
              College
              <input type="list" required list="collegeList" id="ccollege" name="ccollege" class="form-control">
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
              </datalist>
            </div>
            <div class="form-group">
              Department
              <input type="list" list="DepartmentList" required id="department" name="department" class="form-control">
              <datalist class="" id="DepartmentList">
                <?php
                $getCourse = "SELECT college,department,course_code,course_desc FROM tbl_course GROUP BY department";
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
            <div class="form-group">
              Course Code
              <input type="text" required id="coursecode" name="coursecode" class="form-control">
            </div>
            <div class="form-group">
              Course Description
              <input type="text" required id="coursedesc" name="coursedesc" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" name="addcourse" id="addcourse">Add Course</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-----MODALS------->


  <script type="text/javascript">
  $("#addcourse").on("click", function(){

    $('#addcourse').prop('disabled', true);
    $("#addcourse").html('Adding Course...');

    var ccollege = $('#ccollege').val();
    var coursecode = $('#coursecode').val();
    var coursedesc = $('#coursedesc').val();
    var department = $('#department').val();

    if (coursecode == "" || coursedesc == "" ||ccollege == "" || department == ""){

      $('#addcourse').prop('disabled', false);
      $("#addcourse").html('Add Course');
      setTimeout(function () {
        $("#submit-alert").removeClass("alert alert-success");
        $("#submit-alert").addClass("alert alert-warning");
        $('#submit-alert').html("Incomplete Data.");
        $('#submit-alert')
        //.hide()
        .fadeIn(500)
        .delay(2000)
        .fadeOut(500);
      }, 0);
    }
    else{

      var data = {
        'ccollege': ccollege,
        'coursecode': coursecode,
        'coursedesc': coursedesc,
        'department': department,
        'addcourse': 'addcourse'
      };
      data = $(this).serialize() + "&" + $.param(data);


      $.ajax({
        type: 'POST',
        url: 'model/course.php',
        dataType : 'json',
        data: data,
        success: function (data) {
          if(data == 'exist'){
            $('#addcourse').prop('disabled', false);
            $("#addcourse").html('Add Course');

            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-success");
              $("#submit-alert").addClass("alert alert-warning");
              $('#submit-alert').html("Data existed in the database.");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(2000)
              .fadeOut(500);
            }, 0);
          }
          else{
            $('#addcourse').prop('disabled', false);
            $("#addcourse").html('Add Course');
            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-warning");
              $("#submit-alert").addClass("alert alert-success");
              $('#submit-alert').html("Command completed successfully!");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(2000)
              .fadeOut(500);
            }, 0);

            setTimeout(function () {
              location.href = "courses";
            }, 2000);
          }
        }
      });
    }

  });

  </script>


  <!-------->

  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
