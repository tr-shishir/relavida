<?php

/*

type: layout

name: Product col 4

position: 35

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-0';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-35-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="shop/products" limit="8" col_count="4" template="skin-2"/>
    </div>
</section>