<?php

require('dbconn.php');

if (isset($_POST['clean'])) {

  $tbl_sections = "TRUNCATE TABLE tbl_sections";
  OpenConn()->query($tbl_sections);

  $tbl_attendance = "TRUNCATE TABLE tbl_attendance";
  OpenConn()->query($tbl_attendance);

  $tbl_course = "TRUNCATE TABLE tbl_course";
  OpenConn()->query($tbl_course);

  $tbl_events = "TRUNCATE TABLE tbl_events";
  OpenConn()->query($tbl_events);

  $tbl_students = "TRUNCATE TABLE tbl_students";
  OpenConn()->query($tbl_students);

  $tbl_sections = "TRUNCATE TABLE tbl_sections";
  OpenConn()->query($tbl_sections);


  echo json_encode(array('cleaned'));
}









?>
