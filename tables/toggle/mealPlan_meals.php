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
  $adding = mysqli_num_rows($find) == 0;
  if ($adding) {
    $add = "INSERT INTO `Project_Database`.`MEAL_PLAN_CONTAINS`
                    (`MealPlan_Id`, `Meal_Id`, `Date_Time`, `User_Id`, `Dependent_Name`)
            VALUES ('$MealPlan_Id', '$Meal_Id',  NULL   ,   NULL  , NULL);";
    $success = $db->query($add);  //edit button will be on the table view to change those nulls
    echo "adding...";
  } else {
    //remove meal
    $delete = "DELETE FROM `Project_Database`.`MEAL_PLAN_CONTAINS`
                WHERE `Meal_Id` = '$Meal_Id' AND `MealPlan_Id` = '$MealPlan_Id';";
    $success = $db->query($delete);
    echo "Deleting... ";
  }
  if ($success) {
    $sql = "SELECT * FROM `Project_Database`.`MEAL_PLAN_CONTAINS`
            WHERE `MealPlan_Id` = '$MealPlan_Id';";
    $numMeals = mysqli_num_rows($db->query($sql));

    $update =  "UPDATE `Project_Database`.`MEAL_PLAN`
                SET `NumberOfMeals` = '$numMeals'
                WHERE `MealPlan_Id` = '$MealPlan_Id';";
    $successUpdate = $db->query($update);
  }
  
  //can echo success here to return a result
  echo $db->error;
  echo (($successUpdate)? "":"Partial ") . (($success)? "Success!":"Failed.");

 ?>
