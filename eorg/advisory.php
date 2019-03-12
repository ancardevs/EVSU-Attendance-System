
<?php
require('layout/header.php');

if (isset($_GET['instructorid'])) {
  $idno = $_GET['instructorid'];
  $name = $_GET['instructorname'];
  $role = $_GET['role'];
}
?>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="js/custom.js"></script>

<script>
$(document).ready(function(){
  $('#instructors').addClass('nav-item active')
});
</script>

<div id="content-wrapper">

  <div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <div style="float:left;">
          <?php
            if ($role == 'instructor') {
              ?>
               <a href="settings" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Go Back</a>
              <?php
            }else{
              ?>
              <a href="instructors" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Go Back</a>
              <?php
            }

           ?>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-chalkboard-teacher"></span> Advisory List</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <div class="col-md-12" style="background:white;">


            <h4><?php echo $name; ?>  </h4>
            <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:20%; ">
              <div style="display:block; right:180px; margin: 0 auto; width:400px;" id="submit-alert" class=""></div>
            </div>
            <div class="row">

              <!----------------------------------------------------------------------------------->
              <?php

                $getteacher1 = "SELECT
                tad.id as id,
                tad.course_year as cyear,
                tad.course_code as ccode,
                tad.section as section
                FROM tbl_advisory as tad

                WHERE tad.teacher_no = '$idno'";

                $result1 = OpenConn()->query($getteacher1);
                if ($result1->num_rows > 0) {
                  while ($row = $result1->fetch_assoc()){
                    $id = $row["id"];
                    $cyear = $row["cyear"];
                    $ccode = $row["ccode"];
                    $csection = $row["section"];
                    ?>

                  <div class="col-md-4">
                    <br>

                    <div class="" style="border:1px #a4a4a4 solid;border-radius:6px; padding:10px;">
                      <div class="">
                        <b>Year</b>
                        <input class='form-control' value="<?php echo $cyear; ?>" list='YearList' id='cyear<?php echo $id ?>' name=''/>

                        <b>Course</b>
                        <input class='form-control' value="<?php echo $ccode; ?>" list='CourseList' id='ccode<?php echo $id ?>' name=''/>

                        <b>Section</b>
                        <input type='text' class='form-control' value="<?php echo $csection; ?>" id='csection<?php echo $id ?>' name=''/>

                        <div style='width:100%;height:5px;'></div>
                        <input type="hidden" id="refid<?php echo $id; ?>" name="" value="<?php echo $id; ?>">
                        <button type='button' title="Delete" id="removead<?php echo $id; ?>" class='btn btn-danger' ><span class='fa fa-trash'></span></button>
                        <button type='button' title="Update" id="updatead<?php echo $id; ?>" class='btn btn-primary' ><span class='fa fa-sync'></span></button>
                        <div style='width:100%;height:5px;'></div>

                        <script type="text/javascript">

                          $("#removead<?php echo $id; ?>").on('click',function(){
                            $('#removead<?php echo $id ?>').prop('disabled', true);
                            $("#removead<?php echo $id ?>").html('<span class="fa fa-trash"></span> Deleting Advisory...');

                            var data = {
                              "refid" : $('#refid<?php echo $id ?>').val(),
                              "idnumber" : $('#insid').val(),

                              "cyear" : $('#cyear<?php echo $id ?>').val(),
                              "ccode" : $('#ccode<?php echo $id ?>').val(),
                              "csection" : $('#csection<?php echo $id ?>').val(),
                              "deleteadvisory": 'deleteadvisory'
                            }
                            data = $(this).serialize() + "&" + $.param(data);

                            $.ajax({
                              type: 'POST',
                              url: 'model/advisory.php',
                              dataType : 'json',
                              data: data,
                              success: function (data) {

                                if (data=="deleted") {
                                  $('#removead<?php echo $id ?>').prop('disabled', false);
                                  $("#removead<?php echo $id ?>").html('<span class="fa fa-trash"></span>');

                                  setTimeout(function () {
                                    $("#submit-alert").addClass("alert alert-warning");
                                    $('#submit-alert').html("Advisory Removed successfully!");
                                    $('#submit-alert')
                                    //.hide()
                                    .fadeIn(500)
                                    .delay(5000)
                                    .fadeOut(500);
                                  }, 0);

                                  setTimeout(function () {
                                    location.href = "advisory.php?instructorid=<?php echo $idno; ?>&instructorname=<?php echo $name; ?>&role=<?php echo $role; ?>";
                                  }, 2000);
                                }

                              }
                            })
                          });


                          $("#updatead<?php echo $id; ?>").on('click',function(){
                            $('#updatead<?php echo $id ?>').prop('disabled', true);
                            $("#updatead<?php echo $id ?>").html('<span class="fa fa-sync"></span> Deleting Advisory...');

                            var data = {
                              "refid" : $('#refid<?php echo $id ?>').val(),
                              "idnumber" : $('#insid').val(),

                              "cyear" : $('#cyear<?php echo $id ?>').val(),
                              "ccode" : $('#ccode<?php echo $id ?>').val(),
                              "csection" : $('#csection<?php echo $id ?>').val(),
                              "updateadvisory": 'updateadvisory'
                            }
                            data = $(this).serialize() + "&" + $.param(data);

                            $.ajax({
                              type: 'POST',
                              url: 'model/advisory.php',
                              dataType : 'json',
                              data: data,
                              success: function (data) {

                                if (data=="updated") {
                                  $('#updatead<?php echo $id ?>').prop('disabled', false);
                                  $("#updatead<?php echo $id ?>").html('<span class="fa fa-sync"></span>');

                                  setTimeout(function () {
                                    $("#submit-alert").removeClass("alert alert-warning");
                                    $("#submit-alert").addClass("alert alert-success");
                                    $('#submit-alert').html("Advisory Updated successfully!");
                                    $('#submit-alert')
                                    //.hide()
                                    .fadeIn(500)
                                    .delay(5000)
                                    .fadeOut(500);
                                  }, 0);

                                  setTimeout(function () {
                                    location.href = "advisory.php?instructorid=<?php echo $idno; ?>&instructorname=<?php echo $name; ?>&role=<?php echo $role; ?>";
                                  }, 2000);
                                }

                              }
                            })
                          });
                        </script>
                      </div>
                    </div>

                    <br>
                  </div>
                  <?php
                }
              }else{
                ?>
                  <div class="col-md-12">
                    <div class="alert alert-info">
                      <h5>No current Advisory</h5>
                    </div>
                  </div>
                <?php
              }
              ?>
            </div>
            <datalist class="" id="YearList">
                <option value="First Year"></option>
                <option value="Second Year"></option>
                <option value="Third Year"></option>
                <option value="Fourth Year"></option>
            </datalist>
            <hr>
            <button type="button" id="addAdvisory" style="border-radius:0px;" class="btn btn-primary" id="addAdvisory" ><span class="fa fa-plus"></span> Add Advisory / Handled Class</button>
            <br><br>

              <div id="ContentDiv" class="form-row"></div>


            <datalist class="" id="CourseList">
              <?php
              $getCourses = "SELECT DISTINCT id, course_code,course_desc FROM tbl_course";
              $result = OpenConn()->query($getCourses);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $course_code = $row['course_code'];
                  $course_desc = $row['course_desc'];
                  ?>
                  <option value="<?php echo $course_code; ?>"><?php echo $course_desc; ?></option>
                  <?php
                }
              }
               ?>
            </datalist>
          </div>
        </div>
      </div>
      <input type="hidden" name="" id="insid" value="<?php echo $idno; ?>">
      <div class="card-footer small text-muted" ><button style="float:right;" class="btn btn-info" type="button" id="newAdvisory" name="button">Add to advisory</button> </div>
    </div>
  </div>


  <script type="text/javascript">

  var arraycs = new Array();

  var intCourse=0;
  var intSection=0;
  var intYear=0;

  $("#newAdvisory").on('click',function() {

    for(x=1; x<=intCourse; x++){
      var ccourse = $('#TxtCourse' + x).val();
      var csection = $('#TxtSection' + x).val();
      var cyear = $('#TxtYear' + x).val();
      arraycs.push({myyear : cyear,mycourse : ccourse, mysection : csection});
    }

      $('#newAdvisory').prop('disabled', true);
      $("#newAdvisory").html('Adding Advisory...');

      var data = {
        "idnumber" : $('#insid').val(),
        "coursesec":JSON.stringify(arraycs),
        "newadvisory" : "newadvisory"
      };

      data = $(this).serialize() + "&" + $.param(data);

      $.ajax({
        type: 'POST',
        url: 'model/advisory.php',
        dataType : 'json',
        data: data,
        success: function (data) {

          if (data=="saved") {
            $('#removead').prop('disabled', false);
            $("#removead").html('<span class="fa fa-trash"></span>');

            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-warning");
              $("#submit-alert").addClass("alert alert-success");
              $('#submit-alert').html("Command completed successfully! Incomplete advisory information will not be save.");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(5000)
              .fadeOut(500);
            }, 0);

            setTimeout(function () {
              location.href = "advisory.php?instructorid=<?php echo $idno; ?>&instructorname=<?php echo $name; ?>&role=<?php echo $role; ?>";
            }, 2000);
          }
        }


      });

  });


  //------------------------------------------------------


  $("#addAdvisory").on("click",function(){
    intCourse = intCourse + 1;
    intSection = intSection + 1;
    intYear= intYear + 1;

    var contentID = document.getElementById('ContentDiv');
    var newTBDiv = document.createElement('div');
    newTBDiv.setAttribute('id','Hosp'+intCourse);
    newTBDiv.setAttribute('class','col-md-3');
    newTBDiv.setAttribute('title','Remove');
    newTBDiv.setAttribute('style','border:1px #a4a4a4 solid;border-radius:6px;  margin-bottom:10px;');
    newTBDiv.innerHTML = "<b>Year</b> <input class='form-control' list='YearList' id='TxtYear" + intYear + "' name='TxtYear" + intYear + "'/> " +
    "<b>Course</b> <input class='form-control' list='CourseList' id='TxtCourse" + intCourse + "' name='TxtCourse" + intCourse + "'/> " +
    "<b>Section</b> <input type='text' class='form-control' id='TxtSection" + intSection + "' name='TxtSection" + intSection + "'/> " +
    "<div style='width:100%;height:5px;'></div>"+
    "<button type='button' class='btn btn-danger' onclick='removeElement(\"" + intCourse + "\")'><span class='fa fa-trash'></span></button><div style='width:100%;height:5px;'></div>";
    contentID.appendChild(newTBDiv);
  });




  //FUNCTION TO REMOVE TEXT BOX ELEMENT
  function removeElement(id)
  {
    if(intCourse != 0)
    {
      var contentID = document.getElementById('ContentDiv');
      //alert(contentID);
      contentID.removeChild(document.getElementById('Hosp'+id));
      intCourse = intCourse-1;
      intSection = intSection-1;
      intYear = intYear-1;
    }
    arraycs.length = 0;
  }

  </script>








  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
