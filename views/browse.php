<?php
  ob_start();
  session_start();
  define(root, "../../");
  include ("../connection/dbConfig.php");
  $homepage = "../views/standardHomepage.php";
  if ($_SESSION['Curator_Flag'] == 1)
    $homepage = "../views/curatorHomepage.php";

  //$niether = isset($_POST['neither']); //not used really

  switch ($_POST['mine']){
    case "all":
      $all = "checked";
      $mine = $notMine = "unchecked";
      break;
    case "true":
      $mine = "checked";
      $all = $notMine = "unchecked";
      break;
    case "false":
      $notMine = "checked";
      $mine = $all = "unchecked";
      break;
  }

  if( isset($_POST['btnbrowse'] )) {
    $browse = $_POST['browse'];

    $append = appendMine("Recipe_Id", "USER_RECIPES") . appendSafeRecipes($_SESSION['user_id']);
    $sqlrecipe = "SELECT * FROM `Project_Database`.`RECIPE` WHERE (`RECIPE_ID` IN (SELECT `Recipe_Id` FROM `Project_Database`.`RECIPE_TAGS` WHERE `Tag` LIKE '%" . $browse . "%') OR `Name` LIKE '%". $browse ."%') $append;" ;
    $_SESSION['sqlBrowseRecipe'] = $sqlrecipe;

    $append = appendMine("Meal_Id", "USER_MEALS");
    $sqlmeal = "SELECT * FROM `Project_Database`.`MEAL` WHERE (`Meal_Id` IN (SELECT `Meal_Id` FROM `Project_Database`.`MEAL_TAGS` WHERE `Tags` LIKE '%". $browse ."%') OR `Meal_type` LIKE '%". $browse ."%') $append;" ;
    $_SESSION['sqlBrowseMeal'] = $sqlmeal;

    $append = appendMine("MealPlan_Id", "USER_MEAL_PLANS");
    $sqlmealPlan = "SELECT * FROM `Project_Database`.`MEAL_PLAN` WHERE (`Name` LIKE '%". $browse ."%') $append;" ;
    $_SESSION['sqlMealPlan'] = $sqlmealPlan;
  }
  function appendMine($id_type, $user_table) {
    $uID = $_SESSION['user_id'];
    if ($_POST['mine'] == 'all') {
      return "";
    } else {
      $mine = $_POST['mine']=='true';
      $not = ($mine)?"":" NOT";
      return " AND `$id_type`$not IN (SELECT `$id_type` FROM `Project_Database`.`$user_table` WHERE `User_Id` = '$uID')";
    }
  }
  function appendSafeRecipes($uID) {
    $safe = isset($_POST["safe"]);
    $app =" AND `Recipe_Id` IN (SELECT c.`Recipe_Id` FROM `Project_Database`.`RECIPE_CONTAINS` as c, `Project_Database`.`USER_RECIPES` as u
                                WHERE c.`Recipe_Id` = u.`Recipe_Id`
                                AND  c.`Ingredient` NOT IN (SELECT `Allergy`
                                                    FROM `Project_Database`.`ALLERGY` as a
                                                    WHERE a.`User_Id` = '$uID'))";
    return ($safe)?  $app : "";
  }
?>


<html>
  <head>
    <title> Cake. </title>
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      -->
      <style>
      /* extra stuff keenan would be proud of maybe <- yes I'm proud */
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
      <table style="width:100%">
        <tr>
          <td style="width:10%;">Show: </td>
          <td style="width:2%;"><input type="radio" name="mine" value="all" title="Show all" <?=$all?>></td>
          <td style="width:10%;"> All </td>
          <td style="width:2%;"><input type="radio" name="mine" value="true" title="Only show things I have saved" <?=$mine?>></td>
          <td style="width:10%;"> My Stuff </td>
          <td style="width:2%;"><input type="radio" name="mine" value="false" title="Only show things I don't have saved" <?=$notMine?>></td>
          <td style="width:10%;"> Not My Stuff </td>
          <td style="width:10%;">&nbsp;</td>
          <td style="width:2%;border-left:2px solid #F0F8FF;"><input type="checkbox" name="safe" value="true" title="Only show recipes that I am not allergic to" <?=($_POST['safe'])? "checked":"unchecked"?>></td>
          <td style="width:10%;"> Safe </td>
          <td style="width:32%;">&nbsp;</td>
        </tr>
      </table>
      <input type="hidden" name="search" value="TRUE">
    </form>
    <body>
      <h3> Recipes: </h3>
      <iframe src="../tables/recipes.php?b=true" style="width:100%;height:30%;"></iframe><br><br>
      <h3> Meals: </h3>
      <iframe src="../tables/meals.php?b=true" style="width:100%;height:30%;"></iframe></body>
      <h3> Meal Plans: </h3>
      <iframe src="../tables/mealPlans.php?b=true" style="width:100%;height:30%;"></iframe></body>
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
