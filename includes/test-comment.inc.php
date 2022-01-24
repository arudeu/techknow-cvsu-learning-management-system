<?php
include 'dbh.inc.php';
$id = $_POST['idUsers'];
$sql = "SELECT * FROM users WHERE idUsers = ".$id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc())
{
    echo "<img class='text-center' src='acctapproval/".$row['imageUsers']."' style='width: 80%;'>";
}