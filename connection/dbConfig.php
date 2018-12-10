<!--the information for the server connection--->
<?php

  define('DB_SERVER', 'cpsc471-project-instance.ceecwhryx0kc.us-east-2.rds.amazonaws.com');
  define('DB_USERNAME', 'masterUser');
  define('DB_PASSWORD', 'masterPassword');
  define('DB_DATABASE', 'Project_Database');
  $root = dirname(__DIR__);

  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  $_SESSION['connection'] = $db;
  $_SESSION['root'] = $root;
  // Check connection
  if (mysqli_connect_errno($db))
  {
   echo "Failed to connect to our MySQL Server: " . mysqli_connect_error();
  }
  //echo "-->" . $root . "<--";
?>
