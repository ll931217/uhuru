<?php
  $con = new mysqli("localhost", "root", "");
  $createUser = "CREATE USER 'shifu'@'localhost' IDENTIFIED BY 'eRL14kMf'";
  if ($con->query($createUser) === true) {
    echo "SUCCESS: Created user 'shifu'!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $grantPriv = "GRANT ALL PRIVILEGES ON bob_db.* TO 'shifu'@'localhost'";
  if ($con->query($grantPriv) === true) {
    echo "SUCCESS: Privileges Granted to shifu!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }
  $con->close();
?>
