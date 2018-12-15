<?php
//TODO heavy testing to do with reloading the page
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $MealPlan_Id = $numMeals = "";

  $valid_input = !empty($_POST['mpName']) && $_GET['mpId'] <> NULL;

  if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $name = text_input($_POST["mpName"]);
    $MealPlan_Id = $_GET['mpId'];

    //count meals
    $sql = "SELECT * FROM `Project_Database`.`MEAL_PLAN_CONTAINS`
            WHERE `MealPlan_Id` = '$MealPlan_Id';";
    $row = $db->query($sql);
    $numMeals = mysqli_num_rows($row);

    if ($_POST['saveMP'] ) {
      if ( $valid_input ) { // save && $valid_input
        $_SESSION['submitted'] = true;
        //begin sql
        $sql = "UPDATE `Project_Database`.`MEAL_PLAN`
                SET `Name`          = '$name', `NumberOfMeals` = '$numMeals'
                WHERE `MealPlan_Id` = '$MealPlan_Id';";
        $success1 = $db->query($sql);
        if (!$success1){
          echo $sql;
          echo $db->error;
        }
        $creator = $uID = $_SESSION['user_id'];
        $sql = "INSERT INTO `Project_Database`.`USER_MEAL_PLANS`(`User_Id`, `MealPlan_Id`)
                      VALUES('$uID', '$MealPlan_Id');";
        $success2 = $db->query($sql);
        if (!$success2){
          echo $sql;
          echo $db->error;
        }

        if ($success1 === TRUE && $success2 === TRUE) {
          echo "<script type='text/javascript'>alert(\"Successful Submission.\");location.href = '../../views/mealPlans.php';</script>";
        } else {
          echo "<script type='text/javascript'>alert(\"Unsuccessful Submission, try again.\");</script>";
        }

        //get creator name
        $sql = "SELECT Screen_Name FROM `Project_Database`.`END_USER` WHERE `User_Id` = '$creator';";
        $res = $db->query($sql);
        $cRow = $res->fetch_assoc();
        $creator = $cRow['Screen_Name'];

      } else {  // !$valid_input
        $result = ($_GET['mpId'] == NULL)? "An unexpected error occured, Please reload the page":"Missing values!";
        echo "<script type='text/javascript'>alert('$result');</script>";

      }
    } else {  // back / cancel
      //delete the thing we just Added if it wasnt saved
      if ($_SESSION['submitted'] == false) {
        $sql = "DELETE FROM `Project_Database`.`MEAL_PLAN`
                WHERE `MealPlan_Id` = '$MealPlan_Id';";
        $db->query($sql);
      }
      header('location: ../../views/mealPlans.php');
      $_SESSION['submitted'] = false;
      //if that fails we get a bunch of random entries popping up in the db, which is ok with me for now
    }
  } else {  //first coming to page
    /**/
    $sql = "SELECT * FROM `Project_Database`.`MEAL_PLAN`;";
    $row = $db->query($sql);
    $MealPlan_Id = mysqli_num_rows($row) + 1; // <- cause we dont auto increment the id
    $uID = $_SESSION['user_id'];

    $sql = "INSERT INTO `Project_Database`.`MEAL_PLAN`(`MealPlan_Id`, `Name`, `NumberOfMeals`, `creator`)
                  VALUES('$MealPlan_Id','','0','$uID');";
    $success = $db->query($sql);
    if ($success) {
      $_GET['mpId'] = $MealPlan_Id;
    } else {
      $_GET['mpId'] = "";
    }
    $_SESSION['submitted'] = false;
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
  <link rel="stylesheet" href="../../styles/body_styles.css">
</head>
<div class="center" style="width:80%">
<h2><?echo ($_POST['mpName'] == NULL)? "Add Meal Plan:" : $_POST['mpName']?></h2>
<body>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?mpId=$MealPlan_Id";?> method="post" id="info">
    <tr><td>Meal Plan Name:</td><td><input type="text" name="mpName" style="width:100%" value="<?echo $_POST['mpName'];?>"></td></tr>
    <tr><td># Meals:</td><td><input type="text" style="width:100%" value="<?echo $numMeals;?>" readonly></td></tr>
    <tr><td>Creator:</td><td><input type="text" style="width:100%" value="<?echo $creator;?>" readonly></td></tr>
  </form>
  <form action="../../views/mealPlans.php" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="back" value="TRUE" form="info">Cancel</button></td>
    <td><button class="button" style="width:100%" type="submit" name="saveMP" value="TRUE" form="info">Save</button></td>
  </tr>
</body>
</div>
</html>
