<?php
require 'dbh.inc.php';
$userid = $_SESSION['userId'];

if(isset($_POST['editsubmit']))
{
    $usersql = "SELECT * FROM users WHERE idUsers = $userid";
    $userres = $conn->query($usersql);
    while($userrow = $userres->fetch_assoc())
    {
        if($userrow['accounttypeUsers'] == 'Student')
        {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $bday = $_POST['bday'];
            $user = $_POST['user'];
            $course = $_POST['course'];
            $sid = $_POST['sid'];

            $sql = "UPDATE users SET fnameUsers = '$fname', lnameUsers = '$lname', addressUsers = '$address', bdayUsers = '$bday', usernameUsers = '$user', course = '$course', studentIDUsers = '$sid' WHERE idUsers = '$userid'";
            $res = $conn->query($sql);
            echo "<script type='text/javascript'>window.top.location='../user.php?id=".$userid."&success';</script>";
            exit;
        }
        elseif($userrow['accounttypeUsers'] == 'Teacher')
        {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $address = $_POST['address'];
            $bday = $_POST['bday'];
            $user = $_POST['user'];
            $dept = $_POST['dept'];
            $eid = $_POST['eid'];

            $sql = "UPDATE users SET fnameUsers = '$fname', lnameUsers = '$lname', addressUsers = '$address', bdayUsers = '$bday', usernameUsers = '$user', departmentUsers = '$dept', employeeIDUsers = '$eid' WHERE idUsers = '$userid'";
            $res = $conn->query($sql);
            echo "<script type='text/javascript'>window.top.location='../user.php?id=".$userid."&success';</script>";
            exit;
        }
    }
}
else
{
    echo "<script type='text/javascript'>window.top.location='../user.php';</script>";
    exit;
}