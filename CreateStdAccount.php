<?php
ob_start();
session_start();
 ?>

<html>
<body>
  <form action="homepage.php" method="post">

  Username: <input type="text" name="Username" value="<?php echo $name;?>"><br><br>
  Password: <input type="password" name="Password" value="<?php echo $name;?>"><br>
  Email: <input type="text" name="Username" value="<?php echo $name;?>"><br>
  <input type="submit" name="createStdAccount" value="submit">
</form>
</body>
</html?>
