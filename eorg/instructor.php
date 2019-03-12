  <?php
  require('layout/header.php');
  require('model/data.class.php');
  $getdata = new getData();

  ?>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="js/custom.js"></script>

  <script>
  $(document).ready(function(){
    $('#instructors').addClass('nav-item active')
  });
  </script>

  <div id="content-wrapper">

    <div class="container-fluid">
      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <div style="float:left;">
            <button data-toggle="modal" data-target="#addStudent" class="btn btn-primary">Add Instructor</button>
          </div>

          <div style="float:right;">
            <h4><span class="fa fa-chalkboard-teacher"></span> Instructors</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID No.</th>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>College</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php


                $getteacher1 = "SELECT DISTINCT
                    tt.id AS id,
                    tt.college AS college,
                    tt.teacher_no AS teacher_no,
                    tt.first_name AS first_name,
                    tt.middle_name AS middle_name,
                    tt.last_name AS last_name,
                    tt.caddress AS caddress,
                    tt.phone AS phone,
                    tt.email AS email

                FROM tbl_teacher as tt

                ";
                $result1 = OpenConn()->query($getteacher1);
                if ($result1->num_rows > 0) {
                  while ($row = $result1->fetch_assoc()) {
                    $id = $row['id'];
                    $college = $row['college'];
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
                      <td><a title="<?php echo $email; ?>" href="mailto:<?php echo $email; ?>" style="text-decoration:none;"><?php echo $fullname; ?></a> </td>
                      <td><?php echo $phone; ?></td>
                      <td><?php echo $college; ?></td>
                      <td>
                        <button type="button" data-toggle="modal" data-target="#updateinstructormodal<?php echo $id; ?>" class="btn btn-primary"><span class="fa fa-pen"></span></button>
                      </td>
                    </tr>

                    <div id="updateinstructormodal<?php echo $id;?>" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4>Instructor Information</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
                            <div style="display:none; margin:0px auto; width:400px;" id="submit-alert<?php echo $id;?>" class=""></div>
                          </div>

                          <div class="modal-body">

                            <form action="model/student.php" method="post">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  Instructor ID No.
                                  <input type="text" value="<?php echo $instructor_no; ?>" required name="idnumber" id="idnumber<?php echo $id;?>" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                  College
                                  <input type="list" list="collegeList" name="college" value="<?php echo $college; ?>" class="form-control" id="college<?php echo $id;?>">

                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-4">
                                  <label for=""><span class="font-red"></span>First Name</label><strong style="color:red;">*</strong>
                                  <input type="text" name="firstname" value="<?php echo $first_name; ?>" class="form-control" id="firstname<?php echo $id;?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="">Middle Name</label>
                                  <input type="text" name="middlename" value="<?php echo $middle_name; ?>" class="form-control" id="middlename<?php echo $id;?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for=""><span class="font-red"></span>Last Name</label><strong style="color:red;">*</strong>
                                  <input type="text" name="lastname" value="<?php echo $last_name; ?>" class="form-control" id="lastname<?php echo $id;?>" required>
                                </div>
                              </div>


                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for=""><span class="font-red"></span>Email</label><strong style="color:red;">*</strong>
                                  <input type="text" name="emailadd" value="<?php echo $email; ?>" class="form-control" id="emailadd<?php echo $id;?>" required>
                                </div>

                                <div class="form-group col-md-6">
                                  <label for=""><span class="font-red"></span>Contact</label><strong style="color:red;">*</strong>
                                  <input type="text" name="contact" value="<?php echo $phone; ?>" class="form-control" id="contact<?php echo $id;?>" required>
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for=""><span class="font-red"></span>Address</label><strong style="color:red;">*</strong>
                                  <input type="text" name="address" value="<?php echo $caddress; ?>" class="form-control" id="address<?php echo $id;?>" required>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <a href="advisory.php?instructorid=<?php echo $instructor_no; ?>&instructorname=<?php echo $fullname ?>&role=administrator" style="border-radius:0px;" class="btn btn-primary" id="viewAdvisory" ><span class="fa fa-list"></span> View Advisory Information</a>

                                </div>
                              </div>


                            </form>
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" value="<?php echo $instructor_no;?>" name="" id="ref<?php echo $id;?>">
                            <button type="button" class="btn btn-success" name="updateinstructor" id="updateinstructor<?php echo $id;?>"><span class="fa fa-sync"></span> </button>
                            <button type="button" class="btn btn-danger" id="deleteinstructor<?php echo $id;?>"><span class="fa fa-trash"></span> </button>

                          </div>

                        </div>

                      </div>
                    </div>


                    <script type="text/javascript">

                    //Update Instructor
                    $('#updateinstructor<?php echo $id;?>').on('click',function(){

                      if($('#idnumber<?php echo $id;?>').val() == "" ||
                      $('#firstname<?php echo $id;?>').val() == "" ||
                      $('#lastname<?php echo $id;?>').val() == "" ||
                      $('#emailadd<?php echo $id;?>').val() == "" ||
                      $('#section<?php echo $id;?>').val() == "" ||
                      $('#contact<?php echo $id;?>').val() == "" ||
                      $('#department<?php echo $id;?>').val() == "" ||
                      $('#address<?php echo $id;?>').val() == ""){

                        setTimeout(function () {
                          $('#submit-alert<?php echo $id;?>').removeClass('alert alert-success');
                          $("#submit-alert<?php echo $id;?>").addClass("alert alert-warning");

                          $('#submit-alert<?php echo $id;?>').html("Please fill all required fields!");
                          $('#submit-alert<?php echo $id;?>')
                          //.hide()
                          .fadeIn(500)
                          .delay(2000)
                          .fadeOut(500);
                        }, 0);

                        setTimeout(function () {
                          location.href = "instructors";
                        }, 2000);

                      }else{

                        $('#updateinstructor<?php echo $id ?>').prop('disabled', true);
                        $("#updateinstructor<?php echo $id ?>").html('<span class="fa fa-sync"></span> Updating Instructor...');

                        var data = {
                          "idnumber" : $('#idnumber<?php echo $id;?>').val(),
                          "firstname" : $('#firstname<?php echo $id;?>').val(),
                          "middlename" : $('#middlename<?php echo $id;?>').val(),
                          "lastname" : $('#lastname<?php echo $id;?>').val(),
                          "emailadd" : $('#emailadd<?php echo $id;?>').val(),
                          "contact" : $('#contact<?php echo $id;?>').val(),
                          "section" : $('#section<?php echo $id;?>').val(),
                          "address" : $('#address<?php echo $id;?>').val(),
                          "refid" : $('#ref<?php echo $id;?>').val(),
                          "department" : $('#department<?php echo $id;?>').val(),
                          "updateinstructor" : "updateinstructor"
                        };

                        data = $(this).serialize() + "&" + $.param(data);

                        $.ajax({
                          type: 'POST',
                          url: 'model/instructor.php',
                          dataType : 'json',
                          data: data,
                          success: function (data) {
                            if(data == 'updated'){

                              $('#updateinstructor<?php echo $id ?>').prop('disabled', false);
                              $("#updateinstructor<?php echo $id ?>").html('<span class="fa fa-sync"></span>');

                              setTimeout(function () {
                                $("#submit-alert<?php echo $id ?>").removeClass("alert alert-warning");
                                $("#submit-alert<?php echo $id ?>").addClass("alert alert-success");
                                $('#submit-alert<?php echo $id ?>').html("Data updated successfully.");
                                $('#submit-alert<?php echo $id ?>')
                                //.hide()
                                .fadeIn(500)
                                .delay(2000)
                                .fadeOut(500);
                              }, 0);

                              setTimeout(function () {
                                location.href = "instructor.php";
                              }, 2000);
                            }
                          }
                        });
                      }

                    });

                    //Delete Instructor
                    $('#deleteinstructor<?php echo $id;?>').on('click',function(){

                      $('#deleteinstructor<?php echo $id ?>').prop('disabled', true);
                      $("#deleteinstructor<?php echo $id ?>").html('<span class="fa fa-trash"></span> Deleting Instructor...');

                      var data = {
                        "idnumber" : $('#idnumber<?php echo $id ?>').val(),
                        "deleteinstructor": 'deleteinstructor'
                      }
                      data = $(this).serialize() + "&" + $.param(data);

                      $.ajax({
                        type: 'POST',
                        url: 'model/instructor.php',
                        dataType : 'json',
                        data: data,
                        success: function (data) {
                          $('#deleteinstructor<?php echo $id ?>').prop('disabled', false);
                          $("#deleteinstructor<?php echo $id ?>").html('<span class="fa fa-trash"></span>');

                          setTimeout(function () {
                            $("#submit-alert<?php echo $id; ?>").addClass("alert alert-warning");
                            $('#submit-alert<?php echo $id; ?>').html("Instructor Removed successfully!");
                            $('#submit-alert<?php echo $id; ?>')
                            //.hide()
                            .fadeIn(500)
                            .delay(2000)
                            .fadeOut(500);
                          }, 0);

                          setTimeout(function () {
                            location.href = "instructors";
                          }, 2000);
                        }
                      })

                    });
                    </script>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">DataTables v1.10.18</div>
      </div>
    </div>



    <div id="addStudent" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4>Instructor Information</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div style="text-align:center; z-index:9999; width: 100%; text-align:center; position:fixed; top:8%; ">
            <div style="display:none; margin:0px auto; width:400px;" id="submit-alert" class=""></div>
          </div>

          <div class="modal-body">

            <form action="model/student.php" method="post">
              <div class="form-row">
                <div class="form-group col-md-6">
                  Instructor ID No.
                  <input type="text" required name="idnumber" id="idnumber" class="form-control">
                </div>
                <div class="form-group col-md-6">
                  College
                  <input type="list" list="collegeList" class="form-control" name="college" id="college">
                  <datalist class="" id="collegeList">
                    <option value=""></option>
                    <?php
                    $getCourse = "SELECT college,course_code,course_desc FROM tbl_course GROUP BY college";
                    $result = OpenConn()->query($getCourse);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $college = $row['college'];
                            $course_code = $row['course_code'];
                            $course_name = $row['course_desc'];
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
                  <label for=""><span class="font-red"></span>First Name</label><strong style="color:red;">*</strong>
                  <input type="text" name="firstname" class="form-control" id="firstname" required>
                </div>
                <div class="form-group col-md-4">
                  <label for="">Middle Name</label>
                  <input type="text" name="middlename" class="form-control" id="middlename" required>
                </div>
                <div class="form-group col-md-4">
                  <label for=""><span class="font-red"></span>Last Name</label><strong style="color:red;">*</strong>
                  <input type="text" name="lastname" class="form-control" id="lastname" required>
                </div>
              </div>


              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for=""><span class="font-red"></span>Email</label><strong style="color:red;">*</strong>
                  <input type="text" name="emailadd" class="form-control" id="emailadd" required>
                </div>

                <div class="form-group col-md-6">
                  <label for=""><span class="font-red"></span>Contact</label><strong style="color:red;">*</strong>
                  <input type="text" name="contact" class="form-control" id="contact" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for=""><span class="font-red"></span>Address</label><strong style="color:red;">*</strong>
                  <input type="text" name="address" class="form-control" id="address" required>
                </div>
              </div>
              <hr>

              <style media="screen">
                #ContentDiv::-webkit-scrollbar {
                  width: 6px;
                }
                #ContentDiv::-webkit-scrollbar-thumb {
                  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
                }
              </style>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <button type="button" style="border-radius:0px;" class="btn btn-primary" id="addAdvisory" ><span class="fa fa-plus"></span> Add Advisory / Handled Class</button>
                  <br><br>
                  <div id="ContentDiv" class="resp1 form-row"></div>
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
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <div style="display:none; z-index:9999; top:10%; left:10%; position:fixed; margin:0 auto;text-align:center; margin-top:10px; width:400px;" id="success-alert" class="alert alert-success">Command completed successfully !</div>

            <button type="button" class="btn btn-success" name="addinstructor" id="addinstructor">Add Instructor</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

          </div>
        </div>

      </div>
    </div>

    <datalist class="" id="YearList">
        <option value="First Year"></option>
        <option value="Second Year"></option>
        <option value="Third Year"></option>
        <option value="Fourth Year"></option>
    </datalist>




    <script type="text/javascript">
    //Adding Instructor

    var arraycs = new Array();

    var intCourse=0;
    var intSection=0;
    var intYear=0;


    $("#addinstructor").on('click', function () {
      if($('#idnumber').val() == "" ||
      $('#firstname').val() == "" ||
      $('#lastname').val() == "" ||
      $('#emailadd').val() == "" ||
      $('#contact').val() == "" ||
      $('#address').val() == "" ||
      $('#college').val() == ""){

        setTimeout(function () {
          $('#submit-alert').removeClass('alert alert-danger');
          $('#submit-alert').removeClass('alert alert-warning');
          $("#submit-alert").addClass("alert alert-warning");

          $('#submit-alert').html("Please fill all required fields!");
          $('#submit-alert')
          //.hide()
          .fadeIn(500)
          .delay(2000)
          .fadeOut(500);
        }, 0);

      }else{

        for(x=1; x<=intCourse; x++){
          var ccourse = $('#TxtCourse' + x).val();
          var csection = $('#TxtSection' + x).val();
          var cyear = $('#TxtYear' + x).val();
          arraycs.push({myyear : cyear,mycourse : ccourse, mysection : csection})
        }

        $('#addinstructor').prop('disabled', true);
        $("#addinstructor").html('Saving Information...');
        var data = {
          "idnumber" : $('#idnumber').val(),
          "firstname" : $('#firstname').val(),
          "middlename" : $('#middlename').val(),
          "lastname" : $('#lastname').val(),
          "emailadd" : $('#emailadd').val(),
          "contact" : $('#contact').val(),
          "college" : $('#college').val(),
          "address" : $('#address').val(),
          "coursesec":JSON.stringify(arraycs),
          "addinstructor" : "addinstructor"
        };

        data = $(this).serialize() + "&" + $.param(data);

        $.ajax({
          type: 'POST',
          url: 'model/instructor.php',
          dataType : 'json',
          data: data,
          success: function (data) {
            if(data == 'exist'){
              arraycs.length = 0;
              setTimeout(function () {

                $('#addinstructor').prop('disabled', false);
                $("#addinstructor").html('Add Instructor');

                $("#submit-alert").removeClass("alert alert-success");
                $("#submit-alert").addClass("alert alert-warning");
                $('#submit-alert').html("Data existed in the database.");
                $('#submit-alert')
                //.hide()
                .fadeIn(500)
                .delay(2000)
                .fadeOut(500);
              }, 0);

            }else if(data == 'mailerr'){
              $('#addinstructor').prop('disabled', false);
              $("#addinstructor").html('Add Instructor');
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
                location.href = "instructors";
              }, 2000);

            }

            else{
              $('#addinstructor').prop('disabled', false);
              $("#addinstructor").html('Add Instructor');

                setTimeout(function () {
                  $("#submit-alert").removeClass("alert alert-warning");
                  $("#submit-alert").addClass("alert alert-success");
                  $('#submit-alert').html("Command completed successfully! Incomplete advisory information will not be save.  Mail sent.");
                  $('#submit-alert')
                  //.hide()
                  .fadeIn(500)
                  .delay(2000)
                  .fadeOut(500);
                }, 0);

                setTimeout(function () {
                  location.href = "instructors";
                }, 2000);
              }


          }
        });
      }
    });





    //FUNCTION TO ADD TEXT BOX ELEMENT

    $("#addAdvisory").on("click",function(){
      intCourse = intCourse + 1;
      intSection = intSection + 1;
      intYear= intYear + 1;

      var contentID = document.getElementById('ContentDiv');
      var newTBDiv = document.createElement('div');
      newTBDiv.setAttribute('id','Hosp'+intCourse);
      newTBDiv.setAttribute('class','col-md-4');
      newTBDiv.setAttribute('title','Remove');
      newTBDiv.setAttribute('style','border:1px #a4a4a4 solid;border-radius:6px;  margin-bottom:10px;');
      newTBDiv.innerHTML = "<b>Year</b> <input class='form-control' list='YearList' id='TxtYear" + intYear + "' name='TxtYear" + intYear + "'/> " +
      "<b>Course</b> <input class='form-control' list='CourseList' id='TxtCourse" + intCourse + "' name='TxtCourse" + intCourse + "'/> " +
      "<b>Section</b> <input type='text' class='form-control' id='TxtSection" + intSection + "' name='TxtSection" + intSection + "'/> " +
      "<div style='width:100%;height:5px;'></div>"+
      "<button type='button' class='btn btn-danger' onclick='removeElement(\"" + intCourse + "\")'><span class='fa fa-trash'></span></button><div style='width:100%;height:5px;'></div>";
      contentID.appendChild(newTBDiv);
    });




    //FUNCTION TO REMOVE TEXT BOX ELEMENT
    function removeElement(id)
    {
      if(intCourse != 0)
      {
        var contentID = document.getElementById('ContentDiv');
        //alert(contentID);
        contentID.removeChild(document.getElementById('Hosp'+id));
        intCourse = intCourse-1;
        intSection = intSection-1;
        intYear = intYear-1;
      }
      arraycs.length = 0;
    }


    </script>

    <!-- /.container-fluid -->
    <?php require('layout/footer.php'); ?>
