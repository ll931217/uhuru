<!-- This commented out section tag is for future increments if the client wants to implement a video background for his website, but I think as it is, the website is slow enough. -->
<!-- <section id="home" data-section-name="home" data-vide-bg="mp4: videos/0.mp4, webm: videos/0.webm, ogv: videos/0.ogv, poster: images/0.jpg" data-vide-options="posterType: jpg, loop: true, muted: true, position: 0% 0%"> -->
<section id="home" name="home" data-section-name="home" class="collapsed">
  <article class="collapsed">
    <div class="content">
      <?php
        if (isset($_GET['deleteStatus'])) {
          $success = join(' ', explode('_', $_GET['deleteStatus']));
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
        if (isset($_GET['loginStatus'])) {
          $error = join(' ', explode('_', $_GET['loginStatus']));
          ?>
            <div class="panel panel-danger statusFade">
              <div class="panel-heading">
                <h3 class="panel-title">Error</h3>
              </div>
              <div class="panel-body">
                <p class="text-danger"><?php echo $error; ?></p>
              </div>
            </div>
          <?php
        }
      ?>
      <p class="text-center">
        (Click the image to view details about us)
      </p>
      <a href=".info" data-toggle="collapse"><img src="<?php echo $root2; ?>images/IMG-20160404-WA0003.jpg" alt="BLACKED OWNED BUSINESSES" id="logo" /></a>
      <p class="info collapse">
        Uhuru Economic Network is a response to the clarion call of a more equal and dignified society. It is one of many solutions to the engineered and very deliberate social, economic and holistic destruction of people of colour all over the world. We at Black Owned Business aim to uplift men, women and children of colour by providing them a comprehensive compilation of black-owned business options to assist in clearing the path for black self-determination and black love of self. We will promote an all-inclusive network of excellence from the black street vendor to the black chartered accountant, from the black farmer to the black artist, from the Cape to Limpopo , from the Namaqualand to Mpumalanga.
      </p>
    </div>
    <a href="#biz"><img src="<?php echo $root2; ?>images/down-arrow.png" alt="Keep Scrolling" class="downArrow"/></a>
  </article>
</section>
