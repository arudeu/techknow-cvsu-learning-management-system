<?php
include 'dbh.inc.php';
include 'posts.inc.php';

$postID = $_POST['postID'];
$id = $_SESSION['userId'];

$editselect = "SELECT * FROM posts WHERE postID = '$postID'";
$editresult = $conn->query($editselect);

while($editrow = $editresult->fetch_assoc())
{
    $mid=$_SESSION['userId'];
        $sql1 = "SELECT * FROM users WHERE idUsers = '$mid'";
        $result1 = $conn->query($sql1);

        
            echo "<form method='POST' action='includes/post-edit-modal.inc.php'>
            <div class='form-group'>
            <select class='form-control' id='exampleFormControlSelect1' name='utype'>";
            echo"<option selected hidden value='".$editrow['posttype']."'>".$editrow['posttype']."</option>";
                while($row1 = $result1->fetch_assoc())
                {
                    if($row1['accounttypeUsers']=='Student')
                    {
                    
                    echo "<option value='Announcement'>Announcement</option>
                    <option value='Discussion'>Discussion</option>
                    <option value='Question'>Question</option>";
                    
                    }
                    else if($row1['accounttypeUsers']=='Teacher')
                    {
                    echo "<option value='Announcement'>Announcement</option>
                    <option value='Discussion'>Discussion</option>
                    <option value='Question'>Question</option>
                    <option value='Module'>Module</option>
                    <option value='Meeting'>Meeting</option>
                    <option value='Activity'>Activity</option>
                    <option value='Quiz'>Quiz</option>";
                    }
                }
                echo "</select>";
                echo "</div>";
                
                    
                

                $sql = "SELECT * FROM users WHERE idUsers = $id";
                $result = $conn->query($sql);
                echo"<div class='form-group'>
                <select class='form-control' id='exampleFormControlSelect1' name='ugrp'>";
                while($row = $result->fetch_assoc())
                {
                    if($row['accounttypeUsers']=='Student')
                    {
                    $grpsql="SELECT * FROM members WHERE memberID = '$mid'";
                    $grpresult = $conn->query($grpsql);
                    echo"<option selected hidden value='".$editrow['grpcode']."'>".$editrow['groupID']."</option>";
                    while($grprow = $grpresult->fetch_assoc())
                    {

                        echo"<option value='".$grprow['grpcode']."'>".$grprow['grptitle']."</option>";
                    }
                    echo"</select>";


                    }
                    else if ($row['accounttypeUsers']=='Teacher')
                    {
                    $grpsql="SELECT * FROM groups WHERE grpauthorID = '$mid'";
                    $grpresult = $conn->query($grpsql);
                    echo"<option selected hidden value='".$editrow['grpcode']."'>".$editrow['groupID']."</option>";
                    while($grprow = $grpresult->fetch_assoc())
                    {

                        echo"<option value='".$grprow['grpcode']."'>".$grprow['grptitle']."</option>";

                    }

                    echo"</select>";
                    }
                    
                }
                echo "</div>";
                
                  


    echo '<div class="form-group">
        <input type="text" class="form-control" id="subject-name" placeholder="Subject" value="'.$editrow['subjectID'].'" name = "subj">
        </div>
        <div class="form-group">
        <textarea class="form-control" id="message-text" placeholder="Discuss here..." name = "msg">'.$editrow['message'].'</textarea>
        </div>';
    echo '<div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" name="editsubmit" value="'.$postID.'">Edit</button>
         </div>';
    echo "</form>";
    }

if(isset($_POST['editsubmit']))
{
    $pid = $_POST['editsubmit'];
    $utype = $_POST['utype'];
    $ugrp = $_POST['ugrp'];
    $subj = $conn -> real_escape_string($_POST['subj']);
    $msg = $conn -> real_escape_string($_POST['msg']);

    
    $updatesql = "UPDATE posts SET posts.posttype = '$utype', posts.grpcode = '$ugrp', posts.groupID = (SELECT groups.grptitle FROM groups WHERE groups.grpcode = '$ugrp'), posts.subjectID = '$subj', posts.message = '$msg' WHERE posts.postID = '$pid'";
    $conn->query($updatesql);
    echo "<script type='text/javascript'>window.top.location='home.php';</script>"; 
    exit();
}

