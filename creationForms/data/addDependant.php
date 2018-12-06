<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
$GLOBALS['allergyCount'] = 0;
  // define variables and set to empty values
  $User_Id = $Name = $Relationship = $No_of_allergies = $Allergy = $Severity = "";

  //handle adding Dependant
  if (isset($_POST['addDependant']) && !empty($_POST['DepName']) && !empty($_POST['relationship'])) {
    $User_Id = $_SESSION['user_id'];
    $Name = $_POST['DepName'];
    $Relationship = $_POST['relationship'];

    //begin sql
    if (!empty($_POST['Allergy']) && !empty($_POST['Severity']))
    {
      $Allergy = $_POST['Allergy'];
      $Severity = $_POST['Severity'];
      $sql = "INSERT INTO Project_Database.DEPENDANTS(`User_Id`,`Name`,`Relationship`, `No-of_allergies`) VALUES(". $User_Id .",'" . $Name ."','".$Relationship."',1);";
      echo "$sql";
      $result = mysqli_query($db,$sql);
      $sql = "INSERT INTO Project_Database.ALLERGY(`User_Id`,`Dep_name`,`Allergy`,`Severity`) VALUES(". $User_Id .",'" . $Name ."','".$Allergy."','".$Severity."');";

    }
    else {
      $sql = "INSERT INTO Project_Database.DEPENDANTS(`User_Id`,`Name`,`Relationship`,`No-of_allergies`) VALUES(". $User_Id .",'" . $Name ."','".$Relationship."','0');";

    }

  $result = mysqli_query($db,$sql);

  if ($result === TRUE) {
    $result = "Successful Submission.";
  } else {
    $result = "Unsuccessful Submission.";
  }
  echo "<script type='text/javascript'>alert('$result');</script>";
}//end of post
else if (isset($_POST['addDependant'])) {
  $result = "depName or relationship are incomplete";
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
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>
<h2>
  Add Dependant
</h2>

  <body>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">

      Name:
        <input type="text" name="DepName" value=<?php echo "$Name";?>>
      <br>
      <br>
      Relationship:
        <input type="text" name="relationship" value=<?php echo "$Relationship";?>>
      <br>
      <br>
      Allergy:
      <input type="text" name="Allergy">
      <br>
      <br>
      Severity:
      <input type="number" name="Severity">
      <br>
      <br>
      <input type="submit" name="addDependant" value="Confirm Dependant">
      <br>
      <br>
      <input type="submit" name="alergies" value="add additional Alergy">

      <!-- <input type="submit" name="browse" value="Browse"> -->
    </form>

    <form action="../../myStuff/guestbook.php" method="post">
    <input type="submit" name="addDependant" value="Close">
    </form>


<?php
//handle addAlergy
if (isset($_POST['alergies']) && !empty($_POST['DepName']) && !empty($_POST['relationship']) && !empty($_POST['Allergy']) && !empty($_POST['Severity'])) {
  $User_Id = $_SESSION['user_id'];
  $Name = $_POST['DepName'];
  $Allergy = $_POST['Allergy'];
  $Severity = $_POST['Severity'];

  //begin sql
  //need to fix mmkay
  $sql = "INSERT INTO Project_Database.ALLERGY(`User_Id`,`Dep_name`,`Allergy`,`Severity`) VALUES(". $User_Id .",'" . $Name ."','".$Allergy."','".$Severity."');";
  $result = mysqli_query($db,$sql);
  if ($result === TRUE) {
    $count = $GLOBALS['allergyCount'];
    $count++;
    $GLOBALS['allergyCount'] = $count;
    //adjust table by altering count
    $sql = "UPDATE `Project_Database`.`DEPENDANTS`
SET
`User_Id` = `User_Id:`,
`Name` = `Name:`,
`Relationship` = `Relationship:`,
`No-of_allergies` = `No-of_allergies:`
WHERE `No-of_allergies` = '$count';";
echo "$sql";
$result = mysqli_query($db,$sql);
if ($result === TRUE) {
  $result = "Successful Submission.";
} else {
  $result = "Unsuccessful Submission.";
}
}
else {
  $result = "Unsuccessful Submission.(Insert failed)";
}
  echo "<script type='text/javascript'>alert('$result');</script>";

}//end of POST
else if (isset($_POST['alergies'])) {
  $message = "no allergy to add!";
  echo "<script type='text/javascript'>alert('$message');</script>";
}

?>


  </body>
</html>
