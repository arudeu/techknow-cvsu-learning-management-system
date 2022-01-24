<?php
include 'dbh.inc.php';

echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
echo "<form action='includes/admin-delete.inc.php' method='POST'>
<button type='submit' name='deleteuser' value='".$_POST['idUsers']."'>Delete</button>
</form>";

if(isset($_POST['deleteuser']))
{
    $uid = $_POST['deleteuser'];
    $deletesql = "DELETE FROM users WHERE idUsers = '$uid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM members WHERE memberID = '$uid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM posts WHERE userID = '$uid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM comment WHERE userID = '$uid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM groups WHERE grpauthorID = '$uid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM submissions WHERE userID = '$uid'";
    $deleteres = $conn->query($deletesql);
    echo "<script type='text/javascript'>window.top.location='../admin.php?delete=success';</script>"; 
    exit;
}
