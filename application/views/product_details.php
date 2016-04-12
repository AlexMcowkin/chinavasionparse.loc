<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Chinavasion's Product Details:</h4>
      </div>
    </div>
    
    <?php if(is_array($result)): ?>
    <div class="row">
      <div class="col-md-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            Product Main Info
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-condensed table-striped table-bordered">
          <tbody>
            <tr>
              <td>ID:</td>
              <td><?=$result['id']?></td>
            </tr>
            <tr>
              <td>SKU:</td>
              <td><?=$result['sku']?></td>
            </tr>
            <tr>
              <td>EAN:</td>
              <td><?=$result['ean']?></td>
            </tr>
            <tr>
              <td>NAME:</td>
              <td><?=$result['full_product_name']?></td>
            </tr>
            <tr>
              <td>CATEGORY:</td>
              <td><?=$result['category_name']?></td>
            </tr>
            <tr>
              <td>URL:</td>
              <td><a href="<?=$result['product_url']?>" target="_blank"><?=$result['product_url']?></a></td>
            </tr>
            <tr>
              <td>PRICE:</td>
              <td><?=$result['price']?></td>
            </tr>
            <tr>
              <td>STATUS:</td>
              <td>
              <?php
              if($result['status'] == "Out of Stock") {echo '<p class ="text-danger"><strong>Out of Stock</strong></p>';}
              elseif($result['status'] == "In Stock") {echo '<p class ="text-success"><strong>In Stock</strong></p>';}
              else echo '<p class ="text-primary"><strong>'.$result['status'].'</strong></p>';
              ?>
              </td>
            </tr>
            <tr>
              <td>CONTINUITY:</td>
              <td>
              <?php
                if($result['continuity'] == "Normal Product") {echo '<p class ="text-success"><strong>Normal Product</strong></p>';}
                elseif($result['continuity'] == "Soon Discontinued") {echo '<p class ="text-danger"><strong>Soon Discontinued</strong></p>';}
                else echo '<p class ="text-primary"><strong>'.$result['continuity'].'</strong></p>';
              ?>
              </td>
            </tr>
            <tr>
              <td>short description:</td>
              <td><?=$result['meta_description']?></td>
            </tr>
          </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            Product Images
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-hover table-condensed table-bordered">
                <tbody>
                  <tr>
                    <td>IMAGE:</td>
                   <td><?=$result['main_picture']?></td>
                  </tr>
                  <tr>
                    <td>additional images:</td>
                    <td>
                    <?php
                    foreach($result['additional_images'] as $one_img)
                    {
                      echo $one_img.'<br />';
                    }
                    ?>
                    </td>
                  </tr>
                  <tr>
                    <td><a href="<?=base_url();?>parseimg" target="_blank" title="download images">Download images:</a></td>
                    <td><small><?=$result['product_url']?></small></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            Product Description
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-condensed">
                <tbody>        
                  <tr>
                    <td><?=$result['overview']?></td>
                  </tr>
                  <tr>
                    <td><?=$result['specification']?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
    <?php else: ?>
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?=$result; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div> 