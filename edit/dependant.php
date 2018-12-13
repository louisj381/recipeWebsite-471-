<?php
ob_start();
session_start();
include("../connection/dbConfig.php");
  // define variables and set to empty values
  if ( !$_POST['saveEdits'] && !$_POST['delete'] && $_SERVER["REQUEST_METHOD"] == "POST" ) {
    echo 'updating referer' ;
    $back = $_SERVER['HTTP_REFERER'];
  }
  $dName = $_GET['d'];
  $uID = $_SESSION['user_id'];
  $relation = $num_allergies = "";

  $sql = "SELECT * FROM `Project_Database`.`DEPENDANTS` WHERE `User_Id` = '$uID' AND `Name` = '$dName';";
  $res = $db->query($sql);
  $depRow = $res->fetch_assoc();

  //get out of here if no work
  if (mysqli_num_rows($res) == 0) {
    echo "<script type='text/javascript'>alert('oops!\n$db->error');</script>"; // this wont display
    header("location: $back");
  } else {
    $relation = $depRow['Relationship'];
    $num_allergies = $depRow['No-of_allergies']; /* yeesh whatta name */
  }
  $valid_input = ( !empty($_POST['relation']) );

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['delete']) {
    $sql = "DELETE FROM `Project_Database`.`DEPENDANTS`
            WHERE `User_Id` = '$uID' AND `Name` = '$dName' ;";
    if ( $db->query($sql) ) {
      $result = "Successful Saving Changes";
      header('location: ../tables/dependants.php'); // lol dip
    } else {
      $result = "Unsuccessful Saving Changes";
    }
  } else
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_input && $_POST['saveEdits']) {
    $relation = text_input($_POST['relation']);
    $sql = "UPDATE `Project_Database`.`DEPENDANTS`
            SET `Relationship` = '$relation'
            WHERE `User_Id` = '$uID' AND `Name` = '$dName' ;";
    if ($db->query($sql)) {
      $result = "Successful Saving Changes";
    } else {
      $result = "Unsuccessful Saving Changes";
    }
  } else //end post
  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['saveEdits']) {
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
  $dName = $_GET['d'];
  //$relation = $depRow['Relationship'];
 ?>

<html>
<head>
  <title> Cake. </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>
<div class="center" style="width:90%">
<body>
  <table style="width:100%">
    <tr><td><h1 style="font-size:30pt;margin-bottom:0px;"><? echo ucwords($dName)?></h1></td>
    <td><?php echo "<p>$result</p>";?></td></tr>
  </table>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?d=$dName";?> method="post" id="info">
    <tr><td>Relationship:</td><td><input type="text" name="relation" style="width:100%" value="<?=$relation?>"></td></tr>
  </form>
  <form action="../tables/dependants.php" method="post" id="back"></form>
  <form action="addAllergy.php?d=<?=$dName?>" method="post" id="algy"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="saveEdits" value="TRUE" form="info">Save</button></td>
    <td><button class="button" style="width:100%" type="submit" name="addyBoi" value="TRUE" form="algy">Add Allergy</button></td>
  </tr><tr>
    <td colspan="100%"><button class="button" style="width:100%" type="submit" name="delete" value="TRUE" form="info">Delete</button></td>
  </tr><tr>
    <td colspan="100%"><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
  </tr>
  </table>
  <iframe src="../tables/allergies.php?d=<?=$dName?>" style="width:100%;height:40%;" allowTransparency="true"></iframe>
</body>
</html>
