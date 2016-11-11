<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  header("Content-Type: application/json");
  include $root . "connectDB.php";
  $selectCity = "SELECT * FROM city";
  $datas = "";
  $x = 0;
  $result = $con->query($selectCity);
  while ($row = $result->fetch_assoc()) {
    $datas[$x] = array("id" => $row['city_id'], "name" => $row["city_name"], "latitude" => $row["city_latitude"], "longitude" => $row["city_longitude"]);
    $x++;
  }
  echo json_encode($datas);
?>
