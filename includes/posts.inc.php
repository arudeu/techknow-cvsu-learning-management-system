<?php

  //SUBMIT USER POSTS IN BLACKBOARD
function setPost($conn)
{
  if (isset($_POST['postsubmit']))
  {


      //FOR IMAGES
      $file = $_FILES['imageupload'];
      $fileName = $_FILES['imageupload']['name'];
      $fileTmpName = $_FILES['imageupload']['tmp_name'];
      $fileSize = $_FILES['imageupload']['size'];
      $fileError = $_FILES['imageupload']['error'];
      $fileType = $_FILES['imageupload']['type'];

      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg', 'jpeg', 'png');

      if (in_array($fileActualExt, $allowed))
      {
        if ($fileError === 0)
        {
          if ($fileSize < 5242880)
          {

            $fileNameNew = "post".uniqid('', true).".".$fileActualExt;
            $fileDest = 'uploads/'.$fileNameNew;

            move_uploaded_file($fileTmpName, $fileDest);

            $uid = $_POST['uid'];
            $ugrp = $_POST['ugrp'];
            $utype = $_POST['utype'];
            $date = $_POST['date'];
            $subject = $conn -> real_escape_string($_POST['subject']);
            $message = $conn -> real_escape_string($_POST['message']);

            $deadlinedatetime = $_POST['deadlinedate'];
            $hours = $_POST['hours'];
            $meetingcode = generateMeetingCode($conn);

            $sql = "INSERT INTO posts (userID, grpcode, groupID, date, subjectID, message, posttype, deadlinedate, imgStatus, imagename, hours, meetingcode, status) VALUES ('$uid', '$ugrp', (SELECT grptitle FROM members WHERE grpcode = '$ugrp' AND memberID = '$uid'), '$date', '$subject', '$message', '$utype', '$deadlinedatetime', 1, '$fileNameNew', '$hours', '$meetingcode', 'Active')";
            $result = mysqli_query($conn, $sql);
            $userid = $_SESSION['userId'];
            $createmsgsql = "SELECT * FROM users WHERE idUsers = '$userid'";
            $createmsgres = $conn->query($createmsgsql);
            while($createmsgrow = $createmsgres->fetch_assoc())
            {
              $notifmsg = $createmsgrow['fnameUsers']." ".$createmsgrow['lnameUsers']." posted ".$utype." to ".$ugrp;
              $notifsql = "INSERT INTO notifications (notifmsg, notifdate, notifgrp) VALUES ('$notifmsg', '$date', '$ugrp')";
              $conn->query($notifsql);
            }
            echo "<script>
              $.bootstrapGrowl('Posted!',{
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
            echo "<script>
              $.bootstrapGrowl('Image is too large! Max size of 5MB only.',{
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
          echo "<script>
              $.bootstrapGrowl('The file is curropted!',{
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
        //FOR FILES
        $file = $_FILES['fileupload'];
        $fileName = $_FILES['fileupload']['name'];
        $fileTmpName = $_FILES['fileupload']['tmp_name'];
        $fileSize = $_FILES['fileupload']['size'];
        $fileError = $_FILES['fileupload']['error'];
        $fileType = $_FILES['fileupload']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('pdf', 'ppt', 'docx', 'txt', 'doc');

        if (in_array($fileActualExt, $allowed))
        {
          if ($fileError === 0)
          {
            if ($fileSize < 5242880)
            {

              $fileNameNew = uniqid('', true).$fileName;
              $fileDest = 'fileuploads/'.$fileNameNew;

              move_uploaded_file($fileTmpName, $fileDest);

              $uid = $_POST['uid'];
              $ugrp = $_POST['ugrp'];
              $utype = $_POST['utype'];
              $date = $_POST['date'];
              $subject = $conn -> real_escape_string($_POST['subject']);
              $message = $conn -> real_escape_string($_POST['message']);
              $deadlinedatetime = $_POST['deadlinedate'];
              $hours = $_POST['hours'];
              $meetingcode = generateMeetingCode($conn);
              $sql = "INSERT INTO posts (userID, grpcode, groupID, date, subjectID, message, posttype, deadlinedate, attachstatus, attachname, hours, meetingcode, status) VALUES ('$uid', '$ugrp', (SELECT grptitle FROM members WHERE grpcode = '$ugrp' AND memberID = '$uid'), '$date', '$subject', '$message', '$utype', '$deadlinedatetime', 1, '$fileNameNew', '$hours', '$meetingcode', 'Active')";
              $result = mysqli_query($conn, $sql);
              $userid = $_SESSION['userId'];
            $createmsgsql = "SELECT * FROM users WHERE idUsers = '$userid'";
            $createmsgres = $conn->query($createmsgsql);
            while($createmsgrow = $createmsgres->fetch_assoc())
            {
              $notifmsg = $createmsgrow['fnameUsers']." ".$createmsgrow['lnameUsers']." posted ".$utype." to ".$ugrp;
              $notifsql = "INSERT INTO notifications (notifmsg, notifdate, notifgrp) VALUES ('$notifmsg', '$date', '$ugrp')";
              $conn->query($notifsql);
            }
              echo "<script>
              $.bootstrapGrowl('Posted!',{
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
              echo "<script>
              $.bootstrapGrowl('Image is too large! Max size of 5MB only.',{
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
            echo "<script>
              $.bootstrapGrowl('The file is curropted!',{
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
          //FOR VIDEOS
          $file = $_FILES['videoupload'];
          $fileName = $_FILES['videoupload']['name'];
          $fileTmpName = $_FILES['videoupload']['tmp_name'];
          $fileSize = $_FILES['videoupload']['size'];
          $fileError = $_FILES['videoupload']['error'];
          $fileType = $_FILES['videoupload']['type'];

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = array('mp4', 'mov', 'avi');

          if (in_array($fileActualExt, $allowed))
          {
            if ($fileError === 0)
            {
              if ($fileSize < 26214400)
              {

                $fileNameNew = uniqid('', true).$fileName;
                $fileDest = 'videouploads/'.$fileNameNew;

                move_uploaded_file($fileTmpName, $fileDest);

                $uid = $_POST['uid'];
                $ugrp = $_POST['ugrp'];
                $utype = $_POST['utype'];
                $date = $_POST['date'];
                $subject = $conn -> real_escape_string($_POST['subject']);
                $message = $conn -> real_escape_string($_POST['message']);
                $deadlinedatetime = $_POST['deadlinedate'];
                $hours = $_POST['hours'];
                $meetingcode = generateMeetingCode($conn);
                $sql = "INSERT INTO posts (userID, grpcode, groupID, date, subjectID, message, posttype, deadlinedate, videostatus, videoname, hours, meetingcode, status) VALUES ('$uid', '$ugrp', (SELECT grptitle FROM members WHERE grpcode = '$ugrp' AND memberID = '$uid'), '$date', '$subject', '$message', '$utype', '$deadlinedatetime', 1, '$fileNameNew', '$hours', '$meetingcode', 'Active')";
                $result = mysqli_query($conn, $sql);
                $userid = $_SESSION['userId'];
            $createmsgsql = "SELECT * FROM users WHERE idUsers = '$userid'";
            $createmsgres = $conn->query($createmsgsql);
            while($createmsgrow = $createmsgres->fetch_assoc())
            {
              $notifmsg = $createmsgrow['fnameUsers']." ".$createmsgrow['lnameUsers']." posted a ".$utype." to ".$ugrp;
              $notifsql = "INSERT INTO notifications (notifmsg, notifdate, notifgrp) VALUES ('$notifmsg', '$date', '$ugrp')";
              $conn->query($notifsql);
            }
                echo "<script>
              $.bootstrapGrowl('Posted!',{
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
                echo "<script>
                $.bootstrapGrowl('Video is too large! Max size of 25MB only.',{
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
              echo "<script>
              $.bootstrapGrowl('The file is curropted!',{
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
            $uid = $_POST['uid'];
            $ugrp = $_POST['ugrp'];
            $utype = $_POST['utype'];
            $date = $_POST['date'];
            $subject = $conn -> real_escape_string($_POST['subject']);
            $deadlinedatetime = $_POST['deadlinedate'];
            $hours = $_POST['hours'];
            $message = $conn -> real_escape_string($_POST['message']);
            $meetingcode = generateMeetingCode($conn);
            

            $sql = "INSERT INTO posts (userID, grpcode, groupID, date, subjectID, message, posttype, deadlinedate, hours, meetingcode, status) VALUES ('$uid', '$ugrp', (SELECT grptitle FROM members WHERE grpcode = '$ugrp' AND memberID = '$uid'), '$date', '$subject', '$message', '$utype', '$deadlinedatetime', '$hours', '$meetingcode', 'Active')";
            $result = $conn->query($sql);

            $userid = $_SESSION['userId'];
            $createmsgsql = "SELECT * FROM users WHERE idUsers = '$userid'";
            $createmsgres = $conn->query($createmsgsql);
            while($createmsgrow = $createmsgres->fetch_assoc())
            {
              $searchgrpsql = "SELECT * FROM groups WHERE grpcode = '$ugrp'";
              $searchgrpres = $conn->query($searchgrpsql);
              while($searchgrprow = $searchgrpres->fetch_assoc())
              {
                $notifmsg = $createmsgrow['fnameUsers']." ".$createmsgrow['lnameUsers']." posted a ".strtolower($utype)." to ".$searchgrprow['grptitle'];

                $notifsql = "INSERT INTO notifications (userid, notifmsg, notifdate, notifgrp) VALUES ('$userid', '$notifmsg', '$date', '$ugrp')";
                $conn->query($notifsql);
              }
              
            }
            echo "<script>
              $.bootstrapGrowl('Posted!',{
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

}

  function setSubmit($conn)
  {
    if (isset($_POST['submissionsubmit']))
    {
        //FOR IMAGES
        $file = $_FILES['imageupload'];
        $fileName = $_FILES['imageupload']['name'];
        $fileTmpName = $_FILES['imageupload']['tmp_name'];
        $fileSize = $_FILES['imageupload']['size'];
        $fileError = $_FILES['imageupload']['error'];
        $fileType = $_FILES['imageupload']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed))
        {
          if ($fileError === 0)
          {
            if ($fileSize < 5000000)
            {

              $fileNameNew = "imagesubmit".uniqid('', true).".".$fileActualExt;
              $fileDest = 'submissions/'.$fileNameNew;

              move_uploaded_file($fileTmpName, $fileDest);

              $uid = $_POST['uid'];
              $date = $_POST['date'];
              $pid = $_POST['submissionsubmit'];
              

              $sql = "INSERT INTO submissions (postID, userID, imgStatus, imgname, posttype, datedeadline, datepassed) VALUES ('$pid', '$uid', 1, '$fileNameNew', (SELECT posttype FROM posts WHERE postID = '$pid'), (SELECT date FROM posts WHERE postID = '$pid'), '$date')";
              $result = $conn->query($sql);
              echo "<script type='text/javascript'>window.history.back();</script>"; 
              exit;
            }
            else
            {
              echo "<div id='notify'><p>Image is too large!</p></div>";
            }
          }
          else
          {
            echo "<div id='notify'><p>There was an error!</p></div>";
          }
        }
        else
        {
          //FOR FILES
          $file = $_FILES['fileupload'];
          $fileName = $_FILES['fileupload']['name'];
          $fileTmpName = $_FILES['fileupload']['tmp_name'];
          $fileSize = $_FILES['fileupload']['size'];
          $fileError = $_FILES['fileupload']['error'];
          $fileType = $_FILES['fileupload']['type'];

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = array('pdf', 'ppt', 'docx', 'txt', 'doc');

          if (in_array($fileActualExt, $allowed))
          {
            if ($fileError === 0)
            {
              if ($fileSize < 5000000)
              {

                $fileNameNew = "filesubmit".uniqid('', true).$fileName.".".$fileActualExt;
                $fileDest = 'submissions/'.$fileNameNew;

                move_uploaded_file($fileTmpName, $fileDest);

                $uid = $_POST['uid'];
                $date = $_POST['date'];
                $pid = $_POST['submissionsubmit'];
                

                $sql = "INSERT INTO submissions (postID, userID, attachstatus, attachname, posttype, datedeadline, datepassed) VALUES ('$pid', '$uid', 1, '$fileNameNew', (SELECT posttype FROM posts WHERE postID = '$pid'), (SELECT date FROM posts WHERE postID = '$pid'), '$date')";
                $result = $conn->query($sql);
                echo "<script type='text/javascript'>window.history.back();</script>"; 
                exit;
              }
              else
              {
                echo "<div id='notify'><p>Image is too large!</p></div>";
              }
            }
            else
            {
              echo "<div id='notify'><p>There was an error!</p></div>";
            }
          }
          else
          {
            //FOR VIDEOS
            $file = $_FILES['videoupload'];
            $fileName = $_FILES['videoupload']['name'];
            $fileTmpName = $_FILES['videoupload']['tmp_name'];
            $fileSize = $_FILES['videoupload']['size'];
            $fileError = $_FILES['videoupload']['error'];
            $fileType = $_FILES['videoupload']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('mp4', 'mov', 'avi');

            if (in_array($fileActualExt, $allowed))
            {
              if ($fileError === 0)
              {
                if ($fileSize < 1000000000)
                {

                  $fileNameNew = "videosubmit".uniqid('', true).$fileName.".".$fileActualExt;
                  $fileDest = 'submissions/'.$fileNameNew;

                  move_uploaded_file($fileTmpName, $fileDest);

                  $uid = $_POST['uid'];
                  $date = $_POST['date'];
                  $pid = $_POST['submissionsubmit'];
                  

                  $sql = "INSERT INTO submissions (postID, userID, videostatus, videoname, posttype, datedeadline, datepassed) VALUES ('$pid', '$uid', 1, '$fileNameNew', (SELECT posttype FROM posts WHERE postID = '$pid'), (SELECT date FROM posts WHERE postID = '$pid'), '$date')";
                  $result = $conn->query($sql);
                  echo "<script type='text/javascript'>window.history.back();</script>"; 
                  exit;
                }
                else
                {
                  echo "<div id='notify'><p>Video is too large!</p></div>";
                }
              }
              else
              {
                echo "<div id='notify'><p>There was an error!</p></div>";
              }
            }
            else
            {
              echo "<div id='notify'><p>Please attach a file</p></div>";
            }

            
          }



        }



      }
  }

  //GET USER POSTS IN BLACKBOARD
  function getPost($conn)
  {
    ////////////////////POST STARTS/////////////
      $userid = $_SESSION['userId'];
      $sql = "SELECT * FROM posts WHERE grpcode IN (SELECT grpcode FROM members WHERE memberID = '$userid') OR grpcode IN (SELECT grpcode FROM groups WHERE grpauthorID = '$userid') ORDER BY date DESC";
      $result = $conn->query($sql);
      $postnum = mysqli_num_rows($result);
      if ($postnum>0)
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
              echo "<div class='row-sm-6 d-flex justify-content-end' >";
                echo '<div class="post-tools btn-group" id="post-tools" onmouseover="posttoolsOver()" onmouseout="posttoolsOut()"  role="group" aria-label="Basic example" style="position:absolute; z-index:1;display: none;">';
                echo "<button class='get-edit btn btn-sm' style='float:none; color: #5d008e;' data-id='".$row['postID']."' data-toggle='modal' data-target='#editmodal'>";
                echo "<i class='fas fa-edit'></i>";
                echo "</button>";
                echo "<button class='get-delete btn btn-sm' data-id='".$row['postID']."' data-toggle='modal' data-target='#exampleModalCenter'style='float:none; color: #5d008e;'>";
                echo "<i class='fas fa-trash'></i>";
                echo "</button>";
                echo "</div>";
              echo "</div>";
            }
            else
            {
              echo "<div class='row-sm-6 d-flex justify-content-end'>";
              echo '<div class="post-tools btn-group" onmouseover="posttoolsOver()" onmouseout="posttoolsOut()" role="group" aria-label="Basic example" style="position:absolute; z-index:1; display: none;">';
                echo "<button style='color: #5d008e;' class='get-report btn btn-sm' name='postID' data-id='".$row['postID']."' data-toggle='modal' data-target='#reportmodal'>";
                echo "<i class='fas fa-flag'></i>";
                echo "</button>";
              echo "</div>";
              echo "</div>";
            }
              echo "<div class='row' id='user-post' onmouseover='posttoolsOver()' onmouseout='posttoolsOut()' onClick='location.href=\"submission.php?room=".$row['grpcode']."&type=".$row['posttype']."&title=".$row['postID']."\"'>";
              echo "<div class='row-sm-3 col-sm-12 user-avatar'>";
              if($rowImg['status'] == 0)
               {
                 echo "<img src='uploads/profile".$id.".jpg'>";
               }
               else
               {
                 echo "<img src='images/techknow-unknown.png'>";
               }
            }
            echo "<div id='row-sm-4 user-name'>";
            echo "Posted by  <strong>".$row1['fnameUsers']." ".$row1['lnameUsers'];
            if ($row1['accounttypeUsers'] == "Teacher")
            {
              echo "<i class='fas fa-check-circle' style='color: #5D008E; margin-left: 3px;'></i>";
            }
            echo "</strong>";
            echo "<div class='float-right' id='user-actions'>";
            
            
            
            echo "</div>";
            echo "</div>";
  
            echo  "<div id='row-sm-4 user-edit'>";
            
            echo  "<form id='user-edit' method='POST'>
  
                  <input type='hidden' name='uid' value='".$row['userID']."'>
                  <input type='hidden' name='ugrp' value='".$row['groupID']."'>
                  <input type='hidden' name='date' value='".$row['date']."'>
                  <input type='hidden' name='subject' value='".$row['subjectID']."'>
                  <input type='hidden' name='message' value='".$row['message']."'>
                  </form>
                  ";
            echo  "</div>";
  
            echo "<div id='row-sm-4 user-group'>";
            echo "From <strong>".$row['groupID']."</strong>";
            echo "<span style='margin:0 5px; background: #5D008E; color: #ecf0f1; padding: 0 10px; border-radius: 10px;
            font-weight: 600; font-size: 10px;'>".$row['posttype']."</span>";
            echo "</div>";
  
            echo "</div>";
  
            
            
            echo "<div class='row-sm-6 col-sm-12 user-subject'>";
            echo $row['subjectID'];
            echo "";
            echo "<div class='row-sm-6 user-date'>";
            
            //$myDateTime = DateTime::createFromFormat('Y-m-d', $weddingdate);
            //$formattedweddingdate = $myDateTime->format('d-m-Y');
  
            $datepost = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
            $finaldate = $datepost->format('F d, Y - H:i A');
            echo $finaldate;
  
  
            echo "</div>";
  
            echo "</div>";
  
  
            
            echo "<div class='row-sm-12 user-message'>";
            echo "<div class='col-sm-12'><p>";
            echo $row['message'];

            echo "</p></div></div>";
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
            $finaldatedeadline = $datedeadline->format('F d, Y - h:i A');
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
            if($row['posttype'] == 'Meeting')
            {
              echo "<div class='col-md-7'>";
              echo "<strong style='word-wrap: normal;'>Schedule: ".$finaldatedeadline." | ".$row['hours']." hrs</strong>";
              echo "</div>";
              $sql2 = "SELECT * FROM users WHERE idUsers = $userid";
              $res2 = $conn->query($sql2);
              $num2 = mysqli_num_rows($res2);
              while ($row2 = $res2->fetch_assoc())
              {
                if($row2['accounttypeUsers'] == 'Teacher')
                {
                  echo "<div class='col-md-5 text-center'>";
                  echo "<strong>Code: <a href='meetings.php'>".$row['meetingcode']."</a></strong>";
                  echo "</div>";
                }
                if($row2['accounttypeUsers'] == 'Student')
                {
                  echo "<div class='col-md-5 text-center'>";
                  echo "<strong>Code: <a href='meetings.php?roomid=".$row['meetingcode']."'>".$row['meetingcode']."</a></strong>";
                  echo "</div>";
                }
              }
              
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
        
        echo "<div class='row text-center box-divs' role='alert'>
        <img src='icons/search.gif' style='width:25px; height:25px; margin-right:10px;'><strong>No posts found!</strong>
        </div>";
      }
      ////////////////////POST ENDS/////////////////////////
      
  }

  //GET USER PROFILE IN BLACKBOARD
  function getProfile($conn)
  {
    $id = $_SESSION['userId'];
    $sql = "SELECT * FROM users WHERE idUsers = $id";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      if($row['accounttypeUsers']=='Student')
      {
      echo "<div class='home-profile'>
        <img src='images/techknow-unknown.png'>
        <h3 id='welcome'>Welcome,</h3>
        <h3>".$row['fnameUsers']." ".$row['lnameUsers']."</h3>
        <h6>".$row['course']."</h6>
        <h6>".$row['usernameUsers']."</h6>
        <h6>".$row['studentIDUsers']."</h6>
        <button>View Profile</button>
      </div>
     <div class='home-profile'>
       <h3>Your classes</h3>";
       $sql1 = "SELECT * FROM members WHERE memberID = $id";
       $result1 = $conn->query($sql1);
       $numrow1 = mysqli_num_rows($result1);
       if ($numrow1 > 0)
       {
         while($row1 = $result1->fetch_assoc())
         {
           echo "
           <a href='#'>".$row1['grptitle']."</a>
           ";
         }

       }
       else
       {
         echo "<a>".$numrow1." class found</a>";
       }

       echo "</div>
      <form class='enroll-class' action='.joinGroup($conn).' method='POST'>
        <h3>Join your class!</h3>
        <input type='text' name='roomcode' placeholder='Enter room code'>
        <button type='submit' name='submitcode'><i class='fas fa-arrow-circle-right'></i></button>
      </form>
    </div>";
      }
      elseif ($row['accounttypeUsers']=='Teacher')
      {
        echo "<div class='home-profile'>
          <img src='images/techknow-unknown.png'>
          <h3 id='welcome'>Welcome,</h3>
          <h3>".$row['fnameUsers']." ".$row['lnameUsers']."</h3>
          <h6>".$row['departmentUsers']."</h6>
          <h6>".$row['usernameUsers']."</h6>
          <h6>".$row['employeeIDUsers']."</h6>
          <button>View Profile</button>
        </div>
       <div class='home-profile'>
         <h3>Your classes</h3>";
         $sql1 = "SELECT * FROM groups WHERE grpauthorID = $id";
         $result1 = $conn->query($sql1);
         while($row1 = $result1->fetch_assoc())
         {
             echo "
             <a href='#'>".$row1['grptitle']."</a>
             ";
         }

         echo "</div>
        <form class='enroll-class'>
          <h5>CREATE YOUR CLASS</h5>
          <a href = 'class.php';>Create now</a>
        </form>
      </div>";
      }
    }
  }


  //DELETES USER POSTS IN BLACKBOARD
function deletePost($conn)
{
  if (isset($_POST['submitDelete']))
  {
    $pid = $_POST['submitDelete'];
    $deletesql = "DELETE FROM posts WHERE postID = $pid";
    $deleteresult = $conn->query($deletesql);
    $deletesql1 = "DELETE FROM comment WHERE postID = $pid";
    $deleteresult1 = $conn->query($deletesql1);
    echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
    exit;
  }
}


  //TRIGGERS post WHEN USER VIEWS THE POSTS IN BLACKBOARD
function getModalPost($conn)
{
    $pid = $_POST['postid'];
    $sql = "SELECT * FROM posts WHERE postID = '$pid'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc())
    {
      echo "<div class='modal-container'>
        <div class='modal-post'>
          ".$row['subjectID']."
        </div>
      </div>";
    }
}

function generateMeetingCode($conn)
  {
    $keyLength = 6;
    $str = "1234567890";
    $randstr = substr(str_shuffle($str), 0, $keyLength);

    $checkkey = checkKeys($conn, $randstr);


    while ($checkkey == true)
    {
      $randstr = substr(str_shuffle($str), 0, $keyLength);
      $checkkey = checkKeys($conn, $randstr);
    }

    return $randstr;

  }