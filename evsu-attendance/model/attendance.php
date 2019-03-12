<?php
require('dbconn.php');


if (is_ajax()) {

  if (isset($_POST['attendace'])) {

    date_default_timezone_set('Asia/Manila');
    $timescanned =  date('Y/m/d H:i:s');
    //$timescanned = "";
    $datetoday = date('Y/m/d');

    //Variables-----------------------------------------------------------------
    $idnumber = mysqli_real_escape_string(OpenConn(),$_POST['idnumber']);
    $eventno = mysqli_real_escape_string(OpenConn(),$_POST['eventno']);
    //--------------------------------------------------------------------------

    //Start check if the id number is a student of the campus
    $checkifstudent  = "SELECT first_name,last_name FROM tbl_students WHERE student_no = '$idnumber' ";
    $checkifstudentresult = OpenConn()->query($checkifstudent);
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


      //If Id number is verified as a student then:
      if(mysqli_num_rows($checkifstudentresult) == 1)
      {
        //Start attendace for all student
        $check_if_respondent_all  = "SELECT tr.event_no AS eno, tr.course_code AS ccode, tr.course_year AS cyear FROM tbl_respondent AS tr WHERE tr.course_code = 'All' AND tr.course_year = 'All' AND tr.event_no = '$eventno' ";
        $check_if_respondent_all_result = OpenConn()->query($check_if_respondent_all);

        if(mysqli_num_rows($check_if_respondent_all_result) > 0)
        {

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
          $checkattresult = OpenConn()->query($checkatt);



          //if time-in is not present, then execute insert time-in for a specific id number
          if(mysqli_num_rows($tiresult) == 0){
          $timein = "INSERT INTO tbl_attendance (event_no,student_no)
          VALUES('$eventno','$idnumber')";
          $inresult = OpenConn()->query($timein);
          echo json_encode('timein');
          }else{}



          //if time-in is present present, then execute update time-out for a specific id number
          if(mysqli_num_rows($toresult) == 1){
          $timeout = "UPDATE tbl_attendance
          SET ontime_out = '$timescanned'
          WHERE student_no = '$idnumber' AND event_no = '$eventno'
          AND ontime_out IS NULL
          AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d')";
          $outresult = OpenConn()->query($timeout);
          echo json_encode('timeout');
          }else{}




          //if attendace is completed, then return false, set prompt to exceed
          if(mysqli_num_rows($checkattresult) == 1){
          echo json_encode('exceed');
          }else{}

        }
        else
        {
          //echo json_encode(array("jump from: for all student"));
          by_specific_year_specific_course($idnumber,$eventno);
        }

        //echo json_encode(array("You're here, All"));

      }
      else
      {
        echo json_encode('notastudent');
      }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  }
}






//----------------------------------------------------------------------------------------------------------
function by_specific_year_specific_course($idnumber,$eventno){

      $check_if_respondent  = "SELECT ts.student_no AS sname, ts.course_code AS ccode, ts.cyear AS cyear FROM tbl_students AS ts INNER JOIN tbl_respondent AS tr ON ts.cyear = tr.course_year AND ts.course_code = tr.course_code
      WHERE ts.student_no = '$idnumber' AND event_no = '$eventno'";

      $check_if_respondent_result = OpenConn()->query($check_if_respondent);

      if(mysqli_num_rows($check_if_respondent_result) > 0)
      {

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
        $checkattresult = OpenConn()->query($checkatt);



        //if time-in is not present, then execute insert time-in for a specific id number
        if(mysqli_num_rows($tiresult) == 0){
        $timein = "INSERT INTO tbl_attendance (event_no,student_no)
        VALUES('$eventno','$idnumber')";
        $inresult = OpenConn()->query($timein);
        echo json_encode('timein');
        }else{}



        //if time-in is present present, then execute update time-out for a specific id number
        if(mysqli_num_rows($toresult) == 1){
        $timeout = "UPDATE tbl_attendance
        SET ontime_out = '$timescanned'
        WHERE student_no = '$idnumber' AND event_no = '$eventno'
        AND ontime_out IS NULL
        AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d')";
        $outresult = OpenConn()->query($timeout);
        echo json_encode('timeout');
        }else{}




        //if attendace is completed, then return false, set prompt to exceed
        if(mysqli_num_rows($checkattresult) == 1){
        echo json_encode('exceed');
        }else{}
        //echo json_encode(array("You're here, specific_course_specific_year"));
      }
      else
      {
        //echo json_encode(array("jump from: by_specific_year_specific_course"));
        by_specific_year_all_course($idnumber,$eventno);
      }

}






