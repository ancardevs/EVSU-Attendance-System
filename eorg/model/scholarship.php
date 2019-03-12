<?php
    require('dbconn.php');

    session_start();
    $currentsession = $_SESSION['idno'];


    if (isset($_POST['addgrant'])) {
        $grantcode = mysqli_real_escape_string(OpenConn(),$_POST['grantcode']);
        $grantdesc = mysqli_real_escape_string(OpenConn(),$_POST['grantdesc']);

        $checkgrant = "SELECT grant_desc FROM tbl_scholarship WHERE grant_code = '$grantcode'";
        $checkresult = OpenConn()->query($checkgrant);
        if(mysqli_num_rows($checkresult) > 0){

          //Tract Activity
          $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
          VALUES('$currentsession','Added a Scholarship Grant - Course Exist $grantcode','$grantcode','Failed') ";
          OpenConn()->query($trackactivity);
          //Tract Activity

            echo json_encode(array('exist'));
        }else{

            $addgrant = "INSERT INTO tbl_scholarship(grant_code,grant_desc)
            VALUES('$grantcode','$grantdesc')";
            OpenConn()->query($addgrant);

            //Tract Activity
            $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
            VALUES('$currentsession','Added a Scholarship','$grantcode','Successfull') ";
            OpenConn()->query($trackactivity);
            //Tract Activity

            echo json_encode(array('saved'));
        }
    }



    if (isset($_POST['deletegrant'])) {
        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);
        $grantcode = mysqli_real_escape_string(OpenConn(),$_POST['grantcode']);

        $deletegrant = "DELETE FROM tbl_scholarship WHERE id = '$refid'";
        OpenConn()->query($deletegrant);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Deleted a Scholarship','$grantcode','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity

        echo json_encode(array('deleted'));
    }




    if (isset($_POST['updategrant'])) {
        $grantcode = mysqli_real_escape_string(OpenConn(),$_POST['grantcode']);
        $grantdesc = mysqli_real_escape_string(OpenConn(),$_POST['grantdesc']);

        $refid = mysqli_real_escape_string(OpenConn(),$_POST['refid']);

        $updategrant = "UPDATE tbl_scholarship SET grant_code = '$grantcode', grant_desc = '$grantdesc' WHERE id = '$refid'";
        OpenConn()->query($updategrant);

        //Tract Activity
        $trackactivity = "INSERT INTO tbl_sessiontracker (id_no,activity,reference,remarks)
        VALUES('$currentsession','Updated a Scholarship','$grantcode','Successfull') ";
        OpenConn()->query($trackactivity);
        //Tract Activity


        echo json_encode(array('updated'));
    }




?>
