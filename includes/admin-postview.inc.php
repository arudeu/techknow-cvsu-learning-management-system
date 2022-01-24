<?php
include 'dbh.inc.php';

$pid = $_POST['postID'];


$postsql = "SELECT * FROM posts WHERE postID = $pid";
$postresult = $conn->query($postsql);

while($row = $postresult->fetch_assoc())
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
        echo "<div class='row' id='user-post'>";
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
      echo "<div id='row-sm-4 user-name' style='text-align: left;'>";
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

      echo "<div id='row-sm-4 user-group' style='text-align: left;'>";
      echo "From <strong>".$row['groupID']."</strong>";
      echo "<span style='margin:0 5px; background: #5D008E; color: #ecf0f1; padding: 0 10px; border-radius: 10px;
      font-weight: 600; font-size: 10px;'>".$row['posttype']."</span>";
      echo "</div>";

      echo "</div>";

      
      
      echo "<div class='row-sm-6 col-sm-12 user-subject' style='text-align: left;'>";
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


      
      echo "<div class='row-sm-3 user-message'> <p>";
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
      echo "</div>";
      
      
    }
    

}