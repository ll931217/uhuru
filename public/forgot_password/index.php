<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/navi.php';
?>

<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <form class="form-horizontal" method="post">
          <div class="form-group">
            <label for="inputEmail" class="col-md-5 control-label">Enter the email you registered with:</label>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control" id="inputEmail" />
            </div>
          </div>
                  <!-- <div class="form-group">
                  <div class="col-md-offset-5 col-md-7">
                  <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
                </div>
              </div>
              <div class="form-group">
              <div class="col-md-offset-5 col-md-7">
              <input type="text" name="captcha_code" size="10" maxlength="6" />
              <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
            </div>
          </div> -->
          <div class="form-group">
            <div class="col-md-offset-5 col-md-5">
              <button type="submit" name="btnRecover" class="btn btn-default">Recover</button>
            </div>
          </div>
        </form>
        <?php
          include $root . 'send.php';
          if (isset($_POST['btnRecover'])) {
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $checkExists = "SELECT * FROM owner WHERE owner_email = '{$email}'";
            $result = $con->query($checkExists);
            if ($result->num_rows != 0) {
              $token = bin2hex(random_bytes(30));
              $insertToken = "INSERT INTO owner(owner_reset_token) VALUES ('{$token}') WHERE owner_email = '{$email}'";
              $row = $result->fetch_assoc();

              $fromEmail = 'uhuru753@gmail.com';
              $fromName = 'Uhuru Economic Network';
              $toEmail = $email;
              $toName = $row['owner_fname'];
              $subject = 'Password Reset';
              $message = '<!DOCTYPE html>
                  <html lang="en">

                  <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <meta http-equiv="x-ua-compatible" content="ie=edge">
                    <title>Uhuru Economic Network</title>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css">
                  </head>

                  <body>
                    <div class="container">
                      <div class="row">
                        <div class="col-sm-offset-4 col-sm-6">
                          <p>Hello '.$toName.',<br /><br />
                            You have requested to reset your password. Click the following link to reset your password:<br /><br />
                            <a href="'.$actual_link.'reset.php?token='.$token.'">Reset Password</a><br /><br />
                            If you did not request for a password reset, please ignore this email.</p><br /><br />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-offset-4 col-sm-6">
                            Yours sincerely, <br />
                            BLACK OWNED BUSINESS
                          </div>
                        </div>
                      </div>
                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
                      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
                  </body>

                  </html>';
              $redirect = 'Email sent, please check your inbox.';
              $redirectError = '';

              $sendMail = new SendMail();
              $sendMail->send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, $redirect, $redirectError);

              $ownerID = 0;
              $timestamp = $_SERVER['REQUEST_TIME'];
              $getOwnerID = "SELECT owner_id FROM owner WHERE owner_email = '{$email}'";
              $result = $con->query($getOwnerID);
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ownerID = $row['owner_id'];
              }
              $insertToken = "INSERT INTO token(token_content, token_created_at, token_owner) VALUES (?, ?, ?)";
              $stmt = $con->prepare($insertToken);
              $stmt->bind_param('ssi', $token, $timestamp, $ownerID);
              $stmt->execute();
              $stmt->close();
            } else {
              echo '<p class="text-danger bg-warning error">The email enter does not exist</p>';
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
