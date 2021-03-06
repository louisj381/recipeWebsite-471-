<?php
  ob_start();
  session_start();
  $homepage = "../views/standardHomepage.php";
  if ($_SESSION['Curator_Flag'] == 1)
    $homepage = "../views/curatorHomepage.php";
 ?>


<html>
<head>
  <title> Cake. </title>
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>

<!--   STD  USER   -->
<!--    My Info    -->
<?php
  $screen_name = $email = $new_pass = "";   // all
  $f_name = $l_name = $num_allergies = "";  // std
  $credit = $expDay = $cvv = "";            // cur
  $showSTD = $showCUR = false;

  $root = "../";
  include($root . "connection/dbConfig.php");  //to access db
  $uID = $_SESSION['user_id'];

  $sql_end = "SELECT * FROM END_USER WHERE User_Id =" . $uID .";";
  $sql_std = "SELECT * FROM STD_USER WHERE User_Id =" . $uID .";";
  $sql_cur = "SELECT * FROM CURATOR WHERE User_Id =" . $uID .";";

  $end = $db->query($sql_end);
  $std = $db->query($sql_std);
  $cur = $db->query($sql_cur);
  if ( $end->num_rows > 0 ) { //yay user exists
      $row = $end->fetch_assoc();
      $screen_name = $row['Screen_Name'];
      $email = $row['Email_Address'];
      $curFlag = $row['Curator_Flag'];
      if (!$curFlag && $std->num_rows > 0 ) {  //std user  <-- careful! our db is not respectful of this constriant yet
        $row = $std->fetch_assoc();
        $f_name = $row['First_Name'];
        $l_name = $row['Last_Name'];
        $num_allergies = $row['Num_Allergies'];
        $showSTD = true;
      } elseif ($curFlag && $cur->num_rows > 0 ) {  //curator
        $row = $cur->fetch_assoc();
        $credit = $row['Credit_Card'];
        $expDay = $row['Exp_Date'];
        $cvv = $row['Sec_Num'];
        $showCUR = true;
      } else {
        echo "<p id=errorMessage>This user is neither a std user or curator,
        please fix this manually in the DB.</p><br><br><br>";
      }
  } else {
    echo "<p id=errorMessage>Server made a Whoopsie, Try logging in again.</p>";
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['changes'] === "TRUE") {
    $success1 = $success2 = $success3 = $tried = false;
    $update_cred = $update_name = $update_pass = "";
    if ( !empty($_POST['new_pass']) ) {
      $update_pass = "UPDATE `Project_Database`.`END_USER`
                      SET `Hashed_Password` = SHA2('" . $_POST['new_pass'] . "',256)
                      WHERE `User_Id` = '" . $uID . "';";
      $success1 = $db->query($update_pass); $tried = true;
    }
    if (!$curFlag && ($_POST['new_f_name'] <> $f_name || $_POST['new_l_name'] <> $l_name)){
      $update_name = "UPDATE `Project_Database`.`STD_USER`
                      SET `First_Name` = '" . $_POST['new_f_name'] . "',
                          `Last_Name` = '" . $_POST['new_l_name'] . "'
                      WHERE `User_Id` = '" . $uID . "';";
      $success2 = $db->query($update_name); $tried = true;
      if ($success2) {
        $f_name = $_POST['new_f_name'];
        $l_name = $_POST['new_l_name'];
      }
    } elseif ($curFlag && ($_POST['new_cc'] <> $credit || $_POST['new_exp'] <> $expDay || $_POST['new_sec'] <> $cvv)) {
      $update_cred = "UPDATE `Project_Database`.`CURATOR`
                      SET `Credit_Card` = " . $_POST['new_cc'] . ",
                          `Exp_Date` = " . $_POST['new_exp'] . ",
                          `Sec_Num` = " . $_POST['new_sec'] . "
                      WHERE `User_Id` = '" . $uID . "';";
      $success3 = $db->query($update_cred); $tried = true;
      if ($success3) {
        $credit = $_POST['new_cc'];
        $expDay = $_POST['new_exp'];
        $cvv = $_POST['new_sec'];
      }
    }
    if ($success1 || $success2 || $success3) {
      echo "<p>Changes saved.</p>";
    } else if (!$tried){
      echo "<p>No changes to save.</p>";
    } else {
      echo "<p>Error saving changes. " . $db->error . "</p>";
    }
    header("Refresh:3");
  } else {
    echo "<p> &nbsp; </p>";
  }
?>
<body class="center" style="width:80%;">
  <table style="width:100%">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="updateForm">
    <tr><td>Username: </td><td style="text-align:right;"><?=$screen_name?></td></tr>
    <tr><td>Email: </td><td style="text-align:right;"><?=$email?></td></tr>
<!--Change FullName-->
  <?
    if ($showSTD) {
      echo '
          <tr><td>First Name:</td><td><input type="text" name="new_f_name" value="' . $f_name . '" style="width:100%;"></td></tr>
          <tr><td>Last Name: </td><td><input type="text" name="new_l_name" value="' . $l_name . '" style="width:100%;"></td></tr>
          <tr><td>Allergies: </td><td style="text-align:right;">' . $num_allergies . '</td></tr>
      ';
    }
    if ($showCUR) {
      echo '
          <tr><td>Credit Card: </td><td><input type="text" name="new_cc" value="' . $credit . '" style="width:100%;"></td></tr>
          <tr><td>Expiry Date: </td><td><input type="text" name="new_exp" value="' . $expDay . '" style="width:100%;"></td></tr>
          <tr><td>Securiy Num: </td><td><input type="text" name="new_sec" value="' . $cvv . '" style="width:100%;"></td></tr>
      ';
    }
   ?>
<!--Change Password-->
      <tr><td>New Password: </td><td><input type="text" name="new_pass" style="width:100%;"></td></tr>
      <tr><td colspan="100%"><button class="button" style="width:100%;" form="updateForm">Save Changes.</button></td></tr>
      <input type="hidden" name="changes" value="TRUE">
    </form>
    <form action="<?php echo $homepage?>" method="post" id="back"></form>
    <tr><td colspan="100%"><button class="button" style="width:100%;" type="submit" name="back" value="Back to My Stuff" form="back">Back to My Stuff</button></td></tr>
  </table>
 <p>&nbsp;</p>
</body>


</html>