//----------------------------------------------------------------------------------------------------------------
function by_specific_year_all_course($idnumber,$eventno){


      $check_if_respondent_year  = "SELECT ts.student_no AS sname, ts.course_code AS ccode, ts.cyear AS cyear FROM tbl_students AS ts INNER JOIN tbl_respondent AS tr ON ts.course_code = tr.course_code
      WHERE ts.student_no = '$idnumber' AND tr.course_year = 'All'";

      $check_if_respondent_year_result = OpenConn()->query($check_if_respondent_year);

      if(mysqli_num_rows($check_if_respondent_year_result) > 0)
      {
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
        $checkattresult = OpenConn()->query($checkatt);



        //if time-in is not present, then execute insert time-in for a specific id number
        if(mysqli_num_rows($tiresult) == 0){
        $timein = "INSERT INTO tbl_attendance (event_no,student_no)
        VALUES('$eventno','$idnumber')";
        $inresult = OpenConn()->query($timein);
        echo json_encode('timein');
        }else{}



        //if time-in is present present, then execute update time-out for a specific id number
        if(mysqli_num_rows($toresult) == 1){
        $timeout = "UPDATE tbl_attendance
        SET ontime_out = '$timescanned'
        WHERE student_no = '$idnumber' AND event_no = '$eventno'
        AND ontime_out IS NULL
        AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d')";
        $outresult = OpenConn()->query($timeout);
        echo json_encode('timeout');
        }else{}




        //if attendace is completed, then return false, set prompt to exceed
        if(mysqli_num_rows($checkattresult) == 1){
        echo json_encode('exceed');
        }else{}
      //echo json_encode(array("You're here, all_course_specific_year"));

      }
      else
      {
        //echo json_encode(array("jump from: by_specific_year_all_course"));
        specific_course_all_year($idnumber,$eventno);
      }

}








//----------------------------------------------------------------------------------------
function specific_course_all_year($idnumber,$eventno){


      $check_if_respondent_course  = "SELECT ts.student_no AS sname, ts.course_code AS ccode, ts.cyear AS cyear FROM tbl_students AS ts INNER JOIN tbl_respondent AS tr ON ts.cyear = tr.course_year
      WHERE ts.student_no = '$idnumber' AND tr.course_code = 'All'";

      $check_if_respondent_course_result = OpenConn()->query($check_if_respondent_course);

      if(mysqli_num_rows($check_if_respondent_course_result) > 0)
      {
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
        $checkattresult = OpenConn()->query($checkatt);



        //if time-in is not present, then execute insert time-in for a specific id number
        if(mysqli_num_rows($tiresult) == 0){
        $timein = "INSERT INTO tbl_attendance (event_no,student_no)
        VALUES('$eventno','$idnumber')";
        $inresult = OpenConn()->query($timein);
        echo json_encode('timein');
        }else{}



        //if time-in is present present, then execute update time-out for a specific id number
        if(mysqli_num_rows($toresult) == 1){
        $timeout = "UPDATE tbl_attendance
        SET ontime_out = '$timescanned'
        WHERE student_no = '$idnumber' AND event_no = '$eventno'
        AND ontime_out IS NULL
        AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d')";
        $outresult = OpenConn()->query($timeout);
        echo json_encode('timeout');
        }else{}




        //if attendace is completed, then return false, set prompt to exceed
        if(mysqli_num_rows($checkattresult) == 1){
        echo json_encode('exceed');
        }else{}
                //echo json_encode(array("You're here, specific_course_all_year"));

      }
      else
      {
        echo json_encode(array("notrespondent"));
      }


}


function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

?>
