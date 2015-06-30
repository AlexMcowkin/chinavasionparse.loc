<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Parse XML</h4>
      </div>
    </div>

  <div class="row">
    <div class="col-md-12">
      <?php if(!$result):?>
        <div class="alert alert-danger">
          <p>file was NOT parsed</p>
        </div>
      <?php else:?>
        <div class="alert alert-success">
          <p>file was parsed</p>          
          <p>total rows: <?=$result;?></p>
        </div>
      <?php endif;?>
    </div>
  </div>

  </div>
</div> 