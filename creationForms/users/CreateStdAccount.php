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
  $f = $_POST['fname'];
  $la = $_POST['lname'];
  $e = $_POST['email'];
  $p = $_POST['password'];
  $u = $_POST['username'];

  $sql = "SELECT * FROM END_USER WHERE Email_Address ='" . $e . "';";
  $result = mysqli_query($db,$sql);
  $count = mysqli_num_rows($result);
  if($e==NULL || $p==NULL || $u==NULL|| $f==NULL || $la==NULL)
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
    $sql = "INSERT INTO Project_Database.END_USER (`Email_Address`, `Screen_Name`, `Hashed_Password`, `Curator_Flag`) VALUES('". $e . "', '". $u . "', SHA2('" . $p ."',256),'0');";
    mysqli_query($db,$sql);
    $last_id = $db->insert_id;
    $sql = "INSERT INTO Project_Database.STD_USER (`User_Id`,`First_Name`, `Last_Name`, `Num_Allergies`) VALUES('". $last_id ."','" . $f . "', '". $la ."', 0);";
    mysqli_query($db,$sql);
    $error = "Account created! Go to Login";
    echo "<script type = 'text/javascript'>alert('$error');</script>";
  }
}
 ?>

 <html>
 <head><titel><b>Create Standard Account:</b></title></head>
 <body>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  First  Name: <input type="text" name="fname" value="<?php echo $fname;?>"><br><br>
   Last Name: <input type="text" name="lname" value="<?php echo $lname;?>"><br><br>
   Username: <input type="text" name="username" value="<?php echo $username;?>"><br><br>
   Password: <input type="password" name="password" value="<?php echo $password;?>"><br><br>
    Email: <input type="text" name="email" value="<?php echo $email;?>"><br><br>
  <input type="submit" name="btnsubmit" value="submit">
  </form><form  action="../../index.php" method="post">
  <input type="submit" name="btnlogin" value="login">
 </form>
 </body>
 </html?>
