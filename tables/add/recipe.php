<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $Recipe_Id = $_REQUEST['rId'];
    $uID = $_SESSION['user_id'];

  $sql = "SELECT * FROM `Project_Database`.`USER_RECIPES`
          WHERE `Recipe_Id` = '$Recipe_Id' AND `User_Id` = '$uID';";
  $find = $db->query($sql);

  //TOGGLE
  $success = false;
  if (mysqli_num_rows($find) == 0) {
    $add = "INSERT INTO `Project_Database`.`USER_RECIPES` (`User_Id`, `Recipe_Id`)
            VALUES ( '$uID', '$Recipe_Id');";
    $success = $db->query($add);
    echo "adding...";
  } else {
    //remove recipe
    $delete =  "DELETE FROM `Project_Database`.`USER_RECIPES`
                WHERE `Recipe_Id` = '$Recipe_Id' AND `User_Id` = '$uID';";
    $success = $db->query($delete);
    echo "deleting...";
  }

  //can echo success here to return a result
  echo $db->error;
  echo ($success)? "Success!":"Failed.";
 ?>
