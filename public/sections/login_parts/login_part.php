<header class="page-header">
  <h1>Login</h1>
  <p>
    Login and change your business details
  </p>
</header>
<article>
  <?php
    if (isset($_POST['loginBut'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $pass = mysqli_real_escape_string($con, $_POST['pass']);

        $con->autocommit(false);
        $checkOwner = 'SELECT * FROM owner WHERE owner_email = ?';
        $checkAdmin = 'SELECT * FROM admin WHERE admin_email = ?';
        $stmtO = $con->prepare($checkOwner);

        $stmtO->bind_param('s', $email);

        $stmtO->execute();

        $ownerRes = $stmtO->get_result();

        $countO = $ownerRes->num_rows;

        if ($countO > 0) {
            $row = $ownerRes->fetch_assoc();
            $ownerPass = $row['owner_password'];
            if (password_verify($pass, $ownerPass)) {
                echo 'logged in';
                $_SESSION['type'] = 'owner';
                $_SESSION['email'] = $email;
                header('location: ' . $root2 . '?status=Logged_in#login');
            } else {
              header("location: " . $root2 . "?error=Your_e-mail_or_password_is_incorrect#login");
            }
            $stmtO->close();
        } else {
            $stmtA = $con->prepare($checkAdmin);
            $stmtA->bind_param('s', $email);
            $stmtA->execute();
            $adminRes = $stmtA->get_result();
            $countA = $adminRes->num_rows;
            if ($countA > 0) {
                $row = $adminRes->fetch_assoc();
                $adminPass = $row['admin_password'];
                if (password_verify($pass, $adminPass)) {
                    echo 'logged in';
                    $_SESSION['type'] = 'admin';
                    $_SESSION['email'] = $email;
                } else {
                  header("location: " . $root2 . "?error=Your_e-mail_or_password_is_incorrect#login");
                }
                $stmtA->close();
                header('location: ' . $root2 . '?status=Logged_in#login');
            } else {
              header("location: " . $root2 . "?error=Your_e-mail_or_password_is_incorrect_or_your_account_doesn't_exist#login");
            }
        }
    }
    if (isset($_GET['error'])) {
      $error = join(' ', explode("_", $_GET['error']));
      ?>
        <div class="panel panel-danger statusFade" id="error">
          <div class="panel-heading">
            <h3 class="panel-title">Errors</h3>
          </div>
          <div class="panel-body">
            <p class="text-danger"><?php echo $error; ?></p>
          </div>
        </div>
      <?php
    } elseif (isset($_GET['status'])) {
      $success = join(' ', explode('_', $_GET['status']));
      ?>
        <div class="panel panel-success statusFade">
          <div class="panel-heading">
            <h3 class="panel-title">Success</h3>
          </div>
          <div class="panel-body">
            <p class="text-success"><?php echo $success; ?></p>
          </div>
        </div>
      <?php
    }
  ?>
  <form class="form-horizontal" method="post" autocomplete="off">
    <div class="form-group">
      <label for="inputEmail" class="col-md-offset-2 col-md-3 control-label">E-mail:</label>
      <div class="col-md-5">
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="example@gmail.com" />
      </div>
    </div>
    <div class="form-group">
      <label for="inputPass" class="col-md-offset-2 col-md-3 control-label">Password:</label>
      <div class="col-md-5">
        <input type="password" id="inputPass" class="form-control" name="pass" placeholder="password" />
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-5 col-md-5">
        <a href="<?php echo $root2; ?>forgot_password"><small>Forgot your password?</small></a>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-5 col-md-5">
        <button type="submit" class="btn btn-default" name="loginBut">Login</button>
      </div>
    </div>
  </form>
  <p class="text-center text-danger"><a href="mailto:uhuru753@gmail.com">Email</a> us to register your business with us</p>
</article>
