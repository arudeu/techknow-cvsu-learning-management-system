<?php
include 'dbh.inc.php';

if (isset($_POST['reset-password']))
{
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $newpass = $_POST['newpassword'];
    $newpassrep = $_POST['newpasswordrepeat'];

    if(empty($newpass) || empty($newpassrep))
    {
        echo "<script type='text/javascript'>window.top.location='../index.php?resetpass=fieldsempty';</script>"; 
        exit;
    }
    elseif($newpass != $newpassrep)
    {
        echo "<script type='text/javascript'>window.top.location='../index.php?resetpass=newpassdoesntmatch';</script>"; 
        exit;
    }

    $currentdate = date("U");

    
    $resetsql = "SELECT * FROM forgotpassword WHERE selector = ? AND expires >= ?";
    $resetstmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($resetstmt, $resetsql))
    {
        echo "There was an error!";
        exit($conn);
    }
    else
    {
        mysqli_stmt_bind_param($resetstmt, "ss", $selector, $currentdate);
        mysqli_stmt_execute($resetstmt);

        $resetres = mysqli_stmt_get_result($resetstmt);
        if(!$row = mysqli_fetch_assoc($resetres))
        {
            echo "You need to re-submit your request.";
            exit($conn);
        }
        else
        {
            $tokenbin = hex2bin($validator);

            $tokencheck = password_verify($tokenbin, $row['token']);
            
            if($tokencheck === false)
            {
                echo "You need to re-submit your request.";
                exit($conn);
            }
            elseif($tokencheck === true)
            {
                $tokenemail = $row['email'];

                $usersql = "SELECT * FROM users WHERE emailUsers=?";
                $userstmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($userstmt, $usersql))
                {
                    echo "There was an error!";
                    exit($conn);
                }
                else
                {
                    mysqli_stmt_bind_param($userstmt, "s", $tokenemail);
                    mysqli_stmt_execute($userstmt);
                    $userres = mysqli_stmt_get_result($userstmt);
                    if(!$row = mysqli_fetch_assoc($userres))
                    {
                        echo "There was an error!";
                        exit($conn);
                    }
                    else
                    {
                        $updsql = "UPDATE users SET passUsers = ? WHERE emailUsers = ?";
                        $updstmt = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($updstmt, $updsql))
                        {
                            echo "There was an error!";
                            exit($conn);
                        }
                        else
                        {
                            $newpwdhash= password_hash($newpass, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($updstmt, "ss", $newpwdhash, $tokenemail);
                            mysqli_stmt_execute($updstmt);

                            $delsql = "DELETE FROM forgotpassword WHERE email = ?";
                            $delstmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($delstmt, $delsql))
                            {
                                echo "There was an error!";
                                exit($conn);
                            }
                            else
                            {
                                mysqli_stmt_bind_param($delstmt, "s", $tokenemail);
                                mysqli_stmt_execute($delstmt);
                                echo "<script type='text/javascript'>window.top.location='../index.php?passwordresetsuccess';</script>"; 
                                exit;
                            }
                            
                        }
                    }
                }
            }
        }
    }
}