<?php

/*

type: layout

name: Product col 3
position: 9

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
<section class="section <?php print $layout_classes; ?> safe-mode nodrop" field="layout-skin-7-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="shop/products"/>
    </div>
</section>