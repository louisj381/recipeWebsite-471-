<?php
ob_start();
session_start();
include("../../connection/dbConfig.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/body_styles.css">
  </head>
  <div class="center" style="width:80%;">
    <h2>Add Dependant</h2>
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
            <td>Allergy:</td>
            <td><input type="text" name="Allergy"></td>
          </tr><tr>
            <td>Severity:</td>
            <td><input type="number" name="Severity"></td>
          </tr><tr>
            <td><input class="button" type="submit" name="addDependant" value="Confirm Dependant"></td>
            <td><input class="button" type="submit" name="alergies" value="Add Additional Allergy"></td>
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
      $sql = "SELECT * FROM `Project_Database`.`ALLERGY` WHERE (`User_Id` = '$User_Id' AND `Dep_name` = '$Name');";
      $countres = mysqli_query($db,$sql);
      //$count = mysqli_num_rows($db, $countres);
      $count = mysqli_num_rows($countres);
      //adjust table by altering count

      $sql = "UPDATE `Project_Database`.`DEPENDANTS` SET `No-of_allergies` = '$count' WHERE (`User_Id` = '$User_Id' AND `Name` = '$Name');";
      $success1 = $db->query($sql);
  //echo "$result";
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



</html>
