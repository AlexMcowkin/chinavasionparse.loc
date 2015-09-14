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
                <a class="navbar-brand" href="<?=base_url();?>" title="chinavasionparce.loc">Chinavasionparce.loc</a>
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
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li><a href="<?=base_url();?>"><span class="icon-home"></span></a></li>
                        <li><a href="<?=base_url();?>faq"> FAQ</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>parcecategories">Get Categories</a></li>
                                <li><a href="<?=base_url();?>listcategories">List Categories</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=base_url();?>#">category_1</a></li>
                                <li><a href="<?=base_url();?>#">category_2</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=base_url();?>#">refresh site to rebuild this list</a></li>
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
                        <!-- <li><a href="<?=base_url();?>downloadxml">download XML</a></li> -->
                        <!-- <li><a href="<?=base_url();?>parsexml">parse XML</a></li> -->
                        <!-- <li><a href="<?=base_url();?>deletexmls">detele XMLs</a></li> -->
                        <!-- <li><a href="<?=base_url();?>results">parse RESULT</a></li> -->
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- MENU SECTION END-->