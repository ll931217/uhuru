<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/navi.php';
?>
<main>
  <section id="results">
    <article>
      <div class="content">
        <h1>Businesses</h1>
        <?php
          $city = mysqli_real_escape_string($con, $_GET['city']);
          $sector = mysqli_real_escape_string($con, $_GET['sector']);
          echo '<h3>"' . $city . '" - ' . $sector . '</h3>';
          echo '<hr />';
        ?>
        <div class="biz">
          <?php
            $selectBiz = "SELECT biz.biz_id, biz.biz_name, biz.biz_logo, biz.biz_description FROM biz, city, sector WHERE biz.biz_city = city.city_id AND city.city_name = ? AND biz.biz_sector = sector.sector_id AND sector.sector_name = ?";
            $stmt = $con->prepare($selectBiz);
            $stmt->bind_param('ss', $city, $sector);

            $stmt->execute();

            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
              echo '<a href="' . $root2 . 'biz?id=' . $row['biz_id'] . '" class="noUnder"><div class="resBiz"><div class="bizLogo"><img src="' . $root2 . 'images/biz_logos/' . $row['biz_logo'] . '" alt="' . $row['biz_name'] . '" /></div><div class="bizDesc">
              <h2>' . $row['biz_name'] . '</h2>' . $row['biz_description'] . "</div></div></a>";
            }
          ?>
        </div>
      </div>
    </article>
  </section>
</main>

<?php
  include $root . 'layout/footer.php';
?>
