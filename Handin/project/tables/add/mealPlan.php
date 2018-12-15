<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $MealPlan_Id = $_REQUEST['mpId'];
  $uID = $_SESSION['user_id'];
  $channel = $_GET['cId'];

  $sql = ($channel==NULL)?
         "SELECT * FROM `Project_Database`.`USER_MEAL_PLANS`
          WHERE `MealPlan_Id` = '$MealPlan_Id' AND `User_Id` = '$uID';" :
         "SELECT * FROM `Project_Database`.`CHANNEL_CONTAINS`
          WHERE `MealPlanID` = '$MealPlan_Id' AND `ChannelName` = '$channel';";
  $find = $db->query($sql);
  //TOGGLE
  $success = false;
  if (mysqli_num_rows($find) == 0) {
    $add = ($channel==NULL)?
           "INSERT INTO `Project_Database`.`USER_MEAL_PLANS` (`User_Id`, `MealPlan_Id`)
            VALUES ( '$uID', '$MealPlan_Id');" :
           "INSERT INTO `Project_Database`.`CHANNEL_CONTAINS` (`MealPlanID`, `ChannelName`)
            VALUES ( '$MealPlan_Id', '$channel' );";
    $success = $db->query($add);
    echo "adding...";
  } else { //remove mealPlan
    $delete = ($channel==NULL)?
             "DELETE FROM `Project_Database`.`USER_MEAL_PLANS`
              WHERE `MealPlan_Id` = '$MealPlan_Id' AND `User_Id` = '$uID';" :
             "DELETE FROM `Project_Database`.`CHANNEL_CONTAINS`
              WHERE `MealPlanID` = '$MealPlan_Id' AND `ChannelName` = '$channel';";
    $success = $db->query($delete);
    echo "deleting...";
  }

  //can echo success here to return a result
  echo $db->error;
  echo ($success)? "Success!":"Failed.";

 ?>
