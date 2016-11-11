<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'connectDB.php';

  $id = mysqli_real_escape_string($con, $_POST['bizID']);
  $name = mysqli_real_escape_string($con, $_POST['bizName']);
  $logo = mysqli_real_escape_string($con, $_POST['bizLogo']);

  $basename = join('_', explode(' ', $name));
  $dir = $root . 'images/biz_pics/' . $basename;
  $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
  $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
  foreach($files as $file) {
      if ($file->isDir()){
          rmdir($file->getRealPath());
      } else {
          unlink($file->getRealPath());
      }
  }
  rmdir($dir);
  echo 'Directory and its contents deleted';

  if (!unlink($root . 'images/biz_logos/' . $logo)) {
    echo 'Error deleting logo';
  } else {
    echo 'Logo deleted';
  }

  $deleteBiz = "DELETE FROM biz WHERE biz_id = ?";
  $deleteOwner = "DELETE FROM owner WHERE owner_biz = ?";

  $stmt = $con->prepare($deleteBiz);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  $stmt = $con->prepare($deleteOwner);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  header("location: " . $root2 . "?deleteStatus=Business_and_Owner_deleted");
?>
