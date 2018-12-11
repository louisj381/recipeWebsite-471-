<?php
  ob_start();
  session_start();
  define(root, "../");
  include("../connection/dbConfig.php");

//check if there is a channel that EXISTS
$User_Id = $_SESSION['user_id'];
$sql = "SELECT * FROM `Project_Database`.`CHANNEL` WHERE `User_Id` = '$User_Id';";
echo $sql;
//@$res = $db->query($sql);
$res = mysqli_query($db, $sql);
@$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
@$count = mysqli_num_rows($res);
if ($count != 1) {
  $_SESSION['hasChannel'] = TRUE;
}
else {
  $_SESSION['hasChannel'] = FALSE;
}
echo $_SESSION['hasChannel'];
 ?>
<html>
<head>
  <title> Cake. </title>
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
  <link rel="stylesheet" href="../styles/body_styles.css">
  <link rel="stylesheet" href="../styles/channelPopup.css">
</head>
  <body>
    <div class="column4"><p>&nbsp;</p></div>
    <div class="column">
      <p>&nbsp;</p>
      <button class="button" style="width:100%;" onClick="location.href = '../views/browse.php'">Browse</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/MyChannel.php'">My Channel</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/cookbook.php'">Cookbook</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/account.php'">Account</button>
      <button class="button" style="width:100%;" onClick="location.href = '../login.php'">Logout</button>
    </div>
    <div class="column4"><p>&nbsp;</p></div>

  </body>
</html>
