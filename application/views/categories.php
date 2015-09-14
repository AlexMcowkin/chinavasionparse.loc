<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Categories List</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php if($resultparce !== TRUE):?>
          <div class="alert alert-danger">
            <p><?=$resultparce;?></p>
          </div>
        <?php endif;?>
      </div>
    </div>

    <?php if($resultparce === TRUE):?>
      <div class="row">
        <div class="col-md-12">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Link</th>
                <th>Parce Status</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($resultlist as $value):?>
              <tr id="trcatid_<?=$value->id;?>">
                <td><?=$value->id;?></td>
                <td><?=$value->name;?></td>
                <td><a href="<?=$value->url?>" target="_blank" title="click here"><?=$value->url?></a></td>
                <?php if($value->parce_status == '0'):?>
                  <td id="tdcatid_<?=$value->id;?>">
                    <a id="parcebutton" class="btn btn-warning btn-xs" href="#parceit" role="button" rel="<?=$value->id;?>" title="parce it">parce it</a>
                    <img src="img/preloader-small.gif" id="preloader_button"/></td>
                <?php else:?>
                  <td>
                    <span class="text-success">PARCED</span>
                  </td>
                <?php endif;?>
              </tr>
            <?php endforeach;?>
            </tbody>
            </table>
        </div>
      </div>
    <?php endif;?>

  </div>
</div> 