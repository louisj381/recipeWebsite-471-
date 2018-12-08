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
        <th>Unit</th>
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
            $unit = $row['unit'];
            echo "
            <tr onClick=\"location.href = '../edit/Ingredient.php?rId=$id'\">
             <td style=\"text-align:left;width:80%;\">$ingredient</td>
             <td style=\"text-align:center;width:7%;\">$number</td>
             <td style=\"width:13%;\">$unit</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
