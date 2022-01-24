<?php
include 'dbh.inc.php';
echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
echo "<form action='includes/class-kickmember.inc.php' method='POST'>
<input type='hidden' name='room' value='".$_POST['room']."'>
<input type='hidden' name='memid' value='".$_POST['memid']."'>
<button type='submit' class='btn btn-danger' name='kickmember'>Kick</button>
</form>";
if(isset($_POST['kickmember']))
{
    $memid = $_POST['memid'];
    $room = $_POST['room'];
    $deletesql = "DELETE FROM members WHERE memberID = '$memid' AND grpcode = '$room'";
    $deleteres = $conn->query($deletesql);
    echo "<script type='text/javascript'>window.top.location='../class.php?room=".$room."&contents=members&delete=success';</script>"; 
    exit;
}