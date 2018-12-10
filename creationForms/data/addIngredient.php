<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
  // define variables and set to empty values
  $User_Id = $ingrName = $calPgram = $quantity = $unit = "";
  $User_Id = $_SESSION['user_id'];
  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['ingrName']) && !empty($_POST['calPgram'])
    && !empty($_POST['quantity']) && !empty($_POST['unit'])) {
    $ingrName = text_input($_POST["ingrName"]);
    $calPgram = $_POST["calPgram"];
    $quantity = $_POST["quantity"];
    $unit = $_POST["unit"];
    //first check if ingredient already exists in db:
  $sql = "SELECT * FROM `Project_Database`.`INGREDIENT` WHERE `Name` = '$ingrName';";
  $validate = $db->query($sql);

  if (mysqli_num_rows($validate) == 0) {  //if no such ingredient exists, add it
    $sql = "INSERT INTO `Project_Database`.`INGREDIENT`(`Name`,`Cal/g`)VALUES('$ingrName','$calPgram');";
    $success = $db->query($sql);
    if ($success === FALSE) {
      $result = "Unsuccessful adding ingredient";
      echo "<script type='text/javascript'>alert('$result');</script>";
    }
  }

  $sql = "INSERT INTO `Project_Database`.`USER_INGREDIENTS`(`User_Id`,`Ingredient`,`count`,`unit`)VALUES('$User_Id','$ingrName','$quantity','$unit');";
  $success = $db->query($sql);


  if ($success === TRUE) {
    $result = "Successful Submission";
  } else {
    $result = "Unsuccessful adding user_ingredient";
  }
  echo "<script type='text/javascript'>alert('$result');</script>";
}//end post
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['AddIngredient'])) {
  $result = "Missing values!";
  echo "<script type='text/javascript'>alert('$result');</script>";

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
<h2>Add Ingredient:</h2>
<body>
  <table style="width:100%">
  <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="info">
    <tr><td>Ingredient Name:</td><td><input type="text" name="ingrName" style="width:100%"></td></tr>
    <tr><td>Calories per Gram:</td><td><input type="number" name="calPgram" style="width:100%"></td></tr>
    <!-- if recipe given -->
    <tr><td>Quantity:</td><td><input type="number" name="quantity" style="width:100%"></td></tr>
    <tr><td>Unit:</td><td><input type="text" name="unit" style="width:100%"></td></tr>
  </form>
  <form action="../../myStuff/pantry.php" method="post" id="back"></form>
  <tr>
    <td><button class="button" style="width:100%" type="submit" name="Back" value="Back" form="back">Go Back</button></td>
    <td><button class="button" style="width:100%" type="submit" name="AddIngredient" value="Add" form="info">Add</button></td>
  </tr>
</body>
</div>
</html>
