<?php
  if (is_ajax()) {
    if (isset($_POST['cityName']) && !empty($_POST['cityName'])) {
      $city = $_POST['cityName'];
      getSectors($city);
    }
  }

  function is_ajax() {
  	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  }

  function getSectors($cname) {
    $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
    $root2 = "/uhuru/public/";
    include $root . "connectDB.php";
    $retrieveSectors = "SELECT * FROM sector";
    $result = $con->query($retrieveSectors);
    $z = 0;
    $data = "";

    while ($secRow = $result->fetch_assoc()) {
      $secName = $secRow['sector_name'];
      $secCountCity = "SELECT COUNT(*) AS total FROM sector, city, biz WHERE sector.sector_id = biz.biz_sector AND biz.biz_city = city.city_id AND city.city_name = '$cname' AND sector.sector_name = '$secName'";

      $countRes = $con->query($secCountCity);
      $count = $countRes->fetch_assoc();

      $data[$z] = array(
        "sector_name" => $secName,
        "sector_count" => $count['total']
      );

      $z++;
    }
    $con->close();
    echo json_encode($data);
  }
?>
