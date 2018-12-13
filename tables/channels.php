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
        <th>Channel</th>
        <th>Created by</th>
        <th>Subscribers</th>
      </tr>
      <?php
        $root = "../";
        include($root . "connection/dbConfig.php");  //to access db
        $uID = $_SESSION['user_id'];

        $channelName = $_SESSION['channel'];
        $sqlText = "SELECT * FROM CHANNEL;";
        $res = $db->query($sqlText);
        if ( $res->num_rows > 0 ) {
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

            echo "
            <tr>
             <td style=\"width:50%;\">$channel</td>
             <td style=\"width:30%;\">$screen_name</td>
             <td style=\"width:20%;\">$subscribers</td>
            </tr>";
          }
        } else {
          echo "<tr><td>None</td><td></td></tr>";
        }
      ?>
    </table>
  </body>
</html>
