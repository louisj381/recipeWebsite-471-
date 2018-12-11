<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $Meal_Id = $_REQUEST['mId'];
  $MealPlan_Id = $_REQUEST['mpId'];
  $User_Id = $_SESSION['user_id'];

  //TODO update meal contains

  $sql = "SELECT * FROM `Project_Database`.`MEAL_PLAN_CONTAINS`
          WHERE `Meal_Id` = '$Meal_Id' AND `MealPlan_Id` = '$MealPlan_Id';";
  $find = $db->query($sql);

  //$find->fetch_assoc();
  //TOGGLE
  $success = false;
  if (mysqli_num_rows($find) == 0) {
    $add = "INSERT INTO `Project_Database`.`MEAL_PLAN_CONTAINS`
                    (`MealPlan_Id`, `Meal_Id`, `Date_Time`, `User_Id`, `Dependent_Name`)
            VALUES ('$MealPlan_Id', '$Meal_Id',  NULL   ,   NULL  , NULL);";
    $success = $db->query($add);  //edit button will be on the table view to change those nulls
  } else {
    //remove meal
    $delete = "DELETE FROM `Project_Database`.`MEAL_PLAN_CONTAINS`
                WHERE `Meal_Id` = '$Meal_Id' AND `MealPlan_Id` = '$MealPlan_Id';";
    $success = $db->query($delete);
  }
  //can echo success here to return a result
  echo $db->error;
  //echo $success;

 ?>
