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

 <div class="center" style="width:80%;">
   <h1> Channels </h1>
   <body>
     <iframe src="../tables/channels.php?mine=true" style="width:100%;height:60%;"></iframe>
     <form action="../creationForms/data/addMealPlan.php" method="post" id="mealPlan"></form>
     <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="refresh"></form>
     <form action="../views/standardHomepage.php" method="post" id="back"></form>

     <button class="button" style="width:100%;" type="submit" name="Add" value="Add"form="mealPlan">Add</button>
     <button class="button" style="width:100%;" type="submit" name="Refresh" value="Refresh" form="refresh">Refresh</button>
     <button class="button" style="width:100%;" type="submit" name="back" value="Back to My Stuff" form="back">Back to My Stuff</button>
  </body>
 </div>
 </html>
