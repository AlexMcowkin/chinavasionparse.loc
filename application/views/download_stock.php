<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Download CSV Products Stock Data for OpenCart 2.x</h4>
      </div>
    </div>

    <?php if($file_name == 'no_data'):?>
      <h5 class="text-danger">PLEASE, UPLOAD CSV FILE WITH DATA FIRST</h5>
      <p>Cliock here: <a href="<?=base_url();?>uploadstock">upload stock</a></p>
    <?php else:?>
      <div class="row">
        <div class="col-md-12">
          <p>Click here to <a href="<?=base_url().'upload/'.$file_name?>" title="download csv file">download csv file</a></p>
        </div>
      </div>
    <?php endif;?>

    <div class="row">
      <div class="col-md-12">
        <hr />
        <p>otput file example:<br />
          <strong>"SKU","QUANTITY"</strong>
          <br />"sku_1","999"
          <br />"sku_2","0"
        </p>
      </div>
    </div>

  </div>
</div> 