<?php
  include 'includes/dbh.inc.php';
  require "header.php";
 ?>
<main>
    <?php
    if (isset($_SESSION['userId']))
    {
      echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
      exit;
    }
    else if (isset($_POST['signup-adminheader']))
    {
      $getadminsql = "SELECT * FROM users WHERE accounttypeUsers = 'Admin'";
      $getadminresult = $conn->query($getadminsql);
      $getadminnumrow = mysqli_num_rows($getadminresult);
      if($getadminnumrow <= 1)
      {
            echo "<div class='signupbg' style='background-image: url(images/admin-signup-img.jpg); height: 100vh;'>
              <div class='col'>
                <div class='row'>
                  <div class='signupctn text-center box-divs' style='margin-top: 5%;'>
                      <h1 class='card-header'>REGISTER AS ADMIN</h1>
                      <div class='card-body'>
                        <div class='row-sm-12'>
                          <form class='signup-form' action='includes/admin-signup.inc.php' method='post' enctype='multipart/form-data'>
                          <input class='signupinputfrm form-control' type='text' placeholder='First Name' name='fname' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='text' name='lname' placeholder='Last Name' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='text' name='user' placeholder='Username' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='email' name='email' placeholder='Email' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='text' name='employeeID' placeholder='Employee ID' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='password' id='pass' name='pass' placeholder='Password' style='width: 100%;'>
                          <progress class='progress-bar' max='100' value='0' id='pass-strength' name='strength' style='width: 100%;'></progress>
                          <input class='signupinputfrm form-control' type='password' name='pass-repeat' placeholder='Confirm Password' style='width: 100%;'>
                          <input class='signupinputfrm form-control' type='hidden' name='accounttype' value='Admin' style='width: 100%;'>
                          <button type='submit' id='singupsubmit' name='signup-submit' disabled='disabled'>Signup</button>
                          </form>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>";
      }
      else
      {
        echo "<script type='text/javascript'>window.top.location='index.php';</script>"; 
        exit;
      }
      
        
    }
    else 
    {
      echo "<script type='text/javascript'>window.top.location='index.php';</script>"; 
      exit;
    }
    ?>
    
    <script type="text/javascript">
          var pass = document.getElementById("pass")
          pass.addEventListener('keyup',function(){
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

            }
            if (strengthBar.value >= 80)
            {
              submit.removeAttribute('disabled');
            }
            else
            {
              submit.setAttribute('disabled', 'disabled');
            }

          }
        </script>
</main>