<?php
include 'dbh.inc.php';

echo'
<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
<form action="includes/groups-delete-modal.inc.php" method="post">
';
echo'<button type="submit" class="btn btn-danger" name="deletegroup" value="'.$_POST['grpcode'].'">Leave class</button>
</form>
';

if(isset($_POST['deletegroup']))
{
    $uid = $_SESSION['userId'];
    $gid = $_POST['deletegroup'];
    $selectusersql = "SELECT * FROM users WHERE idUsers = $uid";
    $selectuserres = $conn->query($selectusersql);
    while($selectuserrow = $selectuserres->fetch_assoc())
    {
        if($selectuserrow['accounttypeUsers']=='Student')
        {
            $deletemembersql = "DELETE FROM members WHERE grpcode = '$gid' AND memberID = '$uid'";
            $deletememberres = $conn->query($deletemembersql);
            echo "<script type='text/javascript'>window.top.location='class.php?deleteclasssuccess';</script>";
            exit();
        }
        elseif($selectuserrow['accounttypeUsers']=='Teacher')
        {
            $deletepostsql = "DELETE FROM posts WHERE grpcode = '$gid'";
            $deletepostres = $conn->query($deletepostsql);
        
            $deletegroupsql = "DELETE FROM groups WHERE grpcode = '$gid'";
            $deletegroupres = $conn->query($deletegroupsql);
        
            $deletemembersql = "DELETE FROM members WHERE grpcode = '$gid'";
            $deletememberres = $conn->query($deletemembersql);
        
            echo "<script type='text/javascript'>window.top.location='class.php?deleteclasssuccess';</script>";
            exit();
        }
    }
    
    
    
    
}