<!-- <?php
  ob_start();
  session_start();
  define(root, "../../");
 ?>

<html>
  <body>
    <form action='../../views/homepage.php' method="post">
      Username:
        <input type="text" name="Username" value="
        <?php echo $name;?>">
      <br>
      <br>
      Password:
        <input type="password" name="Password" value="
        <?php echo $name;?>">
      <br>
      Email:
        <input type="text" name="Username" value="
        <?php echo $name;?>">
      <br>
      <input type="submit" name="createStdAccount" value="submit">
    </form>
  </body>
</html?> -->
<?php
ob_start();
session_start();
//TODO make unique
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $username = mysqli_real_escape_string($db,$_POST['username']);
  $password = mysqli_real_escape_string($db,$_POST['password']);
  $email = mysqli_real_escape_string($db,$_POST['email']);

  echo $username;
  echo $password;
  echo $email;

  // $sql = "SELECT id FROM admin WHERE username = '$myusername' and passcode = '$mypassword'";
  // $result = mysqli_query($db,$sql);
  // $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  // $active = $row['active'];
}
 ?>

 <html>
 <body>
   <form action="homepage.php" method="post">

   Username: <input type="text" name="username" value="<?php echo $username;?>"><br><br>
   Password: <input type="password" name="password" value="<?php echo $password;?>"><br>
    Email: <input type="text" name="email" value="<?php echo $email;?>"><br>
   <input type="submit" name="btnsubmit" value="submit">
 </form>
   <form action="index.php" method="post">
     <input type="submit" name="createStdAccount" value="Create Standard User">
   </form>
 </body>
 </html?>
