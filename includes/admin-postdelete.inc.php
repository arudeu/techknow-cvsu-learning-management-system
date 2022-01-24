<?php
include 'dbh.inc.php';

echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
echo "<form action='includes/admin-postdelete.inc.php' method='POST'>
<button type='submit' name='deleteadminpost' value='".$_POST['postID']."'>Delete</button>
</form>";

if(isset($_POST['deleteadminpost']))
{
    $pid = $_POST['deleteadminpost'];
    $deletesql = "DELETE FROM reports WHERE postID = '$pid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM posts WHERE postID = '$pid'";
    $deleteres = $conn->query($deletesql);
    $deletesql = "DELETE FROM comment WHERE postID = '$pid'";
    $deleteres = $conn->query($deletesql);
    echo "<script type='text/javascript'>window.top.location='../admin.php?type=flags&delete=success';</script>"; 
    exit;
}