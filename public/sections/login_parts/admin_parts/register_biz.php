<form class="form-horizontal" action="<?php echo $root2; ?>sections/login_parts/admin_parts/registerBiz.php" method="post" enctype="multipart/form-data">
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
  ?>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Register a business</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <p class="text-danger">When registering a business, it is required that you register an owner for that business as well.</p>
            <div class="form-group">
              <label for="inputBizName" class="col-md-4 control-label">Business Name:</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="bizName" id="inputBizName" required>
              </div>
            </div>
            <div class="form-group">
              <label for="selectCity" class="col-md-4 control-label">Select City:</label>
              <div class="col-md-7">
                <select class="form-control" name="city">
                  <script type="text/javascript">
                    $.getJSON('json/getCity.php', function(json) {
                      for (var i = 0; i < json.length; i++) {
                        var cid = parseInt(json[i]["id"]);
                        var cname = json[i]["name"];
                        $('select[name="city"]').append("<option value='" + cid + "'>" + cname + "</option>");
                      }
                    });
                  </script>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="selectSector" class="col-md-4 control-label">Select Sector:</label>
              <div class="col-md-7">
                <select class="form-control" name="sector">
                  <script type="text/javascript">
                    $.getJSON('json/getSector.php', function(json) {
                      for (var i = 0; i < json.length; i++) {
                        var sid = parseInt(json[i]["id"]);
                        var sname = json[i]["name"];
                        $('select[name="sector"]').append("<option value='" + sid + "'>" + sname + "</option>");
                      }
                    });
                  </script>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputBizTel" class="col-md-4 control-label">Business Tel:</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="bizTel" id="inputBizTel" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputBizWebsite" class="col-md-4 control-label">Business Website:</label>
              <div class="col-md-7">
                <input type="text" class="form-control" name="bizWebsite" id="inputBizWebsite">
                <h6 class="text-info text-right">This is optional</h6>
              </div>
            </div>
            <div class="form-group">
              <label for="inputBizDesc" class="col-md-4 control-label">Business Description:</label>
              <div class="col-md-7">
                <textarea name="bizDesc" class="form-control" rows="6" required></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="uploadBizLogo" class="col-md-4 control-label">Upload a logo:</label>
              <div class="col-md-7">
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="bizLogo" id="uploadBizLogo" accept=".jpg, .png" required />
                <h6>File upload size limit is 2MB, it will fail if it exceeds the limit.</h6>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="panel-heading">
      <h3 class="panel-title">Register the business owner</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="inputOwnFName" class="col-md-4 control-label">Owner First Name:</label>
            <div class="col-md-7">
              <input type="text" class="form-control" id="inputOwnFName" name="fname" required />
            </div>
          </div>
          <div class="form-group">
            <label for="inputOwnLName" class="col-md-4 control-label">Owner Last Name:</label>
            <div class="col-md-7">
              <input type="text" class="form-control" id="inputOwnLName" name="lname" required />
            </div>
          </div>
          <div class="form-group">
            <label for="inputOwnEmail" class="col-md-4 control-label">Owner Email:</label>
            <div class="col-md-7">
              <input type="text" class="form-control" id="inputOwnEmail" name="email" required />
            </div>
          </div>
          <div class="form-group">
            <label for="inputOwnCell" class="col-md-4 control-label">Owner Cell:</label>
            <div class="col-md-7">
              <input type="text" class="form-control" id="inputOwnLName" name="cell" required />
            </div>
          </div>
          <div class="form-group">
            <label for="inputOwnTel" class="col-md-4 control-label">Owner Tel:</label>
            <div class="col-md-7">
              <input type="text" class="form-control" id="inputOwnTel" name="tel" required />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel-heading">
      <h3 class="panel-title"><span class="glyphicon glyphicon-info-sign"></span> Please check the details before clicking the following button</h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-11">
          <button type="submit" class="btn btn-success pull-right" name="butRegister">Register</button>
        </div>
      </div>
    </div>
  </div>
</form>
