<!-- HEADER END-->
<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <p>
                <a class="navbar-brand" href="<?=base_url();?>" title="chinavasionparse.loc"><span style="color:#F5F5F5;text-shadow: 2px 2px 2px #333;">ChinavasionParse.loc</span></a>
                <small>based on chinavasion.com API</small>
            </p>
         </div>
    </div>
</div>
<!-- LOGO HEADER END-->
<section class="menu-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-collapse collapse ">
                    <ul id="menu-top" class="nav navbar-nav navbar-left">
                        <li><a href="<?=base_url();?>"><span class="icon-home icon-large"></span></a></li>
                        <li><a href="<?=base_url();?>logout" onclick="return confirm('Are you sure?')" title="logout"><span class="icon-power-off icon-large"></span></a></li>
                        <li><a href="<?=base_url();?>faq" title="FAQ"><span class="icon-question-sign icon-large"></span></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">PARSING DATA <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>parcecategories">Parse Categoreis</a></li>
                                <li><a href="<?=base_url();?>listcategories">Parse Products</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">New Products <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>parcenewproducts">Get New Products</a></li>
                                <li><a href="<?=base_url();?>getnewproducts">Show New Products Links</a></li>
                            </ul>
                        </li>
                        <li><a href="<?=base_url();?>parseimg">Save Images</a></li>
                    </ul>

                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">OpenCart: STOCK <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>opencart/uploadstock">UPLOAD STOCK</a></li>
                                <li><a href="<?=base_url();?>opencart/downloadstock">DOWNLOAD STOCK</a></li>
                                <li><a href="<?=base_url();?>opencart/checkprices">CHECK PRICES</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">OpenCart: NEW <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>opencart/csvcatcommon">CSV: import categories common data</a></li>
                                <li><a href="<?=base_url();?>opencart/csvcattext">CSV: import categories text</a></li>
                                <li><a href="<?=base_url();?>opencart/csvcatlayout">CSV: import categories to layout</a></li>
                                <li><a href="<?=base_url();?>opencart/csvcatstore">CSV: import categories to store</a></li>
                                <li><a href="<?=base_url();?>opencart/csvcatseo">CSV: import categories seo url</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=base_url();?>opencart/csvprodcommon">CSV: import products common data</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodtext">CSV: import products text</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodimg">CSV: import products images</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodcat">CSV: import products to category</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodlayout">CSV: import products to layout</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodstore">CSV: import products to store</a></li>
                                <li><a href="<?=base_url();?>opencart/csvprodseo">CSV: import products seo url</a></li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- MENU SECTION END-->