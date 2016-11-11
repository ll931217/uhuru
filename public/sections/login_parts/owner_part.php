<header class="page-header">
  <h2>Welcome Business Owner</h2>
</header>
<article>
  <?php
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
    include $root . 'sections/login_parts/owner_parts/owner_details.php';
    include $root . 'sections/login_parts/owner_parts/biz_desc.php';
    include $root . 'sections/login_parts/owner_parts/biz_images.php';
    include $root . 'sections/login_parts/owner_parts/owner_pass.php';
  ?>
</article>
