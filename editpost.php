<?php
  date_default_timezone_set('Asia/Manila');
  include 'includes/dbh.inc.php';
  include 'includes/posts.inc.php';
  require "header.php";
 ?>
<head>
  <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
 <main>

     <div class="home-container">
       <?php
       if (isset($_SESSION['userId']))
       {
         echo "<form class='post-something' method='POST' action='".setPost($conn)."'>
          <input type='text' name='subject' placeholder='Subject'>
          <textarea name='message' rows='8' placeholder='Discuss something...'></textarea>
          <input type='hidden' name='ugrp' value='Web Development'>
          <input type='hidden' name='uid' value='".$_SESSION['userId']."'>
          <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
          <button type='submit' name='image'><i class='fas fa-image'></i></button>
          <button type='submit' name='attach'><i class='fas fa-paperclip'></i></button>
          <button type='submit' name='postsubmit'>Post</button>
        </form>";
          echo "<form action='".getPost($conn)."' method='POST'>
          </form>";
       }
       ?>
     <!--fade background
        get the certain post to be edited
        center things
        -->
     </div>
     <script src="js/techknow-script.js"></script>
 </main>
