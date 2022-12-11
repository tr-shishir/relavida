<?php

/*

type: layout

name: Product With Sidebar V2

position: 4

*/

?>

<section class="section safe-mode nodrop" field="layout-shop-main-layout-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="shop-container">
            <div class="row">
                <div class="col-md-3">
                    <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
                </div>
                <div class="col-md-9">
                    <module type="shop/productsv2" hide_paging="true" limit="6" col_count="3" />
                </div>
            </div>
        </div>
    </div>
</section>
