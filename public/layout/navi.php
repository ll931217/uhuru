<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
?>
<div id="navi">
  <nav id="theBar">
    <ul class="topnav">
      <li class="hamburger"><a href="javascript:void(0)" onclick="myFunction()">&#9776;</a></li>
      <li><a href="<?php echo $root2; ?>#home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
      <li><a href="<?php echo $root2; ?>#biz">Businesses</a></li>
      <?php
        if (isset($_SESSION["email"])) {
          echo '<li><a href="' . $root2 . '#login">Profile</a></li>';
          echo '<li><a href="' . $root2 . 'logout">Logout</a></li>';
        } else {
          echo '<li><a href="' . $root2 . '#login">Login</a></li>';
        }
      ?>
      <li><a href="<?php echo $root2; ?>#contact">Contact Us</a></li>
    </ul>
  </nav>
  <script>
    function myFunction() {
      $('.topnav').toggleClass('responsive');
    }
  </script>
</div>
