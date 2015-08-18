<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">Chinavasion New Prooduct</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php
        if(is_array($result))
        {
          $i = 1;
          foreach ($result as $value)
          {
            echo "<p> ".$i++." <a href='".$value."' target='_blank'>".$value."</a></p>";
          }
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