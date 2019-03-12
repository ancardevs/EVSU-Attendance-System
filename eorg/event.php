<?php
require('layout/header.php');
require('model/data.class.php');
$getdata = new getData();
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
          <button data-toggle="modal" data-target="#addEvent" class="btn btn-primary">Add Event</button>
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
                <th>Code</th>
                <th>Organizer</th>
                <th>Name</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if($_SESSION['role'] == "Administrator"){
                $sessionuserid = $_SESSION['idno'];
                $getEvents = "SELECT DISTINCT te.id,
                  te.organizer as college,
                  te.event_no AS event_no,
                  te.event_date AS event_date,
                  te.event_name AS event_name,
                  te.event_venue AS event_venue,
                  te.event_cover AS event_cover,

                  te.event_description AS event_description,
                  te.login_time AS login_time,

                  te.logout_time AS logout_time

                FROM tbl_events as te
                
                ";
              }else{
                $sessionuserid = $_SESSION['idno'];
                $getEvents = "SELECT DISTINCT te.id,
        				  tc.college as college,
                  te.event_no AS event_no,
                  te.event_date AS event_date,
                  te.event_name AS event_name,
                  te.event_venue AS event_venue,
                  te.event_cover AS event_cover,

                  te.event_description AS event_description,
                  te.login_time AS login_time,

                  te.logout_time AS logout_time

                FROM tbl_events as te
                INNER JOIN tbl_college as tc
                on te.organizer = tc.id_no
                WHERE te.organizer = '$sessionuserid'";
              }


              $result = OpenConn()->query($getEvents);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $event_no = $row['event_no'];
                  $college = $row['college'];
                  $event_date = $row['event_date'];
                  $event_cover = $row['event_cover'];

                  $event_venue = $row['event_venue'];

                  $event_name = $row['event_name'];

                  $eventdesc = $row['event_description'];
                  $login = $row['login_time'];
                  $logout = $row['logout_time'];

                  ?>
                  <tr>
                    <td><?php echo $event_no; ?></td>
                    <td><?php echo $college; ?></td>
                    <td><?php echo $event_name; ?></td>
                    <td><?php echo $event_date; ?></td>
                    <td>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateeventmodal<?php echo $id;?>"><span class="fa fa-pen"></span></button>
                    </td>
                  </tr>


                  <!---MODAL----->
                  <div id="updateeventmodal<?php echo $id;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4>Event Information</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
                          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert<?php echo $id; ?>" class=""></div>
                        </div>


                        <div class="modal-body">
                          <form action="model/event.php" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                              <div class="form-group col-md-3">
                                Event Number
                                <input id="eventno<?php echo $id; ?>" disabled type="text" class="form-control" value="<?php echo $event_no;?>">
                              </div>
                              <div class="form-group col-md-3">
                                Event Date
                                <input type="date" value="<?php echo date('Y-m-d',strtotime($event_date)); ?>" required id="eventdate<?php echo $id; ?>" name="eventdate" class="form-control">
                              </div>
                              <div class="form-group col-md-3">
                                Log-in
                                <input type="time" required id="eventlogin<?php echo $id; ?>" value="<?php echo $login; ?>" name="eventlogin" class="form-control">
                              </div>
                              <div class="form-group col-md-3">
                                Log-out
                                <input type="time" required id="eventlogout<?php echo $id; ?>" value="<?php echo $logout; ?>" name="eventlogout" class="form-control">
                              </div>

                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                Event Venue
                                <input type="text" value="<?php echo $event_venue; ?>" required id="eventvenue<?php echo $id; ?>" name="eventvenue" class="form-control" >
                              </div>
                              <div class="form-group col-md-6">
                                Event Name
                                <input type="text" id="eventname<?php echo $id; ?>" class="form-control" value="<?php echo $event_name;?>" >
                              </div>

                            </div>
                            <style media="screen">
                              #ContentDiv::-webkit-scrollbar {
                                width: 6px;
                              }
                              #ContentDiv::-webkit-scrollbar-thumb {
                                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
                              }
                            </style>

                            <div class="form-group">
                              Event Description
                              <textarea name="eventdesc" id="eventdesc<?php echo $id; ?>" class="form-control"rows="5"><?php echo $eventdesc;?></textarea>
                            </div>

                            <div class="form-row">
                              Image <br>
                              <div class="form-group col-md-12" style="text-align:center;">
                                <img style="width:100%; height:auto;" src="img/events/<?php echo $event_cover; ?>" alt="">
                              </div>

                              <!--div class="form-group col-md-6">
                                Select Respondent - <i style="font-size:12px;color:indianred;">Leave blank to add custom respondent</i>
                                <select name="" id="updrresp" class="form-control">
                                  <option value="<?php //echo $respondent; ?>"><?php //echo $respondent; ?></option>
                                  <option value="">All Colleges</option>
                                  <option value="{}">First Year</option>
                                  <option value="{}">Second Year</option>
                                  <option value="{}">Third Year</option>
                                  <option value="{}">Fourth Year</option>
                                </select>
                              </div-->
                            </div>

                            <hr>
                            <div class="form-row">
                              <div class="resps form-group col-md-12">
                                <a href="respondent.php?eventid=<?php echo $event_no; ?>&eventname=<?php echo $event_name ?>" style="border-radius:0px;" class="btn btn-primary">
                                  <span class="fa fa-list"></span> View Event Respondents
                                </a>
                              </div>
                            </div>

                        </div>




                        <div class="modal-footer">
                          <input type="hidden" name="refid" value="<?php echo $event_no; ?>" id="refid<?php echo $event_no; ?>">
                          <button type="button" class="btn btn-success" name="updateevent" id="updateevent<?php echo $id ?>"><span class="fa fa-sync"></span> </button>
                          <button type="button" class="btn btn-danger" name="deleteevent" id="deleteevent<?php echo $id ?>"><span class="fa fa-trash"></span></button>
                        </div>
                      </div>
                    </div>
                  </div>


                  <script type="text/javascript">

                      $("#updateevent<?php echo $id ?>").on("click", function(){

                      $('#updateevent<?php echo $id ?>').prop('disabled', true);
                      $("#updateevent<?php echo $id ?>").html('<span class="fa fa-sync"></span> Updating Event...');


                      var data = {
                        "refid" : $('#refid<?php echo $event_no; ?>').val(),

                        "eventno" : $('#eventno<?php echo $id ?>').val(),
                        "eventdate" : $('#eventdate<?php echo $id; ?>').val(),
                        "eventlogin" : $('#eventlogin<?php echo $id ?>').val(),
                        "eventlogout" : $('#eventlogout<?php echo $id ?>').val(),
                        "eventname" : $('#eventname<?php echo $id ?>').val(),
                        "eventvenue" : $('#eventvenue<?php echo $id ?>').val(),


                        "eventdesc" : $('#eventdesc<?php echo $id ?>').val(),
                        "updateevent": 'updateevent'
                      }
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/event.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                          $('#updateevent<?php echo $id ?>').prop('disabled', false);
                          $("#updateevent<?php echo $id ?>").html('<span class="fa fa-sync"></span>');

                          setTimeout(function () {
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-success");
                            $('#submit-alert<?php echo $id; ?>').html("Event Updated successfully!");
                            $('#submit-alert<?php echo $id; ?>')
                            //.hide()
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "events";
                          }, 2000);

                        }
                      })
                    });


                    $("#deleteevent<?php echo $id ?>").on("click", function(){
                      $('#deleteevent<?php echo $id ?>').prop('disabled', true);
                      $("#deleteevent<?php echo $id ?>").html('<span class="fa fa-trash"></span> Deleting Event...');
                      var data = {
                        "refid" : $('#refid<?php echo $event_no ?>').val(),
                        "deleteevent": 'deleteevent'
                      }
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/event.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                          $('#deleteevent<?php echo $id ?>').prop('disabled', false);
                          $("#deleteevent<?php echo $id ?>").html('<span class="fa fa-trash"></span>');

                          setTimeout(function () {
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-warning");
                            $('#submit-alert<?php echo $id; ?>').html("Event Removed successfully!");
                            $('#submit-alert<?php echo $id; ?>')
                            //.hide()
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "events";
                          }, 2000);

                        }
                      })
                    });



                      //UPDATING Events
                      $("#cusrespondent<?php echo $id ?>").on("click",function(){
                        $('select').val('');

                        intCourse = intCourse + 1;
                        intYear = intYear + 1;

                        var contentID = document.getElementById('ContentDiv<?php echo $id ?>');
                        var newTBDiv = document.createElement('div');
                        newTBDiv.setAttribute('id','UpdE'+intCourse);
                        newTBDiv.setAttribute('class','col-md-4');
                        newTBDiv.setAttribute('title','Remove');
                        newTBDiv.setAttribute('style','border:1px #a4a4a4 solid; border-radius:6px;  margin-bottom:10px;');
                        newTBDiv.innerHTML = "<b>Course</b> <input class='form-control' list='CourseList' id='TxtCourse" + intCourse + "' name='TxtCourse" + intCourse + "'/> " +
                        "<b>Year</b> <input type='text' class='form-control' id='TxtYear" + intYear + "' name='TxtYear" + intYear + "'/> " +
                        "<div style='width:100%;height:5px;'></div>"+
                        "<button type='button' class='btn btn-danger' onclick='removeElement(\"" + intCourse + "\")'><span class='fa fa-trash'></span></button><div style='width:100%;height:5px;'></div>";
                        contentID.appendChild(newTBDiv);
                      });


                      $("#upbtnimg").click(function () {
                        $('#upfileimage').click();
                      });

                      $("#upfileimage").change(function() {
                        var filePath=$('#upfileimage').val();
                        $("#upbtnimg").html("<span class='fa fa-image'></span> "+ filePath.substring(12));
                      });

                      $('#updrresp').on('change', function (e) {
                          var myNode = document.getElementById("ContentDiv<?php //echo $id ?>");
                          while (myNode.firstChild) {
                              myNode.removeChild(myNode.firstChild);
                          }
                          intCourse = intCourse-1;
                          intYear = intYear-1;

                          arrayresp.length = 0;
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


  <!--MODALS---->
  <div id="addEvent" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4>Event Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
          <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
        </div>

        <div class="modal-body">
          <form action="model/event.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group col-md-3">
                Event Number
                <div id="loadid">
                  <?php
                  $getdata -> geteventid();
                  ?>
                </div>
              </div>
              <div class="form-group col-md-3">
                Event Date
                <input type="date" required id="eventdate" name="eventdate" class="form-control">
              </div>
              <div class="form-group col-md-3">
                Log-in
                <input type="time" required id="eventlogin" name="eventlogin" class="form-control">
              </div>
              <div class="form-group col-md-3">
                Log-out
                <input type="time" required id="eventlogout" name="eventlogout" class="form-control">
              </div>

            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                Event Venue
                <input type="text" required id="eventvenue" name="eventvenue" class="form-control" >
              </div>
              <div class="form-group col-md-6">
                Event Name
                <input type="text" required id="eventname" name="eventname" class="form-control" >
              </div>

            </div>
            <style media="screen">
              #ContentDiv::-webkit-scrollbar {
                width: 6px;
              }
              #ContentDiv::-webkit-scrollbar-thumb {
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
              }
            </style>

            <div class="form-group">
              Event Description
              <textarea name="eventdesc" id="eventdesc" class="form-control"rows="3"></textarea>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                Organizer <br>
                <?php if ($_SESSION['role'] == "Administrator"): ?>
                  <input type="list" list="OrganizerList" class="form-control" required name="organizer" id="organizer">
                <?php else: ?>
                  <input type="text" class="form-control" value="<?php echo $_SESSION['idno']; ?>" disabled required name="organizer" id="organizer">
                <?php endif; ?>

              </div>
              <div class="form-group col-md-6">
                Image <br>
                <input type="file" required name="image" id="fileimage" accept="image/*">
              </div>


            </div>

            <hr>
            <div class="form-row">
              <div class="resps form-group col-md-12">
                <button type="button" style="border-radius:0px;" class="btn btn-primary" id="cusrespondent" >
                  <span class="fa fa-plus"></span> Add Custom Respondent</button>
                <br><br>
                <div id="ContentDiv"  class="resp1 form-row"></div>

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

        <div class="modal-footer">
          <input type="hidden" required name="erespondent" id="erespondent" value="">

          <button type="button" class="btn btn-success" name="checkadd" id="checkadd">Add Event</button>
          <button type="submit" style="display:none;" class="btn btn-success" name="addevent" id="addevent">Add Event</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>

    </div>
  </div>
  <!--MODALS-->
