<?php

if (isset($_POST['login-adminheader']))
{
  require 'dbh.inc.php';

  $userid = $_POST['userid'];
  $passid = $_POST['passid'];

  if (empty($userid) || empty($passid))
  {
    header("Location: ../admin.php?error=emptyfields");
    exit();
  }
  else
  {
    $sql = "SELECT * FROM users WHERE usernameUsers=? OR emailUsers=? AND accounttypeUsers = 'Admin';";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql))
    {
      header("Location: ../admin.php?error=sqlerror");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt, "ss", $userid, $userid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result))
      {
        $pwdCheck = password_verify($passid, $row['passUsers']);
        if ($pwdCheck == false)
        {
          header("Location: ../admin.php?error=wrongpwd");
          exit();
        }
        else if ($row['accounttypeUsers'] !== 'Admin')
        {
          header("Location: ../admin.php?error=invalidparticipant");
          exit();
        }
        else if ($pwdCheck == true)
        {
          session_start();
          $_SESSION['adminuserId'] = $row['idUsers'];

          header("Location: ../admin.php?login=success");
          exit();
        }
        else
        {
          header("Location: ../admin.php?error=wrongpwd");
          exit();
        }
      }
      else
      {
        header("Location: ../admin.php?error=nouser");
        exit();
      }
    }
  }
}
else
{
  header("Location: ../admin.php?login=success");
  exit();
}
