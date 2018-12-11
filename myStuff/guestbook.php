<?php
  ob_start();
  session_start();
  $homepage = "../views/standardHomepage.php";
  if ($_SESSION['Curator_Flag'] == 1)
    $homepage = "../views/curatorHomepage.php";
 ?>
<html>
  <head>
    <title> Cake. </title>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>

<div class="center" style="width:80%;">
  <h2> Guestbook: </h2>
  <body>
    <iframe src="../tables/dependants.php" style="width:100%;"></iframe>
    <form action="../creationForms/data/addDependant.php" method="post" id="addDep"></form>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="refresh"></form>
    <form action="<?php echo $homepage?>" method="post" id="back"></form>

    <button class="button" style="width:100%;" type="submit" name="Add" value="Add"form="addDep">Add</button>
    <button class="button" style="width:100%;" type="submit" name="Refresh" value="Refresh" form="refresh">Refresh</button>
    <button class="button" style="width:100%;" type="submit" name="back" value="Back to My Stuff" form="back">Back to My Stuff</button>
 </body>
</div>
</html>
