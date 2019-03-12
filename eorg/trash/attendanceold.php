









<?php
require('dbconn.php');



if (is_ajax()) {
  if (isset($_POST['attendace'])) {


    $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumer']);

    $eventdetails = mysqli_real_escape_string(OpenConn(),$_POST['eventdetails']);
    $result_explode = explode('|', $eventdetails);
    $eventno = $result_explode[0];
    $eventyear = $result_explode[1];
    $eventcourse = $result_explode[2];
    $timescanned = date('Y-m-d H:i:s');
    $datetoday = date('Y/m/d');


    //Start check if the id number is a student of the campus
    $checkifstudent  = "SELECT * FROM tbl_students WHERE student_no = '$idnumber' ";
    $checkifstudentresult = OpenConn()->query($checkifstudent);

    //If Id number is verified as a student then:
    if(mysqli_num_rows($checkifstudentresult) == 1){

      //Start filter for all student --Where Event is applicable to all
      $checkall  = "SELECT * FROM tbl_events as te INNER JOIN tbl_students as ts ON te.cyear = ts.cyear WHERE te.event_no = '$eventno'
      AND te.course_code = '$eventcourse' AND te.cyear = '$eventyear' AND te.event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";
      $checkallresult = OpenConn()->query($checkall);

      //If applicable to all then:
      if(mysqli_num_rows($checkallresult) == 1){

        //check if the time-in for a specific id number is present
        $checktimein = "SELECT * FROM tbl_attendance
        WHERE student_no = '$idnumber'
        AND event_no = '$eventno'
        AND ontime_in IS NOT NULL
        AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
        $tiresult = OpenConn()->query($checktimein);


        //check if the time-out for a specific id number is present
        $checktimeout = "SELECT * FROM tbl_attendance
        WHERE student_no = '$idnumber'
        AND event_no = '$eventno'
        AND ontime_out IS NULL
        AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
        $toresult = OpenConn()->query($checktimeout);


        //check if the attendance for a specific id number is completed
        $checkatt = "SELECT * FROM tbl_attendance
        WHERE student_no = '$idnumber'
        AND event_no = '$eventno'
        AND ontime_out IS NOT NULL
        AND ontime_in IS NOT NULL AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
        $checkresult = OpenConn()->query($checkatt);



        //if time-in is not present, then execute insert time-in for a specific id number
        if(mysqli_num_rows($tiresult) == 0){
          $timein = "INSERT INTO tbl_attendance (event_no,student_no)
          VALUES('$eventno','$idnumber')";

          $inresult = OpenConn()->query($timein);
          echo json_encode('timein');
        }else{

        }

        //if time-in is present present, then execute update time-out for a specific id number
        if(mysqli_num_rows($toresult) == 1){
          $timeout = "UPDATE tbl_attendance
          SET ontime_out = '$timescanned'
          WHERE student_no = '$idnumber'
          AND ontime_out IS NULL
          AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d')";
          $outresult = OpenConn()->query($timeout);
          echo json_encode('timeout');
        }else{

        }

        //if attendace is completed, then return false, set prompt to exceed
        if(mysqli_num_rows($checkresult) == 1){
          echo json_encode('exceed');
        }else{
          echo json_encode('nodata');
        }






      }else{

      }
      //End filter for all student --Where Event is applicable to all

    }else{
      echo json_encode('notastudent');
    }
  }
}



function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}










































//-------------------------------------------------------
/*
  }*/

  //----------------------------------------------------------------------------

  /*public function getevents()
  {
  $getEvents = "select * from tbl_events";
  $result = OpenConn()->query($getEvents);

  if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $id = $row['id'];
  $event_no = $row['event_no'];
  $event_date = $row['event_date'];
  $event_name = $row['event_name'];
  $course_id = $row['course_code'];
  ?>
  <tr>
  <td>
  <?php echo $event_no; ?>
  </td>
  <td>
  <?php echo $event_name; ?>
  </td>
  <td>
  <?php echo $event_date; ?>
  </td>
  <td>
  <button type="button" class="btn btn-primary"><span class="fa fa-pen"></span></button>
  <button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
  </td>
  </tr>

  <?php
}
}
}*/

