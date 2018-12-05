<!the information for the server connection>
<?php
  define('DB_SERVER', 'cpsc471-project-instance.ceecwhryx0kc.us-east-2.rds.amazonaws.com');
  define('DB_USERNAME', 'masterUser');
  define('DB_PASSWORD', 'masterPassword');
  define('DB_DATABASE', 'Project_Database');

  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
  if(mysqli_connect_errno($db))
  {
    echo "Failed to connect to database:".mysqli_connect_error();
  }
?>
