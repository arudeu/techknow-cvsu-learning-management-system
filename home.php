<?php
  date_default_timezone_set('Asia/Manila');
  include 'includes/dbh.inc.php';
  include 'includes/posts.inc.php';
  include 'includes/groups.inc.php';
  include 'includes/upload.inc.php';
  require "header.php";
 ?>
<head>
  <title>Blackboard | TechKnow</title>
  <link rel="stylesheet" href="/css/styles.css" type="text/css">
  <script>
  tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
  tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

  function GetClock(){
    var d=new Date();
    var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getYear();
  if(nyear<1000) nyear+=1900;
  var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

  if(nhour==0){ap=" AM";nhour=12;}
  else if(nhour<12){ap=" AM";}
  else if(nhour==12){ap=" PM";}
  else if(nhour>12){ap=" PM";nhour-=12;}

  if(nmin<=9) nmin="0"+nmin;
  if(nsec<=9) nsec="0"+nsec;

  document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
  
  }

  window.onload=function(){
  GetClock();
  setInterval(GetClock,1000);
  }
  </script>
</head>

<main onload='startTime()' style='min-height: 95vh;'>
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
    <div class="grid-padding" style="background: #dfe4ea; padding:10px;">
    
    <div class="row">
    <!-- START FIRST COL -->
        <div class="col-md-3 column-details">
            <div class="make-me-sticky">
            <?php
            $id = $_SESSION['userId'];
            $sql = "SELECT * FROM users WHERE idUsers = $id";
            $result = $conn->query($sql);
            
            // START PERSONAL DETAILS

            echo "<div class='row-md-4 text-center box-divs'>";
            
            while($row = $result->fetch_assoc())
            {
                $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
                $resultImg = $conn->query($sqlImg);

                echo "<form action='includes/upload.inc.php' method='POST' enctype='multipart/form-data'>
                <input type='file' name='avatar' class='changeprofilepic' onchange='displayImage(this)' id='profilepic' accept='image/*'></input>
                <label for='profilepic' id='avatar'>";

                if(mysqli_num_rows($resultImg) > 0)
                {
                    while($rowImg = $resultImg->fetch_assoc())
                    {
                      $ext = pathinfo("uploads/profile".$id, PATHINFO_EXTENSION);
                        if($rowImg['status'] == 0)
                        {
                            echo "<img src='uploads/profile".$id.".jpg".$ext."' class='img-fluid profileimg' onclick='triggerUpload()' id='profiledisplay' onclick='triggerUpload()'>";
                        }
                        else
                        {
                             echo "<img src='images/techknow-unknown.png' class='img-fluid profileimg' onclick='triggerUpload()' id='profiledisplay' onclick='triggerUpload()'>";
                        }
                        echo $ext;
                    }
                }
                else
                {
                    echo "<img src='images/techknow-unknown.png' id='profiledisplay' onclick='triggerUpload()'>";
                }

                
                echo "</label>
                <button id='uploadprofile' type='submit' name='upload' onclick='hideUpload()'>Upload</button>
                </form>";

                if ($row['accounttypeUsers'] == 'Student')
                {
                  echo"<h3>".$row['fnameUsers']." ".$row['lnameUsers']."</h3>
                  <h6>".$row['course']."</h6>
                  <h6>".$row['usernameUsers']."</h6>
                  <h6>".$row['studentIDUsers']."</h6>
                  <button id='viewprofile'><a style='text-decoration: none; color:#ecf0f1;' href='user.php?id=$id'>View Profile</a></button>";
                }
                elseif ($row['accounttypeUsers']== 'Teacher')
                {
                  echo"<h3>".$row['fnameUsers']." ".$row['lnameUsers']."<i class='fas fa-check-circle' style='color: #5D008E; margin-left: 3px;'></i></h3>
                  <h6>".$row['departmentUsers']."</h6>
                  <h6>".$row['usernameUsers']."</h6>
                  <h6>".$row['employeeIDUsers']."</h6>
                  <button id='viewprofile'><a style='text-decoration: none; color:#ecf0f1;' href='user.php?id=$id'>View Profile</a></button>";
                }
                
            }

            echo "</div>";

            // END PERSONAL DETAILS

             ?>
            

            <!-- START CLASSES -->
            
            <div class="row-md-4 text-center box-divs">
                <h6>YOUR CLASSES</h6>
                
                <?php
                $sql1 = "SELECT * FROM members WHERE memberID = $id AND status = 'Active'";
                $result1 = $conn->query($sql1);
                $sql1num = mysqli_num_rows($result1);
                if ($sql1num > 0)
                {
                  echo '<div class="columnclass">';
                      while($row1 = $result1->fetch_assoc())
                      {
                      echo "<a class='classes' href='class.php?room=".$row1['grpcode']."&contents=posts' style='border-left-color:".$row1['color'].";'>".$row1['grptitle']."</a>";
                      }
                  echo'</div>';
                }
                else if (mysqli_num_rows($result1) <= 0) 
                {
                  echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No active classes found</h6>";
                }
                
                    
            
                ?>
            </div>

            <!-- END CLASSES -->

            <!-- START JOIN CLASS -->

            <div class="row-md-4 text-center box-divs">
                <?php
                $id = $_SESSION['userId'];
                $sql = "SELECT * FROM users WHERE idUsers = $id";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc())
                {
                    if($row['accounttypeUsers']=='Student')
                    {
                        echo "<form class='enroll-class' method='POST' action='".setMember($conn)."'>
                        <h6>JOIN YOUR CLASS!</h6>
                        <input type='text' name='code' placeholder='Enter room code'>
                        <button id='viewprofile' type='submit' name='submitcode'>Join now</button>
                        </form>";
                    }
                    elseif ($row['accounttypeUsers']=='Teacher')
                    {
                        echo "<form class='enroll-class'>
                        <h6>CREATE YOUR CLASS</h6>
                        <a id='viewprofile' href = 'class.php';>Create now</a>
                        </form>";
                    }
                }
                ?>
            </div>
            
            <!-- END JOIN CLASS -->
            </div>
            
        </div>

    <!-- END FIRST COL -->

    <!-- START SECOND COL -->

        <div class="col-md-6">
        <div class="make-me-sticky">
            <div class="row box-divs">
                <?php
                if (isset($_SESSION['userId']))
                {
                    $mid=$_SESSION['userId'];
                    $sql1 = "SELECT * FROM users WHERE idUsers = $id";
                    $result1 = $conn->query($sql1);

                  echo "<form id='postform' class='post-something' method='POST' action='".setPost($conn)."' enctype='multipart/form-data'>";
                  echo "<div class='form-group'>";
                  echo "<select id='groupselectpost' name='utype'>
                        <option selected hidden value='0'>Select Post Tag</option>";
                  while($row1 = $result1->fetch_assoc())
                   {
                     if($row1['accounttypeUsers']=='Student')
                     {
                      echo "<option value='Announcement'>Announcement</option>
                      <option value='Discussion'>Discussion</option>
                      <option value='Question'>Question</option>";
                      echo "</select>";
                     }
                     elseif($row1['accounttypeUsers']=='Teacher')
                     {
                      echo "<option value='Announcement'>Announcement</option>
                      <option value='Discussion'>Discussion</option>
                      <option value='Question'>Question</option>
                      <option value='Module'>Module</option>
                      <option value='Meeting'>Meeting</option>
                      <option value='Activity'>Activity</option>
                      <option value='Quiz'>Quiz</option>";
                      echo "</select>";
                     }
                   }
                  
                    
                  

                  $sql = "SELECT * FROM users WHERE idUsers = $id";
                  $result = $conn->query($sql);
                  echo"<select id='groupselectpost' name='ugrp'>";
                   while($row = $result->fetch_assoc())
                   {
                     if($row['accounttypeUsers']=='Student')
                     {
                       $grpsql="SELECT * FROM members WHERE memberID = $mid";
                       $grpresult = $conn->query($grpsql);
                       echo "<option selected hidden value='0'>Select class</option>";
                       while($grprow = $grpresult->fetch_assoc())
                       {
         
                         echo"<option value='".$grprow['grpcode']."'>".$grprow['grptitle']."</option>";
                       }
                       echo"</select>";
         
         
                     }
                     else if ($row['accounttypeUsers']=='Teacher')
                     {
                       $grpsql="SELECT * FROM groups WHERE grpauthorID = $mid";
                       $grpresult = $conn->query($grpsql);
                       echo "<option selected hidden value='0'>Select class</option>";
                       while($grprow = $grpresult->fetch_assoc())
                       {
         
                         echo"<option value='".$grprow['grpcode']."'>".$grprow['grptitle']."</option>";
         
                       }
         
                       echo"</select>";
                     }
                   }
                   echo "<br><input type='datetime-local' placeholder='dd/mm/yyyy --:-- --' name='deadlinedate' id='deadlinedate' style='display:none;'>";
                   echo "<label class='col-md-6' id='hourslbl' style='display:none;'>Duration in hours: </label>";
                   echo "<input class='col-md-6 text-center' type='number' name='hours' id='hours' value='1' min='1' max='5' style='display:none;'>";
                   echo"<input type='text' id= 'subjectbox' name='subject' placeholder='Subject'>
                   <textarea id= 'messagebox' name='message' rows='8' placeholder='Discuss something...'></textarea>
                   <input type='hidden' name='uid' value='".$_SESSION['userId']."'>
                   <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                   <input id='img-upload' type='file' accept='image/*' name='imageupload' onchange='displayAttachImage(this)'></input>
                   <label for='img-upload' id='img-upload'><i class='fas fa-image'></i></label>
                   <input id='file-upload' type='file' accept='application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                   text/plain, application/pdf' name='fileupload'></input>
                   <label for='file-upload'><i class='fas fa-paperclip'></i></label>
                   <input id='video-upload' type='file' accept='video/*' name='videoupload' onchange='displayAttachVideo(this)'></input>
                   <label for='video-upload' id='video-upload'><i class='fas fa-video'></i></i></label>
         
                   <button type='submit' name='postsubmit' id='submitpost' disabled='disabled'>Post</button>
                   <img src='' id='imageattach'>
                   </div>
                   </form>";
                }
                else
                {
                   header("Location: index.php");
                }
                ?>
            </div>

                <?php
                
                echo "<div id='home-posts'>
                ".getPost($conn)."
                </div>";
                echo "<div class= 'row'>";
                echo "<button class= 'col-md-12 box-divs' id= 'showmoreposts' style= ''><strong>Show More Posts</strong></button>";
                echo "</div>";
                ?>

        </div>
        <script>
        $(document).ready(function(){
          $("#home-posts").slice(0, 4).show();
          $("#showmoreposts").on("click", function(e){
            e.preventDefault();
            $("#home-posts:hidden").slice(0.4).slideDown();
            if ($("#home-posts:hidden").length == 0){
              $("#showmoreposts").text("That's all for today!");
            }
          });
        })
        </script>
        </div>
    <!-- END SECOND COL -->
                
    
    <!-- START THIRD COL -->
        <div class="col-md-3">

            <div class="make-me-sticky">

                <div class="row-md-3 box-divs clock" style="background: #5D008E; border-color: #5D008E;">
                    <div id='bgclock'><h3 id='clockbox'></h3></div>
                </div>

                <div class="row-md-3 text-center box-divs">
                    <h6>MEETING SCHEDULE TODAY</h6>
                      <?php
                        $meetingnowsql = "SELECT * FROM posts WHERE posttype = 'Meeting' AND CAST(CURRENT_DATE AS date) = CAST(deadlinedate AS date) ORDER BY deadlinedate ASC";
                        $meetingnowres = $conn->query($meetingnowsql);
                        $meetingnownum = mysqli_num_rows($meetingnowres);
                        if($meetingnownum > 0)
                        {
                          while($meetingnowrow = $meetingnowres->fetch_assoc())
                          {
                            $hrs = $meetingnowrow['hours'];
                            $starttime = date('h:i A', strtotime($meetingnowrow['deadlinedate']));
                            $endtime = date('h:i A', strtotime($meetingnowrow['deadlinedate']) + 60 * 60 * $hrs);
                            echo '<h6 style="padding: 5px 0; border-radius: 3px; font-size: 13px;">'.$starttime.' - '.$endtime.' | ';
                            $uid = $meetingnowrow['userID'];
                            $uidsql = "SELECT * FROM users WHERE idUsers = '$uid'";
                            $uidres = $conn->query($uidsql);
                            $uidnum = mysqli_num_rows($uidres);
                            while($uidrow = $uidres->fetch_assoc())
                            {
                              echo $uidrow['fnameUsers'].' '.$uidrow['lnameUsers'].'</h6>';
                            }
                          }
                        }
                        else
                        {
                          echo '<h6 style="padding: 5px 0; border-radius: 3px; font-size: 13px;">No meetings found</h6>';
                        }
                        
                      ?>
                      
                </div>

                <div class="row-md-3 text-center box-divs">
                    <h6>YOUR MEETINGS</h6>
                    <?php 
                    $id = $_SESSION['userId'];
                    $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                    $acctyperesult = $conn->query($acctypesql);
                    while($acctyperow = $acctyperesult->fetch_assoc())
                    {
                        if($acctyperow['accounttypeUsers']=='Student')
                        {
                            $meetingsql = "SELECT * FROM posts WHERE posttype = 'Meeting' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $meetingresult = $conn->query($meetingsql);
                            $meetingnum = mysqli_num_rows($meetingresult);
                            if($meetingnum > 0)
                          {
                            echo '<div class="columnclass">';
                            while($meetingrow = $meetingresult->fetch_assoc())
                            {
                                $roomcode = $meetingrow['grpcode'];
                                $grpsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID = '$id'";
                                $grpresult = $conn->query($grpsql);
                                
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  $deadline = date('m-d h:i A', strtotime($meetingrow['deadlinedate']));
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=Meeting&title=".$meetingrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$meetingrow['subjectID']."</a>";
                                }
                                
                                
                                
                            }
                            echo "</div>";
                          }
                            if ($meetingnum<=0)
                            {
                                echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No activities found</h6>";
                            }
                            else
                            {
                                echo "";
                            }

                        }
                        elseif ($acctyperow['accounttypeUsers']=='Teacher')
                        {
                          
                            
                            $meetingsql = "SELECT * FROM posts WHERE posttype = 'Meeting' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $meetingresult = $conn->query($meetingsql);
                            $meetingnum = mysqli_num_rows($meetingresult);
                            if($meetingnum > 0)
                            {
                            echo '<div class="columnclass">';
                            while($meetingrow = $meetingresult->fetch_assoc())
                            {
                                $roomcode = $meetingrow['grpcode'];
                                $grpsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID = $id";
                                $grpresult = $conn->query($grpsql);
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  $deadline = date('m-d h:i A', strtotime($meetingrow['deadlinedate']));
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=Meeting&title=".$meetingrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$meetingrow['subjectID']."</a>";
                                    
                                }
                                
                                
                            }
                            echo '</div>';
                            }
                            if ($meetingnum<=0)
                            {
                              echo '<h6 style="padding: 5px 0; border-radius: 3px; font-size: 13px;">No meetings found</h6>';
                            }
                        }
                    }
                    ?>
                     
                </div>

                <div class="row-md-3 text-center box-divs">
                    <h6>ACTIVITIES</h6>
                    <?php 
                    $id = $_SESSION['userId'];
                    $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                    $acctyperesult = $conn->query($acctypesql);
                    while($acctyperow = $acctyperesult->fetch_assoc())
                    {
                        if($acctyperow['accounttypeUsers']=='Student')
                        {
                            $activitysql = "SELECT * FROM posts WHERE posttype = 'Activity' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $activityresult = $conn->query($activitysql);
                            $activitynum = mysqli_num_rows($activityresult);
                            if($activitynum > 0)
                          {
                            echo '<div class="columnclass">';
                            while($activityrow = $activityresult->fetch_assoc())
                            {
                                $roomcode = $activityrow['grpcode'];
                                $grpsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID = '$id'";
                                $grpresult = $conn->query($grpsql);
                                
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  $deadline = date('m-d h:i A', strtotime($activityrow['deadlinedate']));
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=Activity&title=".$activityrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$activityrow['subjectID']."</a>";
                                }
                                
                                
                                
                            }
                            echo "</div>";
                          }
                            if ($activitynum<=0)
                            {
                                echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No activities found</h6>";
                            }
                            else
                            {
                                echo "";
                            }

                        }
                        elseif ($acctyperow['accounttypeUsers']=='Teacher')
                        {
                          
                            
                            $activitysql = "SELECT * FROM posts WHERE posttype = 'Activity' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $activityresult = $conn->query($activitysql);
                            $activitynum = mysqli_num_rows($activityresult);
                            if($activitynum > 0)
                            {
                            echo '<div class="columnclass">';
                            while($activityrow = $activityresult->fetch_assoc())
                            {
                                $roomcode = $activityrow['grpcode'];
                                $grpsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID = $id";
                                $grpresult = $conn->query($grpsql);
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  $deadline = date('m-d h:i A', strtotime($activityrow['deadlinedate']));
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=Activity&title=".$activityrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$activityrow['subjectID']."</a>";
                                    
                                }
                                
                                
                            }
                            echo '</div>';
                            }
                            if ($activitynum<=0)
                            {
                              echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No activities found</h6>";
                            }
                        }
                    }
                    ?>
                </div>

                <div class="row-md-3 text-center box-divs">
                    <h6>QUIZZES</h6>
                    
                    <?php
                    $id = $_SESSION['userId'];
                    $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                    $acctyperesult = $conn->query($acctypesql);
                    while($acctyperow = $acctyperesult->fetch_assoc())
                    {
                        if($acctyperow['accounttypeUsers']=='Student')
                        {

                            $quizsql = "SELECT * FROM posts WHERE posttype = 'Quiz' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $quizresult = $conn->query($quizsql);
                            $quiznum = mysqli_num_rows($quizresult);
                            
                          if($quiznum > 0)
                          {
                            echo '<div class="columnclass">';
                            while($quizrow = $quizresult->fetch_assoc())
                            {
                                $deadline = date('m-d h:i A', strtotime($quizrow['deadlinedate']));
                                $roomcode = $quizrow['grpcode'];
                                $grpsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID = '$id'";
                                $grpresult = $conn->query($grpsql);
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=quiz&title=".$quizrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$quizrow['subjectID']."</a>";
                                        
                                    
                                }
                                
                                
                            }
                            echo '</div>';
                          }
                            
                            if ($quiznum<=0)
                            {
                                echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No quizzes found</h6>";
                            }
                            else
                            {
                                echo "";
                            }

                        }
                        elseif ($acctyperow['accounttypeUsers']=='Teacher')
                        {
                            
                            $quizsql = "SELECT * FROM posts WHERE posttype = 'Quiz' AND status = 'Active' AND CURRENT_DATE() < deadlinedate";
                            $quizresult = $conn->query($quizsql);
                            $quiznum = mysqli_num_rows($quizresult);
                            
                            if($quiznum > 0)
                            {
                              echo '<div class="columnclass">';
                            while($quizrow = $quizresult->fetch_assoc())
                            {
                                $deadline = date('m-d h:i A', strtotime($quizrow['deadlinedate']));
                                $roomcode = $quizrow['grpcode'];
                                $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                $grpresult = $conn->query($grpsql);
                                while($grprow = $grpresult->fetch_assoc())
                                {
                                  
                                    
                                  echo "<a class='classes' href='submission.php?room=".$roomcode."&type=quiz&title=".$quizrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$deadline." | ".$quizrow['subjectID']."</a>";
                                    
                                        
                                }
                                
                                
                            }
                            echo '</div>';
                          }
                            
                            if ($quiznum<=0)
                            {
                                echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No quizzes found</h6>";
                            }
                            else
                            {
                                echo "";
                            }
                        }
                    }
                    ?>
                </div>

            </div>

        </div>
    <!-- END THIRD COL -->

        </div>
    </div>
  </div>
