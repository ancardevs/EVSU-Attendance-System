<?php
    require('dbconn.php');

    session_start();
    $currentsession = $_SESSION['idno'];


    if (isset($_POST['addcourse'])) {
        $course_code = mysqli_real_escape_string(OpenConn(),$_POST['coursecode']);
        $course_desc = mysqli_real_escape_string(OpenConn(),$_POST['coursedesc']);

        $college = mysqli_real_escape_string(OpenConn(),$_POST['ccollege']);
        $department = mysqli_real_escape_string(OpenConn(),$_POST['department']);

        $checkcourse = "SELECT course_desc FROM tbl_course WHERE course_code = '$course_code'";
        $checkresult = OpenConn()->query($checkcourse);
        if(mysqli_num_rows($checkresult) > 0){

          //Tract Activity
          $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
          VALUES('$currentsession','Added a Course - Course Exist $course_code','$course_code','Failed') ";
          OpenConn()->query($trackactivity);
          //Tract Activity

            echo json_encode(array('exist'));

        }else{

            $addcourse = "INSERT INTO tbl_course(college,department,course_code,course_desc)
            VALUES('$college','$department','$course_code','$course_desc')";
            OpenConn()->query($addcourse);

            //Tract Activity
            $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
            VALUES('$currentsession','Added a Course','$course_code','Successfull') ";
            OpenConn()->query($trackactivity);
            //Tract Activity

            echo json_encode(array('saved'));
        }
    }



    if (isset($_POST['deletecourse'])) {

        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
        $coursecode = mysqli_real_escape_string(OpenConn(),$_POST['coursecode']);

        $updatecourse = "DELETE FROM tbl_course WHERE id = '$refid'";
        OpenConn()->query($updatecourse);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Deleted a Course','$coursecode','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        echo json_encode(array('deleted'));
    }




    if (isset($_POST['updatecourse'])) {
        $college = mysqli_real_escape_string(OpenConn(),$_POST['ccollege']);
        $department = mysqli_real_escape_string(OpenConn(),$_POST['department']);
        $coursecode = mysqli_real_escape_string(OpenConn(),$_POST['coursecode']);
        $coursedesc = mysqli_real_escape_string(OpenConn(),$_POST['coursedesc']);

        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

        $updatecourse = "UPDATE tbl_course SET college = '$college',department ='$department', course_code = '$coursecode', course_desc = '$coursedesc' WHERE id = '$refid'";
        OpenConn()->query($updatecourse);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Updated a Course','$coursecode','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity


        echo json_encode(array('updated'));
    }




?>
