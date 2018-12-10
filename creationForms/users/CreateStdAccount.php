<?php
 ob_start();
 session_start();
 define(root, "../../");
include ("../../connection/dbConfig.php");

//TODO make unique
if( $_POST['btnsubmit'] === "TRUE" ) {
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
    $success1 = mysqli_query($db,$sql);
    $last_id = $db->insert_id;
    $sql = "INSERT INTO Project_Database.STD_USER (`User_Id`,`First_Name`, `Last_Name`, `Num_Allergies`) VALUES('". $last_id ."','" . $f . "', '". $la ."', 0);";
    $success2 = mysqli_query($db,$sql);
    if (!$success1 || !$success2){
      $error = "oops! " . $db->error;
    } else {
      $error = "Account created!";//Go to Login
    }
    echo "<script type = 'text/javascript'>alert('$error');location.href = '../../login.php'</script>";
  }
}
 ?>

 <!-- <html>
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
 </html> -->

 <html>
 <head>
   <title> Cake. </title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../../styles/body_styles.css">
 </head>
 <h2>Create Standard Account:</h2>
 <body class="center" style="width:80%;">
   <table style="width:100%;">
     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="submitStd">
       <tr><td>Username:           </td><td><input style="width:99%;" type="text" name="username" value="<?php echo $u;?>"></td></tr>
       <tr><td>Password:           </td><td><input style="width:99%;" type="password" name="password" value="<?php echo $p;?>"></td></tr>
       <tr><td>Email:              </td><td><input style="width:99%;" type="text" name="email" value="<?php echo $email;?>"></td></tr>
       <tr><td>First Name: </td><td><input style="width:99%;" type="text" name="fname" value="<?php echo $cc;?>"></td></tr>
       <tr><td>Last Name:    </td><td><input style="width:99%;" type="text" name="lname" value="<?php echo $ex;?>"></td></tr>
     </form>
     <tr><td>
       <button class="button" name="btnsubmit" value="TRUE" form="submitStd" style="width:100%;">Submit</button>
     </td><td>
       <button class="button" onClick="location.href = '../../login.php'" style="width:100%;">Cancel</button>
     </td></tr>
   </table>
 </body>
 </html?>
