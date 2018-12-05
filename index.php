<?php
ob_start();
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['Username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['Password']);

      $sql = "SELECT User_Id FROM  WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
         session_register("myusername");
         $_SESSION['login_user'] = $myusername;

         header("location: welcome.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }

 ?>

<html>
<body>
  <form action="homepage.php" method="post">

  Username: <input type="text" name="Username" value="<?php echo $name;?>"><br><br>
  Password: <input type="password" name="Password" value="<?php echo $name;?>"><br>
  <input type="submit" name="login" value="login">
</form>
  <form action="CreateStdAccount.php" method="post">
    <input type="submit" name="createStdAccount" value="Create Standard User">
  </form>
  <form action="CreateCurAccount.php" method="post">
    <input type="submit" name="createCurAccount" value="Create Curator">
  </form>
</body>
</html?>
