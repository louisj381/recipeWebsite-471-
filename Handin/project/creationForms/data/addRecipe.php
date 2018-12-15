<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $Recipe_Id = $rName = $rPrep = $rCook = $rRate = $rInstr = "";

  if ( !$_POST['saveEdits'] && $_SERVER["REQUEST_METHOD"] == "POST" ) {
  //!($_SERVER['HTTP_REFERER'] != $_SERVER['PHP_SELF']) ){
    //echo 'updating referer' ;
    $back = $_SERVER['HTTP_REFERER'];
  }

  $sql = "SELECT * FROM `Project_Database`.`RECIPE`;";
  $res = $db->query($sql);
  $Recipe_Id = mysqli_num_rows($res);
  //echo $Recipe_Id;
  $uID = $_SESSION['user_id'];

  $valid_input = (!empty($_POST['rName']) && !empty($_POST['rPrep']) && !empty($_POST['rCook']) && !empty($_POST['rInstr']));
  $rName = text_input($_POST['rName']);
  $rPrep = $_POST['rPrep'];
  $rCook = $_POST['rCook'];
  $rRate = $_POST['rRate'];
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_input && $_POST['addRecipe']) {
    //more code of a desperate man
    $rName = text_input($_POST['rName']);
    $rPrep = $_POST['rPrep'];
    $rCook = $_POST['rCook'];
    $rRate = $_POST['rRate'];
    $uID = $_SESSION['user_id'];

    if (empty($_POST['rRate'])){
      $rRate = "NULL";
    } else {
      $rRate = $_POST['rRate'];
    }
    $rInstr = $_POST['rInstr'];
    $Recipe_Id = ($Recipe_Id <> NULL)? $Recipe_Id : $_GET['rId'];
    // echo $Recipe_Id;
    $sql = "INSERT INTO `Project_Database`.`RECIPE`
                    (`Recipe_Id`,`Name`,`PrepTime`, `CookTime`, `Rating`, `Instructions`, `creator`)
            VALUES ('$Recipe_Id', '$rName', '$rPrep', '$rCook', '$rRate', '$rInstr', '$uID' )";
    $success1 = $db->query($sql);
    $sql = "INSERT INTO `Project_Database`.`USER_RECIPES` (`User_Id`,`Recipe_Id`) VALUES ('$uID', '$Recipe_Id');";
    $success2 = $db->query($sql);
     echo $sql;
    if ($success1 == TRUE && $success2 == TRUE) {
      $result = "Successful Saving Changes: " . $db->error;
    } else {
      $result = "Unsuccessful Saving Changes: " . $db->error;
    }

  }//end post
  else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['addRecipe']) {
    $result = "Missing values!";
    echo "<script type='text/javascript'>alert('$result');</script>";
  } else {
    //just entered page
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
  <link rel="stylesheet" href="../../styles/body_styles.css">
</head>
<div class="center" style="width:80%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;">Add Recipe:</h1></td>
    <td><?php echo "<p><b>$result</b></p>";?></td></tr>
  </table>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?rId=$Recipe_Id";?> method="post" id="info">
    <tr><td style="width: 40%">Recipe Name:</td><td><input type="text" name="rName" style="width:100%" value="<?php echo ($result=="Missing values!")? $rName:'' ?>"></td></tr>
    <tr><td>PrepTime:</td><td><input type="number"  name="rPrep" style="width:100%" value="<?php echo ($result=="Missing values!")? $rPrep:'' ?>"></td></tr>
    <tr><td>CookTime:</td><td><input type="number"  name="rCook" style="width:100%" value="<?php echo ($result=="Missing values!")? $rCook:'' ?>"></td></tr>
    <tr><td>Rating:</td><td><input type="text"      name="rRate" style="width:100%" value="<?php echo ($result=="Missing values!")? $rRate:'' ?>"></td></tr>

    <tr>
      <td style="padding-top:5px;">Instructions:</td><td>
      <textarea class="textinput" type="text" name="rInstr" style="margin:auto;width:100%;text-align:left;" form="info">
        <?php echo ($result=="Missing values!")? $rInstr:"" ?>
      </textarea></td>
    </tr>
  </form>
  <form action="../../views/recipes.php" method="post" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="addRecipe" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  <tr><td colspan="100%"><iframe src="../../tables/ingredients.php?rId=<?echo $Recipe_Id?>" style="width:100%;height:150%;"><iframe></td></tr>
  </table>
</body>
</div>
</html>
