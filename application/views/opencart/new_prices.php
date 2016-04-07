<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Chinavasion's New Prices</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php
        if(is_array($result) && !(empty($result)))
        {
          $i = 1;
        ?>
        <p>Download <a href="<?=base_url();?>upload/opencart/<?=$downloadcsv;?>" title="csv new price update">new price update</a>.</p>
        <hr />
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Sku</th>
              <th>Old CV Price</th>
              <th>New CV Price</th>
              <th>New OC Price</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            foreach ($result as $value)
            {
              echo '<tr>';
              echo "<td>".$i++."</td>";
              echo "<td>".$value[0]."</td>";
              echo "<td>".$value[1]."</td>";
              echo "<td class='text-danger'>".$value[2]."</td>";
              echo "<td class='text-success'>".mysellprice($value[2])."</td>";
              echo "<td><a href='".$value[3]."' target='_blank'>".$value[3]."</a></td>";
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
        <hr />
        <p>Download <a href="<?=base_url();?>upload/opencart/<?=$downloadcsv;?>" title="csv new price update">new price update</a>.</p>
        <?php
        }
        else
        {
          echo "<h1 class='text-warning'>PRICES didnt change</h1>";
        }
        ?>
      </div>
    </div>

  </div>
</div> 