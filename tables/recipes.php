<?php
  ob_start();
  session_start();
 ?>

<html>
  <head>
    <link rel="stylesheet" href="../styles/body_styles.css">
    <link rel="stylesheet" href="../styles/table_styles.css">
  </head>
  <body>
    <table>
      <tr>
        <!-- <th style="width:auto;">ID</th> -->
        <th>Recipe</th>
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
            }
            //<td>$id</td>
            echo "
            <tr onClick=\"location.href = '../edit/recipe.php?rId=$id'\">

              <td>$name</td>
              <td style=\"text-align:center;\">$prep Minutes</td>
              <td style=\"text-align:center;\">$rating Stars</td>
              <td>$instructions</td>
              <td>$ingredients</td>
              </tr>";
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>

    </table>
  </body>
</html>
