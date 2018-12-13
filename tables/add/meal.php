<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $Meal_Id = $_REQUEST['mId'];
  $uID = $_SESSION['user_id'];

  $sql = "SELECT * FROM `Project_Database`.`USER_MEALS`
          WHERE `Meal_Id` = '$Meal_Id' AND `User_Id` = '$uID';";
  $find = $db->query($sql);

  //TOGGLE
  $success = false;

  if (mysqli_num_rows($find) == 0) {
    $add = "INSERT INTO `Project_Database`.`USER_MEALS` (`User_Id`, `Meal_Id`)
            VALUES ( '$uID', '$Meal_Id');";
    $success = $db->query($add);
    echo "adding...";
  } else {
    //remove Meal
    $delete =  "DELETE FROM `Project_Database`.`USER_MEALS`
                WHERE `Meal_Id` = '$Meal_Id' AND `User_Id` = '$uID';";
    $success = $db->query($delete);
    echo "deleting...";
  }
  //can echo success here to return a result
  echo $db->error;
  echo ($success)? "Success!":"Failed.";

 ?>
