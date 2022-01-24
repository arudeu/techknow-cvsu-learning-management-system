<?php
  if (isset($_POST['signup-submit']))
  {
    require 'dbh.inc.php';

    $firstname = $_POST['fname'];
    $lastname = $_POST['lname'];
    $gender = $_POST['gender'];
    $bday = $_POST['bday'];
    $address = $_POST['address'];
    $username = $_POST['user'];
    $department = $_POST['department'];
    $mail = $_POST['email'];
    $eid = $_POST['employeeID'];
    $password = $_POST['pass'];
    $passwordrepeat = $_POST['pass-repeat'];
    $acct = $_POST['accounttype'];

    if (empty($firstname) || empty($lastname) || empty($gender) || empty($bday) || empty($address) || empty($username) || empty($mail) || empty($department) || empty($eid) || empty($password) || empty($passwordrepeat))
    {
      header("Location: ../signup.php?error=emptyfields&user=".$username."&fname=".$firstname."&lname=".$lastname."&email=".$mail."&employeeid=".$eid);
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
        $file = $_FILES['imageid'];
        $fileName = $_FILES['imageid']['name'];
        $fileTmpName = $_FILES['imageid']['tmp_name'];
        $fileSize = $_FILES['imageid']['size'];
        $fileError = $_FILES['imageid']['error'];
        $fileType = $_FILES['imageid']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png', 'gif');
          if (in_array($fileActualExt, $allowed))
          {
            if ($fileError === 0)
            {
              if ($fileSize < 5000000)
              {
                  $fileNameNew = $lastname."_".$firstname."-".$eid.".".$fileActualExt;
                  $fileDest = '../acctapproval/'.$fileNameNew;

                  move_uploaded_file($fileTmpName, $fileDest);

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
                      header("Location: ../signup.php?error=usertaken=".$username);
                      exit();
                    }
                    else
                    {
                      $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
                      $stmt = mysqli_stmt_init($conn);

                      if (!mysqli_stmt_prepare($stmt, $sql))
                      {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                      }
                      else
                      {
                        $sql = "INSERT INTO users (fnameUsers, lnameUsers, bdayUsers, genderUsers, addressUsers, usernameUsers, departmentUsers, emailUsers, employeeIDUsers, passUsers, accounttypeUsers, statusUsers, imageUsers) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        $stat = 'Pending';
  
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                          header("Location: ../signup.php?error=sqlerror");
                          exit();
                        }
                        else
                        {
                          $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
                          mysqli_stmt_bind_param($stmt, "sssssssssssss", $firstname, $lastname, $bday, $gender, $address, $username, $department, $mail, $eid, $hashedpwd, $acct, $stat, $fileNameNew);
                          mysqli_stmt_execute($stmt);
                          
                          $sql = "INSERT INTO profileimg (idUsers, status) VALUES ((SELECT idUsers FROM users WHERE usernameUsers = '$username'), '1')";
                          mysqli_query($conn, $sql);
  
                          header("Location: ../signup.php?success=login");
                          exit();
                        }
                      }
                      
                    }

                  }
              }
              else
              {
                header("Location: ../signup.php?error=imglarge");
                exit();
              }
            }
            else
            {
                header("Location: ../signup.php?error=imgerror");
                exit();
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
