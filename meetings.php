<?php
    date_default_timezone_set('Asia/Manila');
    include 'includes/dbh.inc.php';
    include 'includes/posts.inc.php';
    include 'includes/groups.inc.php';
    include 'includes/upload.inc.php';
    require "header.php";
?>
<main>
<title>Meetings | TechKnow</title>

<div class="meetingsdiv container-fluid row-md-12">
    <div class="row">
        <div class="embed-responsive embed-responsive-16by9 col-md-8" id="video-container">
            <video class="embed-responsive-item" id="video-preview" loop allowfullscreen=""></video>
        </div>
        <div class="col-md-4 live-c">
            <h4>Live Chat</h4>
            <div class="row-md-12 livechat">
                <div class="col-md-12">
                    <div class="row">
                    <input class="form-control" type="text" id="input-text-chat" placeholder="Say something...">
                    </div>
                    <div class="row" id="chat-container">
                        <div class="chat-output"></div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>

    <div class="page-footer row">
        <div class="live-control col-md-6">
            <div class="row-md-12">
                    <input type="text" class="form-control" id="room-id" placeholder="Meeting code" autocorrect=off autocapitalize=off size=20>
<?php
$id = $_SESSION['userId'];
$acctsql = "SELECT * FROM users WHERE idUsers = '$id'";
$acctres = $conn->query($acctsql);
while($acctrow = $acctres->fetch_assoc())
{
    if($acctrow['accounttypeUsers'] == 'Teacher')
    {
        echo '<button id="open-room"><strong style="padding: 5px;"><i class="fas fa-arrow-right" style="padding: 5px;"></i></strong></button>';
        echo '<button id="join-room" style="display: none;"><strong style="padding: 5px;"><i class="fas fa-arrow-right" style="padding: 5px;"></i></strong></button>';
        echo '<button id="open-camera"><strong style="padding: 5px;"><i class="fas fa-video"></i></strong></button>';
        echo '<button id="open-share-screen"><strong style="padding: 5px;"><i class="fas fa-desktop"></i></strong></button>';
    }
    elseif($acctrow['accounttypeUsers'] == 'Student')
    {
        echo '<button id="open-room" style="display: none;"><strong style="padding: 5px;"><i class="fas fa-arrow-right" style="padding: 5px;"></i></strong></button>';
        echo '<button id="join-room"><strong style="padding: 5px;"><i class="fas fa-arrow-right" style="padding: 5px;"></i></strong></button>';
        echo '<button id="open-camera" style="display: none;"><strong style="padding: 5px;"><i class="fas fa-video"></i></strong></button>';
        echo '<button id="open-share-screen" style="display: none;"><strong style="padding: 5px;"><i class="fas fa-desktop"></i></strong></button>';
    }
}
?>
                    
                    
                    
                    
                    
            </div>
            
        </div>
        <div class="viewers-panel col-md-6" id="room-urls">
            <div class="row-md-12 text-center" style="margin-top: 10px;">

                <h4 id="broadcastcounter">Viewers</h4>
                <div id="viewers">
                    
                </div>
            </div>
            
        </div>
    </div>
    
</div>

</main>

<script src="https://www.webrtc-experiment.com/common.js"></script>
<script src="dist/RTCMultiConnection.min.js"></script>
<script src="node_modules/webrtc-adapter/out/adapter.js"></script>
<script src="node_modules/socket.io/client-dist/socket.io.js"></script>

<script src="node_modules/fbr/FileBufferReader.js"></script>
<script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>
<script src="js/techknow-meeting.js"></script>

<script>
///TEXTCHAT

document.getElementById('input-text-chat').onkeyup = function(e) {
            if (e.keyCode != 13) return;

                // removing trailing/leading whitespace
            this.value = "<?php
            $id = $_SESSION['userId'];
            $sql = "SELECT * FROM users WHERE idUsers = $id";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc())
            {
                echo "<img src='uploads/profile".$row['idUsers'].".jpg' style='height:15px; width:15px; margin-right:5px; border-radius: 180px;'>"."<strong style='color:white; margin-right:10px;'>".$row['fnameUsers']." ".$row['lnameUsers'].":</strong>";
            }
          ?>" + this.value.replace(/^\s+|\s+$/g, '');
                if (!this.value.length) return;

                connection.send(this.value);
                appendDIV(this.value);
                this.value = '';
            };

            var chatContainer = document.querySelector('.chat-output');

            function appendDIV(event) {
                var div = document.createElement('div');
                div.className = 'chatmsg';
                div.innerHTML = event.data || event;
                chatContainer.insertBefore(div, chatContainer.firstChild);
                div.tabIndex = 0;
                div.focus();

                document.getElementById('input-text-chat').focus();
            }
            connection.onmessage = appendDIV;
</script>
