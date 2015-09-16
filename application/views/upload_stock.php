<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Import OpenCart 2.x Products Stock</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php if($this->session->flashdata('success')):?>
        <div class="alert alert-success">
          <p>Your file <strong><?=$filename;?></strong> was successfully uploaded!</p>
        </div>
        <?php endif;?>
        
        <?php if($this->session->flashdata('error')):?>
        <div class="alert alert-danger">
          <?php foreach($this->session->flashdata('error') as $error):?>
            <p><?=$error;?></p>
          <?php endforeach;?>
        </div>
        <?php endif;?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php echo form_open_multipart('chinavasioncontroller/uploadstock'); ?>
          <div class="form-group">
                <label for="title">CSV file:</label>
                <input type="file" name="userfile" class="form-control" id="file" placeholder="CSV File Here..." accept="text/csv" required />
            </div>            
            <div class="form-group">
                <input type="submit" name="submit" value="UPLOAD" class="btn btn-success" />
                <input type="reset" name="reset" value="REFUSE" class="btn btn-warning" />
            </div>
        </form>
      </div>
    </div>

  </div>
</div> 