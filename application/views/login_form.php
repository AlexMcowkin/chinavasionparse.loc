<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Login</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="alert alert-danger">
          <?php echo validation_errors(); ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <?php echo form_open('loginoutcontroller/index'); ?>
          <div class="form-group">
              <label for="title">Email:</label>
              <input type="email" name="mailLogin" required placeholder="Email Here..." class="form-control" value="admin@admin.com"/>
          </div>
          <div class="form-group">
              <label for="title">Product Link:</label>
              <input type="password" name="pwdLogin" required placeholder="Password Here..." class="form-control" value="admin"/>
          </div>
          <div class="form-group">
              <input type="submit" name="submitlogin" value="LOGIN" class="btn btn-success" />
          </div>
        </form>
      </div>
    </div>

  </div>
</div> 