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
    function remove( allergy, dName ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "toggle/allergy.php?d=" + dName + "&a=" + allergy + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table id=fancyTable>
      <tr>
        <th>&nbsp;</th>
        <th>Allergen</th>
        <th>Severity</th>
      </tr>
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $dName = $_GET['d'];

        $sqlText = "SELECT * FROM `ALLERGY` WHERE `User_Id` ='$uID' AND `Dep_name`='$dName';";
        //echo $sqlText;
        $res = $db->query($sqlText);

        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            $name = $row['Allergy'];
            $sev = $row['Severity']; //check this
            echo "
            <tr>
              <td><button class=\"smallButton\" onClick=\"remove('$name','$dName')\">Remove</button></td>
              <td style=\"width:70%;\">$name</td>
              <td style=\"width:30%;\">$sev</td>
            </tr>";
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
