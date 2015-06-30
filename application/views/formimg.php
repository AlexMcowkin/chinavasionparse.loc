<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Get Images</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
      <?php echo form_open('chinavasioncontroller/parseimg'); ?>
            <div class="form-group">
                <label for="title">Product Link</label>
                <input type="text" name="produckulr" required placeholder="Product Link" class="form-control"/>
            </div>            
            <div class="form-group">
                <input type="submit" name="submit" value="GET" class="btn btn-success" />
            </div>
            </form>
      </div>
    </div>

  </div>
</div> 