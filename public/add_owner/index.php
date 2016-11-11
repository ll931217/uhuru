<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';

  if (!isset($_SESSION['email'])) {
    header("location: {{$root2}}?loginStatus=Please_login_to_view_content");
  }

  $biz_id = null;
  if (isset($_POST['bizID'])) {
    $biz_id = mysqli_real_escape_string($con, $_POST['bizID']);
  }
?>
<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <?php
          if (isset($_GET['error'])) {
            $error = join(' ', explode("_", $_GET['error']));
            ?>
              <div class="panel panel-danger" id="error">
                <div class="panel-heading">
                  <h3 class="panel-title">Errors</h3>
                </div>
                <div class="panel-body">
                  <p class="text-danger"><?php echo $error; ?></p>
                  <a href="<?php echo $root2; ?>#login"><button type="button" class="btn btn-success pull-right">Go Back</button></a>
                </div>
              </div>
            <?php
          } elseif (isset($_GET['status'])) {
            $success = join(' ', explode('_', $_GET['status']));
            ?>
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h3 class="panel-title">Success</h3>
                </div>
                <div class="panel-body">
                  <p class="text-success"><?php echo $success; ?></p>
                  <a href="<?php echo $root2; ?>#login"><button type="button" class="btn btn-success pull-right">Go Back</button></a>
                </div>
              </div>
            <?php
          }
        ?>
        <div class="row">
          <div class="col-md-offset-2 col-md-9">
            <h2>Fill in the form to add an owner</h2>
          </div>
        </div>
        <hr />
        <form class="form-horizontal" method="post">
          <input type="hidden" name="biz_id" value="<?php echo $biz_id; ?>" />
          <div class="form-group">
            <label for="inputFName" class="col-md-4 control-label">First name:</label>
            <div class="col-md-7">
              <input type="text" name="fname" id="inputFName" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputLName" class="col-md-4 control-label">Last name:</label>
            <div class="col-md-7">
              <input type="text" name="lname" id="inputLName" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-md-4 control-label">Email:</label>
            <div class="col-md-7">
              <input type="email" name="email" id="inputEmail" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputCell" class="col-md-4 control-label">Cell:</label>
            <div class="col-md-7">
              <input type="text" name="cell" id="inputCell" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="inputTel" class="col-md-4 control-label">Tel:</label>
            <div class="col-md-7">
              <input type="text" name="tel" id="inputTel" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-11">
              <button class="btn btn-success pull-right" name="butAdd" type="submit">Add Owner</button>
            </div>
          </div>
        </form>
        <?php
        if (isset($_POST['butAdd'])) {
          echo 'butAdd pressed <br /><br />';
          function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
              $n = rand(0, $alphaLength);
              $pass[] = $alphabet[$n];
            }
            //turn the array into a string
            return implode($pass);
          }

          include $root . 'layout/hasher.php';
          include $root . 'send.php';

          $error = 0;

          $fname = mysqli_real_escape_string($con, $_POST['fname']);
          $lname = mysqli_real_escape_string($con, $_POST['lname']);
          $email = mysqli_real_escape_string($con, $_POST['email']);
          $cell = mysqli_real_escape_string($con, $_POST['cell']);
          $tel = mysqli_real_escape_string($con, $_POST['tel']);
          $biz_id = mysqli_real_escape_string($con, $_POST['biz_id']);

          $unhashed_pass = randomPassword();
          $hasher = new HashPassword();
          $hashed_pass = $hasher->Hash($unhashed_pass);

          // echo 'fname: ' . $fname . '<br />';
          // echo 'lname: ' . $lname . '<br />';
          // echo 'email: ' . $email . '<br />';
          // echo 'cell: ' . $cell . '<br />';
          // echo 'tel: ' . $tel . '<br />';
          // echo 'biz_id: ' . $biz_id . '<br />';
          // echo 'unhashed_pass: ' . $unhashed_pass . '<br />';
          // echo 'hashed_pass: ' . $hashed_pass . '<br />';

          $checkIfExists = "SELECT * FROM owner WHERE owner_email = ?";
          $addOwner = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES (?, ?, ?, ?, ?, ?, ?)";

          if (!($stmt = $con->prepare($checkIfExists))) {
            echo "Prepare failed: (" . $con->errno . ") " . $con->error;
            $error++;
          }
          if (!$stmt->bind_param('s', $email)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            $error++;
          }
          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $error++;
          }
          $results = $stmt->get_result();

          if ($results->num_rows > 0) {
            header("location: " . $root2 . "add_owner/?error=Owner_already_exists");
          }

          $stmt->close();

          if (!($stmt = $con->prepare($addOwner))) {
            echo "Prepare failed: (" . $con->errno . ") " . $con->error;
            $error++;
          }
          if (!$stmt->bind_param('ssssssi', $fname, $lname, $email, $cell, $tel, $hashed_pass, $biz_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            $error++;
          }
          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $error++;
          }

          $fromEmail = 'uhuru753@gmail.com';
          $fromName = 'Uhuru Economic Network';
          $toEmail = $email;
          $toName = $fname . ' ' . $lname;
          $subject = 'You are registered!';
          $message = "Greetings {$toName}, <br /><br />

                      Thank you for registering with us, the following are your login details:<br /><br />

                      Email:         {$email}<br />
                      Password:      {$unhashed_pass}<br /><br />

                      Website Address: {$actual_link}<br /><br />

                      Login to change your details or the details of the company. <br /><br />

                      Yours sincerely,<br />
                      Uhuru Economic Network";

          $sendMail = new SendMail();
          $sendMail->Send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, '', '');

          $stmt->close();
          if ($error == 0) {
            header("location: " . $root2 . "add_owner?status=Owner_added");
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
