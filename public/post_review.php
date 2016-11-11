<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'connectDB.php';

  $username = mysqli_real_escape_string($con, $_POST['username']);
  $desc = mysqli_real_escape_string($con, $_POST['review']);
  $id = mysqli_real_escape_string($con, $_POST['biz_id']);
  $rating = mysqli_real_escape_string($con, $_POST['rating']);
  $date = date('Y-m-d H:i:s');

  $insertReview = "INSERT INTO review(review_username, review_desc, review_rating, review_created_at, review_biz) VALUES (?, ?, ?, ?, ?)";

  $stmt = $con->prepare($insertReview);
  $stmt->bind_param('ssdsi', $username, $desc, $rating, $date, $id);
  $stmt->execute();

  $stmt->close();
  $con->close();
  header('location: ' . $root2 . 'biz/?id=' . $id);
?>
