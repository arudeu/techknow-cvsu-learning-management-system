<?php
  date_default_timezone_set('Asia/Manila');
  include 'includes/dbh.inc.php';
  include 'includes/posts.inc.php';
  include 'includes/groups.inc.php';
  include 'includes/upload.inc.php';
  require "header.php";
 ?>
<main>
  <script src='/js/techknow-script.js'></script>
  <link rel="stylesheet" href="css/styles.css" type="text/css">

  <?php
  if (isset($_SESSION['userId']))
  {
    $id = $_SESSION['userId'];
    $sql = "SELECT * FROM users WHERE idUsers = $id";
    $result = $conn->query($sql);
    echo "<div class='container-fluid padding box-container'>
          <div class='grid-padding' style='background: #dfe4ea; padding:10px;'>
            <div class='row-lg-12'>
                    <div class='box-divs'>
                    <div class='row user-header'>
                      <div class='row user-image'>
                      ";
                      $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
                      $resultImg = $conn->query($sqlImg);
                      echo "<form action='includes/upload.inc.php' method='POST' enctype='multipart/form-data'>
                      <input type='file' name='avatar' class='changeprofilepic' onchange='displayImage(this)' id='profilepic' accept='image/*'></input>
                      <label for='profilepic' id='avatar'>";
                      if(mysqli_num_rows($resultImg) > 0)
                      {
                        while($rowImg = $resultImg->fetch_assoc())
                        {
                          if($rowImg['status'] == 0)
                          {
                            echo "<img src='uploads/profile".$id.".jpg' onclick='triggerUpload()' id='profiledisplay' onclick='triggerUpload()'>";
                          }
                          else
                          {
                            echo "<img src='images/techknow-unknown.png' onclick='triggerUpload()' id='profiledisplay' onclick='triggerUpload()'>";
                          }
                        }
                     }
                     else
                       {
                         echo "<img src='images/techknow-unknown.png' id='profiledisplay' onclick='triggerUpload()'>";
                       }
                       echo "</label>
                       <button id='uploadprofile' type='submit' name='upload' onclick='hideUpload()'>Upload</button>
                       </form>";

                      echo"</div>
                    </div>
                      <div class='row user-fullname'>";
                      while($row = $result->fetch_assoc())
                      {
                          echo "<title>".$row['fnameUsers']." ".$row['lnameUsers']." | TechKnow</title>";
                          echo "<input type='text' name='' disabled value='".$row['fnameUsers']." ".$row['lnameUsers']."'>";


                        echo"</div>
                        <div class='user-name'>";
                          echo "
                          <button id='editprofile' style = 'font-size: 15px;' onclick='enableinputprofile()'>Edit Profile</button>
                          <form method='POST' action='includes/edit-profile.inc.php'>
                          <div class='user-name text-center'>
                          <button id='submitprofile' style = 'font-size: 15px; display: none;' type='submit' name='editsubmit'>Save Profile</button>
                          </div>
                        </div>
                        </div>";


                        if ($row['accounttypeUsers']=='Student')
                        {
                          echo"<div class = 'col-md-12'>
                            <div class = 'row'>
                                <div class='col box-divs'>
                                  <div class='user-pinfo'>

                                  <h6><i class='fas fa-signature'></i>First Name</h6>
                                  <input class='inputprofile' type='text' id='fname-profile' name='fname' disabled value='".$row['fnameUsers']."'>

                                  <h6><i class='fas fa-signature'></i>Last Name</h6>
                                  <input class='inputprofile' type='text' id='lname-profile' name='lname' disabled value='".$row['lnameUsers']."'>

                                  <h6><i class='fas fa-map-marker-alt'></i></i>Address</h6>
                                  <input class='inputprofile' type='text' id='address-profile' name='address' disabled value='".$row['addressUsers']."'>

                                  <h6><i class='fas fa-birthday-cake'></i></i>Birthday</h6>
                                  <input class='inputprofile' type='date' id='bday-profile' name='bday' disabled value='".$row['bdayUsers']."'>

                                  </div>
                                </div>
                                <div class='col box-divs'>
                                  <div class='user-pinfo'>

                                  <h6><i class='fas fa-user'></i>Username</h6>
                                  <input class='inputprofile' type='text' id='username-profile' name='user' disabled value='".$row['usernameUsers']."'>

                                  <h6><i class='fas fa-book'></i>Course</h6>
                                  <select id='course-profile' name='course' disabled>
                                  <option selected hidden value='".$row['course']."'>".$row['course']."</option>
                                  ";
                                  $coursesql = "SELECT * FROM coursedept WHERE type = 'Course'";
                                  $courseres = $conn->query($coursesql);

                                  while($courserow = $courseres->fetch_assoc())
                                  {
                                    echo "<option value = '".$courserow['title']."'>".$courserow['code']." - ".$courserow['title']."</option>";
                                  }
                                  echo"</select>

                                  <h6><i class='fas fa-graduation-cap'></i>Student ID</h6>
                                  <input class='inputprofile' type='text' id='studentid-profile' name='sid' disabled value='".$row['studentIDUsers']."'>

                                  <h6><i class='fas fa-envelope-open-text'></i>Email</h6>
                                  <input type='email' id='email-profile' disabled value='".$row['emailUsers']."'>


                                  </div>
                                </div>
                              </div>";

                        }
                        elseif($row['accounttypeUsers']=='Teacher')
                        {
                           echo"<div class = 'col-md-12'>
                            <div class = 'row'>
                                <div class='col box-divs'>
                                  <div class='user-pinfo'>

                                  <h6><i class='fas fa-signature'></i>First Name</h6>
                                  <input class='inputprofile' type='text' id='fname-profile' name='fname' disabled value='".$row['fnameUsers']."'>

                                  <h6><i class='fas fa-signature'></i>Last Name</h6>
                                  <input class='inputprofile' type='text' id='lname-profile' name='lname' disabled value='".$row['lnameUsers']."'>

                                  <h6><i class='fas fa-map-marker-alt'></i></i>Address</h6>
                                  <input class='inputprofile' type='text' id='address-profile' name='address' disabled value='".$row['addressUsers']."'>

                                  <h6><i class='fas fa-birthday-cake'></i></i>Birthday</h6>
                                  <input class='inputprofile' type='date' id='bday-profile' name='bday' disabled value='".$row['bdayUsers']."'>

                                  </div>
                                </div>
                                <div class='col box-divs'>
                                  <div class='user-pinfo'>

                                  <h6><i class='fas fa-user'></i>Username</h6>
                                  <input class='inputprofile' type='text' id='username-profile' name='user' disabled value='".$row['usernameUsers']."'>

                                  <h6><i class='fas fa-book'></i>Department</h6>
                                  <select id='course-profile' name='dept' disabled>
                                  <option selected hidden value='".$row['departmentUsers']."'>".$row['departmentUsers']."</option>
                                  ";
                                  $deptsql = "SELECT * FROM coursedept WHERE type = 'Department'";
                                  $deptres = $conn->query($deptsql);

                                  while($deptrow = $deptres->fetch_assoc())
                                  {
                                    echo "<option value = '".$deptrow['title']."'>".$deptrow['code']." - ".$deptrow['title']."</option>";
                                  }
                                  echo"</select>
                                  <h6><i class='fas fa-graduation-cap'></i>Employee ID</h6>
                                  <input class='inputprofile' type='text' id='studentid-profile' name='eid' disabled value='".$row['employeeIDUsers']."'>

                                  <h6><i class='fas fa-envelope-open-text'></i>Email</h6>
                                  <input type='email' id='email-profile' disabled value='".$row['emailUsers']."'>


                                  </div>
                                </div>
                              </div>";

                        }


                    }

echo "</form>
</div>";

  }
  else
  {
    echo "<script type='text/javascript'>window.top.location='index.php';</script>"; 
    exit;
  }
   ?>

<script>
  function enableinputprofile()
  {
    document.getElementById('editprofile').style.display= "none";
    document.getElementById('submitprofile').style.display= "block";
    document.getElementById('editprofile').style.visibility= "hidden";
    document.getElementById('submitprofile').style.visibility= "visible";

    document.getElementById('fname-profile').disabled = false;
    document.getElementById('lname-profile').disabled = false;
    document.getElementById('address-profile').disabled = false;
    document.getElementById('bday-profile').disabled = false;
    document.getElementById('username-profile').disabled = false;
    document.getElementById('course-profile').disabled = false;
    document.getElementById('studentid-profile').disabled = false;
    document.getElementById('dept-profile').disabled = false;
    document.getElementById('employeeid-profile').disabled = false;

    

  }
</script>
</main>
