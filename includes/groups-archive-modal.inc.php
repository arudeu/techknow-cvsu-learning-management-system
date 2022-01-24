<?php
include 'dbh.inc.php';

echo'
<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
<form action="includes/groups-archive-modal.inc.php" method="post">
';
echo'<button type="submit" class="btn btn-danger" name="archivegroup" value="'.$_POST['grpcode'].'">Archive class</button>
</form>
';

if(isset($_POST['archivegroup']))
{
    $gid = $_POST['archivegroup'];
    $archiveclasssql = "UPDATE groups SET status = 'Archived' WHERE grpcode = '$gid'";
    $archiveclassres = $conn->query($archiveclasssql);
    $archivememsql = "UPDATE members SET status = 'Archived' WHERE grpcode = '$gid'";
    $archivememres = $conn->query($archivememsql);
    $archivepostsql = "UPDATE posts SET status = 'Archived' WHERE grpcode = '$gid'";
    $archivepostres = $conn->query($archivepostsql);
    echo "<script type='text/javascript'>window.top.location='../class.php?archiveclasssuccess';</script>";
    exit();
}