</div>

<datalist class="" id="YearList">
    <option value="All"></option>
    <option value="First Year"></option>
    <option value="Second Year"></option>
    <option value="Third Year"></option>
    <option value="Fourth Year"></option>
</datalist>

<datalist class="" id="OrganizerList">
  <?php
  $getOrg = "SELECT
      tcol.id_no AS orgno,
      tcol.college AS college,
      te.organizer AS tcol
  FROM
      tbl_college as tcol
      LEFT JOIN tbl_events as te
      ON te.organizer = tcol.id_no GROUP BY tcol.id_no";
  $result = OpenConn()->query($getOrg);

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $college = $row['college'];
          $orgno = $row['orgno'];
          ?>
          <option value="<?php echo $orgno; ?>"><?php echo $college; ?></option>
      <?php
      }
  }
  ?>
</datalist>





  <script>

  var arrayresp = new Array();

  var intCourse=0;
  var intYear=0;


    $("#addevent").click(function () {
      $('#checkadd').prop('disabled', true);
      $("#checkadd").html('Adding Event...');
    });



  $("#checkadd").click(function () {
    if ($('#eventno').val() == "" ||
      $('#eventname').val() == "" ||
      $('#organizer').val() == "" ||
      $('#eventdate').val() == "" ||
      $('#eventvenue').val() == "" ||
      $('#image').val() == "" ||
      $('#eventvenue').val() == "" ||
      $('#eventlogin').val() == "" ||
      $('#eventlogout').val() == "" ||
      $('#eventdesc').val() == "") {
        arrayresp.length = 0;
        setTimeout(function () {
          $("#submit-alert").removeClass("alert alert-success");
          $("#submit-alert").addClass("alert alert-warning");
          $('#submit-alert').html("Please fill all required fiels!");
          $('#submit-alert')
          //.hide()
          .fadeIn(500)
          .delay(2000)
          .fadeOut(500);
        }, 0);

    }else{

      if ($('#erespondent').val() == "") {
        for(x=1; x<=intCourse; x++){
         var ccourse = $('#TxtCourse' + x).val();
         var cyear = $('#TxtYear' + x).val();
         //arrayresp.length = 0;
         arrayresp.push({mycourse : ccourse, myyear : cyear})
       }
       $('#erespondent').val(JSON.stringify(arrayresp));
     }else{

     }
      $('#addevent').click();
    }
  });





  //-----------------FUNCTION TO ADD TEXT BOX ELEMENT ADDING EVENTS

  $("#cusrespondent").on("click",function(){
    $('select').val('');

    intCourse = intCourse + 1;
    intYear = intYear + 1;

    var contentID = document.getElementById('ContentDiv');
    var newTBDiv = document.createElement('div');
    newTBDiv.setAttribute('id','AddE'+intCourse);
    newTBDiv.setAttribute('class','col-md-4');
    newTBDiv.setAttribute('title','Remove');
    newTBDiv.setAttribute('style','border:1px #a4a4a4 solid; border-radius:6px;  margin-bottom:10px;');
    newTBDiv.innerHTML = "<b>Course</b> <input class='form-control' list='CourseList' id='TxtCourse" + intCourse + "' name='TxtCourse" + intCourse + "'/> <div style='width:100%;height:5px;'></div>" +
    "<b>Year</b> <input type='list' list='YearList' class='form-control' id='TxtYear" + intYear + "' name='TxtYear" + intYear + "'/> <div style='width:100%;height:5px;'></div>" +
    "<div style='width:100%;height:5px;'></div>"+
    "<button type='button' class='btn btn-danger' onclick='removeElement(\"" + intCourse + "\")'><span class='fa fa-trash'></span></button><div style='width:100%;height:5px;'></div>";
    contentID.appendChild(newTBDiv);

    $('#erespondent').val("");
  });


  //FUNCTION TO REMOVE TEXT BOX ELEMENT
  function removeElement(id)
  {
    if(intCourse != 0)
    {
      var contentID = document.getElementById('ContentDiv');
      //alert(contentID);
      contentID.removeChild(document.getElementById('AddE'+id));
      intCourse = intCourse-1;
      intYear = intYear-1;
    }

  }
  //------------------FOR ADDING EVENTS





















  /*$('#drresp').on('change', function (e) {
      var myNode = document.getElementById("ContentDiv");
      while (myNode.firstChild) {
          myNode.removeChild(myNode.firstChild);
      }
      intCourse = 0;
      intYear = 0;

      $('#erespondent').val($('#drresp').val());

  });*/




  </script>



  <!-- /.container-fluid -->
  <?php require('layout/footer.php'); ?>
