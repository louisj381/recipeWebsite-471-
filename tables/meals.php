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
        <th>Meal</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = $_SESSION['sqlBrowseMeal'];
        $res = $db->query($sqlText);
        if (empty($_SESSION['sqlBrowseMeal'])) {
          //do nothing
        }elseif ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Meal_type'];
            echo "
            <tr>
             <td>$name</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