//--------------------------------------------------------------------------

/*  public function getcoursenames()
{
$getEvents = "select id,course_code,course_desc from tbl_course";
$result = OpenConn()->query($getEvents);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$course_code = $row['course_code'];
$course_name = $row['course_desc'];
?>
<option value="<?php echo $course_code; ?>"><?php echo $course_name; ?></option>
<?php
}
}
}*/







/*public function editcourses()
{
$getcourseinfo = "select id, course_code,course_desc from tbl_course";
$result = OpenConn()->query($getcourseinfo);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$id = $row['id'];
$coursecode = $row['course_code'];
$coursedesc = $row['course_desc'];
?>
<div id="updatecode<?php echo $coursecode; ?>" class="modal fade" role="dialog">
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
<input type="text" id="course<?php echo $id; ?>" value="<?php echo $coursecode; ?>" required id="coursecode" name="coursecode" id="courseNumber" class="form-control">
</div>
<div class="form-group">
Course Description
<input type="text" id="desc<?php echo $id; ?>" value="<?php echo $coursedesc; ?>" required id="coursedesc" name="coursedesc" id="courseNumber" class="form-control">
</div>

<div class="modal-footer">
<input type="hidden" value="<?php echo $id;?>" id="ref<?php echo $id;?>">
<button type="button" class="btn btn-success" name="updatecourse" id="updatecourse<?php echo $id; ?>">Update Course</button>
<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>
</div>
</div>
<script>
//Update Course
$("#updatecourse<?php echo $id;?>").click(function () {

var data = {
"coursecode" : $('#course<?php echo $id; ?>').val(),
"coursedesc" : $('#desc<?php echo $id; ?>').val(),
"id" : $('#ref<?php echo $id; ?>').val(),
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
setTimeout(function () {
$("#loadtable").load(" #loadtable");
$("#submit-alert<?php echo $id; ?>").addClass("alert alert-success");
$('#submit-alert<?php echo $id; ?>').html("Data succesfully updated.");
$('#submit-alert<?php echo $id; ?>')
.fadeIn(500)
.delay(2000)
.fadeOut(500);
}, 0);
}
}
});
});

</script>
<?php
}
}
}*/
//----------------------------------------------------------------------------







/*public function getstudents()
{
$getStudents = "select * from tbl_students";
$result = OpenConn()->query($getStudents);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$student_no = $row['student_no'];
$first_name = $row['first_name'];
$middle_name = $row['middle_name'];
$last_name = $row['last_name'];
$cyear = $row['cyear'];
$course_code = $row['course_code'];
$section = $row['section'];
$caddress = $row['caddress'];
$birthday = $row['birthday'];
$phone = $row['phone'];
$email = $row['email'];

$fullname = $first_name.' '.$last_name;
?>
<tr>
<td><?php echo $student_no; ?></td>
<td><?php echo $fullname; ?></td>
<td><?php echo $cyear; ?></td>
<td><?php echo $course_code; ?></td>
<td><?php echo $section; ?></td>

<td>
<button type="button" data-toggle="modal" data-target="#updatecode<?php echo $ccode; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
<button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
</td>
</tr
<?php
}
}
}*/


//----------------------------------------------------------------------------

/*  public function getinstructors()
{
$getStudents = "select * from tbl_teacher";
$result = OpenConn()->query($getStudents);

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$instructor_no = $row['teacher_no'];
$first_name = $row['first_name'];
$middle_name = $row['middle_name'];
$last_name = $row['last_name'];
$caddress = $row['caddress'];
$phone = $row['phone'];
$email = $row['email'];

$fullname = $first_name.' '.$last_name;
?>
<tr>
<td><?php echo $instructor_no; ?></td>
<td><?php echo $fullname; ?></td>
<td><?php echo $phone; ?></td>
<td><?php echo $email; ?></td>

<td>
<button type="button" data-toggle="modal" data-target="#updatecode<?php echo $ccode; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
<button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
</td>
</tr>
<?php
}
}
}*/

?>
