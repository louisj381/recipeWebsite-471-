<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $Meal_Id = $_REQUEST['mId'];
  $Recipe_Id = $_REQUEST['rId'];

  //TODO update meal contains

  $sql = "SELECT * FROM `Project_Database`.`RECIPE_CONTAINS`
          WHERE `Ingredient` = '$ingrName' AND `Recipe_Id` = '$Recipe_Id';";
  $find = $db->query($sql);
  //$find->fetch_assoc();
  //TOGGLE
  //print_r($find);
  $success = false;
  if (mysqli_num_rows($find) == 0) {
    $add = "INSERT INTO `Project_Database`.`RECIPE_CONTAINS` (`Recipe_Id`, `Ingredient`, `Quantity`, `Unit`)
            VALUES ( '$Recipe_Id' , '$ingrName' , 1, 'cup');";
    $success = $db->query($add);
  } else {
    //remove ingredient
    $delete = "DELETE FROM `Project_Database`.`RECIPE_CONTAINS`
                WHERE `Ingredient` = '$ingrName' AND `Recipe_Id` = '$Recipe_Id';";
    $success = $db->query($delete);
  }
  //can echo success here to return a result
  echo $db->error;
  //echo $success;

 ?>
