<?php

/*

type: layout

name: Product With Sidebar

position: 2

*/

?>

<div class="nk-box bg-white nodrop safe-mode" field="layout-skin-70-<?php print $params['id'] ?>" rel="module"  id="projects">
    <div class="nk-gap-4 mt-5"></div>

    <h2 class="text-xs-center display-4">Last Products</h2>

    <div class="nk-gap mnt-6"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 allow-drop">
                <div class="text-xs-center">Donec orci sem, pretium ac dolor et, faucibus faucibus mauris. Etiam,pellentesque faucibus. Vestibulum gravida volutpat ipsum non ultrices.
                </div>
            </div>
        </div>
    </div>

    <div class="nk-gap-2 mt-12"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                <module type="shop/products" limit="6" col_count="3"/>
            </div>
        </div>
    </div>
    <div class="nk-gap-2 mt-12"></div>
</div>