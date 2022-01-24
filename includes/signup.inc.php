<?php
  if (isset($_POST['signup-submit']))
  {
    require 'dbh.inc.php';

    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $username = $_POST['user'];
    $mail = $_POST['email'];
    $sid = $_POST['studentid'];
    $password = $_POST['pass'];
    $passwordrepeat = $_POST['pass-repeat'];

    if (empty($firstname) || empty($lastname)|| empty($username) || empty($mail) || empty($sid) || empty($password) || empty($passwordrepeat))
    {
      header("Location: ../signup.php?error=emptyfields&user=".$username."&fname=".$firstname."&lname=".$lastname."&email=".$mail."&studentid=".$sid);
      exit();
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../signup.php?error=invaliduser&email");
      exit();
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
      header("Location: ../signup.php?error=invalidemail&user=".$username);
      exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../signup.php?error=invaliduser&email=".$mail);
      exit();
    }
    else if ($password !== $passwordrepeat)
    {
      header("Location: ../signup.php?error=passwordcheck&user=".$username."&email=".$mail);
      exit();
    }
    else
    {
      $sql = "SELECT usernameUsers FROM users WHERE usernameUsers=?";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../signup.php?error=sqlerror");
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0)
        {
          header("Location: ../signup.php?error=usertaken=".$mail);
          exit();
        }
        else
        {
          $sql = "INSERT INTO users (fnameUsers, lnameUsers, usernameUsers, emailUsers, studentIDUsers, passUsers) VALUES (?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql))
          {
            header("Location: ../signup.php?error=sqlerror");
            exit();
          }
          else
          {
            $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $username, $mail, $sid, $hashedpwd);
            mysqli_stmt_execute($stmt);
            header("Location: ../signup.php?success");
            exit();
          }
        }

      }

    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

  }
  else
  {
    header("Location: ../signup.php ");
    exit();
  }
