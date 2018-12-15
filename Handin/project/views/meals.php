<?php
  ob_start();
  session_start();
  $uID = $_SESSION['user_id'];
  $sqlmeal = "SELECT * FROM `Project_Database`.`MEAL`
              WHERE `Meal_Id` IN (SELECT `Meal_Id`
                                FROM `Project_Database`.`USER_MEALS` as `m`
                                WHERE `m`.`User_Id` = '$uID');" ;
  $_SESSION['sqlBrowseMeal'] = $sqlmeal;
 ?>
<html>
  <head>
    <title> Cake. </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/body_styles.css">
  </head>


<div class="center" style="width:80%;">
  <h2> My Meals: </h2>
  <body>
    <iframe src="../tables/meals.php" style="width:100%;height:60%;"></iframe>

    <!-- <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="addMeal"></form>
    <button class="button" style="width:100%;" form="addMeal">Add</button> -->
    <button class="button" style="width:100%;" onClick="location.href = '../creationForms/data/addMeal.php'">Add Meal</button>
    <button class="button" style="width:100%;" onClick="location.href = '../views/homepage.php'">Go Back</button>
  </body>
</div>
</html>
