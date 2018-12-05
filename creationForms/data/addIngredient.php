<?php
  // define variables and set to empty values
  $ingrName = $calPgram = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['ingrName']) && !empty($_POST['calPgram'])) {
    $ingrName = text_input($_POST["ingrName"]);
    $calPgram = $_POST["calPgram"];
  }
  //begin sql
  $sql = "INSERT INTO `Project_Database`.`INGREDIENT`(`Name`,`Cal/g`)VALUES('$ingrName','$calPgram');";
  $success = $_SESSION['connection']->query($sql);

  if ($success === TRUE) {
    alert("Successful Submission.");
  } else {
    alert("Unsuccessful Submission.");
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
</html>
