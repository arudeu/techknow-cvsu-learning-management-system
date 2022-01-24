<?php
include 'includes/dbh.inc.php';
echo '<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/8005793680.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Detect.js/2.2.2/detect.min.js" integrity="sha512-iNuMM5cmiXDvk4VCTp6UEbDwYy/dA3CFTTYKB6/V+LD62S58TQZ+sykXzhmVT1QvqHD39ZhecsPGXjZUaIuSWQ==" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap-growl/jquery.bootstrap-growl.min.js"></script>
  </head>
  <body>
  <header>';
        if (isset($_SESSION['userId']))
        {
          $id = $_SESSION['userId'];
          $sql = "SELECT * FROM users WHERE idUsers = $id";
          $result = $conn->query($sql);
          while($row = $result->fetch_assoc())
          { 
            $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
            $resultImg = $conn->query($sqlImg);
            echo '<nav class="tc-nv-br navbar navbar-light bg-inverse navbar-expand-lg fixed-top">
          <a class="navbar-brand techknow-logo float-left" href="home.php">
            <img src="images/tc-logo-1.png" alt="techknow-logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"  style="color: #E84118;">
          <span class="navbar-toggler-icon"></span>
          </button>

          <div class="logincreds collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="home.php"><i class="fas fa-chalkboard-teacher chalkboard-teacher"></i>Blackboard</a></li>
              <li class="nav-item"><a href="class.php"><i class="fas fa-chalkboard chalkboard"></i>Classes</a></li>
              '//<li class="nav-item"><a href="#"><i class="fas fa-pen pen"></i>Quizzes</a></li>
              .'
              <li class="nav-item"><a href="user.php?id='.$id.'">';
              while($rowImg = $resultImg->fetch_assoc())
              {
                  if ($rowImg['status'] == 0)
                  {
                    echo'<img src="uploads/profile'.$row['idUsers'].'.jpg" style="height:20px; width:20px; margin-right:5px; border-radius: 180px;">';
                  }
                  elseif (($rowImg['status'] == 1))
                  {
                    echo'<img src="images/techknow-unknown.png" alt="unknown-pic" style="height:20px; width:20px; margin-right:5px; border-radius: 180px;">';
                  }
                
              }
              

              echo $row['fnameUsers'].'</a>
              </li>
              <li class="nav-item dropdown">
              <a nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell bell"></i>
              </a>
              <ul class="notifbox dropdown-menu" aria-labelledby="navbarDropdown">';
              $userid = $_SESSION['userId'];
              $notificationsql = "SELECT * FROM notifications WHERE notifgrp IN (SELECT grpcode FROM members WHERE memberID = '$userid') ORDER BY notifdate DESC LIMIT 5";
              $notificationres = $conn->query($notificationsql);
              while($notifrow = $notificationres->fetch_assoc())
              {
                $notifimg = $notifrow['userid'];
                $getusersql = "SELECT * FROM profileimg WHERE idUsers = '$notifimg'";
                $getuserres = $conn->query($getusersql);
                while($getuserrow = $getuserres->fetch_assoc())
                {
                  
                    echo '<li class="dropdown-item"><a class="notifmsg">';
                  if($getuserrow['status'] == 0)
                  {
                    echo '<img src="uploads/profile'.$notifrow['userid'].'.jpg"';
                  }
                  elseif($getuserrow['status'] == 1)
                  {
                    echo '<img src="images/techknow-unknown.png"';
                  }
                    echo'style="width:50px; height:50px;  border-top-left-radius: 5px; border-bottom-left-radius: 5px;"><p>'.$notifrow["notifmsg"].'</p></a></li>';
                  
                  
                  
                }
                
              }
              echo'</ul>
              </li>
              <form class="log" action="includes/logout.inc.php" method="POST">
              <li class="nav-item"><button class="logouts" type="submit" name="logout-submit"><i class="fas fa-sign-out-alt signout"></i>Logout</button></li>
              </form>
              
            </ul>
          </div>
          </nav>';
          }

        }
        else if (isset($_SESSION['adminuserId']))
        {
          echo '<nav class="tc-nv-br navbar navbar-light bg-inverse navbar-expand-lg fixed-top">
          <a class="navbar-brand techknow-logo float-left" href="admin.php">
            <img src="images/tc-logo-1.png" alt="techknow-logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"  style="color: #E84118;">
          <span class="navbar-toggler-icon"></span>
          </button>

          <div class="logincreds collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="admin.php"><i class="approve fas fa-thumbs-up"></i>Signup Approval</a></li>
              <li class="nav-item"><a href="admin.php?type=flags"><i class="reports fab fa-font-awesome-flag"></i>Flag Reports</a></li>
              <li class="nav-item"><a href="admin.php?type=departments"><i class="plus fas fa-plus"></i>Add</a></li>
              <form class="log" id="logout" action="includes/logout.inc.php" method="post">
                  <li class="nav-item"><button class="logouts" type="submit" name="logout-submit"><i class="fas fa-sign-out-alt signout"></i>Logout</button></li>
              </form>
            </ul>
          </div>
          </nav>';
        }
        
        else {
          echo '<nav class="tc-nv-br navbar navbar-light bg-inverse navbar-expand-lg fixed-top">
          <a class="navbar-brand techknow-logo" href="index.php">
            <img src="images/tc-logo-1.png" alt="techknow-logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="color: #E84118;">
          <span class="navbar-toggler-icon"></span>
          </button>

          <div class="logincreds collapse navbar-collapse" id="navbarResponsive" style="justify-content: center">
          <form class="log" action="includes/login.inc.php" method="post">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item"><input type="text" name="userid" placeholder="Username"></li>
            <li class="nav-item"><input type="password" name="passid" placeholder="Password"></li>
            <li class="nav-item"><a class="forgot-pass" data-toggle="modal" data-target="#forgotmodal">Forgot Password?</a></li>
            <li class="nav-item"><button class="login-submit" type="submit" name="login-submit">Login</button></li>
            </ul>
          </form>
          </div>
          </nav>';
        }

  echo '</header>';
  echo '</body>';
  echo '<script src="js/techknow-script.js"></script>';
  echo '<script>';
      echo '$(document).ready(function(){';
    echo '$(".get-id").click(function(){';
      echo "var idUsers = $(this).data('id');";
       echo '$.ajax({
         url:"includes/test-comment.inc.php",';
         echo "method:'POST',";
         echo "data:{idUsers:idUsers},
         success:function(data){
           
           $('#check-id').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo '<script>';
      echo '$(document).ready(function(){';
    echo '$(".get-status").click(function(){';
      echo "var idUsers = $(this).data('id');";
       echo '$.ajax({
         url:"includes/admin-approval.inc.php",';
         echo "method:'POST',";
         echo "data:{idUsers:idUsers},
         success:function(data){
           
           $('#check-status').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo '<script>';
      echo '$(document).ready(function(){';
    echo '$(".get-reportpostview").click(function(){';
      echo "var postID = $(this).data('id');";
       echo '$.ajax({
         url:"includes/admin-postview.inc.php",';
         echo "method:'POST',";
         echo "data:{postID:postID},
         success:function(data){
           
           $('#check-adminpostview').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo '<script>';
      echo '$(document).ready(function(){';
    echo '$(".get-admindel").click(function(){';
      echo "var idUsers = $(this).data('id');";
       echo '$.ajax({
         url:"includes/admin-delete.inc.php",';
         echo "method:'POST',";
         echo "data:{idUsers:idUsers},
         success:function(data){
           
           $('#check-admindel').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo '<script>';
      echo '$(document).ready(function(){';
    echo '$(".get-adminview").click(function(){';
      echo "var idUsers = $(this).data('id');";
       echo '$.ajax({
         url:"includes/admin-view.inc.php",';
         echo "method:'POST',";
         echo "data:{idUsers:idUsers},
         success:function(data){
           
           $('#check-adminview').html(data);
         
         }
         
       });
    });
    
  });
  </script>";
  
  echo"
  <script>
      $(document).ready(function(){";
    echo '$(".get-kickmember").click(function(){';
      echo "var memid = $(this).data('todo').memid;
      var room = $(this).data('todo').room;
       $.ajax({";
         echo'url:"includes/class-kickmember.inc.php",';
         echo "method:'POST',
         data:{
           memid:memid, 
           room:room
          },
         success:function(data){
           alert(memid)
           $('#check-kickmember').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo"
  <script>
      $(document).ready(function(){";
    echo '$(".get-deletecoursedept").click(function(){';
      echo "var id = $(this).data('id');
       $.ajax({";
         echo'url:"includes/admin-coursedeptdelete.inc.php",';
         echo "method:'POST',
         data:{id:id},
         success:function(data){
           
           $('#check-admincoursedeptdelete').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo"
  <script>
      $(document).ready(function(){";
    echo '$(".get-reportpostdelete").click(function(){';
      echo "var postID = $(this).data('id');
       $.ajax({";
         echo'url:"includes/admin-postdelete.inc.php",';
         echo "method:'POST',
         data:{postID:postID},
         success:function(data){
           
           $('#check-adminpostdelete').html(data);
         
         }
         
       });
    });
    
  });
  </script>";

  echo"
  <script>
      $(document).ready(function(){";
    echo '$(".forgot-pass").click(function(){';
      echo "var postID = $(this).data('id');
       $.ajax({";
         echo'url:"includes/forgotpassword-modal.inc.php",';
         echo "method:'POST',
         data:{postID:postID},
         success:function(data){
           
           $('#check-forgotpassword').html(data);
         
         }
         
       });
    });
    
  });
  </script>

  <script>
      $(document).ready(function(){";
    echo '$(".get-delete").click(function(){';
      echo "var postID = $(this).data('id');
       $.ajax({";
         echo'url:"includes/post-modal.inc.php",';
         echo "method:'POST',
         data:{postID:postID},
         success:function(data){
           
           $('#check-delete').html(data);
         
         }
         
       });
    });
    
  });
  </script>

  <script>
      $(document).ready(function(){";
    echo '$(".get-group-delete").click(function(){';
      echo "var grpcode = $(this).data('id');
       $.ajax({";
         echo'url: "includes/groups-delete-modal.inc.php",';
         echo "method:'POST',
         data:{grpcode:grpcode},
         success:function(data){
           
           $('#check-class-delete').html(data);
         
         }
         
       });
    });
    
  });
  </script>

  <script>
      $(document).ready(function(){";
    echo '$(".get-group-archive").click(function(){';
      echo "var grpcode = $(this).data('id');
       $.ajax({";
         echo'url: "includes/groups-archive-modal.inc.php",';
         echo "method:'POST',
         data:{grpcode:grpcode},
         success:function(data){
           
           $('#check-group-archive').html(data);
         
         }
         
       });
    });
    
  });
  </script>
  
<script>";



      echo "$(document).ready(function(){";
   echo'$(".get-edit").click(function(){';
      echo "var postID = $(this).data('id');
       $.ajax({";
         echo'url:"includes/post-edit-modal.inc.php",';
         echo"method:'POST',
         data:{postID:postID},
         success:function(data){
           
           $('#check-edit').html(data);
         
         }
         
       });
    });
    
  });
  </script>

<script>
      $(document).ready(function(){";
    echo '$(".get-report").click(function(){';
      echo "var postID = $(this).data('id');
       $.ajax({";
         echo 'url:"includes/post-report-modal.inc.php",';
         echo "method:'POST',
         data:{postID:postID},
         success:function(data){
           
           $('#check-report').html(data);
         
         }
         
       });
    });
    
  });
  </script>
  

  <script>
  
  </script>
</html>";
