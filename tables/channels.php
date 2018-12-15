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
    function toggleUser( channel ) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);//shows all echos and prints from target php in the console!
          location.reload();
        }
      };
      xhttp.open("GET", "add/channel.php?cId=" + channel + "&req=" + Math.random());
      xhttp.send();
    }
  </script>
  <body>
    <table id=fancyTable>
      <tr>
        <th colspan="2">Channel</th>
        <th>Created by</th>
        <th>Subscribers</th>
      </tr>
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];
        $browsing = $_GET['b'];

        $channelName = $_SESSION['channel'];
        $append = ($_GET['mine']<>'true')?"":" WHERE `Name` IN (SELECT `Channel` FROM `SUBSCRIPTIONS` WHERE `User_Id`='$uID')";
        $sqlText = "SELECT * FROM CHANNEL$append;";

        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
          //make array of all channels i am subbed to
          $inMyStuff = array("");
          if ( $browsing ) {
            $select = 'Channel';
            $sqlInMyStuff = "SELECT `$select` FROM `Project_Database`.`SUBSCRIPTIONS` WHERE `User_Id` = '$uID';";
            $inMyStuffResult = $db->query($sqlInMyStuff);
            if ( $inMyStuffResult->num_rows > 0  ){
              while ( $row = $inMyStuffResult->fetch_assoc() ) { array_push($inMyStuff, $row[$select]); }
            }
          }
          while ( $row = $res->fetch_assoc() ) {
            $channel = $row['Name'];
            $curID = $row['User_Id'];
            $sqlText = "SELECT `Screen_Name` FROM END_USER WHERE User_Id = $curID;";
            $result = $db->query($sqlText);
            $nextRow = $result->fetch_assoc();
            $screen_name = $nextRow['Screen_Name'];
            $sqlText = "SELECT * FROM `Project_Database`.`SUBSCRIPTIONS` WHERE `Channel` = '$channel';";
            @$result = mysqli_query($db,$sqlText);
            @$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            @$subscribers = mysqli_num_rows($result);
            if ( $browsing ){
              if (!in_array($channel, $inMyStuff)) { //in is an array holding my meals
                $mine = '<img src="../resources/notMine_light.png" alt=" " style="width:24px;height:24px;border:0">';
              } else {
                $mine = '<img src="../resources/mine_light.png" alt="X" style="width:24px;height:24px;border:0">';  //make my meals stand out
              }//<td style=\"width:26px\">$mine</td>
              echo "
              <tr onClick=\"toggleUser('$channel')\">
                <td style=\"width:26px;min-width:26px;\">$mine</td>
                <td style=\"width:50%;\">$channel</td>
                <td style=\"width:30%;\">$screen_name</td>
                <td style=\"width:20%;\">$subscribers</td>
              </tr>";
            } else {
              echo "
              <tr onClick=\"location.href = '../edit/channel.php?cId=$channel'\">
               <td colspan=\"2\"style=\"width:50%;\">$channel</td>
               <td style=\"width:30%;\">$screen_name</td>
               <td style=\"width:20%;\">$subscribers</td>
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
