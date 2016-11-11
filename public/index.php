<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  include $root . 'layout/header.php';
  include $root . 'layout/navi.php';
?>
<main>
  <?php
    include $root . 'sections/home.php';
    include $root . 'sections/business.php';
    include $root . 'sections/login.php';
    include $root . 'sections/contact.php';
  ?>
</main>
<?php include $root . 'layout/footer.php'; ?>
