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

    date_default_timezone_set('Asia/Manila');
    $timescanned =  date('Y/m/d H:i:s');

    //$timescanned = "";
    $datetoday = date('Y/m/d');


    //Start check if the id number is a student of the campus
    $checkifstudent  = "SELECT * FROM tbl_students WHERE student_no = '$idnumber' ";
    $checkifstudentresult = OpenConn()->query($checkifstudent);

    //If Id number is verified as a student then:
    if(mysqli_num_rows($checkifstudentresult) == 1){

      //
      $checkall = "SELECT * FROM tbl_events WHERE event_no = '$eventno' AND cyear = '0' AND course_code = '0' AND event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";
      $checkallresult = OpenConn()->query($checkall);

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

              //echo json_encode('youre here all courses and all year');

            }else{
              //echo json_encode('skip from all courses and all year');
              by_specific_year_specific_course($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday);
            }
          }else{
            echo json_encode('notastudent');
          }
        }
      }






















      //start filter by specific year and specific course (e.g: All 1st Year with HRTM  course only)
      function by_specific_year_specific_course($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday){
        //Check by specific Year and specific course
        $check_by_specific_year_specific_course = "SELECT * FROM tbl_events as te INNER JOIN tbl_students as ts ON te.cyear = ts.cyear AND te.course_code = ts.course_code
        WHERE ts.student_no = '$idnumber' AND te.event_no = '$eventno' AND te.cyear = '$eventyear' AND te.course_code = '$eventcourse' AND te.event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";

        $check_by_specific_year_specific_course_result = OpenConn()->query($check_by_specific_year_specific_course);

        if(mysqli_num_rows($check_by_specific_year_specific_course_result) == 1){
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
                //echo json_encode('youre here specific year and specific course');

              }else{
                //echo json_encode('skip from specific course and specific year');

                by_specific_year_all_course($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday);
              }
            }
            //start filter by specific year and specific course (e.g: All 1st Year with HRTM  course only)














            //start filter by specific year and all course   (e.g: ALL FIRST YEAR ONLY - HRTM/BSINT/ENGENEERING/)
            function by_specific_year_all_course($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday){
              $check_by_specific_year_all_course = "SELECT * FROM tbl_events as te INNER JOIN tbl_students as ts ON te.cyear = ts.cyear
              WHERE ts.student_no = '$idnumber' AND te.event_no = '$eventno' AND te.cyear = '$eventyear' AND te.course_code = '0' AND te.event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";

              $check_by_specific_year_all_course_result = OpenConn()->query($check_by_specific_year_all_course);

              if(mysqli_num_rows($check_by_specific_year_all_course_result) == 1){
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

                      //echo json_encode('youre here specific year and all course');

                    }else{
                      //echo json_encode('skip from specific year and all course');

                      by_specific_course_all_year($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday);
                      //echo json_encode('shit');
                    }
                  }
                  //start filter by specific year and all course   (e.g: ALL FIRST YEAR ONLY - HRTM/BSINT/ENGENEERING/)












                  //start filter by specific course and all year   (e.g: All HRTM ONLY or any other course - 1ST YEAR - 4TH YEAR)
                  function by_specific_course_all_year($idnumber,$eventdetails,$eventno,$eventyear,$eventcourse,$timescanned,$datetoday){
                    $check_by_specific_course_all_year = "SELECT * FROM tbl_events as te INNER JOIN tbl_students as ts ON te.course_code = ts.course_code
                    WHERE ts.student_no = '$idnumber' AND te.event_no = '$eventno' AND te.cyear = '0' AND te.course_code = '$eventcourse'
                    AND te.event_date = DATE_FORMAT(NOW(), '%Y/%m/%d')";

                    $check_by_specific_course_all_year_result = OpenConn()->query($check_by_specific_course_all_year);

                    if(mysqli_num_rows($check_by_specific_course_all_year_result) == 1){
                      //check if the time-in for a specific id number is present
                      $checktimein = "SELECT * FROM tbl_attendance
                      WHERE student_no = '$idnumber'
                      AND event_no = '$eventno'
                      AND ontime_in IS NOT NULL
                      AND  DATE_FORMAT(event_date, '%Y/%m/%d') = DATE_FORMAT(NOW(), '%Y/%m/%d') ";
                      $tiresult = OpenConn()->query($checktimein);


                      //check if the time-out for a specific id number is present
                      $checktimeout = "SELECT * FROM tbl_attendance
                      WHERE event_no = '$eventno' AND student_no = '$idnumber'
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


                            //echo json_encode('your here specific course all year/'.$eventcourse);
                          }else{
                            echo json_encode('no data');
                            //echo json_encode('error specific course all year');
                          }
                        }
                        //end filter by specific course and all year   (e.g: All HRTM ONLY or any other course - 1ST YEAR - 4TH YEAR)






























                        function is_ajax() {
                          return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
                        }

                        ?>
