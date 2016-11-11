<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  include $root . 'layout/header.php';
?>

<main>
  <section>
    <article class="bizInfo">
      <div class="content">
        <?php
          unset($_SESSION['email']);
          unset($_SESSION['type']);
          session_destroy();
        ?>
        <script type="text/javascript">
          var delay = 3000;
          setTimeout(function(){
            window.location = "<?php echo $root2; ?>";
          }, delay);
        </script>
        <p>
          You are now logged out, redirect in 3 seconds...
        </p>
      </div>
    </article>
  </section>
</main>
<?php
  include $root2 . 'layout/footer.php';
?>
