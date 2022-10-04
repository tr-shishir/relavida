<?php

/*

type: layout

name: Products Slider

position: 19

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

<section class="section edit safe-mode nodrop" field="layout-skin-19-<?php print $params['id'] ?>" rel="module">
    <module type="slider" template="slickslider-skin-1"/>
</section>