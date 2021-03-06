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
        <th>Dependants</th>
        <th>Your</th>
        <th>Allergy Count</th>
      </tr>
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
            <tr onClick=\"location.href = '../edit/dependant.php?d=$name'\">
             <td style=\"width:50%;\">$name</td>
             <td style=\"width:30%;\">$relationship</td>
             <td style=\"width:20%;\">$allergies</td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
