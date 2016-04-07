<div class="content-wrapper">
  <div class="container">
    
    <div class="row">
      <div class="col-md-12">
        <h4 class="page-head-line">FAQ</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
          <p>How to use this parser...</p>
          <ul>
            <li>In application\config\constants.php change chanvasion's constants like:
              <ul>
                <li><strong>CHINAVASION_APIKEY</strong> - your chinavasion api key</li>
                <li><strong>CHINAVASION_APIURL_CATEGORY</strong> - the list all of product categories</li>
                <li><strong>CHINAVASION_APIURL_PRODUCTLIST</strong> - get products from specified categories</li>
                <li><strong>CHINAVASION_APIURL_PRODUCTDETAIL</strong> - get single product details</li>
              </ul>
            </li>
            <li>In application\config\constants.php change constant <strong>SAVE_IMAGES_PATH</strong> for saving images right to your desctop</li>
            <li>In application\helpers\chinavasion_helper.php change <strong>price calculation formula</strong></li>
            <li>In TRASH folder you can find database file with structure</li>
            <li>Change your OpenCart database:
              <ul>
                <li>ALTER TABLE `product` ADD `chinavasion_price` DECIMAL(15,4) NOT NULL DEFAULT '0.0000';</li>
                <li>ALTER TABLE `product_description` ADD `specification` TEXT NOT NULL;</li>
              </ul>
            </li>
          </ul>
      </div>
    </div>

  </div>
</div> 