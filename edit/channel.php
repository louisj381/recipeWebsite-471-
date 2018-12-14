<?php
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values
  $channelName = $_GET['cId'];
  $uID = $_SESSION['user_id'];

  $sqlmealPlan = "SELECT * FROM `Project_Database`.`MEAL_PLAN`
                  WHERE `MealPlan_Id` IN (SELECT `MealPlanID`
                                        FROM `Project_Database`.`CHANNEL_CONTAINS` as `ch`
                                        WHERE `ch`.`ChannelName` = '$channelName')";
  $_SESSION['sqlMealPlan'] = $sqlmealPlan;


  $sql = "SELECT * FROM `Project_Database`.`CHANNEL` WHERE `Name` = '$channelName';";
  $res = $db->query($sql);
  $chRow = $res->fetch_assoc();
  $creator = $chRow['User_Id'];

  //get creator name
  $sql = "SELECT `Screen_Name` FROM `Project_Database`.`END_USER` WHERE `User_Id` = '$creator';";
  $res = $db->query($sql);
  $cRow = $res->fetch_assoc();
  $creator = $cRow['Screen_Name'];

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['delete']) {
    $sql = "DELETE FROM `Project_Database`.`SUBSCRIPTIONS`
            WHERE `User_Id` = '$uID' AND `Channel` = '$channelName';";
    $success = $db->query($sql);

    if ($success === TRUE) {
      $result = "Successful Saving Changes";
      header('location: ../tables/channels.php?mine=true');
    } else {
      $result = "Unsuccessful Saving Changes";
    }
  }
  function text_input($data) {
    $data = mb_strtolower($data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
 ?>

<html>
<head>
  <title> Cake. </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td colspan="2"><h1 style="font-size:30pt;margin-bottom:0px;"><?= ucwords($channelName)?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
    <tr><td style="width:34px;"><img src="../resources/user.png" alt="creator:" style="width:32px;height:32px;border:0"></td>
      <td colspan="2"><h1 style="font-size:16pt;margin-bottom:0px;"><?= ucwords($creator)?></h1></td></tr>
  </table>
  <iframe src="../tables/mealPlans.php?b=true" style="width:100%;height:40%;" allowTransparency="true"></iframe>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?cId=$channelName";?> method="post" id="info"></form>
  <form action="../tables/channels.php?mine=true" method="post" id="back"></form>
  <tr>
    <td colspan="100%"><button class="button" style="width:100%" type="submit" name="delete" value="TRUE" form="info">Unsubscribe</button></td>
  </tr><tr>
    <td colspan="100%"><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>

</body>
</html>
