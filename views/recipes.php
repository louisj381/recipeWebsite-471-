<?php
  ob_start();
  session_start();

  $uID = $_SESSION['user_id'];
  $sqlrecipe = "SELECT * FROM Project_Database.RECIPE WHERE RECIPE_ID IN (SELECT Recipe_Id FROM USER_RECIPES WHERE User_Id='$uID')" ;
  $_SESSION['sqlBrowseRecipe'] = $sqlrecipe;
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
    <iframe src="../tables/recipes.php" style="width:100%;height:60%;"></iframe>
    <!-- <p>Selected Recipe: <? echo isset($_POST['recipe_select_1']) ?></p> -->
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="refresh"></form>
    <button class="button" style="width:100%;" form="refresh">Refresh</button>
    <button class="button" style="width:100%;" onClick="location.href = '../creationForms/data/addRecipe.php'">Add Recipe</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/homepage.php'">Go Back</button>
  </body>
</div>
</html>
