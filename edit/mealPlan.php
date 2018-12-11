<?php
//TODO JUST A COPY OF RECIPE
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values
  $MealPlan_Id = $Meal_type = "";
  $MealPlan_Id = $_GET['mpId'];
  $uID = $_SESSION['user_id'];

  $sql = "SELECT * FROM `Project_Database`.`MEAL_PLAN` WHERE `MealPlan_Id` = '$MealPlan_Id';";
  $res = $db->query($sql);
  $mpRow = $res->fetch_assoc();

  //get out of here if no work
  if (mysqli_num_rows($res) == 0) {
    echo "<script type='text/javascript'>alert('oops!\n$db->error');</script>";
    header("location: $back");  //this sends a redirect to the user instead of this page
  } else {
    $mpName = $mpRow['Name'];
    $nMeals = $mpRow['NumberOfMeals'];
    $creator = $mpRow['Creator'];
  }
  //count meals
  $sql = "SELECT COUNT(*) FROM `Project_Database`.`MEAL_PLAN_CONTAINS` WHERE `MealPlan_Id` = '$MealPlan_Id';";
  $res = $db->query($sql);
  $nMeals = mysqli_num_rows($res);

  //get creator name
  $sql = "SELECT Screen_Name FROM `Project_Database`.`END_USER` WHERE `User_Id` = '$creator';";
  $res = $db->query($sql);
  $cRow = $res->fetch_assoc();
  $creator = $cRow['Screen_Name'];

  $valid_input = ( !empty($_POST['mpName']) );

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_input && $_POST['saveEdits']) {
    $mpName = text_input($_POST['mpName']);
    $sql = "UPDATE `Project_Database`.`MEAL_PLAN`
            SET `Name` = '$mpName',
                `NumberOfMeals` = '$nMeals'
            WHERE `MealPlan_Id` = '$MealPlan_Id' ;";
    $success = $db->query($sql);

    if ($success === TRUE) {
      $result = "Successful Saving Changes";
    } else {
      $result = "Unsuccessful Saving Changes";
    }

  }//end post
  else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits']) {
    $result = "Missing values!";
    echo "<script type='text/javascript'>alert('$result');</script>";
  } else {
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
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <!-- one of these will work -->
  <link rel="stylesheet" href="../styles/body_styles.css">

</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;"><? echo ucwords($rName)?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
  </table>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?mpId=$MealPlan_Id";?> method="post" id="info">
    <tr><td>MealPlan Name:</td><td><input type="text" name="mpName" style="width:100%" value="<?echo $mpName?>"></td></tr>
    <tr><td># Meals:</td><td><input type="text" name="nMeals" style="width:100%" value="<?echo $nMeals?>"></td></tr>
    <tr><td>Creator:</td><td><input type="text" name="creator" style="width:100%" value="<?echo $creator?>"></td></tr>
  </form>
  <form action="../tables/meals.php" method="post" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="saveEdits" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>
  <iframe src="../tables/recipes.php?mId=<?echo $Meal_Id?>" style="width:100%;height:40%;" allowTransparency="true"></iframe>
</body>
</html>
