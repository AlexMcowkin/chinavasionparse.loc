<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Get Images</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
      <?php if($result):?>
        <h2>DONE!</h2>
        <strong>Gallery Name & Seo URL:</strong><br /><?=$result;?>
      <?php else:?>
        <h2>ERROR!</h2>
        <strong>The entered URL is not correct OR something else!</strong>
      <?php endif;?>
      </div>
    </div>

    </div>
</div> 