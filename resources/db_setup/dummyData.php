<?php
  include 'connectDB.php';

  // $dbInsertBiz1 = "INSERT INTO biz(biz_name, biz_description, biz_tel, biz_logo, biz_website, biz_sector, biz_city) VALUES ('Save My Souls Corp', 'Corp to save his soul', 0987654321, 'eat_logos_business_two_people.png', 'http://www.savemysoulscorp.co.za', 28, 2)";

  $dbInsertBiz2 = "INSERT INTO biz(biz_name, biz_description, biz_tel, biz_logo, biz_website, biz_sector, biz_city) VALUES ('Lee Corp', 'Corp to help Save My Souls Corp to save his soul', 0987654322, 'eat_logos_business_two_people.png', 'http://www.leecorp.co.za', 28, 2)";

  $dbInsertBiz3 = "INSERT INTO biz(biz_name, biz_description, biz_tel, biz_logo, biz_website, biz_sector, biz_city) VALUES ('Wildwood Lodge', 'Shireen\'s place', 0987654323, 'eat_logos_business_two_people.png', 'http://www.ishmailkids.co.za', 1, 2)";

  // if ($con->query($dbInsertBiz1) === true) {
  //   echo "First business inserted!<br />";
  // } else {
  //   echo "Failed to insert first business: " . $con->error . "<br />";
  // }

  if ($con->query($dbInsertBiz2) === true) {
    echo "Second business inserted!<br />";
  } else {
    echo "Failed to insert second business: " . $con->error . "<br />";
  }

  if ($con->query($dbInsertBiz3) === true) {
    echo "Third business inserted!<br />";
  } else {
    echo "Failed to insert third business: " . $con->error . "<br />";
  }

  // $dbInsertOwner1 = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES ('Liang-Shih', 'Lin', 'liangshihlin@gmail.com', '0797544460', '0538322193', '$2y$10$khcPrN6jh4N3SiwILGM70uS.cb3rBDAWLI1RFRpb0ZyCZ7pJVUGAO', 1)";

  $dbInsertOwner2 = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES ('Lee Shannon', 'Georges', 'miubot@hotmail.com', '0987654321', '0526598652', '$2y$11\$PRBNX8zaqyomQXXYzPw/4eWbuzC31GmOfxSCVlR1AkW9CASZLe6oy', 1)";

  $dbInsertOwner3 = "INSERT INTO owner(owner_fname, owner_lname, owner_email, owner_cell, owner_tel, owner_password, owner_biz) VALUES ('Shireen', 'Ishmail', 'shireenishmail@gmail.com', '0898786654', '27635474368', '$2y$11\$zMVxSCGr/PKRj8Xe.d01WeE9LEbjxm6ivfDUY3W6Km9JC5UIHaDaa', 2)";

  // if ($con->query($dbInsertOwner1) === true) {
  //   echo "First Owner inserted!<br />";
  // } else {
  //   echo "Failed to insert first owner: " . $con->error . "<br />";
  // }

  if ($con->query($dbInsertOwner2) === true) {
    echo "Second Owner inserted!<br />";
  } else {
    echo "Failed to insert second owner: " . $con->error . "<br />";
  }

  if ($con->query($dbInsertOwner3) === true) {
    echo "Third Owner inserted!<br />";
  } else {
    echo "Failed to insert third owner: " . $con->error . "<br />";
  }

  $con->close();
?>
