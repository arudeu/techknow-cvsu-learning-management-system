<?php
include 'dbh.inc.php';
if (isset($_POST['submitcomment']))
{
  $date = $_POST['date'];
  $pid = $_POST['submitcomment'];
  $message = $conn -> real_escape_string($_POST['commentmessage']);
  $uid = $_POST['uid'];
  $sqlinsertcomment = "INSERT INTO comment (postID, userID, message, date) VALUES ('$pid', '$uid', '$message', '$date')";
  $result = $conn->query($sqlinsertcomment);
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
