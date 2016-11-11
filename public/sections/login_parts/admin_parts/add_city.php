<form method="post" action="<?php echo $root2; ?>sections/login_parts/admin_parts/addCity.php" class="form-horizontal">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Add a City</h3>
    </div>
    <div class="panel-body">
      <p class="text-danger"><span class="glyphicon glyphicon-info-sign"></span> If you need help determining the longitudinal and the latitudinal coordinates, please consult the user manual or <a href="mailto:liangshihlin@gmail.com">Liang-Shih Lin</a></p>
      <div class="form-group">
        <label for="inputName" class="col-md-4 control-label">Name:</label>
        <div class="col-md-7">
          <input type="text" class="form-control" id="inputName" name="cname" required />
        </div>
      </div>
      <div class="form-group">
        <label for="inputLat" class="col-md-4 control-label">Latitude:</label>
        <div class="col-md-7">
          <input type="text" class="form-control" id="inputLat" name="cLat" required />
        </div>
      </div>
      <div class="form-group">
        <label for="inputLong" class="col-md-4 control-label">Longitude:</label>
        <div class="col-md-7">
          <input type="text" class="form-control" id="inputLong" name="cLong" required />
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-4 col-md-7">
          <button type="submit" name="addCity" class="btn btn-success pull-right">Add City</button>
        </div>
      </div>
    </div>
  </div>
</form>
