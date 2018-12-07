<?php
//TODO this whole thing
ob_start();
session_start();
  // define variables and set to empty values
  $ingrName = $calPgram = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['ingrName']) && !empty($_POST['calPgram'])) {
    $ingrName = text_input($_POST["ingrName"]);
    $calPgram = $_POST["calPgram"];
  }
  //begin sql
  include("../../connection/dbConfig.php");
  $sql = "INSERT INTO `Project_Database`.`INGREDIENT`(`Name`,`Cal/g`)VALUES('$ingrName','$calPgram');";
  $success = $db->query($sql);

  if ($success === TRUE) {
    echo "<script type='text/javascript'>alert(\"Successful Submission.\");</script>";
  } else {
    echo "<script type='text/javascript'>alert(\"Unsuccessful Submission.\");</script>";
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
<h2>
  Add Ingredient:
</h2>

  <body>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">

      Ingredient Name:
        <input type="text" name="ingrName" value="Butter">
      <br>
      calories per gram:
        <input type="number" name="calPgram" value="
        <?php echo $calPgram;?>">
      <br>
      <br>
      <input type="submit" name="browse" value="Browse">
    </form>

  </body>
  <div class="center" style="width:80%;">
    <h2>Add Meal</h2>
    <body>
      <table style="width:100%">
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
          <tr>
            <td>Name:</td>
            <td><input type="text" name="DepName" value=<?php echo "$Name";?>></td>
          </tr><tr>
            <td>Relationship:</td>
            <td><input type="text" name="relationship" value=<?php echo "$Relationship";?>></td>
          </tr><tr>
            <td>Recipe:</td>
            <td><input type="text" name="Allergy"></td>
          </tr><tr>
            <td>Severity:</td>
            <td><input type="number" name="Severity"></td>
          </tr><tr>
            <td><input class="button" type="submit" name="addmeal" value="Confirm Recipe"></td>
            <td><input class="button" type="submit" name="recipe" value="Add Additional Recipe"></td>
          </tr>
        </form>

        <form action="../../myStuff/guestbook.php" method="post">
          <tr>
            <td colspan="2"><input class="button" type="submit" name="addDependant" value="Close"></td>
          </tr>
        </form>
      </table>
    </body>
  </div>
</html>
