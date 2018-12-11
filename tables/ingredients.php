<?php
  ob_start();
  session_start();

  function printTogglable($row, $rec, $in, $db) {
    $ingredient = $row['Ingredient'];
    $number = $row['count'];
    $unit = $row['unit'];
    if (!in_array($ingredient,$in)) {
      $style = '';
    } else {
      $style = 'background-color:rgba(0,0,0,0.6)';
    }
    $sqlText = "SELECT * FROM RECIPE_CONTAINS WHERE Recipe_Id = '$rec' AND Ingredient = '$ingredient' ;";
    $iInfo = $db->query($sqlText);
    $irow = $iInfo->fetch_assoc();
    $number = $irow['Quantity'];
    $unit = $irow['Unit'];
    echo "
    <tr style=\"$style\">
      <td><button class=\"smallButton\" onClick=\"location.href = '../edit/ingredient.php?rId=$rec&i=$ingredient'\">Edit</button></td>
      <td onClick=\"toggleInRecipe($rec,'$ingredient')\" style=\"text-align:left;width:80%;\">$ingredient</td>
      <td onClick=\"toggleInRecipe($rec,'$ingredient')\" style=\"text-align:center;width:7%;\">$number</td>
      <td onClick=\"toggleInRecipe($rec,'$ingredient')\" style=\"width:13%;\">$unit</td>
    </tr>";
  }
  function printRegular($row) {
    $ingredient = $row['Ingredient'];
    $number = $row['count'];
    $unit = $row['unit'];
    echo "
    <tr onClick=\"location.href = '../edit/ingredient.php?i=$ingredient'\">
     <td style=\"text-align:left;width:80%;\" colspan=\"2\">$ingredient</td>
     <td style=\"text-align:center;width:7%;\">$number</td>
     <td style=\"width:13%;\">$unit</td>
    </tr>";
  }



 ?>
<html>
<script javascript>
  function toggleInRecipe( recipe, ingredient ) {
    var xhttp = new XMLHttpRequest(); //sends a message to server in background
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) { //received response AND respons is ok (200)
        //var response = this.responseText;
        console.log(this.responseText); //prints echos and text output of target php is sent to console
        location.reload();
      }
    };
    // req : request, prevents the browser fromcaching the page-> ensures server updates
    xhttp.open("GET", "toggle/recipe_ingredients.php?rID=" + recipe + "&req=" + Math.random() + "&iName=" + ingredient);
    xhttp.send();
  }
</script>
  <head>
    <link rel="stylesheet" href="../styles/body_styles.css">
    <link rel="stylesheet" href="../styles/table_styles.css">
  </head>
  <body>
    <table>
      <tr>
        <th></th>
        <th>Ingredient</th>
        <th>Number</th>
        <th>Unit</th>
      </tr>
      <!-- next rows -->
      <?php
        $rId = $_GET['rId'];
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        //to get the ingredients for this user
        $sqlText = "SELECT * FROM USER_INGREDIENTS WHERE User_Id =" . $uID .";";
        $res = $db->query($sqlText);

        //copy the ingredients in the thing into an array to check later
        $inRecipe = array("");
        if ( !($rId == NULL) ) {
          $sqlInRecipe = "SELECT `RECIPE_CONTAINS`.`Ingredient` FROM `Project_Database`.`RECIPE_CONTAINS`
                          WHERE `Recipe_Id` = '$rId';";
          $inRecipeResult = $db->query($sqlInRecipe);
          if ( $inRecipeResult->num_rows > 0  ){
            while ( $row = $inRecipeResult->fetch_assoc() ) {
              array_push($inRecipe, $row['Ingredient']);
            }
          }
        }
        if ( $res->num_rows > 0 ) {
          while ( $row = $res->fetch_assoc() ) {
            if ( ($rId == NULL) ){
              printRegular($row);
            } else {
              printTogglable($row, $rId, $inRecipe, $db);
            }
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
