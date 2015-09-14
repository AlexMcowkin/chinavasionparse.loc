<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Chinavasion's New Prooducts</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php
        if(is_array($result))
        {
          $i = 1;
        ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Link</th>
              <th>Sku</th>
            </tr>
          </thead>
          <tbody>
            <?php  
            foreach ($result as $value)
            {
              echo '<tr>';
              echo "<td>".$i++."</td>";
              echo "<td><a href='".$value['0']."' target='_blank'>".$value['0']."</a></td>";
              echo "<td>".$value['1']."</td>";
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
        <?php
        }
        else
        {
          echo "<h1 class='text-warning'>".$result."</h1>";
        }
        ?>
      </div>
    </div>

  </div>
</div> 