<?php
require "header.php";

$selector = $_GET['selector'];
$validator = $_GET['validator'];

if(empty($selector) || empty($validator))
{
    echo "<script type='text/javascript'>window.top.location='index.php';</script>"; 
        exit;
}
echo "<head>";
echo "<title>Forgot Password | TechKnow</title>";
echo "</head>";
if(ctype_xdigit($selector) == true && ctype_xdigit($validator) == true)
{
    echo "<main>";
    echo "<div class='container-fluid padding box-container text-center' style='height: 95vh;'>";
        echo "<div class='grid-padding'>";
        echo "<div class='col-md-12' style='top: 200px;'>";
        echo "<div class='row-md-6'>";
        echo "<div class='box-divs text-center' style='margin: 0 20%;'>";
        echo "<div class='card-body'>";
        echo "<h4 style='color: #5D008E; font-weight: 600;'>RESET PASSWORD</h4>";
            echo "<form action='includes/createnewpassword.inc.php' method='POST'>
            <div class='form-group'>
            <input type='hidden' name='selector' value='".$selector."'>
            <input type='hidden' name='validator' value='".$validator."'>
            <input class='signupinputfrm form-control' id='pass' type='password' name='newpassword' placeholder='Enter new password...'>
            <progress class='progress-bar' max='100' value='0' id='pass-strength' name='pass-strength'></progress>
            <input class='signupinputfrm form-control' type='password' name='newpasswordrepeat' placeholder='Repeat new password...'>
            <button id='signupsubmit' name='reset-password' type='submit' style='width: 100%;' disabled='disabled'>Reset password</button>
            </div>
            </form>";
            echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    echo "</div>";
    echo "</main>";
    echo '<script type="text/javascript">
var pass = document.getElementById("pass")
pass.addEventListener("keyup",function(){
  checkPassword(pass.value)
})
function checkPassword(password)
{
  var strengthBar = document.getElementById("pass-strength")
  var submit = document.getElementById("signupsubmit")
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
        </script>";echo '<script type="text/javascript">
        var pass = document.getElementById("pass")
        pass.addEventListener("keyup",function(){
          checkPassword(pass.value)
        })
        function checkPassword(password)
        {
          var strengthBar = document.getElementById("pass-strength")
          var submit = document.getElementById("signupsubmit")
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
}
