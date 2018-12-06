<?php
ob_start();
session_start();
define(root, "../../");
include ("../../connection/dbConfig.php");

if( $_POST['btnsubmit'] === "TRUE") {

 $cc = $_POST['cc'];
 $ex = $_POST['ex'];
 $sec = $_POST['sec'];
 $e = $_POST['email'];
 $p = $_POST['password'];
 $u = $_POST['username'];


 echo "".$cc."" .$ex."" .$sec."" .$e."" .$p."" .$u."";

 $sql = "SELECT * FROM END_USER WHERE Email_Address ='" . $e . "';";
 $result = mysqli_query($db,$sql);
 $count = mysqli_num_rows($result);
 if($e==NULL || $p==NULL || $u==NULL|| $cc==NULL || $ex==NULL || $sec==NULL)
 {
     $error = "Some fields have been left blank";
     echo "<script type = 'text/javascript'>alert('$error');</script>";
 }
 else if($count>0)
 {
   $error = "That email has already been used please try again";
   echo "<script type = 'text/javascript'>alert('$error');</script>";
 }
 else{
   $sql = "INSERT INTO Project_Database.END_USER (`Email_Address`, `Screen_Name`, `Hashed_Password`, `Curator_Flag`) VALUES('". $e . "', '". $u . "', SHA2('" . $p ."',256),'1');";
   mysqli_query($db,$sql);
   $last_id = $db->insert_id;
   $sql = "INSERT INTO Project_Database.CURATOR (`User_Id`,`Credit_Card`, `Exp_Date`, `Sec_Num`) VALUES('". $last_id ."','" . $cc . "', '". $ex ."','". $sec ."');";
   mysqli_query($db,$sql);
   $error = "Account created! Go to Login";
   echo "<script type = 'text/javascript'>alert('$error');</script>";
 }
}
?>

<html>
<head>
  <title> Cake. </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles/body_styles.css">
</head>
<h2>Create Curator Account:</h2>
<body class="center" style="width:80%;">
  <table style="width:100%;">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="submitCur">
      <tr><td>Username:           </td><td><input style="width:99%;" type="text" name="username" value="<?php echo $u;?>"></td></tr>
      <tr><td>Password:           </td><td><input style="width:99%;" type="password" name="password" value="<?php echo $p;?>"></td></tr>
      <tr><td>Email:              </td><td><input style="width:99%;" type="text" name="email" value="<?php echo $email;?>"></td></tr>
      <tr><td>Credit Card Number: </td><td><input style="width:99%;" type="text" name="cc" value="<?php echo $cc;?>"></td></tr>
      <tr><td>Expiration Date:    </td><td><input style="width:99%;" type="text" name="ex" value="<?php echo $ex;?>"></td></tr>
      <tr><td>Security Number:    </td><td><input style="width:99%;" type="text" name="sec" value="<?php echo $sec;?>"></td></tr>
    </form>
    <tr><td>
      <button class="button" name="btnsubmit" value="TRUE" form="submitCur" style="width:100%;">Submit</button>
    </td><td>
      <button class="button" onClick="location.href = '../../index.php'" style="width:100%;">Cancel</button>
    </td></tr>
  </table>
</body>
</html?>
