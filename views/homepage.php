<?php
ob_start();
session_start();
define(root, "../");
 ?>
<html>
<body>
<form action="../views/browse.php" method="post">
  <input type="submit" name="browse" value="Browse">
</form>
<form action="../myStuff/cookbook.php" method="post">
  <input type="submit" name="cookbook" value="Cookbook">
</form>
<form action="../myStuff/pantry.php" method="post">
  <input type="submit" name="pantry" value="Pantry">
</form>
<form action="../myStuff/guestbook.php" method="post">
  <input type="submit" name="guestbook" value="Guestbook">
</form>
<form action="../myStuff/account.php" method="post">
  <input type="submit" name="account" value="Account">
</form>
<form action="../index.php" method="post">
  <input type="submit" name="logout" value="Logout">
</form>
</body>
</html>
