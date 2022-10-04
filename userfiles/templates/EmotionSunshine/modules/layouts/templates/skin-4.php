<?php

/*

type: layout

name: Home Product

position: 4

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section safe-mode nodrop" field="layout-skin-4_<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="shop-product-all-top">
            <div class="shop-all-top-text edit" field="home_shop_heading" rel="content">
                <h4>UNSERE PRODUKT-HIGHLIGHTS</h4>
            </div>
            <div class="shop-divider"></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <module type="shop/products" template="skin-3" hide_paging="true" limit="8" />
            </div>
        </div>
    </div>
</section>