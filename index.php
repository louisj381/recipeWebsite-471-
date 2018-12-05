<?php
  ob_start();
  session_start();
  define(root, "./");
  include("connection/dbConfig.php");
  //echo $_SESSION['connection'];

  if (isset($_POST['login']) && !empty($_POST['username'])
                && !empty($_POST['password'])) {

        // username and password sent from form
        //$myusername = mysqli_real_escape_string($_SESSION['connection'],$_POST['username']);
        //$mypassword = mysqli_real_escape_string($_SESSION['connection'],$_POST['password']);
        $myusername = $_POST['username'];
        $mypassword = $_POST['password'];

        //  ... ,SHA2('password',256), ...
        $sql = "SELECT User_Id FROM END_USER WHERE Screen_Name = '$myusername' AND Hashed_Password = SHA2('$mypassword',256);";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
           $_SESSION['user_id'] = $row['User_Id'];
           header("location: views/homepage.php");
        }else {
           $error = "Your Login Name or Password is invalid";
        }
      }
 ?>

<html>
  <body>
    <form action="" method="post">
      Username:
        <input type="text" name="username"
        value="happy_dude123">
      <br>
      <br>
      Password:
        <input type="password" name="password"
        value="password123">
      <br>
      <input type="submit" name="login" value="login">
    </form>

    <form action="creationForms/users/CreateStdAccount.php" method="post">
      <input type="submit" name="createStdAccount" value="Create Standard User">
    </form>

    <form action="creationForms/users/CreateCurAccount.php" method="post">
      <input type="submit" name="createCurAccount" value="Create Curator">
    </form>
  </body>
</html>
