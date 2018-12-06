<?php
  ob_start();
  session_start();
 ?>
<html>
  <head>
    <title> Cake. </title>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>
  <h2> In Pantry: </h2>
<div class="column">
  <iframe src="../tables/ingredients.php"></iframe>
</div>
<div class="column">
 <body>


     <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
       <input type="submit" name="Refresh" value="Refresh">
     </form>
     <form action="../views/homepage.php" method="post">
       <input type="submit" name="back" value="Back to My Stuff">
     </form>

 </body>
</div>
</html>
