<?php
include 'dbh.inc.php';

echo'<form method="POST" action="includes/forgotpassword-modal.inc.php">
<div class="form-group">
<input type="email" class="form-control" name="email" placeholder="Enter your email here...">
</div>';
echo '<div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn login-submit" name="forgotsubmit">Submit</button>
      </div>';
echo '</form>';

if(isset($_POST['forgotsubmit']))
{
    if($_POST['email'] == null)
    {
        echo "<script type='text/javascript'>window.top.location='../index.php?resetpass=fieldsempty';</script>"; 
        exit;
    }
    else
    {
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
    
        $url = "www.techknowcvsu.live/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);
    
        $expires = date("U") + 600;
    
        $email = $_POST['email'];
    
        $delsql = "DELETE FROM forgotpassword WHERE email = ?";
        $delstmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($delstmt, $delsql))
        {
            echo "There was an error!";
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($delstmt, "s", $email);
            mysqli_stmt_execute($delstmt);
    
        }
    
        $inssql = "INSERT INTO forgotpassword(selector, token, email, expires) VALUES(?, ?, ?, ?)";
        $insstmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($insstmt, $inssql))
        {
            echo "There was an error!";
            exit();
        }
        else
        {
            $hashedtoken = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($insstmt, "ssss", $selector, $hashedtoken, $email, $expires);
            mysqli_stmt_execute($insstmt);
    
        }
    
        mysqli_stmt_close($insstmt);
    
        $to = $email;
    
        $subject = "Reset your password for TECHKNOW?";
    
        $message = "<p>We received an information that you have forgotten your password to your TECHKNOW account.</p>";
        $message .= "<p>If you request to change your password, click the link below. If not, ignore this message.</p>";
        $message .= "<p><a href='".$url."'>".$url."</a></p>";
    
        $headers = "From: <info@techknowcvsu.live>\r\n";
        $headers .= "Reply-To: info@techknowcvsu.live\r\n";
        $headers .= "Content-type: text/html\r\n";
    
        mail($to, $subject, $message, $headers);
        echo "<script type='text/javascript'>window.top.location='../index.php?resetpass=success';</script>";
        exit();
    }
    

}