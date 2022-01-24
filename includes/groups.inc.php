<?php
function setGroup($conn)
{
  if (isset($_POST['grpsubmit']))
  {
    $roomcode = generateRoomID($conn);
    $title = $_POST['classroom-title'];
    $desc = $_POST['classroom-desc'];
    $course = $_POST['course'];
    $authorID = $_SESSION['userId'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $color = $_POST['color'];


    $sql = "INSERT INTO groups (grpcode, grptitle, grpdesc, grpcourse, grpauthorID, grpauthor, date, color, status) VALUES ('$roomcode', '$title','$desc','$course', '$authorID', '$author', '$date', '$color', 'Active')";
    $result = $conn->query($sql);
    $sql2 = "INSERT INTO members (memberID, grpcode, grptitle, color, status) VALUES ('$authorID', '$roomcode','$title', '$color', 'Active')";
    $result2 = $conn->query($sql2);
    echo "<script>
              $.bootstrapGrowl('Class successfully created!',{
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

function getGroup($conn)
{
  $id = $_SESSION['userId'];
  $sql = "SELECT * FROM users WHERE idUsers = $id";
  $result = $conn->query($sql);

  while($row = $result->fetch_assoc())
  {
    if ($row['accounttypeUsers']=='Teacher')
    {
      $sqlauthor = "SELECT * FROM groups WHERE grpauthorID = $id";
      $resultauthor = $conn->query($sqlauthor);
      while($rowauthor = $resultauthor->fetch_assoc())
      {


          if (mysqli_num_rows($resultauthor)>0)
          {
            echo "<div class='classroom-card'>
              <h4>".$rowauthor['grptitle']."</h4>
              <h6>Room code: ".$rowauthor['grpcode']."</h6>
              <h6>Course: ".$rowauthor['grpcourse']."</h6>
              <h6>Teacher: ".$rowauthor['grpauthor']."</h6>";



              echo"<h6>No. of Members:</h6>";


              echo"</div>";

          }
          else
          {
            echo "<h6>You haven't created a class yet. :(</h6>";
          }
      }
    }
      elseif ($row['accounttypeUsers']=='Student')
      {

        $sqlmember = "SELECT * FROM members WHERE memberID = $id";
        $resultmember = $conn->query($sqlmember);
        while($rowmember = $resultmember->fetch_assoc())
        {
          if (mysqli_num_rows($resultmember)>0)
          {
            echo "<form method='POST' action='class.php'>";
            echo "<button type='submit' class='classroom-card' value='".$rowmember['grptitle']."' name='classdirect'>
                <h4>".$rowmember['grptitle']."</h4>
                </button>";
            echo "</form>";
          }
          else
          {
            echo "<div class='classroom-card'>
            <h6>You haven't joined any class yet. :(</h6>
            </div>";
          }

        }

      }

  }

}

function checkKeys($conn, $randstr)
{
  $sql = "SELECT * FROM  keystring";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result))
  {
    if ($row['keystringKey'] == $randstr)
    {
      $keyExists = true;
      break;
    }
    else
    {
      $keyExists = false;
      break;
    }

    return $keyExists;
  }


}

function generateRoomID($conn)
{
  $keyLength = 8;
  $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
  $randstr = substr(str_shuffle($str), 0, $keyLength);

  $checkkey = checkKeys($conn, $randstr);


  while ($checkkey == true)
  {
    $randstr = substr(str_shuffle($str), 0, $keyLength);
    $checkkey = checkKeys($conn, $randstr);
  }

  return $randstr;

}

function setMember($conn)
{
  if (isset($_POST['submitcode']))
  {
    $id = $_SESSION['userId'];
    $code = $_POST['code'];
    
    $checknumsql = "SELECT * FROM members WHERE grpcode = '".$code."'";
    $checknumresult = $conn->query($checknumsql);
    if (mysqli_num_rows($checknumresult) < 1)
    {
      echo "<script>
              $.bootstrapGrowl('No classes found!',{
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
      $checkidsql = "SELECT * FROM members WHERE memberID = '".$id."' AND grpcode = '".$code."'";
      $checkidresult = $conn->query($checkidsql);
      if (mysqli_num_rows($checkidresult) >= 1)
      {
        echo "<script>
              $.bootstrapGrowl('You're already on this class!',{
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
        $sql2 = "INSERT INTO members(memberID, grpcode, grptitle, color, status) VALUES ($id, (SELECT grpcode FROM groups WHERE grpcode = '$code'), (SELECT grptitle FROM groups WHERE grpcode = '$code'), (SELECT color FROM groups WHERE grpcode = '$code'), 'Active')";
        $result2 = $conn->query($sql2);
        echo "<script type='text/javascript'>window.top.location='class.php';</script>"; 
        exit;
      }
      
    }
  }
}

function getGroupPosts($conn)
{
    $roomcode = $_GET['room'];
    $userid = $_SESSION['userId'];
    $sql = "SELECT * FROM posts WHERE grpcode = $roomcode ORDER BY date DESC";
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
        echo "<div id='row-sm-8 user-post'>";
        echo "<div id='user-avatar'>";
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

        echo "</div>";
        echo "<div id='user-name'>";
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
              </form>
              ";
        echo  "</div>";

        echo "<div id='user-group'>";
        echo "From <strong>".$row['groupID']."</strong>";
        echo "</div>";
        echo "<div id='user-subject'>";
        echo $row['subjectID'];
        echo "</div>";
        echo "<div id='user-date'>";
        echo $row['date'];
        echo "</div>";
        echo "<div id='user-message'> <p>";
        echo $row['message'];
        echo "</p></div>";
        echo "<div id='user-attach-image'>";
        echo "</div>
        <form method='GET' action='comments.php'>";
        echo "<button type='submit' id='view-post' value='".$row['postID']."' name='submitview'>View Post</button>
        </form>";
        echo "</div>";
      }

    }



}
