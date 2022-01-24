<?php

if (isset($_POST['login-submit']))
{
  require_once 'dbh.inc.php';

  $userid = $_POST['userid'];
  $passid = $_POST['passid'];

  if (empty($userid) || empty($passid))
  {
    header("Location: ../index.php?error=emptyfields");
    exit();
  }
  else
  {
    $sql = "SELECT * FROM users WHERE usernameUsers = ? OR passUsers = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
    {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt, "ss", $userid, $userid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      
      if ($row = mysqli_fetch_assoc($result))
      {
        if($row['statusUsers'] == 'Approved')
        {
          $pwdCheck = password_verify($passid, $row['passUsers']);
          if ($pwdCheck == 0)
          {
            header("Location: ../index.php?error=wrongpwd");
            exit();
          }
          else if ($pwdCheck == 1)
          {
            session_start();
            $_SESSION['userId'] = $row['idUsers'];
            $_SESSION['userUsername'] = $row['usernameUsers'];
            header("Location: ../home.php?login=success");
            exit();
          }
        }
        else if($row['statusUsers'] == 'Declined' || $row['statusUsers'] == 'Pending' || $row['statusUsers'] == 'None')
        {
          header("Location: ../index.php?error=statusdeclined");
          exit();
        }
        
      }
      else
      {
        header("Location: ../index.php?error=nouser");
        exit();
      }
    }
  }
}
else
{
  header("Location: ../index.php");
  exit();
}
