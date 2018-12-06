<?php
  ob_start();
  session_start();
  define(root, "../");
 ?>
<html>
<head>
  <title> Cake. </title>
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>
  <body>
    <div class="column4"><p>&nbsp;</p></div>
    <div class="column">
      <p>&nbsp;</p>
      <button class="button" style="width:100%;" onClick="location.href = '../views/browse.php'">Browse</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/cookbook.php'">Cookbook</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/pantry.php'">Pantry</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/guestbook.php'">Guestbook</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/account.php'">Account</button>
      <button class="button" style="width:100%;" onClick="location.href = '../index.php'">Logout</button>
    </div>
    <div class="column4"><p>&nbsp;</p></div>
  </body>
</html>
