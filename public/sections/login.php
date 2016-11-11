<section id="login" name="login">
  <article class="logSec">
    <?php
      if (isset($_SESSION['email'])) {
          if ($_SESSION['type'] === 'admin') {
            include $root . 'sections/login_parts/admin_part.php';
          } elseif ($_SESSION['type'] === 'owner') {
            include $root . 'sections/login_parts/owner_part.php';
          }
      } else {
        include $root . 'sections/login_parts/login_part.php';
      }
    ?>
  </article>
</section>
