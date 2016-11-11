<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  ob_start();
  session_start();
  include $root . 'connectDB.php';
  // $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  $actual_link = "http://$_SERVER[HTTP_HOST]/uhuru/public/";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="author" content="Liang-Shih Lin" />
    <meta content="keywords" content="black, owned, business, businesses, agriculture, South Africa, accommodation, accounting, advertising, aerospace, agribusiness, air transportation, apparel, accessories, auto, banking, beauty, cosmetics, biotechnology, chemical, communications, computer, construction, consulting, consumer products, education, electronics, employment, energy, entertainment, recreation, fashion, financial services, food, beverage, health, information, information technology, insurance, journalism, news, legal services, manufacturing, media, broadcasting, medical devices, supplies, motion pictures, video, music, pharmaceutical, public administration, public relations, publishing, real estate, retail, service, sports, technology, telecommunications, tourism, transportation, travel, utilities, video game, web services" />
    <title>Uhuru Economic Network</title>

    <!-- @NOTE: Put all of these stylesheets into one file, this is ridiculous -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $root2; ?>css/star-rating.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $root2; ?>css/unslider.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $root2; ?>css/footer.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $root2; ?>css/forgot.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $root2; ?>css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $root2; ?>css/biz.css" type="text/css" />
    <link rel="shortcut icon" href="<?php echo $root2; ?>images/logo.ico" />

    <!-- @NOTE: Put all the javascript into one file as well -->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      if (typeof jQuery == 'undefined') {
          document.write(unescape("%3Clink rel='stylesheet' src='<?php echo $root2; ?>css/bootstrap.css' type='text/css'/%3E"));
          document.write(unescape("%3Cscript src='<?php echo $root2; ?>js/jquery-2.2.3.js' type='text/javascript'%3E%3C/script%3E"));
          document.write(unescape("%3Cscript src='<?php echo $root2; ?>js/bootstrap.js' type='text/javascript'%3E%3C/script%3E"));
      }
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/mobile-detect.js/1.3.2/mobile-detect.min.js"></script>
    <script src="<?php echo $root2; ?>js/modernizr-custom.js" type="text/javascript"></script>
    <script src="<?php echo $root2; ?>js/star-rating.min.js" type="text/javascript"></script>
    <script src="<?php echo $root2; ?>js/autoinit.min.js" type="text/javascript"></script>
    <!-- <script src="js/jquery.vide.js" type="text/javascript"></script> -->
    <script src="http://jhere.net/js/jhere.js"></script>
    <script type="text/javascript">
      var md = new MobileDetect(window.navigator.userAgent);

      $(document).on("pageshow", "[data-role='page']", function () {
       $('div.ui-loader').remove();
      });

      function sectorAction(cname) {
        $('.my-slider').unslider('animate:1');
        var data = {
          'cityName' : cname
        };
        $.ajax({
          type: 'POST',
          url: 'json/getNum.php',
          data: data,
          success: function(sectorData) {
            console.log(sectorData);
            data = JSON.parse(sectorData);
            var i = 0;
            var x = 0;
            if (md.mobile() != null) {
              $('div.sectors').append('<select name="sector" onchange="this.form.submit()">');
              $('div.sectors select').append('<option>Select a business sector...</option>');
              for (var i = 0; i < data.length; i++) {
                if (data[i]['sector_count'] != "0") {
                  $('div.sectors select').append('<option value="' + data[i]['sector_name'] + '">' + data[i]['sector_name'] + ' <span class="badge">' + data[i]['sector_count'] + '</span></option>');
                  x++;
                }
              }
              $('div.sectors').append('</select>');
            } else {
              $('div.sectors').append('<ul>');
              for (var i = 0; i < data.length; i++) {
                if (data[i]['sector_count'] != "0") {
                  $('div.sectors ul').append('<li><label for="' + i + '"><input type="radio" name="sector" id="' + i + '" value="' + data[i]['sector_name'] + '" onclick="this.form.submit()" />' + data[i]['sector_name'] + ' <span class="badge">' + data[i]['sector_count'] + '</span></label></li>');
                  x++;
                }
              }
              $('div.sectors').append('</ul>');
            }
            if (x == 0) {
              if (md.mobile() != null) {
                $('div.sectors select').append('<option>No businesses found</option>');
              } else {
                $('div.sectors').append('<center><p>No businesses found</p></center>');
              }
            }
            $('#sectors h2').append(' in "' + cname + '"');
          }
        });
      }

      function getAction(sel) {
        sectorAction(sel.value);
      }

      $(document).ready(function() {
        $('.my-slider').unslider({
          keys: false,
          arrows: false,
          nav: false
        });
        $('#home a img#logo').click(function() {
          $('section#home article').toggleClass(function() {
            if ($(this).is('.collapsed')) {
              return 'uncollapsed';
            } else {
              return 'collapsed';
            }
          });
          if ($('#results div.biz').height() === 0) {
            $('#results span.res').css('display', 'block');
          } else {
            $('#results span.res').css('display', 'none');
          }
        });
        //Creates the smooth scrolling experience when clicking hash anchoring tags.
        $('a[href*="#"]:not([href="#"])').click(function() {
          if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
              $('html, body').animate({
                scrollTop: target.offset().top
              }, 1000);
              return false;
            }
          }
        });
        //Fixes the logo of the website to the top-left corner of the website
        $(window).scroll(function () {
          if ($(this).scrollTop() > $(window).height()){
            $('.logo').addClass('fixed');
          } else {
            $('.logo').removeClass('fixed');
          }
        });
        $('button#back').click(function() {
          $('.my-slider').unslider('animate:0');
          $('div.sectors').empty();
          $('#sectors h2').html('Sectors of Industry');
        });
        $(".delete").click(function(e){
          if(!confirm('Are you sure you want to delete this record?')){
            e.preventDefault();
            return false;
          }
          return true;
        });
        $(".statusFade").fadeIn(1000).delay(2000).fadeOut(1000);
      });

      $(window).on('load', function () {
        $(".pics img.img-thumbnail").on('click touch', function () {
          $(this).toggleClass('zoom');
        });
      });
    </script>
  </head>
  <body>
