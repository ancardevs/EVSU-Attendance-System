
<?php
require('layout/header.php');

if (isset($_GET['eventid'])) {
  $idno = $_GET['eventid'];
  $name = $_GET['eventname'];
}
?>

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
          <a href="events" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Go Back</a>
        </div>

        <div style="float:right;">
          <h4><span class="fa fa-calendar"></span> Event Respondent</h4>
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
                tr.id as id,
                tr.course_year as cyear,
                tr.course_code as ccode
                FROM tbl_respondent as tr

                WHERE tr.event_no = '$idno'";

                $result1 = OpenConn()->query($getteacher1);
                if ($result1->num_rows > 0) {
                  while ($row = $result1->fetch_assoc()){
                    $id = $row["id"];
                    $cyear = $row["cyear"];
                    $ccode = $row["ccode"];

                    ?>

                  <div class="col-md-4">
                    <br>

                    <div class="" style="border:1px #a4a4a4 solid;border-radius:6px; padding:10px;">
                      <div class="">
                        <b>Year</b>
                        <input class='form-control' value="<?php echo $cyear; ?>" list='YearList' id='cyear<?php echo $id ?>' name=''/>

                        <b>Course</b>
                        <input class='form-control' value="<?php echo $ccode; ?>" list='CourseList' id='ccode<?php echo $id ?>' name=''/>


                        <div style='width:100%;height:5px;'></div>
                        <input type="hidden" id="refid<?php echo $id; ?>" name="" value="<?php echo $id; ?>">
                        <input type="hidden" id="eventid<?php echo $id; ?>" name="" value="<?php echo $idno; ?>">
                        <button type='button' title="Delete" id="removeres<?php echo $id; ?>" class='btn btn-danger' ><span class='fa fa-trash'></span></button>
                        <button type='button' title="Update" id="updateres<?php echo $id; ?>" class='btn btn-primary' ><span class='fa fa-sync'></span></button>
                        <div style='width:100%;height:5px;'></div>

                        <script type="text/javascript">
                          $("#removeres<?php echo $id; ?>").on('click',function(){

                            $('#removeres<?php echo $id ?>').prop('disabled', true);
                            $("#removeres<?php echo $id ?>").html('<span class="fa fa-trash"></span> Deleting Respondent...');

                            var data = {
                              "refid" : $('#refid<?php echo $id ?>').val(),
                              "eventid" : $('#eventid<?php echo $id ?>').val(),

                              "cyear" : $('#cyear<?php echo $id ?>').val(),
                              "ccode" : $('#ccode<?php echo $id ?>').val(),

                              "deleterespondent": 'deleterespondent'
                            }
                            data = $(this).serialize() + "&" + $.param(data);

                            $.ajax({
                              type: 'POST',
                              url: 'model/respondent.php',
                              dataType : 'json',
                              data: data,
                              success: function (data) {

                                if (data=="deleted") {
                                  $('#removeres<?php echo $id ?>').prop('disabled', false);
                                  $("#removeres<?php echo $id ?>").html('<span class="fa fa-trash"></span>');

                                  setTimeout(function () {
                                    $("#submit-alert").addClass("alert alert-warning");
                                    $('#submit-alert').html("Respondent Removed successfully!");
                                    $('#submit-alert')
                                    //.hide()
                                    .fadeIn(500)
                                    .delay(5000)
                                    .fadeOut(500);
                                  }, 0);

                                  setTimeout(function () {
                                    location.href = "respondent.php?eventid=<?php echo $idno; ?>&eventname=<?php echo $name ?>";
                                  }, 2000);
                                }

                              }
                            })
                          });



                          $("#updateres<?php echo $id; ?>").on('click',function(){
                            $('#updatead<?php echo $id ?>').prop('disabled', true);
                            $("#updatead<?php echo $id ?>").html('<span class="fa fa-sync"></span> Updating Respondent...');

                            var data = {
                              "refid" : $('#refid<?php echo $id ?>').val(),
                              "eventid" : $('#eventid<?php echo $id ?>').val(),

                              "cyear" : $('#cyear<?php echo $id ?>').val(),
                              "ccode" : $('#ccode<?php echo $id ?>').val(),
                              "updaterespondent": 'updaterespondent'
                            }
                            data = $(this).serialize() + "&" + $.param(data);

                            $.ajax({
                              type: 'POST',
                              url: 'model/respondent.php',
                              dataType : 'json',
                              data: data,
                              success: function (data) {

                                if (data=="updated") {
                                  $('#updatead<?php echo $id ?>').prop('disabled', false);
                                  $("#updatead<?php echo $id ?>").html('<span class="fa fa-sync"></span>');

                                  setTimeout(function () {
                                    $("#submit-alert").removeClass("alert alert-warning");
                                    $("#submit-alert").addClass("alert alert-success");
                                    $('#submit-alert').html("Respondent Updated successfully!");
                                    $('#submit-alert')
                                    //.hide()
                                    .fadeIn(500)
                                    .delay(5000)
                                    .fadeOut(500);
                                  }, 0);

                                  setTimeout(function () {
                                    location.href = "respondent.php?eventid=<?php echo $idno; ?>&eventname=<?php echo $name ?>";
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
                      <h5>No Event Respondent</h5>
                    </div>
                  </div>
                <?php
              }
              ?>
            </div>
            <datalist class="" id="YearList">
              <option value="All"></option>
                <option value="First Year"></option>
                <option value="Second Year"></option>
                <option value="Third Year"></option>
                <option value="Fourth Year"></option>
            </datalist>
            <hr>
            <button type="button" id="addAdvisory" style="border-radius:0px;" class="btn btn-primary" id="addAdvisory" ><span class="fa fa-plus"></span> Add Respondent</button>
            <br><br>

            <div id="ContentDiv" class="form-row"></div>


            <datalist class="" id="CourseList">
              <option value="All"></option>

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
      <div class="card-footer small text-muted" ><button style="float:right;" class="btn btn-info" type="button" id="newRespondent" name="button">Add to Respondent</button> </div>
    </div>
  </div>


  <script type="text/javascript">

  var arrayresp = new Array();

  var intCourse=0;
  var intYear=0;



  $("#newRespondent").on('click',function() {

    for(x=1; x<=intCourse; x++){
      var ccourse = $('#TxtCourse' + x).val();
      var cyear = $('#TxtYear' + x).val();
      arrayresp.push({myyear : cyear,mycourse : ccourse});
    }


      $('#newRespondent').prop('disabled', true);
      $("#newRespondent").html('Adding Respondent...');

      var data = {
        "refid" : $('#insid').val(),
        "eventresp":JSON.stringify(arrayresp),
        "addnewresp" : "addnewresp"
      };

      data = $(this).serialize() + "&" + $.param(data);



      $.ajax({
        type: 'POST',
        url: 'model/respondent.php',
        dataType : 'json',
        data: data,
        success: function (data) {
          if (data=="saved") {
            $('#newRespondent').prop('disabled', false);
            $("#newRespondent").html('<span class="fa fa-trash"></span>');

            setTimeout(function () {
              $("#submit-alert").removeClass("alert alert-warning");
              $("#submit-alert").addClass("alert alert-success");
              $('#submit-alert').html("Respondent that are left blank and will not be saved");
              $('#submit-alert')
              //.hide()
              .fadeIn(500)
              .delay(3000)
              .fadeOut(500);
            }, 0);

            setTimeout(function () {
              location.href = "respondent.php?eventid=<?php echo $idno; ?>&eventname=<?php echo $name ?>";
            }, 2000);
          }
        }
      });







  });


  //------------------------------------------------------


  $("#addAdvisory").on("click",function(){
    intCourse = intCourse + 1;
    intYear= intYear + 1;

    var contentID = document.getElementById('ContentDiv');
    var newTBDiv = document.createElement('div');
    newTBDiv.setAttribute('id','Hosp'+intCourse);
    newTBDiv.setAttribute('class','col-md-3');
    newTBDiv.setAttribute('title','Remove');
    newTBDiv.setAttribute('style','border:1px #a4a4a4 solid;border-radius:6px;  margin-bottom:10px;');
    newTBDiv.innerHTML = "<b>Year</b> <input class='form-control' list='YearList' id='TxtYear" + intYear + "' name='TxtYear" + intYear + "'/> " +
    "<b>Course</b> <input class='form-control' list='CourseList' id='TxtCourse" + intCourse + "' name='TxtCourse" + intCourse + "'/> " +
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
      intYear = intYear-1;
    }
    arraycs.length = 0;
  }

  </script>








  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
