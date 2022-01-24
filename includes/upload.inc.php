<?php
if(!isset($_SESSION))
  {
      session_start();

include_once 'dbh.inc.php';
$id = $_SESSION['userId'];

if (isset($_POST['upload']))
{
  $file = $_FILES['avatar'];

  $fileName = $_FILES['avatar']['name'];
  $fileTmpName = $_FILES['avatar']['tmp_name'];
  $fileSize = $_FILES['avatar']['size'];
  $fileError = $_FILES['avatar']['error'];
  $fileType = $_FILES['avatar']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  if (in_array($fileActualExt, $allowed))
  {
    if ($fileError === 0)
    {
      if ($fileSize < 5000000)
      {
        $fileNameNew = "profile".$id.".".$fileActualExt;
        $fileDest = '../uploads/'.$fileNameNew;

        move_uploaded_file($fileTmpName, $fileDest);
        $sql = "UPDATE profileimg SET status = 0 WHERE idUsers= '$id'";
        $result = mysqli_query($conn, $sql);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
      else
      {
        echo "Image is too large!";
      }
    }
    else
    {
      echo "There was an error!";
    }
  }
  else
  {
    echo "You cannot upload file of this type!";
  }

}


}
