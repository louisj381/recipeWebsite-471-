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
        <th>Meal Plan</th>
        <th># Meals</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = $_SESSION['sqlMealPlan'];
        if (empty($_SESSION['sqlMealPlan'])) {
          //leave
          return;
        }
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = ucwords($row['Name']);
            $id = $row['MealPlan_Id'];
            $nMeals = $row['NumberOfMeals'];
            echo "
            <tr onClick=\"location.href = '../edit/mealPlan.php?mpId=$id'\">
             <td style=\"width:85%\">$name</td>
             <td style=\"width:15%\">$nMeals</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
