<?php
  date_default_timezone_set('Asia/Manila');
  include 'includes/dbh.inc.php';
  include 'includes/posts.inc.php';
  include 'includes/groups.inc.php';
  include 'includes/upload.inc.php';
  require "header.php";
 ?>
<head>

<link rel="stylesheet" href="css/styles.css" type="text/css">

</head>

<main>
<?php
        if (isset($_SESSION['userId']))
        {
          echo "<div class='container-fluid padding box-container'>";
        }
        else
        {
          echo "<script type='text/javascript'>window.top.location='index.php';</script>"; 
          exit;
        }
?>

    <?php
      $postID = $_GET['title'];
      $submissionsql = "SELECT * FROM posts WHERE postID = '$postID'";
      $submissionresult = $conn->query($submissionsql);

      echo "<div class='row'>";
        
        echo "<div class='col-md-6'>";
        
        while($row = $submissionresult->fetch_assoc())
        {
          $id = $row['userID'];
          $sql1 = "SELECT * FROM users WHERE idUsers='$id'";
          $result1 = $conn->query($sql1);
  
          $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
          $resultImg = $conn->query($sqlImg);
          if ($row1 = $result1->fetch_assoc())
          {
            
            echo "<div class='row make-me-sticky' id='user-post'>";
            echo "<div class='row-md-3 col-md-12 user-avatar'>";
            while($rowImg = $resultImg->fetch_assoc())
            {
              if($rowImg['status'] == 0)
               {
                 echo "<img src='uploads/profile".$id.".jpg'>";
               }
               else
               {
                 echo "<img src='images/techknow-unknown.png'>";
               }
            }
            echo "<div id='row-md-4 user-name'>";
            echo "Posted by  <strong>".$row1['fnameUsers']." ".$row1['lnameUsers'];
            if ($row1['accounttypeUsers'] == "Teacher")
            {
              echo "<i class='fas fa-check-circle' style='color: #5D008E; margin-left: 3px;'></i>";
            }
            echo "</strong>";
            echo "</div>";
            echo "<title>".$row['subjectID']."</title>";
            echo  "<div id='row-md-4 user-edit'>";
            echo  "<form id='user-edit' method='POST'>
  
                  <input type='hidden' name='uid' value='".$row['userID']."'>
                  <input type='hidden' name='ugrp' value='".$row['groupID']."'>
                  <input type='hidden' name='date' value='".$row['date']."'>
                  <input type='hidden' name='subject' value='".$row['subjectID']."'>
                  <input type='hidden' name='message' value='".$row['message']."'>
                  </form>
                  ";
            echo  "</div>";
  
            echo "<div id='row-md-4 user-group'>";
            echo "From <strong>".$row['groupID']."</strong>";
            echo "<span style='margin:0 5px; background: #5D008E; color: #ecf0f1; padding: 0 10px; border-radius: 10px;
            font-weight: 600; font-size: 10px;'>".$row['posttype']."</span>";
            echo "</div>";
  
            echo "</div>";
  
            
            
            echo "<div class='row-md-6 col-md-12 user-subject'>";
            echo $row['subjectID'];
            echo "";
            echo "<div class='row-md-6 user-date'>";
            
            //$myDateTime = DateTime::createFromFormat('Y-m-d', $weddingdate);
            //$formattedweddingdate = $myDateTime->format('d-m-Y');
  
            $datepost = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
            $finaldate = $datepost->format('F d, Y - H:i A');
            echo $finaldate;
  
  
            echo "</div>";
  
            echo "</div>";
  
  
            
            echo "<div class='row-md-3 user-message'> <p>";
            echo $row['message'];
            echo "</p></div>";
            echo "<div id='user-attach-image'>";
            echo "</div>";
  
            if ($row['imgStatus'] == 1)
            {
              echo "<img id= 'img-holder' src='uploads/".$row['imagename']."'>";
            }
            if ($row['imgStatus'] == 0)
            {
              echo "";
            }
            if ($row['attachstatus'] == 1)
            {
              echo "<div id= 'attach-holder'><a href='fileuploads/".$row['attachname']."'><h5>".$row['attachname']."</h5><strong>Uploaded by ".$row1['fnameUsers']." ".$row1['lnameUsers']."</strong></a></div>";
            }
            if ($row['attachstatus'] == 0)
            {
              echo "";
            }
            if ($row['videostatus'] == 1)
            {
              echo "<video class='vid-holder' id= 'vid-holder' controls loop>";
              echo "<source src='videouploads/".$row['videoname']."'>";
              echo "</video>";
            }
            if ($row['videostatus'] == 0)
            {
              echo "";
            }

            $pid = $row['postID'];
            $id = $_SESSION['userId'];
            $submissioncheckersql = "SELECT * FROM submissions WHERE userID = '$id' OR postID = '$pid'";
            $submissioncheckerres = $conn->query($submissioncheckersql);
            $submissioncheckernum = mysqli_num_rows($submissioncheckerres);

            $datedeadline = $row['deadlinedate'];
            $date_now = date('Y-m-d H:i:s');
  
            if($row['posttype'] == 'Activity')
            {
              echo "<strong>Deadline: ".$datedeadline."</strong>";
              
              if($date_now > $datedeadline)
              {
                if($row1['accounttypeUsers'] == 'Student')
                {
                  if($submissioncheckernum <= 0)
                  {
                    echo "<label style='background: #c0392b; padding: 0 10px; margin-left: 10px; border-radius:10px; font-size:12px;'><strong style='color: #ecf0f1;'>Missing</strong></label>";
                  }
                  else
                  {
                    echo "<label style='background: #c0392b; padding: 0 10px; margin-left: 10px; border-radius:10px; font-size:12px;'><strong style='color: #27ae60;'>Submitted</strong></label>";
                  }
                }
                else if($row1['accounttypeUsers'] == 'Teacher')
                {
                  echo "";
                }
              }
              else
              {
                echo "";
              }
            }
            if($row['posttype'] == 'Quiz')
            {
              echo "<strong>Schedule: ".$finaldatedeadline."</strong>";
            }

          }
        }
        echo "</div>";
        echo "</div>";
        
       //SUBMISSION
       echo "<div class='col-md-6'>";
          
      echo "<div class='make-me-sticky'>";
              if($_GET['type']=='Activity')
              {
                $id = $_SESSION['userId'];
                $postId = $_GET['title'];
                $sql1 = "SELECT * FROM users WHERE idUsers='$id'";
                $result1 = $conn->query($sql1);
                while($row1 = $result1->fetch_assoc())
                {
                  if($row1['accounttypeUsers'] == 'Teacher')
                  {
                    echo "";
                  }
                  else if($row1['accounttypeUsers'] == 'Student')
                  {
                    
                    $submissionchecksql = "SELECT * FROM submissions WHERE userID = '$id' AND postID = '$postId'";
                    $submissioncheckresult = $conn->query($submissionchecksql);
                    $submissionchecknum = mysqli_num_rows($submissioncheckresult);
                    if ($submissionchecknum > 0)
                    {
                      echo "<div class='row-md-12 box-divs' style='background: #5D008E; color: #ecf0f1; border-color: #5D008E;'>";
                      echo "<h3 class='text-center'>You've already submitted your activity</h3>";
                      echo "</div>";
                    }
                    else
                    {
                      
                      $submissionsql = "SELECT * FROM posts WHERE postID = '$postID'";
                      $submissionresult = $conn->query($submissionsql);
                      while($submissionrow = $submissionresult->fetch_assoc())
                      {
                        $date_now = date('Y-m-d H:i:s');

                        if($date_now > $submissionrow['deadlinedate'])
                        {
                          echo "<div class='row-md-12 box-divs' style='background: #c0392b; color: #ecf0f1; border-color: #c0392b;'>";
                          echo "<h3 class='text-center'>Deadline has passed</h3>";
                          echo "</div>";
                        }
                        else
                        {
                          echo "<div class='row-md-12 box-divs'>";
                          echo "<form id='postform' action='".setSubmit($conn)."' method='post' enctype='multipart/form-data'>"; 
                          echo "<h5>SUBMISSION</h5>";
            
                            echo "<div class='row'>";
            
                              echo "<div class='col-md-6 submit-input'>";
                              //SUBMIT HERE
                                echo "<input type='hidden' name='uid' value='".$_SESSION['userId']."'>
                                <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                              <input id='img-upload' type='file' accept='image/*' name='imageupload' onchange='displayAttachImage(this)'></input>
                              <label for='img-upload' id='img-upload'><i class='fas fa-image'></i></label>
                              <input id='file-upload' type='file' accept='application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                              text/plain, application/pdf' name='fileupload'></input>
                              <label for='file-upload'><i class='fas fa-paperclip'></i></label>
                              <input id='video-upload' type='file' accept='video/*' name='videoupload' onchange='displayAttachImage(this)'></input>
                              <label for='video-upload' id='video-upload'><i class='fas fa-video'></i></i></label>";
                              
                              
                              echo "</div>";
                              echo "<div class='col-md-6'>";
                                      echo "<input type='hidden' name='' value='Submission'>";
                                      echo "<button type='submit' value='".$postID."' id='submissionsubmit' name='submissionsubmit'>Submit Work</button>";
                                    echo "</div>";
                                    echo "<img src='' id='imageattach'>";
                                  echo "</div>";
                                
                              echo "</form>";
                              echo "</div>";
                        }
                      }
                      
                      
                    }
                      
                    
                      
                        
                  }
                }

                
     ///////////////SUBMISSION END/////////////////////////////////
                ////////////////////////////////////SUBMISSION ENTRIES//////////////////////////////
                  $id = $_SESSION['userId'];
                  $sql1 = "SELECT * FROM users WHERE idUsers='$id'";
                  $result1 = $conn->query($sql1);
                  while($row1 = $result1->fetch_assoc())
                  {
                      if($row1['accounttypeUsers'] == 'Teacher')
                      {
                        $getsubmissionsql = "SELECT * FROM submissions WHERE postID = '$postID'";
                        $getsubmissionresult = $conn->query($getsubmissionsql);
                        $getsubmissioncount = mysqli_num_rows($getsubmissionresult);
                        echo "<div class='row-md-12 box-divs'>";
                            echo "<h5>".$getsubmissioncount." submission";
                            if($getsubmissioncount>1)
                            {
                              echo "s</h5>";
                            }
                            else
                            {
                              echo "</h5>";
                            }

                            echo "</div>";

                            while($getsubmissionrow = $getsubmissionresult->fetch_assoc())
                            {
                                  echo "<div class='row-md-12 box-divs'>";
                                    echo "<div class='col-md-12'>"; //avatar
                        
                                      echo "<div class='user-avatar'>"; 
                                        $cmtusrid = $getsubmissionrow['userID'];
                                        $sqlImg2 = "SELECT * FROM profileimg WHERE idUsers = $cmtusrid";
                                        $resultImg2 = $conn->query($sqlImg2);
                                        while($rowImg2 = $resultImg2->fetch_assoc())
                                        {
                                          if($rowImg2['status'] == 0)
                                            {
                                              echo "<img src='uploads/profile".$cmtusrid.".jpg'>";
                                            }
                                            else
                                            {
                                              echo "<img src='images/techknow-unknown.png'>";
                                            }
                                        }
                                      echo "</div>"; 
                                      echo "<div class='col-md-12'>"; //username
                        
                                      echo"<div id='comment-username'>";
                                          $usernamesql = "SELECT * FROM users WHERE idUsers = $cmtusrid";
                                          $usernameresult = $conn->query($usernamesql);
                                          while ($userrow = $usernameresult->fetch_assoc())
                                          {
                                            echo"Submitted by <strong>".$userrow['fnameUsers']." ".$userrow['lnameUsers']."</strong>";
                                          }
                                      echo"</div>";
                        
                                    echo "</div>"; //username
                                    echo "<div class='row'>";
                                  
                                    echo"<div id='comment-date'>";
                                      $datepost = DateTime::createFromFormat('Y-m-d', $getsubmissionrow['datepassed']);
                                      $finaldate = $datepost->format('F d, Y');
                                      echo "<strong>".$finaldate."</strong>";
                                    echo "</div>";
                                    
                                  echo "</div>";
                                    echo "</div>"; //avatar
                        
                                  echo "<div class='row'>";
                                  echo "<div class='col-md-12'>";
                                    echo"<div id='comment-message' style='margin:10px 0;'>";
                                    if ($getsubmissionrow['imgStatus'] == 1)
                                    {
                                      echo "<img id= 'img-holder' src='submissions/".$getsubmissionrow['imgname']."'>";
                                    }
                                    if ($getsubmissionrow['imgStatus'] == 0)
                                    {
                                      echo "";
                                    }
                                    if ($getsubmissionrow['attachstatus'] == 1)
                                    {
                                      echo "<div id= 'attach-holder'><a href='submissions/".$getsubmissionrow['attachname']."'><h5>".$getsubmissionrow['attachname']."</h5><strong>Uploaded by ".$row1['fnameUsers']." ".$row1['lnameUsers']."</strong></a></div>";
                                    }
                                    if ($getsubmissionrow['attachstatus'] == 0)
                                    {
                                      echo "";
                                    }
                                    if ($getsubmissionrow['videostatus'] == 1)
                                    {
                                      echo "<video class='vid-holder' id= 'vid-holder' controls loop>";
                                      echo "<source src='submissions/".$getsubmissionrow['videoname']."'>";
                                      echo "</video>";
                                    }
                                    if ($getsubmissionrow['videostatus'] == 0)
                                    {
                                      echo "";
                                    }
                                    echo"</div>";
                                  echo "</div>";
                                  echo "</div>";
                        
                                echo "</div>";
                            }
                            
                      }
                      else if ($row1['accounttypeUsers'] == 'Student')
                      {
                        echo "";
                      }
                  }


                  

                  
              ////////////////////////////////////END SUBMISSION ENTRIES//////////////////////////////
              }
              else
              {
                echo "";
              }
        //COMMENT SECTION
        $commentsql = "SELECT * FROM comment WHERE postID = '$postID' ORDER BY date DESC";
        $commentresult = $conn->query($commentsql);
        $commentcount = mysqli_num_rows($commentresult);
          echo "<div class='row-md-12 box-divs'>";
            echo "<h5>".$commentcount." comment";
            if($commentcount>1)
            {
              echo "s</h5>";
            }
            else
            {
              echo "</h5>";
            }
            
            echo "<div class='row'>";
              
              echo "<div class='col-md-12'>";
              echo "<form action='includes/comment.inc.php' method='POST'>";
                  echo "<textarea id='messagecmt' name='commentmessage' rows='3' placeholder='Give us your thoughts...'></textarea>";
                  echo "<input type='hidden' name='uid' value='".$_SESSION['userId']."'>";
                  echo "<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>";
              echo "</div>";

              

                  
            echo "</div>";

            echo "<div class='row'>";

                echo "<div class='col-md-12'>";
                  echo "<button type='submit' id='submitcmt' style='float:right;' value='".$postID."' name='submitcomment'>Post</button>";
                echo "</div>";
                
            echo "</div>";
              echo "</form>";

          echo "</div>";
          //END COMMENT SECTION
          //COMMENTS
          if($commentcount<=0)
          {
            echo "<div class='row-md-12 text-center box-divs' style='background: #5D008E; color: #ecf0f1; border-color: #5D008E; min-height:50px;'>";
              echo "<h5>No comments found</h5>";
            echo "</div>";
          }
          else
          {
            while($commentrow = $commentresult->fetch_assoc())
          {
            echo "<div class='row-md-12 box-divs'>";
                echo "<div class='col-md-12'>"; //avatar
    
                  echo "<div class='user-avatar'>"; 
                    $cmtusrid = $commentrow['userID'];
                    $sqlImg2 = "SELECT * FROM profileimg WHERE idUsers = $cmtusrid";
                    $resultImg2 = $conn->query($sqlImg2);
                    while($rowImg2 = $resultImg2->fetch_assoc())
                    {
                      if($rowImg2['status'] == 0)
                        {
                          echo "<img src='uploads/profile".$cmtusrid.".jpg'>";
                        }
                        else
                        {
                          echo "<img src='images/techknow-unknown.png'>";
                        }
                    }
                  echo "</div>"; 
                  echo "<div class='col-md-12'>"; //username
    
                  echo"<div id='comment-username'>";
                      $usernamesql = "SELECT * FROM users WHERE idUsers = $cmtusrid";
                      $usernameresult = $conn->query($usernamesql);
                      while ($userrow = $usernameresult->fetch_assoc())
                      {
                        echo"Comment by <strong>".$userrow['fnameUsers']." ".$userrow['lnameUsers']."</strong>";
                      }
                  echo"</div>";
    
                echo "</div>"; //username
                echo "<div class='row'>";
              
                echo"<div id='comment-date'>";
                  $datepost = DateTime::createFromFormat('Y-m-d H:i:s', $commentrow['date']);
                  $finaldate = $datepost->format('F d, Y - H:i A');
                  echo "<strong>".$finaldate."</strong>";
                echo "</div>";
                
              echo "</div>";
                echo "</div>"; //avatar
    
              echo "<div class='row'>";
              echo "<div class='col-md-12'>";
                echo"<div id='comment-message' style='margin:10px 10px;'>";
                echo $commentrow['message'];
                echo"</div>";
              echo "</div>";
              echo "</div>";
    
            echo "</div>";
          }
          }
        //END COMMENTS
    echo"</div>";
    echo "</div>";
    echo"</div>";
       






    ?>
  </div>
  <script src='/js/techknow-script.js'></script>

  
