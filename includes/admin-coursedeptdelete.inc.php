<?php
include 'dbh.inc.php';

echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>';
echo "<form action='includes/admin-coursedeptdelete.inc.php' method='POST'>
<button type='submit' class='btn btn-danger' name='deletecoursedept' value='".$_POST['id']."'>Delete</button>
</form>";

if(isset($_POST['deletecoursedept']))
{
    $id = $_POST['deletecoursedept'];
    $deletesql = "DELETE FROM coursedept WHERE id = '$id'";
    $deleteres = $conn->query($deletesql);
    echo "<script type='text/javascript'>window.top.location='../admin.php?type=departments&delete=success';</script>"; 
    exit;
}
