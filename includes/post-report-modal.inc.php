<?php
include 'dbh.inc.php';
include 'posts.inc.php';

$postID = $_POST['postID'];
$id = $_SESSION['userId'];


echo '<form action="includes/post-report-modal.inc.php" method="POST">
<div class="form-check">
<input class="form-check-input" type="radio" name="radioq" id="exampleRadios1" value="1" checked>
<label class="form-check-label" for="exampleRadios1">
Irrelevant to the subject or topic
</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="radioq" id="exampleRadios2" value="2">
<label class="form-check-label" for="exampleRadios2">
Shows violence or any sexual content
</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="radioq" id="exampleRadios3" value="3">
<label class="form-check-label" for="exampleRadios3">
Misleading information or links
</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="radioq" id="exampleRadios4" value="4">
<label class="form-check-label" for="exampleRadios4">
It is offensive to students or teachers 
</label>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-danger" name="reportsubmit" value="'.$postID.'">Report</button>
</div>
</form>';

if(isset($_POST['reportsubmit']))
{
    $radiovalue = $_POST['radioq'];
    $postnum = $_POST['reportsubmit'];
    switch ($radiovalue) {
        case 1:
            $reason = "Irrelevant to the subject or topic";
            $reportsql ="INSERT INTO reports (reporterID, reportedID, postID, reasonID, reason) VALUES ('$id', (SELECT userID FROM posts WHERE postID = '$postnum'), '$postnum', '$radiovalue', '$reason')";
            $conn->query($reportsql);
            echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
            break;
        case 2:
            $reason = "Shows violence or any sexual content";
            $reportsql ="INSERT INTO reports (reporterID, reportedID, postID, reasonID, reason) VALUES ('$id', (SELECT userID FROM posts WHERE postID = '$postnum'), '$postnum', '$radiovalue', '$reason')";
            $conn->query($reportsql);
            echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
            break;
        case 3:
            $reason = "Misleading information or links";
            $reportsql ="INSERT INTO reports (reporterID, reportedID, postID, reasonID, reason) VALUES ('$id', (SELECT userID FROM posts WHERE postID = '$postnum'), '$postnum', '$radiovalue', '$reason')";
            $conn->query($reportsql);
            echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
            break;
        case 4:
            $reason = "It is offensive to students or teachers";
            $reportsql ="INSERT INTO reports (reporterID, reportedID, postID, reasonID, reason) VALUES ('$id', (SELECT userID FROM posts WHERE postID = '$postnum'), '$postnum', '$radiovalue', '$reason')";
            $conn->query($reportsql);
            echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
            break;
        }
    
}