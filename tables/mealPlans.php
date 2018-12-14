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
    function toggleUser( mealPlan) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "add/mealPlan.php?mpId=" + mealPlan + "&req=" + Math.random());
      xhttp.send();
    }
    function toggleChannel( mealPlan, channel) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          //var response = this.responseText;
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "add/mealPlan.php?mpId=" + mealPlan + "&cId=" + channel + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table>
      <tr>
        <th colspan="2">Meal Plan</th>
        <th># Meals</th>
      </tr>
      <!-- next rows -->
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $sqlText = $_SESSION['sqlMealPlan'];
        $browsing = $_GET['b'];
        $cId = $_GET['cId'];

        if (empty($_SESSION['sqlMealPlan'])) {
          $sqlText = "SELECT * FROM `Project_Database`.`MEAL_PLAN`;";
        }
        //echo $sqlText;
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          $inMyStuff = array("");
          //make array of all meals i dont have
          if ( $browsing ) {
            $select = 'MealPlan_Id';
            $sqlInMyStuff = "SELECT `$select` FROM `Project_Database`.`USER_MEAL_PLANS` WHERE `User_Id` = '$uID';";
            $inMyStuffResult = $db->query($sqlInMyStuff);
            if ( $inMyStuffResult->num_rows > 0  ){
              while ( $row = $inMyStuffResult->fetch_assoc() ) { array_push($inMyStuff, $row[$select]); }
            }
          } else if ($cId <> NULL) { //for channels
            $sqlInMyStuff = "SELECT `MealPlanID` FROM `Project_Database`.`CHANNEL_CONTAINS` WHERE `ChannelName` = '$cId';";
            //echo $sqlInMyStuff;
            $inMyStuffResult = $db->query($sqlInMyStuff);
            if ( $inMyStuffResult->num_rows > 0  ){
              while ( $row = $inMyStuffResult->fetch_assoc() ) { array_push($inMyStuff, $row['MealPlanID']); }
            }
          }
          while ( $row = $res->fetch_assoc() ) {
            $name = ucwords($row['Name']);
            $id = $row['MealPlan_Id'];
            $nMeals = $row['NumberOfMeals'];
            if ( $browsing || $cId <> NULL){
              if (!in_array($id, $inMyStuff)) { //in is an array holding my meals
                $mine = '<img src="../resources/notMine_light.png" alt=" " style="width:24px;height:24px;border:0">';
              } else {
                $mine = '<img src="../resources/mine_light.png" alt="X" style="width:24px;height:24px;border:0">';  //make my meals stand out
              }//<td style=\"width:26px\">$mine</td>
              $onClick = ($browsing)? "toggleUser($id)":"toggleChannel($id,'$cId')";
              echo "
              <tr onClick=\"$onClick\">
                <td style=\"width:26px\">$mine</td>
                <td style=\"width:85%\">$name</td>
                <td style=\"width:15%\">$nMeals</td>
              </tr>";
            } else {
              echo "
              <tr onClick=\"location.href = '../edit/mealPlan.php?mpId=$id'\">
               <td style=\"width:85%\" colspan=\"2\">$name</td>
               <td style=\"width:15%\">$nMeals</td>
              </tr>";
            }
          }
        } else {
          echo "<tr><td colspan=\"100%\">None</td></tr>";
        }
      ?>
    </table>
  </body>
</html>
