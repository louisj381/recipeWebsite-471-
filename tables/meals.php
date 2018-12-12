<?php
  ob_start();
  session_start();
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO: add meals to database, make browse flag so peeps can add recipes/meals to their list easily
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
  //// TODO:
 ?>

<html>
  <head>
    <link rel="stylesheet" href="../styles/body_styles.css">
    <link rel="stylesheet" href="../styles/table_styles.css">
  </head>
  <script javascript>
    function toggleInMealPlan( meal, mealPlan ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "toggle/mealPlan_meals.php?mpId=" + mealPlan + "&req=" + Math.random() + "&mId=" + meal);
      xhttp.send();
    }
  </script>
  <body>
    <table>
      <tr>
        <th colspan="2">Meal</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        //echo $uID;
        $MealPlan_Id = $_GET['mpId'];
        $sqlText = $_SESSION['sqlBrowseMeal'];
        if (empty($_SESSION['sqlBrowseMeal'])) {
          $sqlText = "SELECT * FROM `Project_Database`.`MEAL`;" ;
          //echo "<tr><td colspan=\"100%\">None</td></tr>";
          //return;
        }
        //$sqlText = "SELECT * FROM `Project_Database`.`MEAL`;" ;
        //echo $sqlText;
        //echo $MealPlan_Id;
        $res = $db->query($sqlText);
        //echo $db->error;
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Meal_type'];
            $id = $row['Meal_Id'];
            if ($MealPlan_Id == NULL) {
              echo "
              <tr onClick=\"location.href = '../edit/meal.php?mId=$id'\">
                <td colspan=\"100%\">$name</td>
              </tr>"; //maybe include tags in this
            } else {
              echo "
              <tr>
                <td><button class=\"smallButton\" onClick=\"location.href = '../edit/meal.php?mId=$id&mpId=$MealPlan_Id'\">Edit</button></td>
                <td onClick=\"toggleInMealPlan($id,$MealPlan_Id);\">$name</td>
              </tr>"; //maybe include tags in this
            }
          }
        } else {
          echo "<tr><td>None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
