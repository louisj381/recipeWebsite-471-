<?php
  ob_start();
  session_start();
 ?>
<html>
  <head>
    <title> Cake. </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>


<div class="center" style="width:80%;">
  <h2> My Recipes: </h2>
  <body>
    <iframe src="../tables/mealPlans.php" style="width:100%;height:40%;"></iframe>

    <!-- <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="addMealPlan"></form>
    <button class="button" style="width:100%;" form="addMealPlan">Add</button> -->
    <button class="button" style="width:100%;" onClick="location.href = '../creationForms/addMealPlan.php'">Add Meal Plan</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/homepage.php'">Go Back</button>
  </body>
</div>
</html>
