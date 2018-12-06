<?php
  ob_start();
  session_start();
  unset($_SESSION['user_id']);
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
           echo "<script type='text/javascript'>alert('$error');</script>";
        }
      }
 ?>
<html>
<head>
  <title> Cake. </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/body_styles.css">
</head>
<body>
  <!-- <div class="column4" ><p>&nbsp;</p></div> -->
  <div class="center" style="width:80%;">
    <p>&nbsp;</p>
      <form action="" method="post" id="loginForm" style="width:100%;">
        <table style="width:100%;">
          <tr><td>Username:</td><td>
          <input type="text" name="username" value="happy_dude123" class="column" style="width:75%;float:right;"></td></tr>
          <tr><td>Password:</td><td>
          <input type="password" name="password" value="password123" class="column" style="width:75%;float:right;"></td></tr>
        </table>
      </form>
      <form action="creationForms/users/CreateStdAccount.php" method="post" id="stdUser"></form>
      <form action="creationForms/users/CreateCurAccount.php" method="post" id="curUser"></form>

      <button class="button" style="width:100%;" type="submit" name="login" form="loginForm">Login</button>
      <button class="button" style="width:100%;" type="submit" name="createStdAccount" form="stdUser">Create Standard User</button>
      <button class="button" style="width:100%;" type="submit" name="createCurAccount" form="curUser">Create Curator</button>
  </div>
  <!-- <div class="column4"><p>&nbsp;</p></div> -->
</body>
</html>
