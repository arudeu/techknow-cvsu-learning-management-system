<?php
  if (isset($_POST['signup-submit']))
  {
    require 'dbh.inc.php';

    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $username = $_POST['user'];
    $mail = $_POST['email'];
    $eid = $_POST['employeeID'];
    $password = $_POST['pass'];
    $passwordrepeat = $_POST['pass-repeat'];
    $acct = $_POST['accounttype'];

    if (empty($firstname) || empty($lastname)|| empty($username) || empty($mail) || empty($eid) || empty($password) || empty($passwordrepeat))
    {
      header("Location: ../admin-signup.php?error=emptyfields&user=".$username."&fname=".$firstname."&lname=".$lastname."&email=".$mail."&employeeid=".$eid);
      exit();
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../admin-signup.php?error=invaliduser&email");
      exit();
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
      header("Location: ../admin-signup.php?error=invalidemail&user=".$username);
      exit();
    }
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
      header("Location: ../admin-signup.php?error=invaliduser&email=".$mail);
      exit();
    }
    else if ($password !== $passwordrepeat)
    {
      header("Location: ../admin-signup.php?error=passwordcheck&user=".$username."&email=".$mail);
      exit();
    }
    else
    {
      $sql = "SELECT usernameUsers FROM users WHERE usernameUsers=?";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../admin-signup.php?error=sqlerror");
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
          header("Location: ../admin-signup.php?error=usertaken=".$mail);
          exit();
        }
        else
        {
          $sql = "INSERT INTO users (fnameUsers, lnameUsers, usernameUsers, emailUsers, employeeIDUsers, passUsers, accounttypeUsers, statusUsers) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          $statusUser = 'None';

          if (!mysqli_stmt_prepare($stmt, $sql))
          {
            header("Location: ../admin-signup.php?error=sqlerror");
            exit();
          }
          else
          {
            $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssssssss", $firstname, $lastname, $username, $mail, $eid, $hashedpwd, $acct, $statusUser);
            mysqli_stmt_execute($stmt);
            
            $sql = "INSERT INTO profileimg (idUsers, status) VALUES ((SELECT idUsers FROM users WHERE usernameUsers = '$username'), '1')";
            mysqli_query($conn, $sql);

            header("Location: ../admin-signup.php?success");
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
    header("Location: ../admin-signup.php ");
    exit();
  }
