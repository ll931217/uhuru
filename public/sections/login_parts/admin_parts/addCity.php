<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public";
  include $root . 'connectDB.php';

  $cname = mysqli_real_escape_string($con, $_POST['cname']);
  $clat = mysqli_real_escape_string($con, $_POST['cLat']);
  $clong = mysqli_real_escape_string($con, $_POST['cLong']);
  $checkIfExists = "SELECT * FROM city WHERE city_latitude = ? AND city_longitude = ?";
  $addCity = "INSERT INTO city(city_name, city_latitude, city_longitude) VALUE (?, ?, ?)";

  $stmt = $con->prepare($checkIfExists);
  $stmt->bind_param('dd', $clat, $clong);
  $stmt->execute();
  $results = $stmt->get_result();

  if ($results->num_rows > 0) {
    $row = $results->fetch_assoc();
    $error = join('_', explode(' ', $row['city_name'] . ' already has these coordinates'));
    header("location: " . $root2 . "?error={$error}#error");
  }

  $stmt->close();

  $stmt = $con->prepare($addCity);
  $stmt->bind_param('sdd', $cname, $clat, $clong);
  $stmt->execute();
  $stmt->close();

  header("location: " . $root2 . "?status=City_added#login");
?>