</main>
<script>
    
  /*postform.addEventListener('input', () => {

    
    
        if (document.getElementById('img-upload').files.length > 0)
        {
        document.getElementById('submissionsubmit').removeAttribute('disabled');
        }
        if(document.getElementById('img-upload').files.length == 0)
        {
        document.getElementById('submissionsubmit').setAttribute('disabled', 'disabled');
        document.getelementById('file-upload').setAttribute('disabled', 'disabled');
        document.getelementById('video-upload').setAttribute('disabled', 'disabled');
        }
        if (document.getElementById('file-upload').files.length > 0)
        {
        document.getElementById('submissionsubmit').removeAttribute('disabled');
        }
        if(document.getElementById('file-upload').files.length == 0)
        {
        document.getElementById('submissionsubmit').setAttribute('disabled', 'disabled');
        document.getelementById('img-upload').setAttribute('disabled', 'disabled');
        document.getelementById('video-upload').setAttribute('disabled', 'disabled');
        }
        if (document.getElementById('video-upload').files.length > 0)
        {
        document.getElementById('submissionsubmit').removeAttribute('disabled');
        }
        if(document.getElementById('video-upload').files.length == 0)
        {
        document.getElementById('submissionsubmit').setAttribute('disabled', 'disabled');
        document.getelementById('img-upload').setAttribute('disabled', 'disabled');
        document.getelementById('file-upload').setAttribute('disabled', 'disabled');
        }
        else
        {
        document.getElementById('submissionsubmit').setAttribute('disabled', 'disabled');
        document.getelementById('file-upload').setAttribute('disabled', 'disabled');
        document.getelementById('video-upload').setAttribute('disabled', 'disabled');
        }
      });
</script>
