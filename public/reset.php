<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/navi.php';
  include $root . 'layout/hasher.php';
  include $root . 'send.php';

  $token = $_REQUEST['token'];
?>
<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <?php
          if (isset($_POST['butReset'])) {
            $new = mysqli_real_escape_string($con, $_POST['newPass']);
            $conP = mysqli_real_escape_string($con, $_POST['conPass']);
            $id = mysqli_real_escape_string($con, $_POST['owner_id']);
            $fname = mysqli_real_escape_string($con, $_POST['owner_fname']);
            $lname = mysqli_real_escape_string($con, $_POST['owner_lname']);
            $email = mysqli_real_escape_string($con, $_POST['owner_email']);
            if ($new === $conP) {
              $updatePass = "UPDATE owner SET owner_password = ? WHERE owner_id = ?";
              $hasher = new HashPassword();
              $hashed = $hasher->Hash($new);

              $stmt = $con->prepare($updatePass);
              $stmt->bind_param('si', $hashed, $id);
              $stmt->execute();
              $stmt->close();

              $fromEmail = 'uhuru753@gmail.com';
              $fromName = 'Uhuru Economic Network';
              $toEmail = $email;
              $toName = $fname . ' ' . $lname;
              $subject = 'Password resetted';
              $message = 'Your new password: ' . $new;

              $sendMail = new SendMail();
              $sendMail->send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, $redirect, $redirectError);
              header("location: " . $root2);
            } else {
              ?>
              <p class="error text-danger bg-warning">The passwords does not match</p>
              <?php
            }
          } else {
            $getTokenData = "SELECT token.token_created_at, owner.owner_id, owner.owner_fname, owner.owner_lname, owner.owner_email FROM token, owner WHERE token.token_content = '{$token}' AND token.token_owner = owner.owner_id";
            $result = $con->query($getTokenData);
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $createdAt = $row['token_created_at'];
              $fname = $row['owner_fname'];
              $lname = $row['owner_lname'];
              $ownerID = $row['owner_id'];
              $ownerEmail = $row['owner_email'];
              $hour = 3600;
              if ($_SERVER['REQUEST_TIME'] - $createdAt > $hour) {
                ?>
                <p class="error text-danger bg-warning">The period in which you can reset your password has expired, click <a href="<?php echo $root2 . 'forgot_password'; ?>">here</a> to send another link</p>
                <?php
              } else {
                ?>
                <div class="row">
                  <form class="form-horizontal" method="post">
                    <input type="hidden" name="owner_id" value="<?php echo $ownerID; ?>">
                    <input type="hidden" name="owner_email" value="<?php echo $ownerEmail; ?>">
                    <input type="hidden" name="owner_fname" value="<?php echo $ownerFname; ?>">
                    <input type="hidden" name="owner_lname" value="<?php echo $ownerLname; ?>">
                    <div class="form-group">
                      <label for="inputNewPass" class="col-md-4 control-label">New Password:</label>
                      <div class="col-md-8">
                        <input type="password" name="newPass" id="inputNewPass" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputConPass" class="col-md-4 control-label">Re-enter Password:</label>
                      <div class="col-md-8">
                        <input type="password" name="conPass" id="inputConPass" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn btn-default" name="butReset">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>
                <?php
              }
            } else {
              header('location: ' . $root2);
            }
          }
        ?>
      </div>
    </article>
  </section>
</main>
<?php
  include $root . 'layout/footer.php';
?>
