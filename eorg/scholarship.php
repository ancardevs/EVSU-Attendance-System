<?php
require('layout/header.php');
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>
<!--script src="js/dtablerefresher.js"></script-->

<script>
$(document).ready(function(){
  $('#scholarship').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <button data-toggle="modal" data-target="#addScholarship" class="btn btn-primary">Add Scholarship</button>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-university"></span> Scholarship</h4>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //$getdata -> getcourses();
              $getGrants = "SELECT DISTINCT id, grant_code,grant_desc FROM tbl_scholarship";
              $result = OpenConn()->query($getGrants);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $grant_code = $row['grant_code'];
                  $grant_desc = $row['grant_desc'];
                  ?>
                  <tr>
                    <td><?php echo $grant_code; ?></td>
                    <td><?php echo $grant_desc; ?></td>
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
                              Course Code
                              <input type="text" id="grantcode<?php echo $id; ?>" value="<?php echo $grant_code; ?>" required  name="coursecode"class="form-control">
                            </div>
                            <div class="form-group">
                              Course Description
                              <input type="text" id="grantdesc<?php echo $id; ?>" value="<?php echo $grant_desc; ?>" required name="coursedesc" class="form-control">
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <input type="hidden" value="<?php echo $id;?>" id="refid<?php echo $id;?>">
                          <button type="button" class="btn btn-success" name="updategrant" id="updategrant<?php echo $id; ?>"><span class="fa fa-sync"></span> </button>
                          <button type="button" class="btn btn-danger" id="deletegrant<?php echo $id; ?>"><span class="fa fa-trash"></span></button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>

                  //Update Course
                  $("#updategrant<?php echo $id;?>").on("click", function(){
                    $('#updategrant<?php echo $id;?>').prop('disabled', true);
                    $("#updategrant<?php echo $id;?>").html('<span class="fa fa-sync"></span> Updating...');

                    var data = {
                      "refid" : $('#refid<?php echo $id; ?>').val(),

                      "grantcode" : $('#grantcode<?php echo $id; ?>').val(),
                      "grantdesc" : $('#grantdesc<?php echo $id; ?>').val(),
                      "updategrant" : "updategrant"
                    };
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/scholarship.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        if(data == 'updated'){
                          $('#updategrant<?php echo $id;?>').prop('disabled', false);
                          $("#updategrant<?php echo $id;?>").html('<span class="fa fa-sync"></span>');
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
                            location.href = "scholarships";
                          }, 2000);

                        }
                      }
                    });
                  });


                  //delete course
                  $("#deletegrant<?php echo $id; ?>").on("click", function(){
                    $('#deletegrant<?php echo $id;?>').prop('disabled', true);
                    $("#deletegrant<?php echo $id;?>").html('<span class="fa fa-trash"></span> Deleting...');
                    var data = {
                      "refid" : $('#refid<?php echo $id; ?>').val(),
                      "grantcode" : $('#grantcode<?php echo $id; ?>').val(),
                      "deletegrant" : "deletegrant"
                    };
                    data = $(this).serialize() + "&" + $.param(data);

                    $.ajax({
                      type: 'POST',
                      url: 'model/scholarship.php',
                      dataType : 'json',
                      data: data,
                      success: function (data) {
                        if(data == 'deleted'){

                          setTimeout(function () {
                            $('#deletegrant<?php echo $id;?>').prop('disabled', false);
                            $("#deletegrant<?php echo $id;?>").html('<span class="fa fa-trash"></span>');

                            $("#submit-alert<?php echo $id; ?>").removeClass("alert alert-success");
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-warning");
                            $('#submit-alert<?php echo $id; ?>').html("Data succesfully removed.");
                            $('#submit-alert<?php echo $id; ?>')
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "scholarships";
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







  <!---MODALS------->
  <div id="addScholarship" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>Scholarship Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:15%; ">
          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
        </div>
        <div class="modal-body">
          <form action="model/course.php" method="post">
            <div class="form-group">
              Grant Code
              <input type="text" required id="grantcode" name="coursecode" class="form-control">
            </div>
            <div class="form-group">
              Grant Description
              <input type="text" required id="grantdesc" name="coursedesc" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" name="addgrant" id="addgrant">Add Scholarship</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!---MODALS------->


  <script type="text/javascript">
  $("#addgrant").on("click", function(){

    $('#addgrant').prop('disabled', true);
    $("#addgrant").html('Adding Scholarship...');

    var grantcode = $('#grantcode').val();
    var grantdesc = $('#grantdesc').val();
    if (grantcode == "" || grantdesc == "") {
      $('#addgrant').prop('disabled', false);
      $("#addgrant").html('Add Scholarship');
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
      $.ajax({
        type: 'POST',
        url: 'model/scholarship.php',
        dataType : 'json',
        data: {
          grantcode: grantcode,
          grantdesc: grantdesc,
          addgrant: 'addgrant'
        },
        success: function (data) {
          if(data == 'exist'){
            $('#addgrant').prop('disabled', false);
            $("#addgrant").html('Add Scholarship');

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
            $('#addgrant').prop('disabled', false);
            $("#addgrant").html('Add Scholarship');
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
              location.href = "scholarships";
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
