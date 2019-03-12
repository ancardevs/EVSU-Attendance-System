<?php

class getData
{
  public function getcoursecodes()
  {
    $getEvents = "select id,course_code,course_desc from tbl_course";
    $result = OpenConn()->query($getEvents);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $course_code = $row['course_code'];
        $course_name = $row['course_desc'];
        ?>
        <option value="<?php echo $course_code; ?>"><?php echo $course_code; ?></option>
        <?php
      }
    }
  }

  //----------------------------------------------------------------

  public function geteventid()
  {
    $getlastno = "SELECT MAX(id) as no FROM tbl_events";
    $result = OpenConn()->query($getlastno);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $no = $row['no'] + 1;
        ?>
        <input readonly type="text" value="EVSU-E00<?php echo $no; ?>" required id="eventno" name="eventno" class="form-control">
        <?php
      }
    } else {
      ?>
      <input readonly type="text" value="EVSU-E00<?php echo $no; ?>" required id="eventno" name="eventno" class="form-control">
      <?php
    }
  }

  //--------------------------------------------------------------------------------
  public function getcourses()
  {
    $getCourses = "
    select DISTINCT
    tc.course_code as ccode,
    tc.course_desc as cdesc
    from tbl_course as tc
    ";
    $result = OpenConn()->query($getCourses);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $ccode = $row['ccode'];
        $cdesc = $row['cdesc'];
        ?>
        <tr>
          <td><?php echo $ccode; ?></td>
          <td><?php echo $cdesc; ?></td>
          <td>
            <button type="button" data-toggle="modal" data-target="#updatecode<?php echo $ccode; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
            <button type="button" class="btn btn-danger"><span class="fa fa-trash"></span></button>
          </td>
        </tr>

          <?php
        }
      }
    }

}

?>
