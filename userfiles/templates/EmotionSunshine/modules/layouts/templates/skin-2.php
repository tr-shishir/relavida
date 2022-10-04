<?php

/*

type: layout

name: Slider Layout

position: 0

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-0';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>
<section class="section home-slider-section edit" field="layout-skin-2-<?php print $params['id'] ?>" rel="module">
    <div class="home-banner">
        <module type="slider" template="slickslider-skin-2"/>
    </div>
</section>
