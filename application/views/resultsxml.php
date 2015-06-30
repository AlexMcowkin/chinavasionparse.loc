<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Parse Result</h4>
      </div>
    </div>

  <div class="row">
    <div class="col-md-12">
      <?php if(!$result):?>
        <div class="alert alert-danger">
          <p>no data to show</p>
        </div>
      <?php else:?>
        <?php if($type == 'onlydates'):?>
          <?php foreach($result as $value):?>
            <a href="<?=base_url();?>results/<?=$value->datetime;?>"><?=$value->datetime;?></a>
            <br />
          <?php endforeach;?>
        <?php elseif($type == 'onlylinks'):?>
          <?php foreach($result as $value):?>
            <a href="<?=$value->url;?>" target="_blank"><?=$value->url;?></a>
            <br />
          <?php endforeach;?>
        <?php endif;?>
      <?php endif;?>
    </div>
  </div>

  </div>
</div> 