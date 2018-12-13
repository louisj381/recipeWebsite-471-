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
    <table id=fancyTable>
      <tr>
        <th>Name</th>
        <th>Number of Meals</th>
      </tr>
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];

        $channelName = $_SESSION['channel'];
        $sqlText = "SELECT `MealPlanID` FROM CHANNEL_CONTAINS WHERE ChannelName = '$channelName';";
        $res = $db->query($sqlText);
        $row = $res->fetch_assoc();
        $Meal_Id = $row['MealPlanID'];
        $sqlText = "SELECT * FROM MEAL_PLAN WHERE MealPlan_Id = '$Meal_Id';";
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Name'];
            $count = $row['NumberOfMeals'];
            echo "
            <tr>
             <td style=\"width:50%;\">$name</td>
             <td style=\"width:50%;\">$count</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
