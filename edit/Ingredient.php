<?php
//yeesh this was a really yike merge conflict, so we should test the heck out of it just in case i broke it
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values   V-------------------unused i think--------------------V
  $User_Id = $ingrName = $iQuantity = $iUnit = $Recipe_Id = $rName = $rPrep = $rCook = $rRate = $rInstr = "";
 //TODO check this
//for the merge im gonna say either of these are possible casue i dont wanna go thru and fix every link
 if ( ($ingrName = $_GET['iName']) == NULL ) {// if Louis' method isnt being used
    $ingrName = $_GET['i'];                   // try Keenan's
 }
  if ( !$_POST['saveEdits'] && !$_POST['delete'] && $_SERVER["REQUEST_METHOD"] == "POST" ) {
  //!($_SERVER['HTTP_REFERER'] != $_SERVER['PHP_SELF']) ){
    echo 'updating referer' ;
    $back = $_SERVER['HTTP_REFERER'];
  }
// <<<<<<< Louis  // i just commented out louis' side until i can see what he did + it would really mess with brackets
//   $User_Id = $_SESSION['user_id'];
//   $sql = "SELECT * FROM `Project_Database`.`USER_INGREDIENTS` WHERE `User_Id` = '$User_Id' AND `Ingredient` = '$ingrName';";
//   $qur = $db->query($sql);
//   if ($qur->num_rows > 0) {
//     $row = $qur->fetch_assoc();
//     $iQuantity = $row['count'];
//     $iUnit = $row['unit'];
//   }
//   $valid_input = (!empty($_POST['iQuantity']) && !empty($_POST['iUnit']));

//   if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits'] && $valid_input) {
//     $ingrName= $_POST['iName'];
//     $iQuantity= $_POST['iQuantity'];
//     $iUnit= text_input($_POST['iUnit']);

//     $sql = "UPDATE `Project_Database`.`USER_INGREDIENTS`
//             SET `count` = '$iQuantity',
//                 `unit` = '$iUnit'
//             WHERE `Ingredient` = '$ingrName' AND
//             `User_Id` = '$User_Id'
//           ;";
//           echo $sql;
//     $success = $db->query($sql);
//     if ($success === TRUE) {
//       $result = "Successful Saving Changes";
// =======

  $sqlIng = "SELECT * FROM `Project_Database`.`INGREDIENT` WHERE `Name` = '$ingrName';";
  $res = $db->query($sqlIng);
  // echo $db->error;
  //get out of here if no work
  if (mysqli_num_rows($res) == 0) {
    echo "<script type='text/javascript'>alert('oops!\n$db->error');</script>";
    header("location: $back");
    //return;
  } else {
    $ingredient = $res->fetch_assoc();
    $iCal = $ingredient['Cal/g'];
  }
