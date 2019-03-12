<?php
 require('model/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EOrg - Student Registration</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
  </head>
  <body>






        <!-- Modal content-->
        <div class="modal-dialog modal-lg">

        <div class="">
        <form action="model/student.php" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <h4>Student Information</h4>
          </div>
          <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
            <div style="display:none; margin:0px auto; width:450px;" id="submit-alert" class=""></div>
          </div>

          <div class="modal-body">

              <div class="form-row">
                <div class="form-group col-md-6">
                  Student ID No.
                  <input type="text" required name="idnumber" id="idnumber" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  College
                  <input type="list" list="CollegeList" name="college" id="college" value="" class="form-control">
                  <datalist class="" id="CollegeList">
                    <?php
                    $getCourses = "SELECT DISTINCT college FROM tbl_course";
                    $result = OpenConn()->query($getCourses);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $college = $row['college'];
                        ?>
                        <option value="<?php echo $college; ?>"><?php echo $college; ?></option>
                        <?php
                      }
                    }
                    ?>
                  </datalist>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  First Name
                  <input type="text" name="firstname" class="form-control" id="firstname" required>
                </div>
                <div class="form-group col-md-4">
                  Middle Name
                  <input type="text" name="middlename" class="form-control" id="middlename" required>
                </div>
                <div class="form-group col-md-4">
                  Last Name
                  <input type="text" name="lastname" class="form-control" id="lastname" required>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-4">
                  Year
                  <input type="list" list="YearList" name="cyear" id="cyear" value="" class="form-control">
                  <datalist class="" id="YearList">
                    <option value="First Year">First Year</option>
                    <option value="Second Year">Second Year</option>
                    <option value="Third Year">Third Year</option>
                    <option value="Fourth Year">Fourth Year</option>
                    <option value="Fifth Year">Fifth Year</option>
                  </datalist>
                </div>
                <div class="form-group col-md-4">
                  Course
                  <input type="list" list="CourseList" name="course" id="course" value="" class="form-control">
                  <datalist class="" id="CourseList">
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

                <div class="form-group col-md-4">
                  Section
                  <input type="text" name="section" class="form-control" id="section" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  Department
                  <input type="list" list="DepartmentList" required id="department" name="department" class="form-control">
                  <datalist class="" id="DepartmentList">
                    <?php
                    $getCourse = "select id,college,department,course_code,course_desc from tbl_course";
                    $result = OpenConn()->query($getCourse);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $college = $row['college'];
                        $department = $row['department'];
                        $course_code = $row['course_code'];
                        $course_name = $row['course_desc'];
                        ?>
                        <option value="<?php echo $department; ?>"><?php echo $department; ?></option>
                        <?php
                      }
                    }
                    ?>
                  </datalist>
                </div>
                <div class="form-group col-md-3">
                  Birthdate
                  <input type="date" name="bdate" class="form-control" id="bdate" required>
                </div>
                <div class="form-group col-md-3">
                  Contact
                  <input type="text" name="contact" class="form-control" id="contact" required>
                </div>
              </div>


              <div class="form-row">
                <div class="form-group col-md-6">
                  Email
                  <input type="text" name="emailadd" class="form-control" id="emailadd" required>
                </div>
                <div class="form-group col-md-6">
                  Scholarship
                  <input type="list" name="scholarship" list="ScholarshipList" class="form-control" value="" id="scholarship" required>
                  <datalist class="" id="ScholarshipList">
                    <?php
                    $getGrant = "SELECT DISTINCT id, grant_code,grant_desc FROM tbl_scholarship";
                    $resultgrant = OpenConn()->query($getGrant);

                    if ($resultgrant->num_rows > 0) {
                      while ($row = $resultgrant->fetch_assoc()) {
                        $id = $row['id'];
                        $grant_code = $row['grant_code'];
                        $grant_desc = $row['grant_desc'];
                        ?>
                        <option value="<?php echo $grant_code; ?>"><?php echo $grant_desc; ?></option>
                        <?php
                      }
                    }
                    ?>
                  </datalist>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  Address
                  <input type="text" name="address" class="form-control" id="address" required>
                </div>
              </div>
          </div>

          <div class="modal-footer">
            <div style="display:none; z-index:9999; top:10%; left:10%; position:fixed; margin:0 auto;text-align:center; margin-top:10px; width:400px;" id="success-alert" class="alert alert-success">Command completed successfully !</div>

            <button type="button" class="btn btn-success" name="addstudent" id="addstudent">Register My Information</button>
            <a href="sewsfeed" class="btn btn-danger" data-dismiss="modal">Cancel</a>
          </div>

        </div>
      </form>
    </div>

  </div>
    <!--modal-->










    <script src="vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript">

    //Addning student

    $("#addstudent").on("click", function(){
      if($('#idnumber').val() == "" ||
      $('#firstname').val() == "" ||
      $('#lastname').val() == "" ||
      $('#cyear').val() == "" ||
      $('#course').val() == "" ||
      $('#college').val() == "" ||
      $('#department').val() == "" ||
      $('#section').val() == "" ||
      $('#emailadd').val() == "" ||
      $('#contact').val() == "" ||
      $('#bdate').val() == "" ||
      $('#address').val() == ""){
        setTimeout(function () {
          $('#submit-alert').removeClass('alert alert-success');
          $("#submit-alert").addClass("alert alert-warning");

          $('#submit-alert').html("Please fill all required fields!");
          $('#submit-alert')
          //.hide()
          .fadeIn(500)
          .delay(2000)
          .fadeOut(500);
        }, 0);
      }else{
        $('#addstudent').prop('disabled', true);
        $("#addstudent").html('Saving Information...');

        var data = {
          "idnumber" : $('#idnumber').val(),
          "firstname" : $('#firstname').val(),
          "middlename" : $('#middlename').val(),
          "lastname" : $('#lastname').val(),

          "college" : $('#college').val(),
          "scholarship" : $('#scholarship').val(),
          "department" : $('#department').val(),


          "cyear" : $('#cyear').val(),
          "course" : $('#course').val(),
          "section" : $('#section').val(),
          "emailadd" : $('#emailadd').val(),
          "contact" : $('#contact').val(),
          "bdate" : $('#bdate').val(),
          "address" : $('#address').val(),

          "addstudent" : "addstudent"
        };
        data = $(this).serialize() + "&" + $.param(data);

        $.ajax({
          type: 'POST',
          url: 'model/student.php',
          dataType : 'json',
          data: data,
          success: function (data) {
            if(data == 'exist'){
              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');
              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-success');
                $('#submit-alert').addClass('alert alert-warning');

                $('#submit-alert').html("Data existed in the database.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(2000)
                .fadeOut(500);
              }, 0);
            }else if(data == 'mailerr'){
              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');
              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-success');
                $("#submit-alert").addClass("alert alert-warning");

                $('#submit-alert').html("Data are saved. <br>Warning: No internet connection, Mail failed to send.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(5000)
                .fadeOut(500);
              }, 0);

              setTimeout(function () {
                location.href = "students";
              }, 2000);

            }else{
              $('#addstudent').prop('disabled', false);
              $("#addstudent").html('Add Student');

              setTimeout(function () {
                $('#submit-alert').removeClass('alert alert-warning');
                $("#submit-alert").addClass("alert alert-success");

                $('#submit-alert').html("Student inserted successfully! Mail sent.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(2000)
                .fadeOut(500);
              }, 0);

              setTimeout(function () {
                location.href = "students";
              }, 2000);
            }

          }
        });
      }
    });
    </script>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <!--script src="vendor/chart.js/Chart.min.js"></script-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="js/demo/datatables-demo.js"></script>
    <!--script src="js/demo/chart-area-demo.js"></script-->

  </body>
</html>
