<?php
  require "header.php";
 ?>

  <main>
  <link rel="stylesheet" href="css/styles.css">
  <section class="blackboard">
      <div class="yourblackboard">
        <h2 id="disch2"><i class="fas fa-chalkboard-teacher chalkboard-teacher"></i>Your Blackboard</h2>
      </div>
      <div class="blackboard-disc">
        <span><img src="images/techknow-unknown.png"></span>
        <span><textarea id="txt" name="name" rows="1" placeholder="Add your discussion..."></textarea></span>

      </div>
      <ul class="disc">
        <li id="discid"><img src="images/techknow-unknown.png">
          <div id="username"><strong>s:anonymous</strong></div>
          <div id="subject">Hello World!</div>
          <div id="classname">Web Dev</div>
          <div id="msg">hi!</div>
          <div id="img"></div>
          <div id="disc-react">
            <button id="heart" type="button" name="button" onclick="toggleLike()"><i class="fas fa-heart heart"></i><span>Like</span></button>
            <textarea id="reply" name="name" rows="1" placeholder="Add your comment..."></textarea>
            <button id="replybtn" type="button" name="button"><i class="fas fa-reply reply"></i><span>Reply</span></button>
          </div>
        </li>
      </ul>
    </section>
  </main>
