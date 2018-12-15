<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $dName = $_REQUEST['d'];
  $allergy = $_REQUEST['a'];
  $uID = $_SESSION['user_id'];


  $delete =  "DELETE FROM `Project_Database`.`ALLERGY`
              WHERE `Allergy` = '$allergy' AND `User_Id` = '$uID' AND `Dep_name`='$dName';";
  $success = $db->query($delete);
  if ($success) {
    $sql = "SELECT * FROM `Project_Database`.`ALLERGY` WHERE (`User_Id` = '$uID' AND `Dep_name` = '$dName');";
    $countres = mysqli_query($db,$sql);
    $count = mysqli_num_rows($countres);
    //adjust table by altering count
    $sql = "UPDATE `Project_Database`.`DEPENDANTS` SET `No-of_allergies` = '$count' WHERE (`User_Id` = '$uID' AND `Name` = '$dName');";
    $success1 = $db->query($sql);
  }
  //can echo success here to return a result
  echo $db->error;
  echo ($success)?"":"Partially". ($success1)? "Success!":"Failed.";
 ?>
