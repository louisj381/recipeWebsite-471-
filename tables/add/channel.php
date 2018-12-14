<?php
ob_start();
session_start();

include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $channel = $_REQUEST['cId'];
  $uID = $_SESSION['user_id'];

  $sql = "SELECT * FROM `Project_Database`.`SUBSCRIPTIONS`
          WHERE `Channel` = '$channel' AND `User_Id` = '$uID';";
  $find = $db->query($sql);

  //TOGGLE
  $success = false;
  if (mysqli_num_rows($find) == 0) {
    $add = "INSERT INTO `Project_Database`.`SUBSCRIPTIONS` (`User_Id`, `Channel`)
            VALUES ( '$uID', '$channel');";
    $success = $db->query($add);
    // echo $add . "\n";
    echo "adding...";
  } else {
    //remove mealPlan
    $delete =  "DELETE FROM `Project_Database`.`SUBSCRIPTIONS`
                WHERE `Channel` = '$channel' AND `User_Id` = '$uID';";
    $success = $db->query($delete);
    echo "deleting...";
  }

  //can echo success here to return a result
  echo $db->error;
  echo ($success)? "Success!":"Failed.";

 ?>
