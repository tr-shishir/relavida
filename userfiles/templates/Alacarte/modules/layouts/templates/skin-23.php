<?php

/*

type: layout

name: Product Col 3

position: 23

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

<section class="section <?php print $layout_classes; ?> safe-mode nodrop" field="layout-skin-22-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-12">
                <module type="shop/products" hide_paging="true" limit="6" />
            </div>
        </div>
    </div>
</section>