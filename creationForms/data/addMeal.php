<?php
//TODO this whole thing
ob_start();
session_start();
  // define variables and set to empty values
  include("../../connection/dbConfig.php");
    // define variables and set to empty values
    $Meal_Id = $numRecipes = "";

    $valid_input = !empty($_POST['mName']) && $_GET['mId'] <> NULL;

    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
      $name = text_input($_POST["mName"]);
      $Meal_Id = $_GET['mId'];

      //count meals
      $sql = "SELECT * FROM `Project_Database`.`MEAL_CONTAINS`
              WHERE `Meal_Id` = '$Meal_Id';";
      $row = $db->query($sql);
      $numRecipes = mysqli_num_rows($row);

      if ($_POST['saveM'] ) {
        if ( $valid_input ) { // save && $valid_input
          $_SESSION['submitted'] = true;
          //begin sql
          $sql = "UPDATE `Project_Database`.`MEAL`
                  SET `Meal_type` = '$name'
                  WHERE `Meal_Id` = '$Meal_Id';";
          $success1 = $db->query($sql);
          if (!$success1){
            echo $sql;
            echo $db->error;
          }
          $creator = $uID = $_SESSION['user_id'];
          $sql = "INSERT INTO `Project_Database`.`USER_MEALS`(`User_Id`, `Meal_Id`)
                        VALUES('$uID', '$Meal_Id');";
          $success2 = $db->query($sql);
          if (!$success2){
            echo $sql;
            echo $db->error;
          }

          if ($success1 === TRUE && $success2 === TRUE) {
            echo "<script type='text/javascript'>alert(\"Successful Submission.\");location.href = '../../views/meals.php';</script>";
          } else {
            echo "<script type='text/javascript'>alert(\"Unsuccessful Submission, try again.\");</script>";
          }

          //get creator name
          $sql = "SELECT Screen_Name FROM `Project_Database`.`END_USER` WHERE `User_Id` = '$creator';";
          $res = $db->query($sql);
          $cRow = $res->fetch_assoc();
          $creator = $cRow['Screen_Name'];

        } else {  // !$valid_input
          $result = ($_GET['mId'] == NULL)? "An unexpected error occured, Please reload the page":"Missing values!";
          echo "<script type='text/javascript'>alert('$result');</script>";

        }
      } else {  // back / cancel
        //delete the thing we just Added if it wasnt saved
        if ($_SESSION['submitted'] == false) {
          $sql = "DELETE FROM `Project_Database`.`MEAL`
                  WHERE `Meal_Id` = '$Meal_Id';";
          $db->query($sql);
        }
        header('location: ../../views/meals.php');
        $_SESSION['submitted'] = false;
        //if that fails we get a bunch of random entries popping up in the db, which is ok with me for now
      }
    } else {  //first coming to page
      /**/
      $sql = "SELECT * FROM `Project_Database`.`MEAL`;";
      $row = $db->query($sql);
      $Meal_Id = mysqli_num_rows($row) + 1; // <- cause we dont auto increment the id
      $uID = $_SESSION['user_id'];

      $sql = "INSERT INTO `Project_Database`.`MEAL`(`Meal_Id`, `Meal_type`)
                    VALUES('$Meal_Id','');";
      $success = $db->query($sql);
      if ($success) {
        $_GET['mId'] = $Meal_Id;
      } else {
        $_GET['mId'] = "";
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
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
    <link rel="stylesheet" href="../../styles/body_styles.css">
  </head>
  <div class="center" style="width:80%">
  <h2><?echo ($_POST['mName'] == NULL)? "Add Meal:" : $_POST['mName']?></h2>
  <body>
    <table style="width:100%">
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?mId=$Meal_Id";?> method="post" id="info">
      <tr><td>Meal Name:</td><td><input type="text" name="mName" style="width:100%" value="<?echo $_POST['mName'];?>"></td></tr>
      <tr><td># Recipes:</td><td><input type="text" style="width:100%" value="<?echo $numRecipes;?>" readonly></td></tr>
    </form>
    <form action="../../views/meals.php" id="back"></form>
    <tr>
      <td><button class="button" style="width:100%" type="submit" name="back" value="TRUE" form="info">Cancel</button></td>
      <td><button class="button" style="width:100%" type="submit" name="saveM" value="TRUE" form="info">Save</button></td>
    </tr>
  </body>
  </div>
</html>
