<?php
ob_start();
session_start();
define(root, "../../");
include ("../../connection/dbConfig.php");

//TODO make unique
if( isset($_POST['btnsubmit'] )) {
 //echo $_POST['username'];
//  echo $_POST['password'];
//  echo $_POST['email'];
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
<head><titel><b>Create Curator Account:</b></title></head>
<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  Username: <input type="text" name="username" value="<?php echo $u;?>"><br><br>
  Password: <input type="password" name="password" value="<?php echo $p;?>"><br><br>
  Email: <input type="text" name="email" value="<?php echo $email;?>"><br><br>
  Credit Card Number: <input type="text" name="cc" value="<?php echo $cc;?>"><br><br>
  Expiration Date: <input type="text" name="ex" value="<?php echo $ex;?>"><br><br>
  Security Number: <input type="text" name="sec" value="<?php echo $sec;?>"><br><br>
  <input type="submit" name="btnsubmit" value="submit">
  </form><form  action="../../index.php" method="post">
  <input type="submit" name="btnlogin" value="login">
  </form>
</body>
</html?>
