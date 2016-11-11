<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  header("Content-Type: application/json");
  include $root . "connectDB.php";
  $selectSectors = "SELECT * FROM sector";
  $datas = "";
  $x = 0;
  $result = $con->query($selectSectors);
  while ($row = $result->fetch_assoc()) {
    $datas[$x] = array("id" => $row['sector_id'], "name" => $row["sector_name"]);
    $x++;
  }
  echo json_encode($datas);
?>