//if checking for ingredient in a particular recipe
$uID = $_SESSION['user_id'];
$rId = $_GET['rId'];
//print_r($_GET);

  if ( $rId <> NULL ) {
    //echo 'Recipe Ingredient';
    $sql = "SELECT * FROM `Project_Database`.`RECIPE_CONTAINS` WHERE `Ingredient` = '$ingrName' AND `Recipe_Id` = '$rId';";
    $res = $db->query($sql);
    $rel = $res->fetch_assoc();

    $amount = $rel['Quantity'];
    $unit = $rel['Unit'];

    $sql = "SELECT * FROM `Project_Database`.`RECIPE` WHERE `Recipe_Id` = '$rId';";
    $res = $db->query($sql);
    $rel = $res->fetch_assoc();
    $rName = $rel['Name'];
  } elseif ( $uID <> NULL) {
    //echo 'User Ingredient';
    $sql = "SELECT * FROM `Project_Database`.`USER_INGREDIENTS` WHERE `Ingredient` = '$ingrName' AND `User_Id` = '$uID';";
    $res = $db->query($sql);
    $rel = $res->fetch_assoc();

    $amount = $rel['count'];
    $unit = $rel['unit'];
  } else {
    //echo "default: >$uID< >$rId<";
  }
  //if deleting
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['delete']) {
    if ($rId <> NULL) { //from recipe
      $resultSuffix = "Deleting From Recipe.";
      $del = "DELETE FROM `Project_Database`.`RECIPE_CONTAINS` WHERE `Ingredient` = '$ingrName' AND `Recipe_Id` = '$rId';";
    } else {  //from user ingredients
      $resultSuffix = "Deleting From Pantry.";
      $del = "DELETE FROM `Project_Database`.`USER_INGREDIENTS` WHERE `Ingredient` = '$ingrName' AND `User_Id` = '$uID';";
    }
    $res = $db->query($del);
    if ($res) {
      $result = "Successful Saving Changes: " . $resultSuffix;
// >>>>>>> Keenan
    } else {
      $result = "Unsuccessful Saving Changes: " . $resultSuffix;
    }
  } else {
    $valid_input = ( !empty($_POST['iName']) && !empty($_POST['iCal']) );



    if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_input && $_POST['saveEdits']) {
      $amount = text_input($_POST['amount']);
      $unit = $_POST['unit'];

      if ($rId <> NULL) { //editing the recipe ingredient
        $sql = "UPDATE `Project_Database`.`RECIPE_CONTAINS`
                SET `Quantity` = '$amount',
                    `Unit` = '$unit'
                WHERE `Ingredient` = '$ingrName';";
      } else {  //editing the user's ingredient
        $sql = "UPDATE `Project_Database`.`USER_INGREDIENTS`
                SET `count` = '$amount',
                    `unit` = '$unit'
                WHERE `Ingredient` = '$ingrName';";
      }
      $success = $db->query($sql);
      if ($success === TRUE) {
        $result = "Successful Saving Changes";
      } else {
        $result = "Unsuccessful Saving Changes: " . $db->error;
      }
      //echo $result;

    }//end post
    else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits']) {
      $result = "Missing values!";
      echo "<script type='text/javascript'>alert('$result');</script>";
    } else {
    }
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
  <link rel="stylesheet" href="../styles/body_styles.css"> <!-- this breaks if theres extra slashes at the end of the page-->
</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;"><?
      $t = ( $_GET['rId'] <> NULL )? "$rName: " : "";
        echo ucwords($ingrName)
        ?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
  </table>
  <table style="width:100%">
<!-- <<<<<<< Louis commented out--> 
<!--   <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?rId=$Recipe_Id";?> method="post" id="info">
    <tr><td>Ingredient:</td><td style="text-align:right;"><?=$ingrName?></td></tr>
    <tr><td>Quantity:</td><td><input type="number"  name="iQuantity" style="width:100%" value="<?echo $iQuantity?>"></td></tr>
    <tr><td>Unit:</td><td><input type="text"  name="iUnit" style="width:100%" value="<?echo $iUnit?>"></td></tr>
    <tr style="height:40%">
  </form>
  <form action="../tables/ingredients.php" method="post" id="back"></form> -->
<!-- ======= -->
  <form action=<?php $r = ( $_GET['rId'] <> NULL )? "&rId=" . $rId : "";
                echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?i=$ingrName" . $r;?> method="post" id="info">
    <tr><td>Ingredient Name:</td><td><input type="text" name="iName" style="width:100%" value="<?echo $ingrName?>" readonly></td></tr>
    <tr><td>Cal / g:</td><td><input type="number"  name="iCal" style="width:100%" value="<?echo $iCal?>" readonly></td></tr>
    <!-- if recipe given -->
    <? if ( $_GET['rId'] <> NULL || $uID <> NULL) {
      echo '
      <tr><td>Amount:</td><td><input type="number"  name="amount" style="width:100%" value="' . $amount . '"></td></tr>
      <tr><td>Unit:</td><td><input type="text"      name="unit" style="width:100%" value="' . $unit . '"></td></tr>
      ';
    }?>
  </form>
  <?  $url = "../tables/ingredients.php"; $i=1;
      foreach ($_GET as $key => $value) {
        if($key == NULL || $value == NULL) continue;
        $url = $url . (($i==1)?"?":"&") . $key . "=" . $value;
        $i++;
      }
      echo '<form action="' . $url . '" method="post" id="back"></form>';
      //TODO that's a useful chunk of code (todo only for ease of access)
  ?>
<!-- >>>>>>> Keenan -->
  <tr>
    <td style="float:right;"><button class="button" style="width:100%" type="submit" name="saveEdits" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="delete" value="TRUE" form="info">Delete</button></td>
  </tr><tr>
    <td colspan="100%"><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>
</body>
</html>
