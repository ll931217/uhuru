<?php $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
$root2 = "/uhuru/public"; ?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Description</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <form class="form-horizontal" method="post">
          <div class="form-group">
            <div class="col-md-12">
              <textarea rows="10" name="bizDesc" class="form-control" id="desc"><?php echo $bizDesc; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary pull-right" name="updateDesc">Update Description</button>
            </div>
          </div>
        </form>
        <?php
          if (isset($_POST['updateDesc'])) {
            $desc = mysqli_real_escape_string($con, $_POST['bizDesc']);
            $updateBizDesc = "UPDATE biz SET biz_description = ? WHERE biz_id = ?";
            $error = 0;
            if (!($stmt = $con->prepare($updateBizDesc))) {
              echo "Prepare failed: (" . $con->errno . ") " . $con->error;
              $error++;
            }

            if (!$stmt->bind_param('si', $desc, $bizID)) {
              echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
              $error++;
            }

            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
              $error++;
            }

            $stmt->close();
            if ($error == 0) {
              header('location: ' . $root2 . '?status=Updated_business_description#login');
            }
          }
        ?>
      </div>
    </div>
  </div>
</div>
