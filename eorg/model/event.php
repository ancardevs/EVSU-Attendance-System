<?php
    require('dbconn.php');
    require('resize-image.class.php');

    session_start();
    $currentsession = $_SESSION['idno'];


    if (isset($_POST['addevent'])) {

        $eventno = mysqli_real_escape_string(OpenConn(),$_POST['eventno']);
        $organizer = mysqli_real_escape_string(OpenConn(),$_POST['organizer']);
        $rawerespondent = $_POST['erespondent'];

        $erespondent = json_decode($rawerespondent,true);

        $eventdate = mysqli_real_escape_string(OpenConn(),$_POST['eventdate']);
        $eventlogin = mysqli_real_escape_string(OpenConn(),$_POST['eventlogin']);
        $eventlogout = mysqli_real_escape_string(OpenConn(),$_POST['eventlogout']);
        $eventname = mysqli_real_escape_string(OpenConn(),$_POST['eventname']);
        //$coursecode = mysqli_real_escape_string(OpenConn(),$_POST['coursecode']);
        //$acadyear = mysqli_real_escape_string(OpenConn(),$_POST['acadyear']);
        $eventdesc = mysqli_real_escape_string(OpenConn(),$_POST['eventdesc']);
        $eventvenue = mysqli_real_escape_string(OpenConn(),$_POST['eventvenue']);


        // Get image name
            $cover = $_FILES['image']['name'];
            //set a file name it could be: $profilename = "sometringhere";
            $imagename = $eventno;
            //get the file extention with the use substring
            $ext1 = substr($cover,-4);
            //get the string length
            $filelength1 = strlen($cover);
            //remove the original filename including the original file extention
            $removename1 = substr($cover,$filelength1);
            //finalize your New Filename
            $coverimage = $imagename.$ext1;
            // image file directory and your new filename
            $target1 = "../img/events/".basename($coverimage);


            $addevent = "INSERT INTO tbl_events(organizer,event_no,event_date,login_time,logout_time,event_name,event_venue,event_cover,event_description) VALUES('$organizer','$eventno','$eventdate','$eventlogin','$eventlogout','$eventname','$eventvenue','$coverimage','$eventdesc')";
            OpenConn()->query($addevent);



            foreach ($erespondent as $key) {
              extract($key);
              $ccourse = $key['mycourse'];
              $cyear = $key['myyear'];

              $resp = $ccourse." - ".$cyear;
              if ($ccourse == "" || $cyear == "") {

                //Tract Activity
                $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
                VALUES('$currentsession','Added a Respondent Failed - Incomplete Data','$eventno','Failed') ";
                OpenConn()->query($trackactivity);
                //Tract Activity

              }else{

                $addresp = "INSERT INTO tbl_respondent(event_no,course_code,course_year) VALUES('$eventno','$ccourse','$cyear')";
                OpenConn()->query($addresp);

                //Tract Activity
                $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
                VALUES('$currentsession','Added a Respondent: $resp','$eventno','Successfull') ";
                OpenConn()->query($trackactivity);
                //Tract Activity

              }


            }





            //move the file to a certain folder with its new filename and Horrayyy ! ! it's my original code...
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target1)) {
              $resizeObj = new resize('../img/events/'.$coverimage);
              $resizeObj -> resizeImage(1920, 789, 'crop');
              $resizeObj -> saveImage('../img/events/'.$coverimage, 100);
            }


        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Added the Event','$eventno','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        //echo json_encode(array($eventlogout));
        header('location: ../event.php');
    }

    if (isset($_POST['deleteevent'])) {
        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
        $deleteevent = "DELETE FROM tbl_events WHERE event_no = '$refid'";
        OpenConn()->query($deleteevent);

        $deleteresp = "DELETE FROM tbl_respondent WHERE event_no = '$refid'";
        OpenConn()->query($deleteresp);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Deleted the Event','$refid','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity


        echo json_encode(array('deleted'));

    }

    if (isset($_POST['updateevent'])) {

        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

        $eventno = mysqli_real_escape_string(OpenConn(),$_POST['eventno']);
        $eventdate = mysqli_real_escape_string(OpenConn(),$_POST['eventdate']);

        $eventlogin = mysqli_real_escape_string(OpenConn(),$_POST['eventlogin']);
        $eventlogout = mysqli_real_escape_string(OpenConn(),$_POST['eventlogout']);

        $eventname = mysqli_real_escape_string(OpenConn(),$_POST['eventname']);

        $eventdesc = mysqli_real_escape_string(OpenConn(),$_POST['eventdesc']);
        $eventvenue = mysqli_real_escape_string(OpenConn(),$_POST['eventvenue']);

        $updateevent = "UPDATE tbl_events SET
        event_date = '$eventdate',
        login_time = '$eventlogin',
        logout_time = '$eventlogout',
        event_name = '$eventname',
        event_venue = '$eventvenue',
        event_description = '$eventdesc'

        WHERE event_no = '$refid' ";
        OpenConn()->query($updateevent);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Updated the Event','$eventno','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        echo json_encode(array('updated'));

    }
?>
