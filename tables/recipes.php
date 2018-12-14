<?php
  ob_start();
  session_start();
 ?>

<html>
  <head>
    <link rel="stylesheet" href="../styles/body_styles.css">
    <link rel="stylesheet" href="../styles/table_styles.css">
  </head>
  <script javascript>
    function toggleInMeal( meal, recipe ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "toggle/meal_recipes.php?rId=" + recipe + "&req=" + Math.random() + "&mId=" + meal);
      xhttp.send();
    }
    function toggleUser( recipe ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "add/recipe.php?rId=" + recipe + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table>
      <tr>
        <!-- <th style="width:auto;">ID</th> -->
        <th colspan="2">Recipe</th>
        <th>PrepTime</th>
        <!-- <th>CookTime</th> -->
        <th>Rating</th>
        <th>Instructions</th>
        <th>Ingredients</th>
      </tr>
      <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post" id="recipeView"></form>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = $_SESSION['sqlBrowseRecipe'];
        //echo $_SESSION['sqlBrowseRecipe'] . "<-";
        if (empty($_SESSION['sqlBrowseRecipe'])) {
          //leave
          return;
        }
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          //if sent here with meal info

          $Meal_Id = $_GET['mId'];
          $browsing = $_GET['b'];
          $inMeal = array("");
          $inMyStuff = array("");
          //make array of all meals i dont have
          if ( $browsing ) {
            $sqlInMyStuff = "SELECT `Recipe_Id` FROM `Project_Database`.`USER_RECIPES` WHERE `User_Id` = '$uID';";
            $inMyStuffResult = $db->query($sqlInMyStuff);
            if ( $inMyStuffResult->num_rows > 0  ){
              while ( $row = $inMyStuffResult->fetch_assoc() ) { array_push($inMyStuff, $row['Recipe_Id']); }
            }
          } else // ya this is supposed to be here
          //make array of all recipes in that meal
          if ( $Meal_Id <> NULL ) {
            $sqlInMeal = "SELECT `MEAL_CONTAINS`.`Recipe_Id` FROM `Project_Database`.`MEAL_CONTAINS` WHERE `Meal_Id` = '$Meal_Id';";
            $inMealResult = $db->query($sqlInMeal);
            if ( $inMealResult->num_rows > 0  ){
              while ( $row = $inMealResult->fetch_assoc() ) { array_push($inMeal, $row['Recipe_Id']); }
            }
          }
          //end of that part
          while ( $row = $res->fetch_assoc() ) {
            $id = $row['Recipe_Id'];
            $name = $row['Name'];
            $prep = $row['PrepTime'];
            #cooktime
            $rating = $row['Rating'];
            $instructions = $row['Instructions'];
            $ingredients = "";
            //add the ingredients to recipes
            $sql = "SELECT * FROM `Project_Database`.`RECIPE_CONTAINS` WHERE RECIPE_ID = '$id';";
            $qur = $db->query($sql);
            if ( $qur->num_rows > 0 ) {
              if ($row = $qur->fetch_assoc()) //add the first one
                $ingredients = $ingredients . $row['Ingredient'];
              while ( $row = $qur->fetch_assoc() ) {
                $ingredients = $ingredients . ", " . $row['Ingredient'];
              }
            }//end of adding ingredients

            if ($Meal_Id <> NULL) {
              if (!in_array($id,$inMeal)) { //in is an array holding the recipe contained in given meal
                $style = '';
              } else {
                $style = 'background-color:rgba(0,0,0,0.6)';  //make included recipes stand out
              }
              echo "<tr onClick=\"toggleInMeal($Meal_Id, $id)\" style=\"$style\">
                <td>$name</td>
                <td style=\"text-align:center;\">$prep Minutes</td>
                <td style=\"text-align:center;\">$rating Stars</td>
                <td>$instructions</td>
                <td>$ingredients</td>
                </tr>";
            } else {
              if ( $browsing ){
                if (!in_array($id, $inMyStuff)) { //in is an array holding my meals
                  $mine = '<img src="../resources/notMine_light.png" alt=" " style="width:24px;height:24px;border:0">';
                } else {
                  $mine = '<img src="../resources/mine_light.png" alt="X" style="width:24px;height:24px;border:0">';  //make my meals stand out
                }//<td style=\"width:26px\">$mine</td>
              } else $mine = '';
              $onClick = ($browsing)? "toggleUser($id)":"location.href = '../edit/recipe.php?rId=$id'";
              $col = ($browsing)? '':'colspan="2"';
              $extra = ($browsing)? "<td style=\"width:26px\">$mine</td>":"";
              echo "
              <tr onClick=\"$onClick\">
                $extra
                <td $col>$name</td>
                <td style=\"text-align:center;\">$prep Minutes</td>
                <td style=\"text-align:center;\">$rating Stars</td>
                <td>$instructions</td>
                <td>$ingredients</td>
                </tr>";
            }
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>

    </table>
  </body>
</html>
