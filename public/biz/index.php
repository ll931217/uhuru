<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/navi.php';

  function is_dir_empty($dir) {
    if (!is_readable($dir)) return NULL;
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != "..") {
        return FALSE;
      }
    }
    return TRUE;
  }

  $id = $_REQUEST['id'];

  $rating = 0;

  $getRating = 'SELECT review_rating FROM review WHERE review_biz = ' . $id;

  $result = $con->query($getRating);

  if ($result->num_rows > 0) {
    $x = 0;
    $temp = 0;
    while ($row = $result->fetch_assoc()) {
      $temp = $temp + $row['review_rating'];
      $x++;
    }
    $rating = $temp / $x;
    $rating = number_format($rating, 2);
  }

?>
<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <?php
          $getOwners = "SELECT owner_fname, owner_lname FROM owner WHERE owner_biz = ?";
          $owners = null;
          if (!($stmt = $con->prepare($getOwners))) {
            echo "Prepare failed: (" . $con->errno . ") " . $con->error;
          }
          if (!$stmt->bind_param('s', $id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
          }
          if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
          }
          $results = $stmt->get_result();
          if ($results->num_rows > 0) {
            $x = 1;
            while ($rows = $results->fetch_assoc()) {
              if ($x == $results->num_rows) {
                $owners .= $rows['owner_fname'] . ' ' . $rows['owner_lname'];
              } else {
                $owners .= $rows['owner_fname'] . ' ' . $rows['owner_lname'] . ', ';
              }
              $x++;
            }
          }
          $getBiz = "SELECT biz.biz_name, biz.biz_description, biz.biz_tel, biz.biz_logo, biz.biz_website, sector.sector_name, city.city_name
                      FROM biz, sector, city
                      WHERE biz.biz_id = ? AND biz.biz_sector = sector.sector_id AND biz.biz_city = city.city_id";

          if ($stmt = $con->prepare($getBiz)) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($name, $desc, $tel, $logo, $website, $sector, $city);
            $stmt->fetch();

            $location = join('_', explode(' ', $name));
        ?>
        <div class="row">
          <div class="col-md-3">
            <img class="img-responsive" src="<?php echo $root2; ?>images/biz_logos/<?php echo $logo; ?>" alt="<?php echo $name; ?>" />
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-10">
                <h2><?php echo $name ?></h2>
              </div>
              <?php
              if (isset($_SESSION['email'])) {
                if ($_SESSION['type'] == 'admin') {
                  ?>
                  <div class="col-md-2">
                    <h2>
                      <form action="<?php echo $root2; ?>deleteBiz/" method="post">
                        <input type="hidden" name="bizID" value="<?php echo $id; ?>" />
                        <input type="hidden" name="bizName" value="<?php echo $name; ?>" />
                        <input type="hidden" name="bizLogo" value="<?php echo $logo; ?>" />
                        <button class="btn btn-danger delete" type="submit">Delete</button>
                      </form>
                    </h2>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
            <hr />
            <div class="basic">
              <div class="row">
                <div class="col-md-12">
                  <span class="lead">Owners:</span> <?php echo $owners ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  Rating: <?php echo $rating; ?>
                </div>
                <div class="col-md-6">
                  Sector: <?php echo $sector; ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  Tel: 0<?php echo $tel; ?>
                </div>
                <div class="col-md-6">
                  City: <?php echo $city; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="pics">
              <?php
                if (file_exists($root . 'images/biz_pics/' . $location)) {
                  $images = glob($root . 'images/biz_pics/' . $location . '/*.{jpg,png}', GLOB_BRACE);
                  if (!is_dir_empty($root . 'images/biz_pics/' . $location)) {
                    echo '<h4>Pictures:</h4>';
                    echo '<ul class="list-inline">';
                    foreach ($images as $image) {
                      $image = strstr($image, $root2);
                      ?>
                      <li><img class="img-thumbnail" src="<?php echo $image; ?>" height="100" width="100" /></li>
                      <?php
                    }
                    echo '</ul>';
                  } else {
                    echo '<p class="text-danger">No pictures found</p>';
                  }
                } else {
                  echo '<p class="text-danger">No pictures found</p>';
                }
              ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <h4>Description:</h4>
            <div class="desc">
              <?php echo $desc; ?>
            </div>
          </div>
        </div>
        <?php
            $stmt->close();
          }
        ?>
        <hr />

        <div class="row">
          <div class="col-md-12">
            <div class="reviews">
              <div class="row">
                <div class="col-md-6">
                  <h4>Reviews:</h4>
                </div>
                <div class="col-md-offset-3 col-md-3 post">
                  <h6 class="text-right"><a href="#post" data-toggle="collapse"><span class="caret"></span> Post a review</a></h6>
                </div>
              </div>
              <div class="row collapse" id="post">
                <div class="col-md-12">
                  <form class="form-horizontal" action="../post_review.php" method="post">
                    <input type="hidden" name="biz_id" value="<?php echo $id; ?>" />
                    <div class="form-group">
                      <label for="inputUsername" class="col-md-3 control-label">Username:</label>
                      <div class="col-md-8">
                        <input type="text" name="username" id="inputUsername" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputRating" class="col-md-3 control-label">Rating:</label>
                      <div class="col-md-8">
                        <input type="number" name="rating" id="inputRating" class="rating" min="1" max="5" step="0.5" size="sm" data-rt1="true" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputReview" class="col-md-3 control-label">Review:</label>
                      <div class="col-md-8">
                        <textarea name="review" id="inputReview" class="form-control" rows="10"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-offset-3 col-md-8">
                        <button type="submit" class="btn btn-default" name="subReview">Send!</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <?php
                $getReviews = "SELECT review_username, review_desc, review_rating, review_created_at FROM review WHERE review_biz = ?";

                if ($stmt = $con->prepare($getReviews)) {
                  $stmt->bind_param('i', $id);
                  $stmt->execute();

                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      ?>
                      <div class="row">
                        <div class="col-md-12">
                          <p class="text-muted pull-right created"><?php echo $row['review_created_at']; ?></p>
                          <blockquote class="card-blockquote pull-left">
                            <p><?php echo $row['review_desc']; ?></p>
                            <footer>Rated: <?php echo $row['review_rating']; ?></footer>
                            <footer><?php echo "By: " . $row['review_username']; ?></footer>
                          </blockquote>
                        </div>
                      </div>
                      <?php
                    }
                  } else {
                    echo '<p class="text-warning">No reviews</p>';
                  }
                  $stmt->close();
                } else {
                  echo '<p class="text-danger">Error: ' . $con->error . '</p>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </article>
  </section>
</main>
<?php
  include $root . 'layout/footer.php';
?>
