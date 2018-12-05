<html>
<body>
  <form action="homepage.php" method="post">

  Username: <input type="text" name="Username" value="<?php echo $name;?>"><br><br>
  Password: <input type="text" name="Password" value="<?php echo $name;?>"><br>
  <input type="submit" name="login" value="login">
</form>
  <form action="CreateStdAccount.php" method="post">
    <input type="submit" name="createStdAccount" value="Create Standard User">
  </form>
  <form action="CreateCurAccount.php" method="post">
    <input type="submit" name="createCurAccount" value="Create Curator">
  </form>
</body>
</html?
