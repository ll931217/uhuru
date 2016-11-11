<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public";
  include $root . 'connectDB.php';

  if (isset($_POST['butRegister'])) {
    $errors = array();

    //Register the business into the system
    $bizName = mysqli_real_escape_string($con, $_POST['bizName']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $sector = mysqli_real_escape_string($con, $_POST['sector']);
    $bizTel = mysqli_real_escape_string($con, $_POST['bizTel']);
    $bizWebsite = mysqli_real_escape_string($con, $_POST['bizWebsite']);
    $bizDesc = mysqli_real_escape_string($con, $_POST['bizDesc']);
    $bizLogo = null;

    include $root . 'layout/hasher.php';

    //Function to generate random password
    //This password will be sent to the owner
    function randomPassword() {
      $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $pass = array(); // remember to declare $pass as an array
      $alphaLength = strlen($alphabet) - 1; // put the length -1 in cache
      for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      //turn the array into a string
      return implode($pass);
    }

    //Register the business owner
    $owner_fname = mysqli_real_escape_string($con, $_POST['fname']);
    $owner_lname = mysqli_real_escape_string($con, $_POST['lname']);
    $owner_email = mysqli_real_escape_string($con, $_POST['email']);
    $owner_cell = mysqli_real_escape_string($con, $_POST['cell']);
    $owner_tel = mysqli_real_escape_string($con, $_POST['tel']);
    $unhashed = randomPassword();
    // Hashed the password
    $hasher = new HashPassword();
    $owner_password = $hasher->Hash($unhashed);

    $basename = join('_', explode(' ', $bizName));
    $dir = $root . 'images/biz_pics/' . $basename;

    // First check if there is already a business with this name and if the owner already exists
    $checkBizExists = "SELECT * FROM biz WHERE biz.biz_name = ?";
    $checkOwnerExists = "SELECT * FROM owner WHERE owner.owner_email = ?";

    $bizCount = 0;
    $ownerCount = 0;

    $stmt = $con->prepare($checkBizExists);
    $stmt->bind_param('s', $bizName);
    $stmt->execute();
    $results = $stmt->get_result();
    if ($results->num_rows > 0) {
      $bizCount++;
    }
    $stmt->close();

    $stmt = $con->prepare($checkOwnerExists);
    $stmt->bind_param('s', $owner_email);
    $stmt->execute();
    $results = $stmt->get_result();
    if ($results->num_rows > 0) {
      $ownerCount++;
    }
    $stmt->close();

    if (($bizCount == 0) || ($ownerCount == 0)) {
      // Uploads the logo selected, saves the name of the logo into the DB
      if (is_uploaded_file($_FILES['bizLogo']['tmp_name'])) {
        $logoErrors = array();

        $logoName = $_FILES['bizLogo']['name'];
        $logoSize = $_FILES['bizLogo']['size'];
        $logoTmp = $_FILES['bizLogo']['tmp_name'];
        $logoType = $_FILES['bizLogo']['type'];
        $logoError = $_FILES['bizLogo']['error'];

        // Creates a directory in which all the pictures for the business will be saved
        if (!is_dir($dir)) {
          mkdir($dir);
          chmod($dir, 0777);
          echo 'Made a directory<br /><br />';
        }

        if ($logoSize > 2097152) {
          $logoErrors[] = 'The file exceeds the size limit (2MB)';
        }

        if (empty($logoErrors) === true) {
          move_uploaded_file($logoTmp, $root . 'images/biz_logos/' . $logoName);
          chmod($root . 'images/biz_logos/' . $logoName, 0777);
          $bizLogo = $logoName;
          // echo 'File upload successful<br />';
        }
      } else {
        $errors[] = "File not uploaded through proper procedures";
      }

      $registerBiz = "INSERT INTO biz(biz_name, biz_description, biz_tel, biz_logo, biz_website, biz_sector, biz_city) VALUES (?, ?, ?, ?, ?, ?, ?)";

      $stmt = $con->prepare($registerBiz);
      $stmt->bind_param('sssssii', $bizName, $bizDesc, $bizTel, $bizLogo, $bizWebsite, $sector, $city);
      $stmt->execute();
      $stmt->close();

      $getBizID = "SELECT biz_id FROM biz WHERE biz_name = ?";
      $stmt = $con->prepare($getBizID);
      $stmt->bind_param('s', $bizName);
      $stmt->execute();
      $result = $stmt->get_result();
      $bizID = null;
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bizID = $row['biz_id'];
      }
      $stmt->close();

      $registerOwner = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $stmt = $con->prepare($registerOwner);
      $stmt->bind_param('ssssssi', $owner_fname, $owner_lname, $owner_email, $owner_cell, $owner_tel, $owner_password, $bizID);
      $stmt->execute();
      $stmt->close();

      if (empty($errors) === true) {
        include $root . 'send.php';
        $sendMail = new sendMail();
        $fromEmail = "uhuru753@gmail.com";
        $fromName = "Uhuru Economic Network";
        $toEmail = $owner_email;
        $toName = $owner_fname . ' ' . $owner_lname;
        $subject = "You are registered!";
        $message = "Greetings {$toName}, <br /><br />

                    Thank you for registering with us, the following are your login details:<br /><br />

                    Email:         {$toEmail}<br />
                    Password:      {$unhashed}<br /><br />

                    Website Address: {$root}<br /><br />

                    Login to change your details or the details of the company. <br /><br />

                    Yours sincerely,<br />
                    Uhuru Economic Network";
        $redirect = "Business and Owner registered";
        $redirectError = "";
        $sendMail->send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, $redirect, $redirectError);
        header("location: " . $root2 . "?status=Business_and_Owner_registered#login");
      } else {
        $error = null;
        for ($i = 0; $i < sizeof($errors); $i++) {
          $error .= '|' . $errors[i];
        }
        header("location: " . $root2 . "?error={$error}#error");
      }
    } else {
      if ($bizCount > 0) {
        header("location: " . $root2 . "?error=Business already exists#error");
      } elseif ($ownerCount > 0) {
        header("location: " . $root2 . "?error=Owner already exists#error");
      }
    }
  }
?>
