<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  $ownerEmail = $_SESSION['email'];
  $getBusinessName = "SELECT biz.biz_id, biz.biz_name, biz.biz_description FROM biz, owner WHERE owner.owner_biz = biz.biz_id AND owner.owner_email = '{$ownerEmail}'";
  $result = $con->query($getBusinessName);
  $bizID = null;
  $bizName = null;
  $bizDesc = null;
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $bizID = $row['biz_id'];
    $bizName = $row['biz_name'];
    $bizDesc = $row['biz_description'];
  }
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo $bizName; ?></h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-12">
        <h3>Owners:</h3>
        <table class="table table-striped table-responsive">
          <thead>
            <th>First name</th>
            <th>Last name</th>
            <th>E-mail</th>
            <th>Cell no:</th>
            <th>Tel no:</th>
            <th colspan="2"></th>
          </thead>
          <tbody>
            <?php
              $getOwner = "SELECT * FROM owner WHERE owner_biz = {$bizID}";
              $result = $con->query($getOwner);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  if ($ownerEmail == $row['owner_email']) {
                    ?>
                    <tr>
                      <form class="form-inline" method="post">
                        <input type="hidden" name="owner_id" value="<?php echo $row['owner_id']; ?>" />
                        <td><input type="text" class="form-control" name="fname" value="<?php echo $row['owner_fname']; ?>" /></td>
                        <td><input type="text" class="form-control" name="lname" value="<?php echo $row['owner_lname']; ?>" /></td>
                        <td><input type="text" class="form-control" name="email" value="<?php echo $row['owner_email']; ?>" /></td>
                        <td><input type="text" class="form-control" name="cell" value="<?php echo $row['owner_cell']; ?>" /></td>
                        <td><input type="text" class="form-control" name="tel" value="<?php echo $row['owner_tel']; ?>" /></td>
                        <td><button type="submit" name="updateOwner"  class="btn btn-primary">Update</button></td>
                        <td></td>
                      </form>
                    </tr>
                    <?php
                  } else {
                    ?>
                    <tr>
                      <form class="form-inline" method="post">
                        <input type="hidden" name="owner_id" value="<?php echo $row['owner_id']; ?>" />
                        <td><input type="text" class="form-control" name="fname" value="<?php echo $row['owner_fname']; ?>" /></td>
                        <td><input type="text" class="form-control" name="lname" value="<?php echo $row['owner_lname']; ?>" /></td>
                        <td><input type="text" class="form-control" name="email" value="<?php echo $row['owner_email']; ?>" /></td>
                        <td><input type="text" class="form-control" name="cell" value="<?php echo $row['owner_cell']; ?>" /></td>
                        <td><input type="text" class="form-control" name="tel" value="<?php echo $row['owner_tel']; ?>" /></td>
                        <td><button type="submit" name="updateOwner"  class="btn btn-primary">Update</button></td>
                        <td><button type="submit" name="deleteOwner"  class="btn btn-danger delete">Delete</button></td>
                      </form>
                    </tr>
                    <?php
                  }
                }
              }
            ?>
          </tbody>
        </table>
        <div class="col-md-12">
          <form class="form-inline" action="<?php echo $root2 . 'add_owner/'; ?>" method="post">
            <input type="hidden" name="bizID" value="<?php echo $bizID; ?>" />
            <button class="btn btn-success pull-right" type="submit" name="addOwner">Add Owner</button>
          </form>
        </div>
        <?php
          if (isset($_POST['updateOwner'])) {
            $id = mysqli_real_escape_string($con, $_POST['owner_id']);
            $fname = mysqli_real_escape_string($con, $_POST['fname']);
            $lname = mysqli_real_escape_string($con, $_POST['lname']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $cell = mysqli_real_escape_string($con, $_POST['cell']);
            $tel = mysqli_real_escape_string($con, $_POST['tel']);

            $updateOwner = "UPDATE owner SET owner_fname = ?, owner_lname = ?, owner_email = ?, owner_cell = ?, owner_tel = ? WHERE owner_id = ?";

            $stmt = $con->prepare($updateOwner);
            $stmt->bind_param('sssssi', $fname, $lname, $email, $cell, $tel, $id);
            $stmt->execute();
            $stmt->close();

            echo $fname . ' data updated';
            header('location: ' . $root2 . '?status=Owner_info_updated#login');
          } elseif (isset($_POST['deleteOwner'])) {
            $id = mysqli_real_escape_string($con, $_POST['owner_id']);
            $fname = mysqli_real_escape_string($con, $_POST['fname']);
            $deleteOwner = "DELETE FROM owner WHERE owner_id = ?";

            $stmt = $con->prepare($deleteOwner);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            echo fname . ' deleted';
            header('location: ' . $root2 . '?status=Owner_deleted#login');
          }
        ?>
      </div>
    </div>
  </div>
</div>
