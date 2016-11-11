<section id="biz" name="biz" data-section-name="biz">
  <script src="js/unslider.js" type="text/javascript"></script>
  <div class="logo">
    <img src="images/logo.png" alt="BLACK OWNED BUSINESS" />
  </div>
  <article>
    <header class="page-header">
      <h1>Businesses</h1>
      <p>
        Look for a business in your area!
      </p>
    </header>
    <article class="provinces">
      <form method="get" action="<?php echo $root2; ?>displayBiz" name="browseForm" id="browseForm">
        <div class="my-slider">
          <ul>
            <li id="mapContainer">
              <h2 id="city">Pick a city</h2>
              <div id="map" data-center="-28.3958185, 25.1811046" data-zoom="5.4" data-enable="false" data-type="terrain"></div>
            </li>
            <li id="sectors">
              <h2>Sectors of industry</h2>
              <div class="sectors"></div>
              <button id="back" class="back btn btn-default" type="button">Back</button>
            </li>
          </ul>
        </div>
        <script type="text/javascript">
          $(window).on('load', function() {
            function marker(cname, lat, long) {
              $('#map').jHERE('marker', [lat, long], {
                icon: 'http://jhere.net/img/pin-black.png',
                anchor: {x: 12, y: 32},
                click: function(){
                  $('<input>').attr({
                    type: 'hidden',
                    id: 'city',
                    name: 'city',
                    value: cname
                  }).appendTo('#browseForm');
                  sectorAction(cname);
                },
                mouseover: function(event) {
                  $('#city').text(cname);
                },
                mouseout: function (event) {
                  $('#city').text('Pick a city');
                }
              });
            }
            $.getJSON('json/getCity.php', function(jsondata) {
              console.log(jsondata);
              for (var i = 0; i < jsondata.length; i++) {
                var cname = jsondata[i]["name"];
                var lat = parseFloat(jsondata[i]["latitude"]);
                var long = parseFloat(jsondata[i]["longitude"]);
                marker(cname, lat, long);
              }
            });

            if (md.mobile() != null) {
              $('#map').css('display', 'none');
              $.getJSON('json/getCity.php', function(jdata) {
                $('#mapContainer').append('<select id="citySel" name="city" onchange="getAction(this)">');
                $('#mapContainer select').append('<option value="">Select a city...</option>');
                for (var i = 0; i < jdata.length; i++) {
                  var name = jdata[i]["name"];
                  $('#citySel').append('<option value="' + name + '">' + name + '</option>');
                }
                $('#mapContainer').append('</select>');
              });
            }
          });
        </script>
      </form>
    </article>
  </article>
</section>
