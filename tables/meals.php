<?php
  ob_start();
  session_start();
  //// TODO: make browse flag so peeps can add recipes/meals to their list easily

  function printBrowse( $name, $id, $inMyStuff ) {
    if (!in_array($id, $inMyStuff)) { //in is an array holding my meals
      $mine = '<img src="../icons/notMine_light.png" alt=" " style="width:24px;height:24px;border:0">';
    } else {
      $mine = '<img src="../icons/mine_light.png" alt="X" style="width:24px;height:24px;border:0">';  //make my meals stand out
    }
    echo "
    <tr onClick=\"toggleUser($id)\">
      <td style=\"width:26px\">$mine</td>
      <td>$name</td>
    </tr>"; //maybe include tags in this
  }

  function printReg( $name ) {
    echo "
    <tr onClick=\"location.href = '../edit/meal.php?mId=$id'\">
      <td colspan=\"100%\">$name</td>
    </tr>"; //maybe include tags in this
  }

  function printToggle($name, $id, $inMealPlan, $MealPlan_Id) {
    if (!in_array($id,$inMealPlan)) { //in is an array holding the meals contained in given mealplan
      $style = '';
    } else {
      $style = 'background-color:rgba(0,0,0,0.6)';  //make included meals stand out
    }
    echo "
    <tr style=\"$style\">
      <td><button class=\"smallButton\" onClick=\"location.href = '../edit/meal.php?mId=$id&mpId=$MealPlan_Id'\">Edit</button></td>
      <td onClick=\"toggleInMealPlan($id,$MealPlan_Id);\">$name</td>
    </tr>"; //maybe include tags in this
  }
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

    function toggleUser( meal ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          //location.reload();
        }
      };
      xhttp.open("GET", "add/meal.php?mId=" + meal + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table>
      <tr>
        <th colspan="100%">Meal</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        //echo $uID;
        $MealPlan_Id = $_GET['mpId'];
        $sqlText = $_SESSION['sqlBrowseMeal'];
        $browsing = $_GET['b'];

        if (empty($_SESSION['sqlBrowseMeal'])) {
          $sqlText = "SELECT * FROM `Project_Database`.`MEAL`;" ;
        }

        $res = $db->query($sqlText);

        if ( $res->num_rows > 0 ) {
          $inMyStuff = array("");
          $inMealPlan = array("");
          //make array of all meals i dont have
          if ( $browsing ) {
            $sqlInMyStuff = "SELECT `Meal_Id` FROM `Project_Database`.`USER_MEALS` WHERE `User_Id` = '$uID';";
            $inMyStuffResult = $db->query($sqlInMyStuff);
            if ( $inMyStuffResult->num_rows > 0  ){
              while ( $row = $inMyStuffResult->fetch_assoc() ) { array_push($inMyStuff, $row['Meal_Id']); }
            }
          } else // ya this is supposed to be here
          //end of that part
          //make array of all recipes in that meal
          if ( $MealPlan_Id <> NULL ) {
            $sqlInMealPlan = "SELECT `MEAL_PLAN_CONTAINS`.`Meal_Id` FROM `Project_Database`.`MEAL_PLAN_CONTAINS` WHERE `MealPlan_Id` = '$MealPlan_Id';";
            $inMealPlanResult = $db->query($sqlInMealPlan);
            if ( $inMealPlanResult->num_rows > 0  ){
              while ( $row = $inMealPlanResult->fetch_assoc() ) { array_push($inMealPlan, $row['Meal_Id']); }
            }
          }
          //end of that part

          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Meal_type'];
            $id = $row['Meal_Id'];
            if ($browsing) {
              printBrowse($name, $id, $inMyStuff);
            } else if ($MealPlan_Id == NULL) {
              printReg($name);
            } else {
              printToggle($name, $id, $inMealPlan, $MealPlan_Id);
            }
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
