<?php
  ob_start();
  session_start();
  include("../connection/dbConfig.php");
  $userID = $_SESSION['user_id'];
  //echo $userID;

  $sql = "SELECT * FROM DEPENDANTS";
  $result = mysqli_query($db,$sql);

  while ($row = mysql_fetch_assoc($result)) {
      print_r($row);
      // do stuff with $row
  }

 ?>


<html>
<head>
  <title>Guestbook</title>
</head>
<body>
    <header>
      <text><b>Your Dependants</b></text>
    </header>
    <textarea name="comment" rows="10" cols="60"></textarea>
    <header>
      <text><b>Their Allergies</b></text>
    </header>
    <textarea name="comment" rows="10" cols="60"></textarea>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
      <button class="btn" style="float:right" onclick="">Add</button>
      <button class="btn" style="float:right" >Edit</button>
      <button class="btn" style="float:right" >Remove</button>
   </form>


</body>
</html>
