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
        $sql = "SELECT * FROM END_USER WHERE Screen_Name = '$myusername' AND Hashed_Password = SHA2('$mypassword',256);";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
           $_SESSION['user_id'] = $row['User_Id'];
           $_SESSION['password'] = $mypassword;
           $_SESSION['Curator_Flag'] = $row['Curator_Flag'];
           if ( $_SESSION['Curator_Flag'] == 1 ) {
             header("location: views/curatorHomepage.php");
           } else {
             header("location: views/standardHomepage.php");
           }
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
  <!-- <div class="center" style="width:80%;"> -->
    <div style="width:90%;margin:auto;">
    <h1 style="font-size:48px;text-align:left;"> Cake. </h1>
    <hr>
    <div style="height:40%;">
      <form action="" method="post" id="loginForm" style="width:100%;">
        <table style="width:100%;">
          <tr><td>Username:</td><td>
          <input type="text" name="username" value="paidUser" class="column" style="width:100%;"></td></tr>
          <tr><td>Password:</td><td>
          <input type="password" name="password" value="1234" class="column" style="width:100%;"></td></tr>
        </table>
      </form>
    </div>
    <!-- </div> -->
      <form action="creationForms/users/CreateStdAccount.php" method="post" id="stdUser"></form>
      <form action="creationForms/users/CreateCurAccount.php" method="post" id="curUser"></form>
    <div style="height:25%;">
      <button class="button" style="width:100%;height:40%" type="submit" name="login" form="loginForm">Login</button>
      <button class="button" style="width:100%;height:30%" type="submit" name="createStdAccount" form="stdUser">Create Standard User</button>
      <button class="button" style="width:100%;height:30%" type="submit" name="createCurAccount" form="curUser">Create Curator</button>
      <button class="button" style="width:100%;" onClick="location.href = './index.php'">Back</button>
    </div>
  </div>
  <!-- <div class="column4"><p>&nbsp;</p></div> -->
</body>
</html>
