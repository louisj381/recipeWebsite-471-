<?php
  ob_start();
  session_start();
  include($root . "../connection/dbConfig.php");  //to access db

  $uID = $_SESSION['user_id'];
  $sqlText = "SELECT `Name` FROM `Project_Database`.`CHANNEL` WHERE `User_Id` = $uID;";
  $res = $db->query($sqlText);
  $row = $res->fetch_assoc();
  $channelName = $row['Name'];
  $_SESSION['channel'] = $channelName;
  $sqlText = "SELECT * FROM `Project_Database`.`SUBSCRIPTIONS` WHERE `Channel` = '$channelName';";
  @$result = mysqli_query($db,$sqlText);
  @$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  @$subs = mysqli_num_rows($result);
  if ($subs < 1)
    $subs = 0;
 ?>
 <html>
   <head>
     <title> Cake. </title>
     <!--
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
       -->
     <link rel="stylesheet" href="../styles/body_styles.css">
   </head>

 <div class="center" style="width:80%;">
   <h1> <? echo $channelName; ?> </h1>
   <h3> <? echo "Subscribers: " . $subs; ?> </h3>
   <body>
     <iframe src="../tables/channel.php" style="width:100%;"></iframe>
     <form action="../creationForms/data/addMealPlan.php" method="post" id="mealPlan"></form>
     <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="refresh"></form>
     <form action="../views/curatorHomepage.php" method="post" id="back"></form>

     <button class="button" style="width:100%;" type="submit" name="Add" value="Add"form="mealPlan">Add</button>
     <button class="button" style="width:100%;" type="submit" name="Refresh" value="Refresh" form="refresh">Refresh</button>
     <button class="button" style="width:100%;" type="submit" name="back" value="Back to My Stuff" form="back">Back to My Stuff</button>
  </body>
 </div>
 </html>
