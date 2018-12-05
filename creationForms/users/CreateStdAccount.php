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
  $e = $_POST['email'];
  $p = $_POST['password'];
  $u = $_POST['username'];

  $sql = "SELECT * FROM END_USER WHERE Email_Address ='" . $e . "';";
  $result = mysqli_query($db,$sql);
  $count = mysqli_num_rows($result);
  if($e==NULL || $p==NULL || $u==NULL)
  {
    {
      $error = "Some fields have been left blank";
      echo "<script type = 'text/javascript'>alert('$error');</script>";
    }
  }
  else if($count>0)
  {
    $error = "That email has already been used please try again";
    echo "<script type = 'text/javascript'>alert('$error');</script>";
  }
  else{
    $sql = "INSERT INTO `END_USER` (`Email_Address`, `Screen_Name`, `Hashed_Password`, `Curator_Flag`) VALUES('". $e . "', '". $u . "', '" . $p ."','false')";
    mysqli_query($db,$sql);
  }

}
 ?>

 <html>
 <body>
   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
   Username: <input type="text" name="username" value="<?php echo $username;?>"><br><br>
   Password: <input type="password" name="password" value="<?php echo $password;?>"><br>
    Email: <input type="text" name="email" value="<?php echo $email;?>"><br>
   <input type="submit" name="btnsubmit" value="submit">
 </form>
 </body>
 </html?>
