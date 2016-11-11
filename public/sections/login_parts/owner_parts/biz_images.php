<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public";
  function is_dir_empty($dir) {
    if (!is_readable($dir)) return NULL;
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        return FALSE;
      }
    }
    return TRUE;
  }
?>

<div class="panel panel-primary" id="pics">
  <div class="panel-heading">
    <h3 class="panel-title">Images</h3>
  </div>
  <div class="panel-body">
    <div class="pics">
      <?php
        $location = join('_', explode(' ', $bizName));
        if (file_exists($root . 'images/biz_pics/' . $location)) { //Check if directory exists
          $images = glob($root . 'images/biz_pics/' . $location . '/*.{jpg,png}', GLOB_BRACE);
          if (!is_dir_empty($root . 'images/biz_pics/' . $location)) {
            echo '<p class="text-success">Pictures:</p>';
            echo '<ul class="list-inline">';
            foreach ($images as $image) {
              $img = $image;
              $image = strstr($image, $root2);
              ?>
              <li>
                <form class="form-horizontal" method="post">
                  <input type="hidden" name="imageName" value="<?php echo $img; ?>" />
                    <div class="form-group">
                      <div class="col-md-12 pic-container">
                        <img class="img-thumbnail" src="<?php echo $image; ?>" height="100" width="100" />
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-danger btn-block delete" name="deleteImg">Delete</button>
                      </div>
                    </div>
                </form>
              </li>
              <?php
            }
            echo '</ul>';
          } else {
            echo '<p class="text-danger">No pictures found</p>';
          }
        } else {
          echo '<p class="text-danger">No pictures found</p>';
        }
      ?>
    </div>
    <?php
      if (isset($_GET['picDel'])) {
        $status = join(' ', explode('_', $_GET['picDel']));
        ?>
        <p class="text-danger"><?php echo $status;?></p>
        <?php
      }
      if (isset($_POST['deleteImg'])) {
        $pic = $_POST['imageName'];
        if (!unlink($pic)) {
          header('location: ' . $root2 . '?picDel=Error_deleting_picture#pics');
        } else {
          header('location: ' . $root2 . '?picDel=Picture_deleted#pics');
        }
      }
    ?>
    <div class="panel panel-primary" id="uploadPic">
      <div class="panel-heading">
        <h3 class="panel-title">Upload a new picture</h3>
      </div>
      <div class="panel-body">
        <form class="form-inline" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <div class="col-md-4">
              <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
              <input type="file" name="pic" accept=".jpg, .png" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-4">
              <button class="btn btn-success pull-right" type="submit" name="butUpload">Upload</button>
            </div>
          </div>
          <div class="form-group">
            <p class="text-warning">(.jpg and .png files only)</p>
          </div>
        </form>
      </div>
    </div>
    <?php
    if (isset($_GET['upPic'])) {
      $status = join(' ', explode('_', $_GET['upPic']));
      ?>
      <p class="text-danger"><?php echo $status;?></p>
      <?php
    }
    if (isset($_POST['butUpload'])) {
      if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
        $basename = join('_', explode(' ', $bizName));
        $dir = $root . "images/biz_pics/" . $basename;

        $picName = $_FILES['pic']['name'];
        $picSize = $_FILES['pic']['size'];
        $picTmp = $_FILES['pic']['tmp_name'];
        $picType = $_FILES['pic']['type'];
        $picError = $_FILES['pic']['error'];

        if ($picSize > 2097152) {
          header("location: " . $root2 . "?upPic=File_exceeds_allowed_file_size#uploadPic");
        }

        chmod($dir . '/' . $picName, 0777);
        move_uploaded_file($picTmp, $dir . '/' . $picName);
        header("location: " . $root2 . "?upPic=File_uploaded_successfully#pics");
      } else {
        header("location: " . $root2 . "?upPic=File_not_uploaded_through_proper_procedures#uploadPic");
      }
    }
    ?>
  </div>
</div>
