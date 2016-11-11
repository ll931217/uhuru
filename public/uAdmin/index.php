<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/hasher.php';
?>

<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <div class="row">
          <div class="col-md-offset-1 col-md-10">
            <h2>Owner Registration</h2>
            <form class="form-horizontal" method="post">
              <div class="form-group">
                <label for="inputOEmail" class="col-md-3 control-label">Email:</label>
                <div class="col-md-9">
                  <input type="email" class="form-control" id="inputOEmail" name="oEmail" />
                </div>
              </div>
              <div class="form-group">
                <label for="inputOPassword" class="col-md-3 control-label">Password:</label>
                <div class="col-md-9">
                  <input type="password" class="form-control" id="inputOPassword" name="oPassword" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn btn-default" name="butOSubmit">Register</button>
                </div>
              </div>
            </form>
            <?php
              if (isset($_POST['butOSubmit'])) {
                $hasher = new HashPassword();
                $fname = "Testing";
                $lname = "Testing";
                $email = $_POST['oEmail'];
                $cell = "0987654321";
                $tel = "0892734652";
                $password = $_POST['oPassword'];
                $password = $hasher->Hash($password);
                $biz = 1;
                $insertOwner = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertOwner);
                $stmt->bind_param('ssssssi', $fname, $lname, $email, $cell, $tel, $password, $biz);
                $stmt->execute();
                $stmt->close();
                echo "Registered";
              }
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-offset-1 col-md-10">
            <h2>Admin Registration</h2>
            <form class="form-horizontal" method="post">
              <div class="form-group">
                <label for="inputEmail" class="col-md-3 control-label">Email:</label>
                <div class="col-md-9">
                  <input type="email" class="form-control" id="inputEmail" name="aEmail" />
                </div>
              </div>
              <div class="form-group">
                <label for="inputAPassword" class="col-md-3 control-label">Password:</label>
                <div class="col-md-9">
                  <input type="password" class="form-control" id="inputAPassword" name="aPassword" />
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                  <button type="submit" class="btn btn-default" name="butASubmit">Register</button>
                </div>
              </div>
            </form>
            <?php
              if (isset($_POST['butASubmit'])) {
                $email = $_POST['aEmail'];
                $hasher = new HashPassword();
                $password = $_POST['aPassword'];
                $password = $hasher->Hash($password);
                $insertAdmin = "INSERT INTO admin(admin_email, admin_password) VALUES (?, ?)";
                $stmt = $con->prepare($insertAdmin);
                $stmt->bind_param('ss', $email, $password);
                $stmt->execute();
                $stmt->close();
                echo "Registered";
              }
            ?>
          </div>
        </div>
      </div>
    </article>
  </section>
</main>
<?php
  include $root . 'layout/footer.php';
?>
