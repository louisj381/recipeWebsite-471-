<?php
  ob_start();
  session_start();
 ?>

<html>
  <head>
    <link rel="stylesheet" href="../styles/table_styles.css">
  </head>
  <body>
    <table id=fancyTable>
      <tr>
        <th>Your</th>
        <th>Dependants</th>
      </tr>
      //next rows
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];

        $sqlText = "SELECT * FROM DEPENDANTS WHERE User_Id =" . $uID .";";
        //echo $sqlText;
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Name'];
            $relationship = $row['Relationship'];
            $allergies = $row['No-of_allergies']; //check this
            echo "
            <tr>
             <td>$name</td>
             <td>$relationship</td>
             <td>$allergies</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
