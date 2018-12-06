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
        <th>Recipe</th>
        <th>PrepTime</th>
        <!-- <th>CookTime</th> -->
        <th>Rating</th>
        <th>Instructions</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = "SELECT * FROM RECIPE;";
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Name'];
            $prep = $row['PrepTime'];
            #cooktime
            $rating = $row['Rating'];
            $instructions = $row['Instructions'];
            echo "
            <tr>
             <td>$name</td>
             <td>$prep</td>
             <td>$rating</td>
             <td>$instructions</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
