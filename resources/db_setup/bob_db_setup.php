<?php
  $host = "localhost";
  $username = "shifu";
  $password = "eRL14kMf";

  $city = array(
    "Pretoria",
    "Cape Town",
    "Durban",
    "Port Elizabeth",
    "Bloemfontein",
    "Mafikeng",
    "Kimberley",
    "Nelspruit",
    "Polokwane"
  );

  $latitude = array(
    "-25.7479",
    "-33.9249",
    "-29.8587",
    "-33.7139",
    "-29.0852",
    "-25.8560",
    "-28.7282",
    "-25.4753",
    "-23.8962"
  );

  $longitude = array(
    "28.2293",
    "18.4241",
    "31.0218",
    "25.5207",
    "26.1596",
    "25.6403",
    "24.7499",
    "30.9694",
    "29.4486"
  );

  $sectors = array(
    "Accommodation",
    "Accounting",
    "Advertising",
    "Aerospace",
    "Agriculture & Agribusiness",
    "Air Transportation",
    "Apparel & Accessories",
    "Auto",
    "Banking",
    "Beauty & Cosmetics",
    "Biotechnology",
    "Chemical",
    "Communications",
    "Computer",
    "Construction",
    "Consulting",
    "Consumer Products",
    "Education",
    "Electronics",
    "Employment",
    "Energy",
    "Entertainment & Recreation",
    "Fashion",
    "Financial Services",
    "Food & Beverage",
    "Health",
    "Information",
    "Information Technology",
    "Insurance",
    "Journalism & News",
    "Legal Services",
    "Manufacturing",
    "Media & Broadcasting",
    "Medical Devices & Supplies",
    "Motion Pictures & Videos",
    "Music",
    "Pharmaceutical",
    "Public Administration",
    "Public Relations",
    "Publishing",
    "Real Estate",
    "Retail",
    "Service",
    "Sports",
    "Technology",
    "Telecommunications",
    "Tourism",
    "Transportation",
    "Travel",
    "Utilities",
    "Video Games",
    "Web Services"
  );

  //Creating the connection to mysqli
  $con = new mysqli($host, $username, $password);

  //Check if connected
  if ($con->connect_error) {
    die("Connection error: " . $con->connect_error . "<br />");
  } else {
    echo "Connected to MySQL server<br />";
  }

  $query = 'CREATE DATABASE IF NOT EXISTS bob_db';
  if (mysqli_query($con, $query)) {
    echo "Database created successful <br />";
  } else {
    echo "Error creating database: " . mysqli_error($con) ."<br />";
  }

  mysqli_select_db($con, 'bob_db');
  echo "Selected bob_db Database<br /><br />";

  echo "Creating tables...<br />";
  $createAdminTB = 'CREATE TABLE admin (
    admin_id INT NOT NULL AUTO_INCREMENT,
    admin_email VARCHAR(60) NOT NULL,
    admin_password VARCHAR(60) NOT NULL,
    PRIMARY KEY(admin_id)
  )';

  if($con->query($createAdminTB) === true) {
    echo "SUCCESS: Table Admin created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createCityTB = 'CREATE TABLE city (
    city_id INT NOT NULL AUTO_INCREMENT,
    city_name VARCHAR(40) NOT NULL,
    city_latitude FLOAT NOT NULL,
    city_longitude FLOAT NOT NULL,
    PRIMARY KEY(city_id)
  )';

  if ($con->query($createCityTB) === true) {
    echo "SUCCESS: Table City created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createSectorTB = 'CREATE TABLE sector (
    sector_id INT NOT NULL AUTO_INCREMENT,
    sector_name VARCHAR(50) NOT NULL,
    PRIMARY KEY(sector_id)
  )';

  if ($con->query($createSectorTB) === true) {
    echo "SUCCESS: Table Sector created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createBizTB = 'CREATE TABLE biz (
    biz_id INT NOT NULL AUTO_INCREMENT,
    biz_name VARCHAR(60) NOT NULL,
    biz_description VARCHAR(500) NOT NULL,
    biz_tel VARCHAR(10) NOT NULL,
    biz_logo VARCHAR(100) NOT NULL,
    biz_website VARCHAR(50),
    biz_sector INT NOT NULL,
    biz_city INT NOT NULL,
    CONSTRAINT fk_sector FOREIGN KEY(biz_sector) REFERENCES sector(sector_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_city FOREIGN KEY(biz_city) REFERENCES city(city_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(biz_id)
  )';

  if ($con->query($createBizTB) === true) {
    echo "SUCCESS: Table Biz created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createOwnerTB = 'CREATE TABLE owner (
    owner_id INT NOT NULL AUTO_INCREMENT,
    owner_fname VARCHAR(40) NOT NULL,
    owner_lname VARCHAR(40) NOT NULL,
    owner_email VARCHAR(40) NOT NULL,
    owner_cell VARCHAR(10) NOT NULL,
    owner_tel VARCHAR(10) NOT NULL,
    owner_password VARCHAR(60) NOT NULL,
    owner_biz INT NOT NULL,
    CONSTRAINT fk_biz FOREIGN KEY(owner_biz) REFERENCES biz(biz_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(owner_id)
  )';

  if ($con->query($createOwnerTB) === true) {
    echo "SUCCESS: Table Owner created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createTokenTB = 'CREATE TABLE token (
    token_id INT NOT NULL AUTO_INCREMENT,
    token_content VARCHAR(400) NOT NULL,
    token_created_at VARCHAR(100) NOT NULL,
    token_owner INT NOT NULL,
    CONSTRAINT fk_token_owner FOREIGN KEY(token_owner) REFERENCES owner(owner_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(token_id)
  )';

  if ($con->query($createTokenTB) === true) {
    echo "SUCCESS: Table Token created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $createReviewTB = 'CREATE TABLE review (
    review_id INT NOT NULL AUTO_INCREMENT,
    review_username VARCHAR(30) NOT NULL,
    review_desc VARCHAR(400) NOT NULL,
    review_rating FLOAT(10) NOT NULL,
    review_created_at DATETIME NOT NULL,
    review_biz INT NOT NULL,
    CONSTRAINT fk_review_biz FOREIGN KEY(review_biz) REFERENCES biz(biz_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY(review_id)
  )';

  if ($con->query($createReviewTB) === true) {
    echo "SUCCESS: Table Review created!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  echo "DONE: All tables created!<br /><br />";
  echo "Populating Tables now<br />";

  $insertAdmin = 'INSERT INTO admin(admin_email, admin_password) VALUES (
    "liangshihlin@yahoo.com",
    "$2y$11$tjU9GK68Tl.pmPCRp0ghdOokzUjIDDgBMUo1iT.bbESG1gTvuXGeO"
  )';

  if ($con->query($insertAdmin) === true) {
    echo "SUCCESS: Admin added!<br />";
  } else {
    echo "ERROR: " . $con->error . "<br />";
  }

  $sectorslen = sizeof($sectors);

  for ($i = 0; $i < $sectorslen; $i++) {
    $insertSector = 'INSERT INTO sector(sector_name) VALUES ("' . $sectors[$i] . '")';
    if ($con->query($insertSector) === true) {
      echo "SUCCESS: Added $sectors[$i]!<br />";
    } else {
      echo "ERROR: Failed to add $sectors[$i](" . $con->error . ")<br />";
    }
  }

  echo "SUCCESS: Sectors added!<br />";

  $citylen = sizeof($city);

  for ($i = 0; $i < $citylen; $i++) {
    $insertCity = 'INSERT INTO city(city_name, city_latitude, city_longitude) VALUES ("' . $city[$i] . '", ' . $latitude[$i] . ', ' . $longitude[$i] . ')';
    if ($con->query($insertCity) === true) {
      echo "SUCCESS: Added $city[$i]!<br />";
    } else {
      echo "ERROR: Failed to add $city[$i](" . $con->error . ")<br />";
    }
  }

  echo "EVERYTHING DONE!";
  $con->close();
?>
