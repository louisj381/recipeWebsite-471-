<?php
  ob_start();
  session_start();
  
  $homepage = "./standardHomepage.php";
  if ($_SESSION['Curator_Flag'] == 1)
    $homepage = "./curatorHomepage.php";

  header("Location: $homepage");
  //this just handles all the pages i forgot to update the homepage of
 ?>
