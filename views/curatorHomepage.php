<?php
  ob_start();
  session_start();
  define(root, "../");
  include("../connection/dbConfig.php");

//check if there is a channel that EXISTS
$User_Id = $_SESSION['user_id'];
$sql = "SELECT * FROM `Project_Database`.`CHANNEL` WHERE `User_Id` = '$User_Id';";

//@$res = $db->query($sql);
$res = mysqli_query($db, $sql);
@$row = mysqli_fetch_array($res,MYSQLI_ASSOC);
@$count = mysqli_num_rows($res);
if ($count == 1) {
  $hasChannel = TRUE;
}
else {
  $hasChannel = FALSE;
}
if (!$hasChannel) {
  echo '<script>
    function OpenForm() {
      document.getElementById("myForm").style.display = "block";
    }
  </script>';
}

 ?>

<script>
  function OpenForm() {
    var display = <?php echo $hasChannel; ?>;
    if (display == 1)
    {
      window.location.href = '../myStuff/MyChannel.php';
    }
    else {
      document.getElementById("myForm").style.display = "block";
    }
  }
</script>
<script>
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }
</script>
<html>
<head>
  <title> Cake. </title>
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    -->
  <!-- <link rel="stylesheet" href="../styles/channelPopup.css"> -->
  <link rel="stylesheet" href="../styles/body_styles.css">
</head>
  <body>
    <div class="column4"><p>&nbsp;</p></div>
    <div class="column">
      <p>&nbsp;</p>
      <button class="button" style="width:100%;" onClick="location.href = '../views/browse.php'">Browse</button>
      <button class="button" style="width:100%;" onClick="OpenForm()">My Channel</button>
      <!-- <button class="button" style="width:100%;" onClick="location.href = '../myStuff/MyChannel.php'">My Channel</button> -->
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/cookbook.php'">Cookbook</button>
      <button class="button" style="width:100%;" onClick="location.href = '../myStuff/account.php'">Account</button>
      <button class="button" style="width:100%;" onClick="location.href = '../login.php'">Logout</button>
    </div>
    <div class="column4"><p>&nbsp;</p></div>
    <style>
    /* body {font-family: Arial, Helvetica, sans-serif;} */
* {box-sizing: border-box;}


/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  /* padding-left: 15px; */
  bottom: 10px;
  center: 0px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width input fields */
.form-container input[type=text], .form-container input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
}

/* When the inputs get focus, do something */
.form-container input[type=text]:focus, .form-container input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>
    <div class="form-popup" id="myForm">
      <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" class="form-container" id="aForm">
        <h1><font color="black">Create Channel</font></h1>

        <label for="channel"><font color="black"><b>Channel Name</b></font></label>
        <input type="text" placeholder="Name..." name="channel" required>

        <label for="psw"><font color="black"><b>Your Password</b></font></label>
        <input type="password" placeholder="Enter your password" name="psw" required>
<!-- //<input class="button" type="submit" name="addDependant" value="Confirm Dependant"> -->
        <!-- <input class="button" type="submit" name="submit"> -->
        <button type="submit" class="btn" form="aForm">Create</button>
        <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
      </form>
    </div>

<?php
//logic for creating a channel

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $channelName = $_POST['channel'];
  $potentialpass = $_POST['psw'];
  $actualpass = $_SESSION['password'];
  if ($potentialpass==$actualpass  ) {
    $sql = "INSERT INTO `Project_Database`.`CHANNEL` (`Name`,`User_Id`) VALUES('$channelName', '$User_Id');";
    $res = mysqli_query($db, $sql);
    $success = "Channel Created";
    if ($_SESSION['channel'] != $channelName) {
      echo "<script type='text/javascript'>alert('$success');window.top.location.href = window.top.location.href;</script>";
      $_SESSION['channel'] = $channelName;
    }
  }
  else if (!$hasChannel) {
    $Errmessage = "Password Incorrect";
    echo "<script type='text/javascript'>alert('$Errmessage');</script>";
    $_SESSION['channel'] = "";
  }

}

 ?>



  </body>
</html>
