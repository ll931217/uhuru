<?php
  $host = "localhost";
  $username = "shifu";
  $password = "eRL14kMf";
  $dbName = "bob_db";

  //Creating the connection to mysqli
  $con = new mysqli($host, $username, $password, $dbName);

  //Check if connected
  if ($con->connect_error) {
    die("Connection error: " . $con->connect_error);
  }
?>
