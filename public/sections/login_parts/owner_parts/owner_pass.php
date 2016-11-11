<?php $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
$root2 = "/uhuru/public"; ?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Change your password</h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" method="post">
      <div class="form-group">
        <label for="inputOldPass" class="col-md-4 control-label">Enter old password:</label>
        <div class="col-md-7">
          <input type="password" class="form-control" name="oldPass" id="inputOldPass" />
        </div>
      </div>
      <div class="form-group">
        <label for="inputNewPass" class="col-md-4 control-label">Enter new password:</label>
        <div class="col-md-7">
          <input type="password" class="form-control" name="newPass" id="inputNewPass" />
        </div>
      </div>
      <div class="form-group">
        <label for="inputNewPass2" class="col-md-4 control-label">Re-enter new password:</label>
        <div class="col-md-7">
          <input type="password" class="form-control" name="newPass2" id="inputNewPass2" />
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-11">
          <button type="submit" class="btn btn-warning pull-right" name="butChange">Change password</button>
        </div>
      </div>
    </form>
    <?php
      if (isset($_POST['butChange'])) {
        if ($_POST['newPass'] == $_POST['newPass2']) {
          $oldPass = mysqli_real_escape_string($con, $_POST['oldPass']);
          $newPass = mysqli_real_escape_string($con, $_POST['newPass']);
          $newPass2 = mysqli_real_escape_string($con, $_POST['newPass2']);
          $correct = false;

          $getHashedPass = "SELECT owner_password FROM owner WHERE owner_email = ?";

          if (!($stmt = $con->prepare($getHashedPass))) {
            echo "Prepare failed: (" . $con->errno . ") " . $con->error;
          }
          if (!$stmt->bind_param('s', $ownerEmail)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }
          $results = $stmt->get_result();
          if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            $DBPass = $row['owner_password'];
            if (password_verify($oldPass, $DBPass)) {
              $correct = true;
            } else {
              header("location: " . $root2 . "?error=Your_old_password_is_incorrect#login");
            }
          }

          $stmt->close();

          if ($correct) {
            $updatePass = "UPDATE owner SET owner_password = ? WHERE owner_email = ?";
            $error = 0;
            include $root . 'layout/hasher.php';

            $hasher = new HashPassword();
            $hashed = $hasher->Hash($newPass);

            if (!($stmt = $con->prepare($updatePass))) {
              echo "Prepare failed: (" . $con->errno . ") " . $con->error;
              $error++;
            }
            if (!$stmt->bind_param('ss', $hashed, $ownerEmail)) {
              echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
              $error++;
            }
            if (!$stmt->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
              $error++;
            }

            $stmt->close();
            if ($error == 0) {
              header("location: " . $root2 . "?status=Password_changed#login");
            }
          }
        } else {
          header("location: " . $root2 . "?error=Your_two_new_passwords_don't_match#login");
        }
      }
    ?>
  </div>
</div>
