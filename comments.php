<?php
  date_default_timezone_set('Asia/Manila');
  include 'includes/dbh.inc.php';
  include 'includes/posts.inc.php';
  include 'includes/comment.inc.php';
  include 'includes/groups.inc.php';
  require "header.php";
 ?>
 <main>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script>
   $(document).ready(function(){
    $('#submitcmt').attr('disabled',true);
    $('#messagecmt').keyup(function(){
        if($(this).val().length !=0)
            $('#submitcmt').attr('disabled', false);
        else
            $('#submitcmt').attr('disabled',true);
    })
  });
   </script>

   <script>
     $(document).ready(function(){
       var commentCount = 3;
       $("#load-comments").click(function(){
         commentCount = commentCount + 3;
          $("#comment-user").load("comments-load.php", {
            commentNewCount: commentCount
            });
          });
       });

     });
   </script>

   <div class='comment-wrapper'>
     <?php

     if (isset($_SESSION['userId']))
     {
         if (isset($_GET['submitview']))
         {
           $pid = $_GET['submitview'];
           $sql = "SELECT * FROM posts WHERE postID = $pid";

           $result = $conn->query($sql);
           while($row = $result->fetch_assoc())
           {
             $id = $row['userID'];
             $sql1 = "SELECT * FROM users WHERE idUsers='$id'";
             $result1 = $conn->query($sql1);

             $sqlImg = "SELECT * FROM profileimg WHERE idUsers = $id";
             $resultImg = $conn->query($sqlImg);
             if ($row1 = $result1->fetch_assoc())
             {
               echo "<div id='user-post-comment'>";
               echo "<div id='user-avatar-comment'>";
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
             }
               echo "</div>";
               echo "<div id='#user-name-comment'>";
               echo "Posted by <strong>".$row1['fnameUsers']." ".$row1['lnameUsers'];
               if ($row1['accounttypeUsers'] == "Teacher")
               {
                 echo "<i class='fas fa-check-circle'></i>";
               }
               echo "</strong>";
               echo "</div>";
               echo  "<div id='user-edit'>";
               echo  "<form id='user-edit' method='POST'>

                     <input type='hidden' name='uid' value='".$row['userID']."'>
                     <input type='hidden' name='ugrp' value='".$row['groupID']."'>
                     <input type='hidden' name='date' value='".$row['date']."'>
                     <input type='hidden' name='subject' value='".$row['subjectID']."'>
                     <input type='hidden' name='message' value='".$row['message']."'>
                     </form>";
                     if ($_SESSION['userId'] == $row['userID'])
                     {
                       echo"<form method='POST'>
                              <button id='edit-links-click'><i class='fas fa-pen-square'></i></button>
                              </form>
                              <form method='POST' action='".deletePost($conn)."'>
                              <button type='submit' value='".$pid."' name='submitDelete' id='edit-links-click'><i class='fas fa-trash'></i></button>
                              </form>";
                     }
                     else {
                       echo"<form method='POST'>
                              <button id='edit-links-click'><i class='fas fa-flag'></i></button>
                              </form>";
                     }


               echo  "</div>";

               echo "<div id='user-group-comment'>";
               echo "From <strong>".$row['groupID']."</strong>";
               echo "</div>";
               echo "<div id='user-subject-comment'>";
               echo $row['subjectID'];
               echo "</div>";
               echo "<div id='user-date-comment'>";
               echo $row['date'];
               echo "</div>";
               echo "<div id='user-message-comment'> <p>";
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
                 echo "<div id= 'attach-holder'><a href='fileuploads/".$row['attachname']."'><h5>".$row['attachname']."</h5><strong>Posted by ".$row1['fnameUsers']." ".$row1['lnameUsers']."</strong></a></div>";
               }
               if ($row['attachstatus'] == 0)
               {
                 echo "";
               }
              }


              //COMMENT SECTION
              echo "<div id='comment-section'>";
              $commentsql = "SELECT * FROM comment WHERE postID = $pid ORDER BY date DESC";
              $commentresult = $conn->query($commentsql);
              $numrow = mysqli_num_rows($commentresult);

              echo "<h3>".$numrow." comments</h3>
                   <form method='POST'>
                   <textarea id='messagecmt' name='commentmessage' rows='3' placeholder='Give us your thoughts...'></textarea>
                   <input type='hidden' name='ugrp' value='Web Development'>
                   <input type='hidden' name='uid' value='".$_SESSION['userId']."'>
                   <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                   <button type='submit' id='submitcmt' value='".$pid."' name='submitcomment'>Comment</button>
                   ";


                   echo"
                   </form>
                   <br><br><br>";

                  // echo "<hr><button id=load-comments>Load more comments</button>";
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
              echo '</div>';
              echo '</div>
              </div>';
              if (isset($_POST['submitcomment']))
              {
                $date = $_POST['date'];
                $pid = $_GET['submitview'];
                $message = $conn -> real_escape_string($_POST['commentmessage']);
                $uid = $_POST['uid'];
                $sqlinsertcomment = "INSERT INTO comment (postID, userID, message, date) VALUES ('$pid', '$uid', '$message', '$date')";
                $result = $conn->query($sqlinsertcomment);
              }

         }


     }
     else
     {
       header("Location: index.php");
     }





      ?>

 </main>
