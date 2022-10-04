<?php

/*

type: layout

name: Product Col 4

position: 2

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


<section class="section <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-products-skin-2-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="shop/products" template="skin-2" limit="8" col_count="4" hide_paging="true"/>  
    </div>
</section>