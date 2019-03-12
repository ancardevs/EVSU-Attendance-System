

<option id="refid<?php echo $id;?>" value="{'eventyear':<?php echo $cyear ?>,'eventcourse':<?php echo $course_code ?>}"><?php echo $event_no; ?> | <?php echo $event_name; ?> | <?php echo $event_date; ?></option>

$obj = json_decode($eventdetails);
echo $obj->course_code; //prints 1
echo $obj->name; //prints foo


//End filter for all student



/*$checkall  = "SELECT * FROM tbl_events WHERE course_code = '0' AND cyear = '0' AND event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";
$checkallresult = OpenConn()->query($checkall);

if(mysqli_num_rows($checkallresult) == 1){
  //check if the time-in for a specific id number is present
  $checktimein = "SELECT * FROM tbl_attendance
  WHERE student_no = '$idnumber'
  AND event_no = '$eventno'
  AND ontime_in IS NOT NULL
  AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
  $tiresult = OpenConn()->query($checktimein);

  //check if the time-ot for a specific id number is present
  $checktimeout = "SELECT * FROM tbl_attendance
  WHERE student_no = '$eventno'
  AND event_no = '$eventno'
  AND ontime_out IS NULL
  AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
  $toresult = OpenConn()->query($checktimeout);

  //check if the attendance for a specific id number is completed
  $checkatt = "SELECT * FROM tbl_attendance
  WHERE student_no = '$eventno'
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
    WHERE student_no = '$eventno'
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

  }

}else{
  echo json_encode('avfalse');
}





*/

/*  $checkav = "SELECT ts.student_no,ts.course_code,ts.cyear FROM tbl_students as ts
INNER JOIN tbl_events as te
ON te.course_code = ts.course_code
WHERE te.event_date = DATE_FORMAT(NOW(),'%Y/%m/%d')
AND ts.student_no = '$id'";

$avresult = OpenConn()->query($checkav);

//if the id number is a respondent then check the time-in and time-out for attendance
if(mysqli_num_rows($avresult) == 1){

  //check if the time-in for a specific id number is present
  $checktimein = "SELECT * FROM tbl_attendance
  WHERE student_no = '$id'
  AND event_no = '$eventno'
  AND ontime_in IS NOT NULL
  AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
  $tiresult = OpenConn()->query($checktimein);

  //check if the time-ot for a specific id number is present
  $checktimeout = "SELECT * FROM tbl_attendance
  WHERE student_no = '$id'
  AND event_no = '$eventno'
  AND ontime_out IS NULL
  AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
  $toresult = OpenConn()->query($checktimeout);

  //check if the attendance for a specific id number is completed
  $checkatt = "SELECT * FROM tbl_attendance
  WHERE student_no = '$id'
  AND event_no = '$eventno'
  AND ontime_out IS NOT NULL
  AND ontime_in IS NOT NULL AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
  $checkresult = OpenConn()->query($checkatt);

  //if time-in is not present, then execute insert time-in for a specific id number
  if(mysqli_num_rows($tiresult) == 0){
    $timein = "INSERT INTO tbl_attendance (event_no,student_no)
    VALUES('$eventno','$id')";

    $inresult = OpenConn()->query($timein);
    echo json_encode('timein');
  }else{

  }

  //if time-in is present present, then execute update time-out for a specific id number
  if(mysqli_num_rows($toresult) == 1){
    $timeout = "UPDATE tbl_attendance
    SET ontime_out = '$timeoutdate'
    WHERE student_no = '$id'
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

  }


}*/

//if the id number is not a respondent then return false
