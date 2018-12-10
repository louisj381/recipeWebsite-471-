<?php
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values
  $Recipe_Id = $rName = $rPrep = $rCook = $rRate = $rInstr = $rIngred = "";
  $Recipe_Id = $_GET['rId'];
  if ( !$_POST['saveEdits'] && $_SERVER["REQUEST_METHOD"] == "POST" ) {
  //!($_SERVER['HTTP_REFERER'] != $_SERVER['PHP_SELF']) ){
    echo 'updating referer' ;
    $back = $_SERVER['HTTP_REFERER'];
  }

  $sql = "SELECT * FROM `Project_Database`.`RECIPE` WHERE `Recipe_Id` = '$Recipe_Id';";
  $res = $db->query($sql);
  $recipe = $res->fetch_assoc();
  //echo $recipe;
  $uID = $_SESSION['user_id'];
  //get out of here if no work
  if (mysqli_num_rows($res) == 0) {
    echo "<script type='text/javascript'>alert('oops!\n$db->error');</script>";
    // if (empty($_GET)) {
    //   header("location: ../views/recipes.php");
    // } else {
    //   header("location: ../../views/recipes.php");
    // }
    header("location: $back");
    //return;
  } else {
    $rName = $recipe['Name'];
    $rPrep = $recipe['PrepTime'];
    $rCook = $recipe['CookTime'];
    $rRate = $recipe['Rating'];
    $rInstr = $recipe['Instructions'];
  }

  //TODO: implement selectable-ingredient table within iframe, to select and edit <- I did that

  // $sql = "SELECT * FROM `Project_Database`.`RECIPE_CONTAINS` WHERE RECIPE_ID = '$Recipe_Id';";
  // $qur = $db->query($sql);
  // if ( $qur->num_rows > 0 ) {
  //   if ($row = $qur->fetch_assoc()) //add the first one
  //     $ingredients = $ingredients . $row['Ingredient'];
  //   while ( $row = $qur->fetch_assoc() ) {
  //     $ingredients = $ingredients . ", " . $row['Ingredient'];
  //   }
  // }

  $valid_input = ( !empty($_POST['rName']) && !empty($_POST['rPrep']) && !empty($_POST['rCook']) && !empty($_POST['rInstr']) );

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_input && $_POST['saveEdits']) {
    $rName = text_input($_POST['rName']);
    $rPrep = $_POST['rPrep'];
    $rCook = $_POST['rCook'];
    if (empty($_POST['rRate'])){
      $rRate = "NULL";
    } else {
      $rRate = $_POST['rRate'];
    }
    $rInstr = $_POST['rInstr'];
    $sql = "UPDATE `Project_Database`.`RECIPE`
            SET `Name` = '$rName',
                `PrepTime` = '$rPrep',
                `CookTime` = '$rCook',
                `Rating` = '$rRate',
                `Instructions` = '$rInstr',
                `creator` = '$uID'
            WHERE `Recipe_Id` = '$Recipe_Id'
          ";
    $success = $db->query($sql);
    if ($success === TRUE) {
      $result = "Successful Saving Changes";
    } else {
      $result = "Unsuccessful Saving Changes";
    }
    //echo $result;

  }//end post
  else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits']) {
    $result = "Missing values!";
    echo "<script type='text/javascript'>alert('$result');</script>";
  } else {
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
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <!-- one of these will work -->
  <link rel="stylesheet" href="../styles/body_styles.css">

</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;"><? echo ucwords($rName)?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
  </table>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?rId=$Recipe_Id";?> method="post" id="info">
    <tr><td>Recipe Name:</td><td><input type="text" name="rName" style="width:100%" value="<?echo $rName?>"></td></tr>
    <tr><td>PrepTime:</td><td><input type="number"  name="rPrep" style="width:100%" value="<?echo $rPrep?>"></td></tr>
    <tr><td>CookTime:</td><td><input type="number"  name="rCook" style="width:100%" value="<?echo $rCook?>"></td></tr>
    <tr><td>Rating:</td><td><input type="text"      name="rRate" style="width:100%" value="<?echo $rRate?>"></td></tr>
    <tr><td colspan="100%"></td></tr>
    <tr style="height:40%">
      <td>Instructions:</td><td><input type="text" name="rInstr" style="width:100%;height:100%" value="<?echo $rInstr?>"></td></tr>
  </form>

  <form action="../tables/recipes.php" method="post" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="saveEdits" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>
  <iframe src="../tables/ingredients.php?rId=<?echo $Recipe_Id?>" style="width:100%;height:40%;" allowTransparency="true"></iframe>
</body>
</html>
