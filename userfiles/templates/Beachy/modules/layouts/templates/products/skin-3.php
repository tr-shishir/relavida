<?php

/*

type: layout

name: Product With Sidebar

position: 99

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>


<section class="section <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-products-skin-99-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9 col-xl-9">
                <module type="shop/products" limit="6" col_count="3" hide_paging="true"/>
            </div>
        </div>
    </div>
</section>