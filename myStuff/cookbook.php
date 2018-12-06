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
  <!-- <h2> Recipes: </h2> -->
  <body>
    <button class="button" style="width:100%;" onClick="location.href = '../views/browse.php'">Add to My Cookbook</button>
    <button class="button" style="width:100%;" onClick="location.href = './pantry.php'">View My Pantry</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/recipes.php'">View My Recipes</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/meals.php'">View My Meals</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/mealPlans.php'">View My Meal Plans</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/homepage.php'">Go Back</button>
  </body>
</div>
</html>
