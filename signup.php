<?php
  require "header.php";

echo' <link rel="stylesheet" href="css/styles.css">
 <title>Signup - TechKnow</title>

 <main>
    <div class="container-fluid padding signupbg" style="background-image: url(images/signup-img.jpg);">
      <div class="grid-padding">
        <div class="row">';
        echo '<div class="row-lg-12 signupctn text-center box-divs">
            <div class="card-body">
            <div class="row">
            <div class="signupsplit col-lg-12">
            <h4 class="text-center"></i>SIGNUP AS A </h4>
            <select class="signupinputfrm form-control" style="text-align: center;" onchange="showsec(this)">
            <option selected value="0">Student</option>
            <option value="1">Teacher</option>
            </select>
            </div>
            </div>
                <div class="row">
                    <div class="signupsplit col-lg-12" id="student-section">
                        <form class="signup-form" action="includes/signup-s.inc.php" method="post" enctype="multipart/form-data">
                      <div class="form-row">
                        <div class="col">
                        <input class="signupinputfrm form-control" type="text" placeholder="First Name" name="fname">
                        </div>
                        <div class="col">
                        <input class="signupinputfrm form-control" type="text" name="lname" placeholder="Last Name">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col">
                        <select class="signupinputfrm form-control" name="gender"><option selected hidden value="0">Select gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        </select>
                        </div>
                        <div class="col">
                        <input class="signupinputfrm form-control" type="date" placeholder="Birthday" name="bday">
                        </div>
                      </div>
                      <input class="signupinputfrm form-control" type="text" name="address" placeholder="Complete Address">
                        <select class="signupinputfrm form-control" name="course"><option selected hidden value="0">Select course</option>';
                        $coursesql = "SELECT * FROM coursedept WHERE type = 'Course'";
                        $courseres = $conn->query($coursesql);

                        while($row = $courseres->fetch_assoc())
                        {
                          echo "<option value = '".$row['title']."'>".$row['code']." - ".$row['title']."</option>";
                        }
                        echo'</select>
                        <input class="signupinputfrm form-control" type="text" name="user" placeholder="Username">
                        <input class="signupinputfrm form-control" type="email" name="email" placeholder="Email">
                        <input class="signupinputfrm form-control" type="text" name="studentid" placeholder="Student ID">
                        <input class="signupinputfrm form-control" type="password" id="pass" name="pass" placeholder="Password">
                        <progress class="progress-bar" max="100" value="0" id="pass-strength" name="pass-strength"></progress>

                        <input class="signupinputfrm form-control" type="password" name="pass-repeat" placeholder="Confirm Password">
                        
                        <input class="signupinputfrm form-control" type="file" class="cvsuid" name="imageid" placeholder="Upload photo of your CVSU-SC ID" accept="image/*"></input>
                        <input class="signupinputfrm form-control" type="hidden" name="accounttype" value="Student">
                        <p style="font-size: 10px;">Attach a selfie of yourself together with your CVSU - Silang Campus ID</p>
                            <div><p style="font-size: 10px;">By signing up, you agree to our <a style="color: #2980b9; cursor: pointer;">terms and conditions</a></p></div>
                        <button type="submit" id="singupsubmit" name="signup-submit" disabled="disabled">Signup</button>
                        </form>
                    </div>
                    
                    <div class="signupsplit col-lg-12" id="teacher-section">
                          
                            <form class="signup-form" action="includes/signup-t.inc.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="col">
                            <input class="signupinputfrm form-control" type="text" name="fname" placeholder="First Name">
                            </div>
                            <div class="col">
                            <input class="signupinputfrm form-control" type="text" name="lname" placeholder="Last Name">
                            </div>
                          </div>
                          <div class="form-row">
                          <div class="col">
                          <select class="signupinputfrm form-control" name="gender"><option selected hidden value="0">Select gender</option>
                          <option value="M">Male</option>
                          <option value="F">Female</option>
                          </select>
                          </div>
                          <div class="col">
                          <input class="signupinputfrm form-control" type="date" placeholder="Birthday" name="bday">
                          </div>
                        </div>
                        <input class="signupinputfrm form-control" type="text" name="address" placeholder="Complete Address">
                            <select class="signupinputfrm form-control" name="department"><option selected hidden value="0">Select department</option>';
                            $coursesql = "SELECT * FROM coursedept WHERE type = 'Department'";
                            $courseres = $conn->query($coursesql);
    
                            while($row = $courseres->fetch_assoc())
                            {
                              echo "<option value = '".$row['title']."'>".$row['code']." - ".$row['title']."</option>";
                            }
                            echo'</select>
                            <input class="signupinputfrm form-control" type="text" name="user" placeholder="Username">
                            <input class="signupinputfrm form-control" type="text" name="email" placeholder="Email">
                            <input class="signupinputfrm form-control" type="text" name="employeeID" placeholder="Employee ID">
                            <input class="signupinputfrm form-control" type="password" id="pass-teach" name="pass" placeholder="Password">
                            <progress class="progress-bar" max="100" value="0" id="pass-strength-teach" name="pass-strength"></progress>
                            <input class="signupinputfrm form-control" type="password" name="pass-repeat" placeholder="Confirm Password">
                            
                            <input class="signupinputfrm form-control" type="file" class="cvsuid" name="imageid" placeholder="Upload photo of your CVSU-SC ID" accept="image/*"></input>
                            <input class="signupinputfrm form-control" type="hidden" name="accounttype" value="Teacher">
                            <p style="font-size: 10px;">Attach a selfie of yourself together with your CVSU - Silang Campus ID</p>
                            <div><p style="font-size: 10px;">By signing up, you agree to our <a style="color: #2980b9; cursor: pointer;">terms and conditions</a></p></div>
                            <button type="submit" id="singupsubmit-teach" name="signup-submit" disabled="disabled">Signup</button>
                            </form>
                        </div>
                            
            </div>
          </div>';
          if(isset($_GET['error']))
          {
            if($_GET['error'] == 'emptyfields' || $_GET['error'] == 'invaliduser' || $_GET['error'] == 'invalidemail' || $_GET['error'] == 'passwordcheck')
            {
            echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: Empty Fields!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
            else if($_GET['error'] == 'sqlerror')
            {
            echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: SQL Error!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
            else if($_GET['error'] == 'emailtaken')
            {
            echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: Email Already Registered!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
            else if($_GET['error'] == 'usertaken')
            {
            echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: Username Already Taken!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
            else if($_GET['error'] == 'imglarge')
            {
              echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: Image too large!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
            else if($_GET['error'] == 'imgerror')
            {
              echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Failed: Image has an error!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
            }
          }
          elseif(isset($_GET['success']))
          {
            echo "<script>
              $('.bootstrap-growl').remove();
              $.bootstrapGrowl('Register Success: Please check your email!',{
                ele: 'body',
                type: 'error',
                offset: {from: 'bottom', amount: 10},
                align: 'left',
                delay: 5000,
                width: 300,
                allow_dismiss: true,
                stackup_spacing: 10
              });
              </script>";
          }
                  
echo '</div>
        
            
        </div>
    </div>';
    echo "<script>
    function showsec(element)
    {
      document.getElementById('student-section').style.display = element.value == 0 ? 'block' : 'none';
      document.getElementById('teacher-section').style.display = element.value == 1 ? 'block' : 'none';
    }
          
    </script>";

    echo '<script type="text/javascript">
          var pass = document.getElementById("pass")
          pass.addEventListener("keyup",function(){
            checkPassword(pass.value)
          })
          function checkPassword(password)
          {
            var strengthBar = document.getElementById("pass-strength")
            var submit = document.getElementById("singupsubmit")
            var strength = 0;
            if (password.match(/[a-zA-Z][a-zA-Z]+/))
            {
                strength +=1
            }
            if (password.match(/[0-9][0-9]+/))
            {
                strength +=1
            }
            if (password.match(/[!@#$%^&*()_+-=/]+/))
            {
                strength +=1
            }
            if (password.length > 6)
            {
                strength +=1
            }
            switch (strength)
            {
              case 0:
                strengthBar.value = 0;
                document.getElementById("pass-strength").style.color = "#e74c3c";
                break;
              case 1:
                strengthBar.value = 20;
                document.getElementById("pass-strength").style.color = "#e74c3c";
                break;
              case 2:
                strengthBar.value = 40;
                document.getElementById("pass-strength").style.color = "#e67e22";
                break;
              case 3:
                strengthBar.value = 60;
                document.getElementById("pass-strength").style.color = "#f1c40f";
                break;
              case 4:
                strengthBar.value = 80;
                document.getElementById("pass-strength").style.color = "#27ae60";
                break;
              case 5:
                strengthBar.value = 100;
                document.getElementById("pass-strength").style.color = "#27ae60";
                break;

            }';
            echo "if (strengthBar.value >= 80)
            {
              submit.removeAttribute('disabled');
            }
            else
            {
              submit.setAttribute('disabled', 'disabled');
            }

          }
        </script>";
?>
 <script type="text/javascript">
          var passa = document.getElementById("pass-teach")
          passa.addEventListener("keyup",function(){
            checkPassworda(passa.value)
          })
          function checkPassworda(passworda)
          {
            var strengthBara = document.getElementById("pass-strength-teach")
            var submita = document.getElementById("singupsubmit-teach")
            var strengtha = 0;
            if (passworda.match(/[a-zA-Z][a-zA-Z]+/))
            {
                strengtha +=1
            }
            if (passworda.match(/[0-9][0-9]+/))
            {
                strengtha +=1
            }
            if (passworda.match(/[!@#$%^&*()_+-=/]+/))
            {
                strengtha +=1
            }
            if (passworda.length > 6)
            {
                strengtha +=1
            }
            switch (strengtha)
            {
              case 0:
                strengthBara.value = 0;
                document.getElementById("pass-strength-teach").style.color = "#e74c3c";
                break;
              case 1:
                strengthBara.value = 20;
                document.getElementById("pass-strength-teach").style.color = "#e74c3c";
                break;
              case 2:
                strengthBara.value = 40;
                document.getElementById("pass-strength-teach").style.color = "#e67e22";
                break;
              case 3:
                strengthBara.value = 60;
                document.getElementById("pass-strength-teach").style.color = "#f1c40f";
                break;
              case 4:
                strengthBara.value = 80;
                document.getElementById("pass-strength-teach").style.color = "#27ae60";
                break;
              case 5:
                strengthBara.value = 100;
                document.getElementById("pass-strength-teach").style.color = "#27ae60";
                break;

            }
            if (strengthBara.value >= 80)
            {
              submita.removeAttribute('disabled');
            }
            else
            {
              submita.setAttribute('disabled', 'disabled');
            }

          }
        </script> </main>