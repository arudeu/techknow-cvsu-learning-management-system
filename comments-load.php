<?php
include 'includes/dbh.inc.php';

$commentNewCount = $_POST['commentNewCount'];
$commentsql = "SELECT * FROM comment ORDER BY date DESC LIMIT $commentNewCount";
$commentresult = $conn->query($commentsql);
  while($commentrow = $commentresult->fetch_assoc())
  {
     echo "<div id='comment-user'>
          <div id='comment-avatar'>";
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
    echo"</div>
         <div id='comment-username'>";
    $usernamesql = "SELECT * FROM users WHERE idUsers = $cmtusrid";
    $usernameresult = $conn->query($usernamesql);
    while ($userrow = $usernameresult->fetch_assoc())
    {
      echo"Comment by <strong>".$userrow['fnameUsers']." ".$userrow['lnameUsers']."</strong>";
    }

    echo"</div>";
    echo"<div id='comment-date'>";
    echo $commentrow['date'];
    echo"</div>";
    echo"<div id='comment-message'>";
    echo $commentrow['message'];
    echo"</div>
         </div>";

    }
 ?>