<?php
echo '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Confirm delete?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    echo '<div class="modal-body">
Are you sure you want to delete this post?
</div>';
echo'
<div class="modal-footer" id="check-delete">';
echo '</div>';
    echo'
  </div>
</div>
</div>';


echo '<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="check-edit">
      
    </div>
    
  </div>
</div>
</div>';

echo '<div class="modal fade" id="reportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">What is wrong with this post</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="check-report">
      
    </div>
    
  </div>
</div>
</div>';
?>

  

  <script src='/js/techknow-script.js'></script>


    <script type="text/javascript">
    postform.addEventListener('input', () => {
        if (subjectbox.value.length > 0 && groupselectpost.value != 0)
        {
        submitpost.removeAttribute('disabled');
        }
        else
        {
        submitpost.setAttribute('disabled', 'disabled');
        }
    });
    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 3000);
    
    </script>





<script>
function posttoolsOver(e)
{
  var x = document.getElementsByClassName('post-tools');
  for (i = 0; i < x.length; i++) 
  {
  x[i].style.display = 'block';
  }
}
function posttoolsOut(e)
{
  var x = document.getElementsByClassName('post-tools');
  for (i = 0; i < x.length; i++) 
  {
  x[i].style.display = 'none';
  }
}
</script>





  <script>
    let options = {
      root: null,
      rootMargin:'0px',
      threshold:1.0
    };
    let callback = (entries, observer)=>{
      entries.forEach(entry => {
        if($(entry.target(0)).attr('class') == 'vid-holder')
        {
          if(entry.isIntersecting)
          {
            console.log("video is playing");
            entry.target(0).play();
          }
          else
          {
            console.log("video is paused");
            entry.target(0).pause();
          }
        }
      });
    }
    let observer = new IntersectionObserver(callback, options);

    observer.observe(document.querySelector('.vid-holder');
  </script>

  <script>
  $(document).ready(function(){
    $('#groupselectpost').on('change', function() {
      if ( this.value == 'Activity')
      {
        $("#deadlinedate").show();
        $("#hours").hide();
        $("#hourslbl").hide();
      }
      else if ( this.value == 'Quiz')
      {
        $("#deadlinedate").show();
        $("#hours").hide();
        $("#hourslbl").hide();
      }
      else if ( this.value == 'Meeting')
      {
        $("#deadlinedate").show();
        $("#hours").show();
        $("#hourslbl").show();
      }
      else
      {
        $("#deadlinedate").hide();
        $("#hours").hide();
        $("#hourslbl").hide();
      }
    });
});
  </script>

  <script>
  document.getElementById('deadlinedate').valueAsDate = new Date();
  </script>
  
  <script>
  var user = detect.parse(navigator.userAgent);

  if (user.browser.family === 'Firefox' || user.browser.family === 'IE') 
  {
  alert('Some features might not work using your current browser. Please change your browser to unlock all features!');   
  }
  </script>
 </main>