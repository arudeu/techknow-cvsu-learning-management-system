<?php
include 'dbh.inc.php';

echo'
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<form action="includes/post-modal.inc.php" method="post">
';
echo'<button type="submit" class="btn btn-danger" name="deletepost" value="'.$_POST['postID'].'">Delete</button>
</form>
';

if(isset($_POST['deletepost']))
{
    $pid = $_POST['deletepost'];
    $deletesql = "DELETE FROM posts WHERE postID = '$pid'";
    $deleteres = $conn->query($deletesql);
    $selectsubmissionsql = "SELECT * FROM submissions WHERE postID = '$pid'";
    $selectsubmissionres = $conn->query($selectsubmissionsql);
    $selectsubmissionnum = mysqli_num_rows($selectsubmissionres);

    if ($selectsubmissionnum > 0)
    {
        $deletesubmissionsql = "DELETE FROM submissions WHERE postID = '$pid'";
        $deletesubmissionres = $conn->query($deletesubmissionsql);
        echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
        exit();
    }
    else
    {
        echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
        exit();
    }
    
}
