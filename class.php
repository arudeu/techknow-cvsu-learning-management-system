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
          header("Location: index.php");
        }
    ?>
        <div class='grid-padding' style="background: #dfe4ea; padding:10px;">
            
                <?php
                
            if(isset($_GET['room']))
            {
                $roomcode = $_GET['room'];
                $membersql = "SELECT * FROM groups WHERE grpcode = '".$_GET['room']."'";
                $memberresult = $conn->query($membersql);

                while($memberrow = $memberresult->fetch_assoc())
                {
                    //$teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                    //$teacherresult = $conn->query($teachersql);
                        echo "<title>".$memberrow['grptitle']." | TechKnow</title>";
                        echo "<div class='row-md-12 text-center box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                        echo "<img src='uploads/profile".$memberrow['grpauthorID'].".jpg'></img>";
                        echo "<h2 style = 'color:  #ecf0f1;'>".$memberrow['grptitle']."</h2>";
                        echo "</div>";

                        echo "<div class='row-md-12 text-center box-divs'>";

                            echo "<div class='col-md-12 text-center class-description'>";
                            echo "<strong style='float: left;'>Room Code: ".$memberrow['grpcode']."</strong>";
                            echo "<strong><i class='fas fa-quote-left' style='margin-right: 5px; color: ".$memberrow['color'].";'></i>".$memberrow['grpdesc']."</strong>";
                            echo "<strong style='float: right;'>Teacher: ".$memberrow['grpauthor']."</strong>";
                            echo "</div>";
                            

                        echo "</div>";
                }
                echo "<div class='row'>";

                echo "<div class='col-md-4'>";

                    echo "<div class='make-me-sticky'>";

                        echo "<div class='row-md-4 text-center box-divs'>";
                        echo "<h6>MEETINGS</h6>";
                        echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No meetings found</h6>";
                        echo "</div>";

                        echo "<div class='row-md-4 text-center box-divs'>";
                        echo "<h6>MODULES</h6>";
                        $id = $_SESSION['userId'];
                        $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                        $acctyperesult = $conn->query($acctypesql);
                        while($acctyperow = $acctyperesult->fetch_assoc())
                        {
                            if($acctyperow['accounttypeUsers']=='Student')
                            {

                                $modulesql = "SELECT * FROM posts WHERE posttype = 'Module' AND grpcode = '$roomcode'";
                                $moduleresult = $conn->query($modulesql);
                                $modulenum = mysqli_num_rows($moduleresult);
                                while($modulerow = $moduleresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($modulenum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=modules&title=".$modulerow['postID']."' style='border-left-color:".$grprow['color'].";'>".$modulerow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
                                }
                                if ($modulenum<=0)
                                {
                                  echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No modules found</h6>";
                                }
                                else
                                {
                                    echo "";
                                }

                            }
                            elseif ($acctyperow['accounttypeUsers']=='Teacher')
                            {
                                $modulesql = "SELECT * FROM posts WHERE posttype = 'Module' AND grpcode = '$roomcode'";
                                $moduleresult = $conn->query($modulesql);
                                $modulenum = mysqli_num_rows($moduleresult);
                                while($modulerow = $moduleresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($modulenum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=modules&title=".$modulerow['postID']."' style='border-left-color:".$grprow['color'].";'>".$modulerow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
                                }
                                if ($modulenum<=0)
                                {
                                  echo "<h6 style='padding: 5px 0; border-radius: 3px; font-size: 13px;'>No modules found</h6>";
                                }
                                else
                                {
                                    echo "";
                                }
                            }
                        }
                        

                        
                        echo "</div>";

                        echo "<div class='row-md-4 text-center box-divs'>";
                        echo "<h6>ACTIVITIES</h6>";
                        $id = $_SESSION['userId'];
                        $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                        $acctyperesult = $conn->query($acctypesql);
                        while($acctyperow = $acctyperesult->fetch_assoc())
                        {
                            if($acctyperow['accounttypeUsers']=='Student')
                            {

                                $activitysql = "SELECT * FROM posts WHERE posttype = 'Activity' AND grpcode = '$roomcode'";
                                $activityresult = $conn->query($activitysql);
                                $activitynum = mysqli_num_rows($activityresult);
                                while($activityrow = $activityresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($activitynum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=activity&title=".$activityrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$activityrow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
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
                                $activitysql = "SELECT * FROM posts WHERE posttype = 'Activity' AND grpcode = '$roomcode'";
                                $activityresult = $conn->query($activitysql);
                                $activitynum = mysqli_num_rows($activityresult);
                                while($activityrow = $activityresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($activitynum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=activity&title=".$activityrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$activityrow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
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
                        }
                        
                        
                        echo "</div>";

                        echo "<div class='row-md-4 text-center box-divs'>";
                        echo "<h6>QUIZZES</h6>";

                        $id = $_SESSION['userId'];
                        $acctypesql = "SELECT * FROM users WHERE idUsers = $id";
                        $acctyperesult = $conn->query($acctypesql);
                        while($acctyperow = $acctyperesult->fetch_assoc())
                        {
                            if($acctyperow['accounttypeUsers']=='Student')
                            {

                                $quizsql = "SELECT * FROM posts WHERE posttype = 'Quiz' AND grpcode = '$roomcode'";
                                $quizresult = $conn->query($quizsql);
                                $quiznum = mysqli_num_rows($quizresult);
                                while($quizrow = $quizresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($quiznum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=quiz&title=".$quizrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$quizrow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
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
                                $quizsql = "SELECT * FROM posts WHERE posttype = 'Quiz' AND grpcode = '$roomcode'";
                                $quizresult = $conn->query($quizsql);
                                $quiznum = mysqli_num_rows($quizresult);
                                while($quizrow = $quizresult->fetch_assoc())
                                {
                                    $grpsql = "SELECT * FROM groups WHERE grpcode = '$roomcode'";
                                    $grpresult = $conn->query($grpsql);
                                    while($grprow = $grpresult->fetch_assoc())
                                    {
                                        if($quiznum > 0)
                                        {
                                            echo "<a class='classes' href='submission.php?room=".$roomcode."&type=quiz&title=".$quizrow['postID']."' style='border-left-color:".$grprow['color'].";'>".$quizrow['subjectID']."</a>";
                                        }
                                    }
                                    
                                    
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

                        
                        echo "</div>";

                    echo "</div>";
                    
                echo "</div>";
                
                echo "<div class='col-md-8'>";

                    echo "<div class='row-md-12 box-divs'>";

                            $mid=$_SESSION['userId'];
                            $sql1 = "SELECT * FROM users WHERE idUsers = $id";
                            $result1 = $conn->query($sql1);
                            
                            echo "<form id='postform' class='post-something' method='POST' action='".setPost($conn)."' enctype='multipart/form-data'>";
                
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
                            
                            echo "<input type='hidden' name='ugrp' value='".$_GET['room']."'>";
                            echo "<br><input type='date' name='deadlinedate' id='deadlinedate' style='display:none;' placeholder='yyyy-mm-dd' value='2020-01-01'>";
                            echo"<input type='text' id= 'subjectbox' name='subject' placeholder='Subject'>
                            <textarea id= 'messagebox' name='message' rows='8' placeholder='Discuss something...'></textarea>
                            <input type='hidden' name='uid' value='".$_SESSION['userId']."'>
                            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                            <input id='img-upload' type='file' accept='image/*' name='imageupload' onchange='displayAttachImage(this)'></input>
                            <label for='img-upload' id='img-upload'><i class='fas fa-image'></i></label>
                            <input id='file-upload' type='file' accept='application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                            text/plain, application/pdf' name='fileupload'></input>
                            <label for='file-upload'><i class='fas fa-paperclip'></i></label>
                            <input id='video-upload' type='file' accept='video/*' name='videoupload' onchange='displayAttachImage(this)'></input>
                            <label for='video-upload' id='video-upload'><i class='fas fa-video'></i></i></label>
                
                            <button type='submit' name='postsubmit' id='submitpost' disabled='disabled'>Post</button>
                            <img src='' id='imageattach'>
                            </form>";
                    echo "</div>";
                    

                    
                    //POSTS
                    $userid = $_SESSION['userId'];
                    $sql = "SELECT * FROM posts WHERE grpcode = '".$_GET['room']."' ORDER BY date DESC";
                    $result = $conn->query($sql);

                    /////////////////////////////////////////////////////////////////
                    echo "<div class='col'>";
                    echo "<div class='row-md-12'>";
                    echo '<ul class="class-page pagination justify-content-center">
                        <li class="page-item" id="posts-page"><a class="page-link" href="class.php?room='.$_GET['room'].'&contents=posts" style="padding: none; color: #5D008E; border:none; background:none; font-weight:600;"><i class="fas fa-envelope-open"></i>Posts</a></li>
                        <li class="page-item" id="members-page"><a class="page-link" href="class.php?room='.$_GET['room'].'&contents=members" style="padding: none; color: #5D008E; border:none; background:none; font-weight:600;"><i class="fas fa-users"></i>Members</a></li>
                        </ul>';
                    echo "</div>";
                    echo "</div>";
                    /////////////////////////////////////////////////////////////////
                    
                
                if($_GET['contents'] == 'posts')
                {
                    echo "<div class='col'>";
                    if (mysqli_num_rows($result)>0)
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $id = $row['userID'];
          $sql1 = "SELECT * FROM users WHERE idUsers='$id'";
          $result1 = $conn->query($sql1);
  
          $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
          $resultImg = $conn->query($sqlImg);
          if ($row1 = $result1->fetch_assoc())
          {
            
            
            while($rowImg = $resultImg->fetch_assoc())
            {
              if ( $row['userID'] == $userid)
            {
              echo "<div class='row-md-6 d-flex justify-content-end' >";
                echo '<div class="post-tools btn-group" id="post-tools" onmouseover="posttoolsOver()" onmouseout="posttoolsOut()"  role="group" aria-label="Basic example" style="position:absolute; z-index:1;display: none;">';
                echo "<button class='get-edit btn btn-sm' style='float:none;' data-id='".$row['postID']."' data-toggle='modal' data-target='#editmodal'>";
                echo "<i class='fas fa-edit'></i>";
                echo "</button>";
                echo "<button class='get-delete btn btn-sm' data-id='".$row['postID']."' data-toggle='modal' data-target='#exampleModalCenter'style='float:none;'>";
                echo "<i class='fas fa-trash'></i>";
                echo "</button>";
                echo "</div>";
              echo "</div>";
            }
            else
            {
              echo "<div class='row-md-6 d-flex justify-content-end'>";
              echo '<div class="post-tools btn-group" onmouseover="posttoolsOver()" onmouseout="posttoolsOut()" role="group" aria-label="Basic example" style="position:absolute; z-index:1; display: none;">';
                echo "<button class='get-report btn btn-sm' name='postID' data-id='".$row['postID']."' data-toggle='modal' data-target='#reportmodal'>";
                echo "<i class='fas fa-flag'></i>";
                echo "</button>";
              echo "</div>";
              echo "</div>";
            }
              echo "<div class='row' id='user-post' onmouseover='posttoolsOver()' onmouseout='posttoolsOut()' onClick='location.href=\"submission.php?room=".$row['grpcode']."&type=".$row['posttype']."&title=".$row['postID']."\"'>";
              echo "<div class='row-md-3 col-md-12 user-avatar'>";
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
            echo "<div class='float-right' id='user-actions'>";
            
            
            
            echo "</div>";
            echo "</div>";
  
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

            $datedeadline = DateTime::createFromFormat('Y-m-d H:i:s', $row['deadlinedate']);
            $finaldatedeadline = $datedeadline->format('F d, Y');
            $date_now = new DateTime();
  
            if($row['posttype'] == 'Activity')
            {
              echo "<strong>Deadline: ".$finaldatedeadline."</strong>";
              
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
  
  
  
            echo "<a class='text-center' id='view-post' href='submission.php?room=".$row['grpcode']."&type=".$row['posttype']."&title=".$row['postID']."'>
            View Post
            </a>";
  
            echo "</div>";
            
            
          }
                        }
                    }
                    else
                    {
                        echo "<div class='row text-center box-divs' style='min-height:15px;' role='alert'>
                        <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No posts found!</strong>
                        </div>";
                    }
                    
                  


                echo "</div>";

                echo "</div>";
                echo "</div>";
                }
                elseif ($_GET['contents'] == 'members')
                {
                  echo "<div class='col'>";
                  $id = $_SESSION['userId'];
                  $accttypesql = "SELECT * FROM users WHERE idUsers = '$id'";
                  $accttyperes = $conn->query($accttypesql);
                  while($accttyperow = $accttyperes->fetch_assoc())
                  {
                    if($accttyperow['accounttypeUsers'] == 'Student')
                    {
                      $mmsql = "SELECT * FROM members WHERE grpcode = '$roomcode' AND memberID NOT IN ('$')";
                      $mmres = $conn->query($mmsql);
                      while($mmrow = $mmres->fetch_assoc())
                      {
                        echo "<div class='row box-divs'>";
                        $mmid = $mmrow['memberID'];
                        $getusersql = "SELECT * FROM profileimg WHERE idUsers = $mmid";
                        $getuserres = $conn->query($getusersql);
                        while($getuserrow = $getuserres->fetch_assoc())
                        {
                            if($getuserrow['status'] == 0)
                            {
                              echo "<div class='col-md-3'><img src = 'uploads/profile".$getuserrow['idUsers'].".jpg' style= 'border-radius: 180px; height: 75px; width: 75px;'>
                              </div>";
                            }
                            elseif($getuserrow['status'] == 1)
                            {
                              echo "<div class='col-md-3'><img src = 'images/techknow-unknown.png' style= 'border-radius: 180px; height: 75px; width: 75px;'>
                              </div>";
                            }
                          
                          
                        }
                        $getusersql = "SELECT * FROM users WHERE idUsers = $mmid";
                        $getuserres = $conn->query($getusersql);
                        while($getuserrow = $getuserres->fetch_assoc())
                        {
                        echo "<div class='col-md-9'><strong>
                        ".$getuserrow['lnameUsers'].", ".$getuserrow['fnameUsers']."</strong>
                        </div>";
                        }
                        echo "</div>";
                      }
                    }
                    elseif($accttyperow['accounttypeUsers'] == 'Teacher')
                    {
                      $mmsql = "SELECT * FROM members WHERE grpcode = '$roomcode'";
                      $mmres = $conn->query($mmsql);
                      while($mmrow = $mmres->fetch_assoc())
                      {
                        echo "<div class='row box-divs'>";
                        $mmid = $mmrow['memberID'];
                        $getusersql = "SELECT * FROM profileimg WHERE idUsers = $mmid";
                        $getuserres = $conn->query($getusersql);
                        while($getuserrow = $getuserres->fetch_assoc())
                        {
                            if($getuserrow['status'] == 0)
                            {
                              echo "<div class='col-md-3'><img src = 'uploads/profile".$getuserrow['idUsers'].".jpg' style= 'border-radius: 180px; height: 75px; width: 75px;'>
                              </div>";
                            }
                            elseif($getuserrow['status'] == 1)
                            {
                              echo "<div class='col-md-3'><img src = 'images/techknow-unknown.png' style= 'border-radius: 180px; height: 75px; width: 75px;'>
                              </div>";
                            }
                          
                          
                        }
                        $getusersql = "SELECT * FROM users WHERE idUsers = $mmid";
                        $getuserres = $conn->query($getusersql);
                        while($getuserrow = $getuserres->fetch_assoc())
                        {
                        echo "<div class='col'><strong>
                        ".$getuserrow['lnameUsers'].", ".$getuserrow['fnameUsers']."</strong>
                        </div>";
                        }
                        if ($mmrow['memberID'] == $id)
                        {
                          echo "<strong>(You)</strong>";
                        }
                        else
                        {
                          echo "<button type='button' id='kickmm' class='get-kickmember' data-todo='".'{"memid":"'.$mmrow["memberID"].'", "room":"'.$roomcode.'"}'."' data-toggle='modal' data-target='#kickmember'><i class='fas fa-times'></i></button>";
                        }
                        
                        echo "</div>";
                      }
                    }
                  }
                    echo "</div>";

                    echo '<div class="modal fade" id="kickmember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to kick this user?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-footer" id="check-kickmember">
                          
                          
                        </div>
                      </div>
                    </div>
                  </div>';
                  if(isset($_GET['delete']))
                  {
                    if($_GET['delete'] == 'success')
                    {
                      echo "<script>
                      $.bootstrapGrowl('Member kicked!',{
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
                }

                    
                    
            }
            elseif(isset($_GET['archiveclasssuccess']))
            {
              echo "<title>Classes | TechKnow</title>";
              echo "<div class='row'>";
                echo "<div class='row-md-12'>";
                echo "<hr class='light'>";
                        $id = $_SESSION['userId'];
                        $idsql = "SELECT * FROM users WHERE idUsers = $id";
                        $idresult = $conn->query($idsql);

                        while($idrow = $idresult->fetch_assoc())
                        {
                            if ($idrow['accounttypeUsers'] == 'Student')
                            {
                                echo "<form action='".setMember($conn)."' method='POST'>";
                                echo "<div class='input-group'>";
                                echo "<input type='text' class='form-control input-default' name='code' placeholder= 'Enter room code'> 
                                <button class='btn btn-default' name='submitcode'>Join Class</button>";
                                echo"</div>";
                                echo "</form>";
                            }
                            else if ($idrow['accounttypeUsers'] == 'Teacher')
                            {
                                echo "<form id='createform' action='".setGroup($conn)."' method='POST'>";
                                    echo "<div class='input-group'>";
                                    echo "<div class='input-group-prepend'>";
                                        echo "<input class='form-control input-default' id='classtitle' type='text' name='classroom-title' placeholder='Class title'>";
                                        echo"<input class='form-control input-default' id='classdesc' type='text' name='classroom-desc' placeholder='Class description'>";
                                        echo "<input type='hidden' name='author' value='".$idrow['fnameUsers']." ".$idrow['lnameUsers']."'>";
                                        echo "<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>";
                                        echo "<input type='hidden' id='color' name='color' value=''>";
                                    echo"</div>";
                                        echo '<select id="classcourse" class="form-control" name="course"><option selected hidden value="0">Select course</option>';
                                        $coursesql = "SELECT * FROM coursedept WHERE type = 'Course'";
                                        $courseres = $conn->query($coursesql);
                
                                        while($row = $courseres->fetch_assoc())
                                        {
                                          echo "<option value = '".$row['title']."'>".$row['code']." - ".$row['title']."</option>";
                                        }
                                        echo'</select>';
                                    
                                    echo"<button type='submit' id='classsub' class='btn btn-default' name='grpsubmit' disabled='disabled'>Create</button>";
                                    
                                    echo"</div>";
                                    echo "</form>";
                                
                            }
                        }

                        echo "<hr class='light'>";
                echo "</div>";
                
            echo "</div>";
            echo "<div class='row'>";
            echo "<h2>Active Classes</h2>";
            echo "</div>";
            echo "<div class='row'>";
                
                ////<!-- START CLASS -->
                    $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Active'";
                    $memberresult = $conn->query($membersql);
                    $membernum = mysqli_num_rows($memberresult);

                    if ($membernum > 0)
                    {
                      
                        while($memberrow = $memberresult->fetch_assoc())
                        {
                            $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                            $teacherresult = $conn->query($teachersql);
    
                            echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                            echo "<div class='row-md-6'>";
                            echo "<div class='col-md-3'>";
    
                            while($teacherrow = $teacherresult->fetch_assoc())
                            {
                                $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                $resultImg = $conn->query($sqlImg);
    
                                while($rowImg = $resultImg->fetch_assoc())
                                {
                                    if($rowImg['status'] == 0)
                                    {
                                        echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                    }
                                    else
                                    {
                                    echo "<img src='images/techknow-unknown.png'>";
                                    }
                                }
                                
                            
                            echo "</div>";
                            echo "<div class='col-md-9'>";
                            echo "<h3>".$memberrow['grptitle']."</h3>";
                            echo "<label>".$memberrow['grpcode']."</label>";
                            echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row-md-6 class-functions'>";
                            echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                            $id = $_SESSION['userId'];
                            $idsql = "SELECT * FROM users WHERE idUsers = $id";
                            $idresult = $conn->query($idsql);
                            while($idrow = $idresult->fetch_assoc())
                            {
                                if ($idrow['accounttypeUsers'] == 'Student')
                                {
                                    
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Leave Class</button>";
                                    
                                }
                                else if ($idrow['accounttypeUsers'] == 'Teacher')
                                {
                                    
                                    echo "<button class='get-group-archive' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#archivemodal'>Archive Class</button>";
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Delete Class</button>";
                                    
                                }
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='row text-center box-divs' style='min-height:15px;' role='alert'>
                        <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                        </div>";
                    }

                    
                
                //<!-- END CLASS -->
                
            echo "</div>";
              echo "<div class='row'>";
              echo "<h2>Archived Classes</h2>";
              echo "</div>";
                  echo "<div class='row'>";
                    
                  ////<!-- START CLASS -->
                      $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Archived'";
                      $memberresult = $conn->query($membersql);
                      $membernum = mysqli_num_rows($memberresult);

                      if ($membernum > 0)
                      {
                        
                          while($memberrow = $memberresult->fetch_assoc())
                          {
                              $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                              $teacherresult = $conn->query($teachersql);
      
                              echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                              echo "<div class='row-md-6'>";
                              echo "<div class='col-md-3'>";
      
                              while($teacherrow = $teacherresult->fetch_assoc())
                              {
                                  $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                  $resultImg = $conn->query($sqlImg);
      
                                  while($rowImg = $resultImg->fetch_assoc())
                                  {
                                      if($rowImg['status'] == 0)
                                      {
                                          echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                      }
                                      else
                                      {
                                      echo "<img src='images/techknow-unknown.png'>";
                                      }
                                  }
                                  
                              
                              echo "</div>";
                              echo "<div class='col-md-9'>";
                              echo "<h3>".$memberrow['grptitle']."</h3>";
                              echo "<label>".$memberrow['grpcode']."</label>";
                              echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                              }
                              echo "</div>";
                              echo "</div>";
                              echo "<div class='row-md-6 class-functions'>";
                              echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                              $id = $_SESSION['userId'];
                              $idsql = "SELECT * FROM users WHERE idUsers = $id";
                              $idresult = $conn->query($idsql);
                              while($idrow = $idresult->fetch_assoc())
                              {
                                  if ($idrow['accounttypeUsers'] == 'Student')
                                  {
                                      echo "<form>";
                                      echo "<button type='submit' id='class-link'>Leave Class</button>";
                                      echo "</form>";
                                  }
                                  else if ($idrow['accounttypeUsers'] == 'Teacher')
                                  {
                                      echo "<form>";
                                      echo "<button type='submit' id='class-link'>Delete Class</button>";
                                      echo "</form>";
                                  }
                              }
                              echo "</div>";
                              echo "</div>";
                          }
                      }
                      else
                      {
                          echo "<div class='col text-center box-divs' role='alert'>
                          <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                          </div>";
                      }

                      
                  
                  //<!-- END CLASS -->
                  
              echo "</div>";

            echo "</div>";
            echo "<script>
              $.bootstrapGrowl('Class archived successfully!',{
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
            elseif(isset($_GET['deleteclasssuccess']))
            {
              echo "<title>Classes | TechKnow</title>";
              echo "<div class='row'>";
                echo "<div class='row-md-12'>";
                echo "<hr class='light'>";
                        $id = $_SESSION['userId'];
                        $idsql = "SELECT * FROM users WHERE idUsers = $id";
                        $idresult = $conn->query($idsql);

                        while($idrow = $idresult->fetch_assoc())
                        {
                            if ($idrow['accounttypeUsers'] == 'Student')
                            {
                                echo "<form action='".setMember($conn)."' method='POST'>";
                                echo "<div class='input-group'>";
                                echo "<input type='text' class='form-control input-default' name='code' placeholder= 'Enter room code'> 
                                <button class='btn btn-default' name='submitcode'>Join Class</button>";
                                echo"</div>";
                                echo "</form>";
                            }
                            else if ($idrow['accounttypeUsers'] == 'Teacher')
                            {
                                echo "<form id='createform' action='".setGroup($conn)."' method='POST'>";
                                    echo "<div class='input-group'>";
                                    echo "<div class='input-group-prepend'>";
                                        echo "<input id='classtitle' class='form-control input-default' type='text' name='classroom-title' placeholder='Class title'>";
                                        echo"<input id='classdesc' class='form-control input-default' type='text' name='classroom-desc' placeholder='Class description'>";
                                        echo "<input type='hidden' name='author' value='".$idrow['fnameUsers']." ".$idrow['lnameUsers']."'>";
                                        echo "<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>";
                                        echo "<input type='hidden' id='color' name='color' value=''>";
                                    echo"</div>";
                                    echo '<select id="classcourse" class="form-control" name="course"><option selected hidden value="0">Select course</option>';
                                    $coursesql = "SELECT * FROM coursedept WHERE type = 'Course'";
                                    $courseres = $conn->query($coursesql);
            
                                    while($row = $courseres->fetch_assoc())
                                    {
                                      echo "<option value = '".$row['title']."'>".$row['code']." - ".$row['title']."</option>";
                                    }
                                    echo'</select>';
                                        echo"<button id='classsub' type='submit' class='btn btn-default' name='grpsubmit' disabled='disabled'>Create</button>";
                                    
                                    echo"</div>";
                                    echo "</form>";
                                
                            }
                        }

                        echo "<hr class='light'>";
                echo "</div>";
                
            echo "</div>";
            echo "<div class='row'>";
            echo "<h2>Active Classes</h2>";
            echo "</div>";
            echo "<div class='row'>";
                
                ////<!-- START CLASS -->
                    $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Active'";
                    $memberresult = $conn->query($membersql);
                    $membernum = mysqli_num_rows($memberresult);

                    if ($membernum > 0)
                    {
                      
                        while($memberrow = $memberresult->fetch_assoc())
                        {
                            $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                            $teacherresult = $conn->query($teachersql);
    
                            echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                            echo "<div class='row-md-6'>";
                            echo "<div class='col-md-3'>";
    
                            while($teacherrow = $teacherresult->fetch_assoc())
                            {
                                $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                $resultImg = $conn->query($sqlImg);
    
                                while($rowImg = $resultImg->fetch_assoc())
                                {
                                    if($rowImg['status'] == 0)
                                    {
                                        echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                    }
                                    else
                                    {
                                    echo "<img src='images/techknow-unknown.png'>";
                                    }
                                }
                                
                            
                            echo "</div>";
                            echo "<div class='col-md-9'>";
                            echo "<h3>".$memberrow['grptitle']."</h3>";
                            echo "<label>".$memberrow['grpcode']."</label>";
                            echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row-md-6 class-functions'>";
                            echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                            $id = $_SESSION['userId'];
                            $idsql = "SELECT * FROM users WHERE idUsers = $id";
                            $idresult = $conn->query($idsql);
                            while($idrow = $idresult->fetch_assoc())
                            {
                                if ($idrow['accounttypeUsers'] == 'Student')
                                {
                                    
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Leave Class</button>";
                                    
                                }
                                else if ($idrow['accounttypeUsers'] == 'Teacher')
                                {
                                    
                                    echo "<button class='get-group-archive' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#archivemodal'>Archive Class</button>";
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Delete Class</button>";
                                    
                                }
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='col text-center box-divs' role='alert'>
                        <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                        </div>";
                    }

                    
                
                //<!-- END CLASS -->
                
            echo "</div>";
              echo "<div class='row'>";
              echo "<h2>Archived Classes</h2>";
              echo "</div>";
                  echo "<div class='row'>";
                    
                  ////<!-- START CLASS -->
                      $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Archived'";
                      $memberresult = $conn->query($membersql);
                      $membernum = mysqli_num_rows($memberresult);

                      if ($membernum > 0)
                      {
                        
                          while($memberrow = $memberresult->fetch_assoc())
                          {
                              $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                              $teacherresult = $conn->query($teachersql);
      
                              echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                              echo "<div class='row-md-6'>";
                              echo "<div class='col-md-3'>";
      
                              while($teacherrow = $teacherresult->fetch_assoc())
                              {
                                  $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                  $resultImg = $conn->query($sqlImg);
      
                                  while($rowImg = $resultImg->fetch_assoc())
                                  {
                                      if($rowImg['status'] == 0)
                                      {
                                          echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                      }
                                      else
                                      {
                                      echo "<img src='images/techknow-unknown.png'>";
                                      }
                                  }
                                  
                              
                              echo "</div>";
                              echo "<div class='col-md-9'>";
                              echo "<h3>".$memberrow['grptitle']."</h3>";
                              echo "<label>".$memberrow['grpcode']."</label>";
                              echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                              }
                              echo "</div>";
                              echo "</div>";
                              echo "<div class='row-md-6 class-functions'>";
                              echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                              $id = $_SESSION['userId'];
                              $idsql = "SELECT * FROM users WHERE idUsers = $id";
                              $idresult = $conn->query($idsql);
                              while($idrow = $idresult->fetch_assoc())
                              {
                                  if ($idrow['accounttypeUsers'] == 'Student')
                                  {
                                      echo "<form>";
                                      echo "<button type='submit' id='class-link'>Leave Class</button>";
                                      echo "</form>";
                                  }
                                  else if ($idrow['accounttypeUsers'] == 'Teacher')
                                  {
                                      echo "<form>";
                                      echo "<button type='submit' id='class-link'>Delete Class</button>";
                                      echo "</form>";
                                  }
                              }
                              echo "</div>";
                              echo "</div>";
                          }
                      }
                      else
                      {
                          echo "<div class='col text-center box-divs' role='alert'>
                          <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                          </div>";
                      }

                      
                  
                  //<!-- END CLASS -->
                  
              echo "</div>";

            echo "</div>";
            echo "<script>
              $.bootstrapGrowl('Class deleted successfully!',{
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
            else
            {
                echo "<title>Classes | TechKnow</title>";
                echo "<div class='row'>";
                echo "<div class='row-md-12'>";
                echo "<hr class='light'>";
                        $id = $_SESSION['userId'];
                        $idsql = "SELECT * FROM users WHERE idUsers = $id";
                        $idresult = $conn->query($idsql);

                        while($idrow = $idresult->fetch_assoc())
                        {
                            if ($idrow['accounttypeUsers'] == 'Student')
                            {
                                echo "<form action='".setMember($conn)."' method='POST'>";
                                echo "<div class='input-group'>";
                                echo "<input type='text' class='form-control input-default' name='code' placeholder= 'Enter room code'> 
                                <button class='btn btn-default' name='submitcode'>Join Class</button>";
                                echo"</div>";
                                echo "</form>";
                            }
                            else if ($idrow['accounttypeUsers'] == 'Teacher')
                            {
                                echo "<form id='createform' action='".setGroup($conn)."' method='POST'>";
                                    echo "<div class='input-group'>";
                                    echo "<div class='input-group-prepend'>";
                                        echo "<input id='classtitle' class='form-control input-default' type='text' name='classroom-title' placeholder='Class title'>";
                                        echo"<input id='classdesc' class='form-control input-default' type='text' name='classroom-desc' placeholder='Class description'>";
                                        echo "<input type='hidden' name='author' value='".$idrow['fnameUsers']." ".$idrow['lnameUsers']."'>";
                                        echo "<input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>";
                                        echo "<input type='hidden' id='color' name='color' value=''>";
                                    echo"</div>";
                                    echo '<select id="classcourse" class="form-control" name="course"><option selected hidden value="0">Select course</option>';
                                    $coursesql = "SELECT * FROM coursedept WHERE type = 'Course'";
                                    $courseres = $conn->query($coursesql);
            
                                    while($row = $courseres->fetch_assoc())
                                    {
                                      echo "<option value = '".$row['title']."'>".$row['code']." - ".$row['title']."</option>";
                                    }
                                    echo'</select>';
                                        echo"<button id='classsub' type='submit' class='btn btn-default' name='grpsubmit' disabled='disabled'>Create</button>";
                                    
                                    echo"</div>";
                                    echo "</form>";
                                
                            }
                        }

                        echo "<hr class='light'>";
                echo "</div>";
                
            echo "</div>";
            echo "<div class='row'>";
            echo "<h2>Active Classes</h2>";
            echo "</div>";
            echo "<div class='row'>";
                
                ////<!-- START CLASS -->
                    $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Active'";
                    $memberresult = $conn->query($membersql);
                    $membernum = mysqli_num_rows($memberresult);

                    if ($membernum > 0)
                    {
                      
                        while($memberrow = $memberresult->fetch_assoc())
                        {
                            $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                            $teacherresult = $conn->query($teachersql);
    
                            echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                            echo "<div class='row-md-6'>";
                            echo "<div class='col-md-3'>";
    
                            while($teacherrow = $teacherresult->fetch_assoc())
                            {
                                $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                $resultImg = $conn->query($sqlImg);
    
                                while($rowImg = $resultImg->fetch_assoc())
                                {
                                    if($rowImg['status'] == 0)
                                    {
                                        echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                    }
                                    else
                                    {
                                    echo "<img src='images/techknow-unknown.png'>";
                                    }
                                }
                                
                            
                            echo "</div>";
                            echo "<div class='col-md-9'>";
                            echo "<h3>".$memberrow['grptitle']."</h3>";
                            echo "<label>".$memberrow['grpcode']."</label>";
                            echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                            }
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row-md-6 class-functions'>";
                            echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                            $id = $_SESSION['userId'];
                            $idsql = "SELECT * FROM users WHERE idUsers = $id";
                            $idresult = $conn->query($idsql);
                            while($idrow = $idresult->fetch_assoc())
                            {
                                if ($idrow['accounttypeUsers'] == 'Student')
                                {
                                    
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Leave Class</button>";
                                    
                                }
                                else if ($idrow['accounttypeUsers'] == 'Teacher')
                                {
                                    
                                    echo "<button class='get-group-archive' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#archivemodal'>Archive Class</button>";
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Delete Class</button>";
                                    
                                }
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                    else
                    {
                        echo "<div class='col text-center box-divs' role='alert'>
                        <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                        </div>";
                    }

                    
                
                //<!-- END CLASS -->
                
            echo "</div>";
              echo "<div class='row'>";
              echo "<h2>Archived Classes</h2>";
              echo "</div>";
                  echo "<div class='row'>";
                    
                  ////<!-- START CLASS -->
                      $membersql = "SELECT * FROM members WHERE memberID = $id AND status = 'Archived'";
                      $memberresult = $conn->query($membersql);
                      $membernum = mysqli_num_rows($memberresult);

                      if ($membernum > 0)
                      {
                        
                          while($memberrow = $memberresult->fetch_assoc())
                          {
                              $teachersql = "SELECT * FROM groups WHERE grpcode = '".$memberrow['grpcode']."'";
                              $teacherresult = $conn->query($teachersql);
      
                              echo "<div class='col-md-4 box-divs class-background' style = 'background: ".$memberrow['color'].";'>";
                              echo "<div class='row-md-6'>";
                              echo "<div class='col-md-3'>";
      
                              while($teacherrow = $teacherresult->fetch_assoc())
                              {
                                  $sqlImg = "SELECT * FROM profileimg WHERE idUsers ='".$teacherrow['grpauthorID']."'";
                                  $resultImg = $conn->query($sqlImg);
      
                                  while($rowImg = $resultImg->fetch_assoc())
                                  {
                                      if($rowImg['status'] == 0)
                                      {
                                          echo "<img src='uploads/profile".$teacherrow['grpauthorID'].".jpg' alt='uploads/profile".$teacherrow['grpauthorID'].".jpg'>";
                                      }
                                      else
                                      {
                                      echo "<img src='images/techknow-unknown.png'>";
                                      }
                                  }
                                  
                              
                              echo "</div>";
                              echo "<div class='col-md-9'>";
                              echo "<h3>".$memberrow['grptitle']."</h3>";
                              echo "<label>".$memberrow['grpcode']."</label>";
                              echo "<label class='label-right'>".$teacherrow['grpauthor']."</label>";
                              }
                              echo "</div>";
                              echo "</div>";
                              echo "<div class='row-md-6 class-functions'>";
                              echo "<a id='class-link' name='room' href='class.php?room=".$memberrow['grpcode']."&contents=posts'>Enter Class</a>";
                              $id = $_SESSION['userId'];
                              $idsql = "SELECT * FROM users WHERE idUsers = $id";
                              $idresult = $conn->query($idsql);
                              while($idrow = $idresult->fetch_assoc())
                              {
                                  if ($idrow['accounttypeUsers'] == 'Student')
                                  {
                                    echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Leave Class</button>";
                                  }
                                  else if ($idrow['accounttypeUsers'] == 'Teacher')
                                  {
                                      
                                      echo "<button class='get-group-delete' type='submit' id='class-link' name='grpcode' data-id='".$memberrow['grpcode']."' data-toggle='modal' data-target='#deletemodal'>Delete Class</button>";
                                      
                                  }
                              }
                              echo "</div>";
                              echo "</div>";
                          }
                      }
                      else
                      {
                          echo "<div class='col text-center box-divs' role='alert'>
                          <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No classes found!</strong>
                          </div>";
                      }

                      
                  
                  //<!-- END CLASS -->
                  
              echo "</div>";

            echo "</div>";
            
            }
            ?>
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

echo '<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Confirm leave?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    echo '<div class="modal-body">
Are you sure you want to leave this class?
</div>';
echo'
<div class="modal-footer" id="check-class-delete">';
echo '</div>';
    echo'
  </div>
</div>
</div>';

echo '<div class="modal fade" id="archivemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Confirm archive?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    echo '<div class="modal-body">
Are you sure you want to archive this class?
</div>';
echo'
<div class="modal-footer" id="check-group-archive">';
echo '</div>';
    echo'
  </div>
</div>
</div>';

?>
        
    </div>


<script type="text/javascript">
var RootUrl = '@Url.Content("~/")';
</script>

<script>
postform.addEventListener('input', () => {
    if (subjectbox.value.length > 0)
    {
    submitpost.removeAttribute('disabled');
    }
    else
    {
    submitpost.setAttribute('disabled', 'disabled');
    }
});
setTimeout(function() {
        $('#notify').fadeOut('fast');
    }, 3000);
</script>
</main>


<script>
    var r = Math.floor(Math.random()*100);
    var g = Math.floor(Math.random()*100);
    var b = Math.floor(Math.random()*100);
    for (var i = 0; i <= 5; i++) 
    {
    var div = document.getElementById("color").value = "rgb("+r+","+g+","+b+")";
    
    }
</script>
<script>
function posttoolsOver()
{
  var x = document.getElementsByClassName('post-tools');
  for (i = 0; i < x.length; i++) 
  {
  x[i].style.display = 'block';
  }
}
function posttoolsOut()
{
  var x = document.getElementsByClassName('post-tools');
  for (i = 0; i < x.length; i++) 
  {
  x[i].style.display = 'none';
  }
}
</script>
<script>
  $(document).ready(function(){
    $('#groupselectpost').on('change', function() {
      if ( this.value == 'Activity')
      {
        $("#deadlinedate").show();
      }
      else if ( this.value == 'Quiz')
      {
        $("#deadlinedate").show();
      }
      else if ( this.value == 'Meeting')
      {
        $("#deadlinedate").show();
      }
      else
      {
        $("#deadlinedate").hide();
      }
    });
});
  </script>

  <script type="text/javascript">
    createform.addEventListener('input', () => {
        if (classtitle.value.length > 0 && classdesc.value.length > 0 && classcourse.value != 0)
        {
        classsub.removeAttribute('disabled');
        }
        else
        {
        classsub.setAttribute('disabled', 'disabled');
        }
    });
    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 3000);
    
    </script>