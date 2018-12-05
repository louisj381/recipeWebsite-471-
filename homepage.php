<?php
ob_start();
session_start();
 ?>
<html>
<body>
<form action="browse.php" method="post">
  <input type="submit" name="browse" value="Browse">
</form>
<form action="cookbook.php" method="post">
  <input type="submit" name="cookbook" value="Cookbook">
</form>
<form action="pantry.php" method="post">
  <input type="submit" name="pantry" value="Pantry">
</form>
<form action="guestbook.php" method="post">
  <input type="submit" name="guestbook" value="Guestbook">
</form>
<form action="account.php" method="post">
  <input type="submit" name="account" value="Account">
</form>
<form action="login.php" method="post">
  <input type="submit" name="logout" value="Logout">
</form>
</body>
</html>
