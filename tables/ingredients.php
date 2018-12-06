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
        <th>Ingredient</th>
        <th>Number</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = "SELECT * FROM USER_INGREDIENTS WHERE User_Id =" . $uID .";";
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $ingredient = $row['Ingredient'];
            $number = $row['count'];
            echo "
            <tr>
             <td style=\"text-align:left;\">$ingredient</td>
             <td style=\"text-align:center;\">$number</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
