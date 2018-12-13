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
    function toggleUser( mealPlan) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          //location.reload();
        }
      };
      xhttp.open("GET", "add/mealPlan.php?mpId=" + mealPlan + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table>
      <tr>
        <th>Meal Plan</th>
        <th># Meals</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = $_SESSION['sqlMealPlan'];
        $browsing = $_GET['b'];

        if (empty($_SESSION['sqlMealPlan'])) {
          $sqlText = "SELECT * FROM `Project_Database`.`MEAL_PLAN`;";
        }

        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = ucwords($row['Name']);
            $id = $row['MealPlan_Id'];
            $nMeals = $row['NumberOfMeals'];
            if ($browsing == true){
              echo "
              <tr onClick=\"toggleUser($id)\">
               <td style=\"width:85%\">$name</td>
               <td style=\"width:15%\">$nMeals</td>
              </tr>";
            } else {
              echo "
              <tr onClick=\"location.href = '../edit/mealPlan.php?mpId=$id'\">
               <td style=\"width:85%\">$name</td>
               <td style=\"width:15%\">$nMeals</td>
              </tr>";
            }
          }
        } else {
          echo "<tr><td>None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
