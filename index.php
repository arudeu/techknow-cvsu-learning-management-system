<?php
  require "header.php";

        if (isset($_SESSION['userId']))
        {
          echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
          exit;
        }
        else if(isset($_SESSION['adminuserId']))
        {
          echo "<script type='text/javascript'>window.top.location='admin.php';</script>"; 
          exit;
        }
        else 
        {
          echo "<head>";
          echo "<title>TechKnow</title>";
          echo "</head>";
          if (isset($_GET['error']))
          {
            if($_GET['error'] == 'emptyfields' || $_GET['error'] == 'nouser' || $_GET['error'] == 'statusdeclined' || $_GET['error'] == 'wrongpwd' || $_GET['error'] == 'sqlerror')
            {
              echo '<main>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                  <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active" style="background-image: url(images/slide1.jpg);">
                    <div class="slidertxt carousel-caption text-center">
                    <h1>WELCOME TO TECHKNOW</h1>
                    <h3>A Video Live Streaming Learning Management System for Cavite State University - Silang Campus</h3>
                    <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                    </div>
                  </div>
                  <div class="carousel-item" style="background-image: url(images/slide2.jpg);">
                    <div class="slidertxt carousel-caption text-center">
                    <h1>INTERACT WITH YOUR STUDENTS!</h1>
                    <h3>Teach Your Students Live Without Using Any Third Party Software</h3>
                    <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                    </div>
                  </div>
                  <div class="carousel-item" style="background-image: url(images/slide3.jpg);">
                    <div class="slidertxt carousel-caption text-center">
                    <h1>CONNECT WITH YOUR TEACHERS!</h1>
                    <h3>Comply With Your Academic Requirements In The Space Of Your Own Home</h3>
                    <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>';
              echo "<script>
              $.bootstrapGrowl('Login Failed',{
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
          else
          {
            echo '<main>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url(images/slide1.jpg);">
                  <div class="slidertxt carousel-caption text-center">
                  <h1>WELCOME TO TECHKNOW</h1>
                  <h3>A Video Live Streaming Learning Management System for Cavite State University - Silang Campus</h3>
                  <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                  </div>
                </div>
                <div class="carousel-item" style="background-image: url(images/slide2.jpg);">
                  <div class="slidertxt carousel-caption text-center">
                  <h1>INTERACT WITH YOUR STUDENTS!</h1>
                  <h3>Teach Your Students Live Without Using Any Third Party Software</h3>
                  <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                  </div>
                </div>
                <div class="carousel-item" style="background-image: url(images/slide3.jpg);">
                  <div class="slidertxt carousel-caption text-center">
                  <h1>CONNECT WITH YOUR TEACHERS!</h1>
                  <h3>Comply With Your Academic Requirements In The Space Of Your Own Home</h3>
                  <a class="btn btn-outline-light btn-lg" href="signup.php">Get Started</a>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>';
          }
        

        }

echo '<div class="modal fade" id="forgotmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Forgot password?</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body" id="check-forgotpassword">

</div>

</div>
</div>
</div>';

echo "<footer class='footer-index'>
<div class='container-fluid padding'>
  <div class='row text-center'>
        <div class='col-md-6'>
        <hr class='dark'>
        <img src='images/tc-logo-1.png' alt='techknow-logo' style='width:150px; height:auto;'>
        <hr class='dark'>
        <p>info@techknowcvsu.live</p>
        <p>Barangay Biga I, Silang, Cavite, Philippines</p>
        </div>
        <div class='col-md-6'>
        <hr class='light'>
        <h5>CONNECT</h5>
        <hr class='dark'>
        <p><a href='https://www.facebook.com/techknowcvsu' target='_blank'>Facebook</a></p>
        <p><a href='https://twitter.com/techknowcvsu' target='_blank'>Twitter</a></p>
        </div>
        <div class='col-12'>
        <hr class='dark'>
        <h5>TECHKNOWCVSU | 2020</h5>
        </div>
        
  </div>
  
</div>
</footer>";

if (isset($_GET['resetpass']))
{
  if($_GET['resetpass'] == "success")
  {
    echo "<script>
              $.bootstrapGrowl('Check your email to reset your password!',{
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
  elseif($_GET['resetpass'] == "fieldsempty")
  {
    echo "<script>
              $.bootstrapGrowl('Password reset fields empty. Please try again!',{
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
  elseif($_GET['resetpass'] == "newpassdoesntmatch")
  {
    echo "<script>
              $.bootstrapGrowl('Your new password doesn't match. Please try again!,{
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
elseif(isset($_GET['passwordresetsuccess']))
{
  echo "<script>
  $.bootstrapGrowl('Password changed successfully!,{
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
      echo"</main>";
