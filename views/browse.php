<?php
ob_start();
session_start();
define(root, "../../");
include ("../connection/dbConfig.php");

if( isset($_POST['btnbrowse'] )) {
 $browse = $_POST['browse'];
 //echo $browse;
 $sqlrecipe = "SELECT * FROM Project_Database.RECIPE WHERE RECIPE_ID IN (SELECT Recipe_Id FROM Project_Database.RECIPE_TAGS WHERE Tag LIKE '%". $browse ."%');" ;
//echo '<input type="hidden" name="sqlRecipe" value="' . $sqlrecipe . '">';
$_SESSION['sqlBrowseRecipe'] = $sqlrecipe;
$sqlmeal = "SELECT * FROM Project_Database.MEAL WHERE Meal_Id IN (SELECT Meal_Id FROM Project_Database.MEAL_TAGS WHERE Tags LIKE '%". $browse ."%');" ;
//echo '<input type="hidden" name="sqlRecipe" value="' . $sqlrecipe . '">';
$_SESSION['sqlBrowseMeal'] = $sqlmeal;
}
?>


<html>
  <head>
    <title> Cake. </title>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>
  <h2> Browse: </h2>
  <!-- THIS IS THE BROWSE FRAME -->
<div class="column">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  Tag: <input type="text" name="browse">
  <input type = "submit" name = "btnbrowse" value = "Search"><br><br>
  <input type="hidden" name="search" value="TRUE">'
  </form>
  <body><iframe src="../tables/recipes.php" ></iframe><br><br>
        <iframe src="../tables/meals.php" ></iframe></body>
  </div>
  <!--          THIS IS NOT          -->
<div class="column">
 <body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <input type="submit" name="Refresh" value="Refresh">
    </form>

    <form action="../views/homepage.php" method="post">
    <input type="submit" name="back" value="Back to My Stuff">
    </form>

 </body>
</div>
</html>
