<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Chinavasion's New Products</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php
        if(is_array($result) && !(empty($result)))
        {
          $i = 1;
        ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Link</th>
              <th>Sku</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            foreach ($result as $value)
            {
              echo '<tr>';
                echo "<td>".$i++."</td>";
                echo "<td><a href='".$value['1']."' target='_blank'>".$value['1']."</a></td>";
                echo "<td>".$value['0']."</td>";
                echo "<td><a href='".base_url()."productdetails/".$value['0']."' title='".$value['0']."' target='_blank'>details</a></td>";
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>

        <hr />
        <ul>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc_product__url_alias.csv" title="oc_product__url_alias">'oc_product__url_alias.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product_to_layout.csv" title="oc__product_to_layout">'oc__product_to_layout.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product_to_store.csv" title="oc__product_to_store">'oc__product_to_store.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product_description.csv" title="oc__product_description">'oc__product_description.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product.csv" title="oc__product">'oc__product.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product_image.csv" title="oc__product_image">'oc__product_image.csv'</a></li>
            <li>Download <a href="<?=base_url();?>upload/opencart/new/oc__product_to_category.csv" title="oc__product_to_category">'oc__product_to_category.csv'</a></li>
        </ul>
        <hr />

        <?php
        }
        else
        {
          echo "<h1 class='text-warning'>No NEW Products</h1>";
        }
        ?>
      </div>
    </div>

  </div>
</div> 