<?php

/*

type: layout

name: Product Col 3

position: 24

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

<section class="section sec-padd-50 safe-mode nodrop" field="layout-skin-24-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <module type="shop/products" template="skin-5" hide_paging="true"/>
            </div>
        </div>
    </div>
</section>