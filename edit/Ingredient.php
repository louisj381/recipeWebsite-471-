<?php
//so far just a copy of recipe
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values
  $User_Id = $ingrName = $iQuantity = $iUnit = "";
  $ingrName = $_GET['iName'];
  if ( !$_POST['saveEdits'] && $_SERVER["REQUEST_METHOD"] == "POST" ) {
  //!($_SERVER['HTTP_REFERER'] != $_SERVER['PHP_SELF']) ){
    echo 'updating referer' ;
    $back = $_SERVER['HTTP_REFERER'];
  }
  $User_Id = $_SESSION['user_id'];
  // $sqlIng = "SELECT * FROM `Project_Database`.`Ingredient` WHERE `Name` = '$ingrName';";
  // // $res = $db->query($sqlIng);
  // //
  // // //echo $ingredient;
  // // $uID = $_SESSION['uID'];
  // // //get out of here if no work
  // // if ($res->num_rows == 0) {
  // //   echo "<script type='text/javascript'>alert('oops!\n$db->error');</script>";
  // //   header("location: $back");
  // //   return;
  // // } else {
  // //   $ingredient = $res->fetch_assoc();
  // //   $iName = $ingredient['Name'];
  // //   $iCal = $ingredient['Cal/g'];
  // // }
  $sql = "SELECT * FROM `Project_Database`.`USER_INGREDIENTS` WHERE `User_Id` = '$User_Id' AND `Ingredient` = '$ingrName';";
  $qur = $db->query($sql);
  if ($qur->num_rows > 0) {
    $row = $qur->fetch_assoc();
    $iQuantity = $row['count'];
    $iUnit = $row['unit'];
  }
  $valid_input = (!empty($_POST['iQuantity']) && !empty($_POST['iUnit']));

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits'] && $valid_input) {
    $ingrName= $_POST['iName'];
    $iQuantity= $_POST['iQuantity'];
    $iUnit= text_input($_POST['iUnit']);

    $sql = "UPDATE `Project_Database`.`USER_INGREDIENTS`
            SET `count` = '$iQuantity',
                `unit` = '$iUnit'
            WHERE `Ingredient` = '$ingrName' AND
            `User_Id` = '$User_Id'
          ;";
          echo $sql;
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
  <link rel="stylesheet" href="http://localhost/styles/body_styles.css">
  <link rel="stylesheet" href="../styles/body_styles.css">
  <link rel="stylesheet" href="../../styles/body_styles.css">
  <link rel="stylesheet" href="../../../styles/body_styles.css">

</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;"><? echo ucwords($rName)?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
  </table>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?rId=$Recipe_Id";?> method="post" id="info">
    <tr><td>Ingredient:</td><td style="text-align:right;"><?=$ingrName?></td></tr>
    <tr><td>Quantity:</td><td><input type="number"  name="iQuantity" style="width:100%" value="<?echo $iQuantity?>"></td></tr>
    <tr><td>Unit:</td><td><input type="text"  name="iUnit" style="width:100%" value="<?echo $iUnit?>"></td></tr>
    <!-- <tr><td>Rating:</td><td><input type="text"      name="rRate" style="width:100%" value="<?echo $rRate?>"></td></tr> -->
    <tr style="height:40%">
      <!-- <td>Instructions:</td><td><input type="text" name="rInstr" style="width:100%;height:100%" value="<?echo $rInstr?>"></td></tr> -->
  </form>
  <form action="../tables/ingredients.php" method="post" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="saveEdits" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>
</body>
</html>
