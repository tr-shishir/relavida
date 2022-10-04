<?php

/*

type: layout

name: Brands Slider

position: 26

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-100';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section <?php print $layout_classes; ?> fx-deactivate edit safe-mode nodrop" field="layout-skin-26-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="pictures" template="skin-1"/>
    </div>
</section>