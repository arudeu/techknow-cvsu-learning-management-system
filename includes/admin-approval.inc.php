<?php
include 'dbh.inc.php';


echo "<form action='includes/admin-approval.inc.php' method='POST'>
<button type='submit' name='declineapplication' value='".$_POST['idUsers']."'>Decline</button>
<button type='submit' name='approveapplication' value='".$_POST['idUsers']."'>Approve</button>
</form>";

if(isset($_POST['approveapplication']))
{
    $dataid = $_POST['approveapplication'];
    $approvesql = "UPDATE users SET statusUsers = 'Approved' WHERE idUsers = '$dataid'";
    $conn->query($approvesql);
    $confirmsql = "SELECT * FROM users WHERE idUsers = '$dataid'";
    $to = $conn->query($confirmsql);
    while($row = $to->fetch_assoc())
    {
        $tostring = $row["emailUsers"];
        $from = "info@techknowcvsu.live";

        $subject = "Your TechKnow account has been approved!";
        $message = "<p>Greetings, ".$row['fnameUsers']."!</p>";
        $message .= "<p>We are glad to inform you that your TechKnow account has been approved!</p>";
        $message .= "<p>You can now login to your account using the credentials that you have input to our system</p>";
        $message .= "<p>Thank you for signing up CAVSUEÑOS!</p><p><a href='techknowcvsu.live'>Click here</a> to redirect to our website.</p><strong>FROM TECHKNOW TEAM</strong></p>";

        $headers = "From: TechKnow <info@techknowcvsu.live>\r\n";
        $headers .= "Reply-To: ".$tostring."\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($tostring, $subject, $message, $headers);
        echo "<script type='text/javascript'>window.top.location='../admin.php?success';</script>"; 
        exit;
    }
    
}
if(isset($_POST['declineapplication']))
{
    $dataid = $_POST['declineapplication'];
    $declinesql = "UPDATE users SET statusUsers = 'Declined' WHERE idUsers = '$dataid'";
    $conn->query($declinesql);
    $confirmsql = "SELECT * FROM users WHERE idUsers = '$dataid'";
    $to = $conn->query($confirmsql);
    while($row = $to->fetch_assoc())
    {
        $tostring = $row["emailUsers"];
        $from = "info@techknowcvsu.live";

        $subject = "Update to your TECHKNOW account application";
        $message = "<p>Greetings, ".$row['fnameUsers']."!</p>";
        $message .= "<p>We are sorry to inform you that your TECHKNOW account application has been declined.</p>";
        $message .= "<p>Only students and teachers of Cavite State University - Silang Campus are allowed to signup to our website</p>";
        $message .= "<p>Thank you for your kind consideration.</p><p><strong>FROM TECHKNOW TEAM</strong></p>";

        $headers = "From: TECHKNOW <info@techknowcvsu.live>\r\n";
        $headers .= "Reply-To: ".$tostring."\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($tostring, $subject, $message, $headers);
        echo "<script type='text/javascript'>window.top.location='../admin.php?success';</script>"; 
        exit;
    }
}

