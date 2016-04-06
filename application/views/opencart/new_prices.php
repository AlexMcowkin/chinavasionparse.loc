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
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Sku</th>
              <th>Old Price</th>
              <th>New Price</th>
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
              echo "<td><a href='".$value[3]."' target='_blank'>".$value[3]."</a></td>";
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
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