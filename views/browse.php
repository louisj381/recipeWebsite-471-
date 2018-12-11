<?php
ob_start();
session_start();
define(root, "../../");
include ("../connection/dbConfig.php");
$homepage = "../views/standardHomepage.php";
if ($_SESSION['Curator_Flag'] == 1)
  $homepage = "../views/curatorHomepage.php";


if( isset($_POST['btnbrowse'] )) {
 $browse = $_POST['browse'];
 //echo $browse;
 $sqlrecipe = "SELECT * FROM Project_Database.RECIPE WHERE RECIPE_ID IN (SELECT Recipe_Id FROM Project_Database.RECIPE_TAGS WHERE Tag LIKE '%". $browse ."%');" ;
//echo '<input type="hidden" name="sqlRecipe" value="' . $sqlrecipe . '">';
$_SESSION['sqlBrowseRecipe'] = $sqlrecipe;
$sqlmeal = "SELECT * FROM Project_Database.MEAL WHERE Meal_Id IN (SELECT Meal_Id FROM Project_Database.MEAL_TAGS WHERE Tags LIKE '%". $browse ."%');" ;
//echo '<input type="hidden" name="sqlRecipe" value="' . $sqlrecipe . '">';
$_SESSION['sqlBrowseMeal'] = $sqlmeal;
$sqlmealPlan = "SELECT * FROM Project_Database.MEAL_PLAN WHERE Name LIKE '%". $browse ."%';" ;
//echo '<input type="hidden" name="sqlRecipe" value="' . $sqlrecipe . '">';
$_SESSION['sqlMealPlan'] = $sqlmealPlan;
}
?>


<html>
  <head>
    <title> Cake. </title>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
      <style>
      /* extra stuff keenan would be proud of maybe */
        input[name=browse] {
          background-image: url("../icons/search.png");
          background-position: left;
          background-size: contain;
          background-repeat: no-repeat;
          padding: 5px 20px 5px 40px;
        }
      </style>
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>
  <!-- THIS IS THE BROWSE FRAME -->
  <div class="center" style="width:80%;">
    <h2> Browse: </h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <table style="width:100%;">
        <tr>
          <td style="width:10%;">Search:</td>
          <td style="width:85%;"><input type="text" name="browse" style="width:100%;" placeholder="Search..."></td>
          <td style="width:5%;"><button class="button" type = "submit" name = "btnbrowse" value = "Search">Go!</button></td>
        </tr>
      </table>
      <input type="hidden" name="search" value="TRUE">
    </form>
    <body>
      <h3> Recipes: </h3>
      <iframe src="../tables/recipes.php" style="width:100%;height:30%;"></iframe><br><br>
      <h3> Meals: </h3>
      <iframe src="../tables/meals.php" style="width:100%;height:30%;"></iframe></body>
    <form action=<?php echo $homepage?> method="post" id="back"></form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="refresh"></form>
    <table style="width:100%;">
      <tr>
        <td><button class="button" style="width:100%;" type="submit" name="Refresh" value="Refresh" form="refresh">Refresh</button></td>
        <td><button class="button" style="width:100%;" type="submit" name="back" value="Back to My Stuff" form="back">Back</button></td>
      </tr>
    </table>
 </body>
</div>
</html>
