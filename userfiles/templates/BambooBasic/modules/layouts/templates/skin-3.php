<?php

/*

type: layout

name: Title, Text and Button

position: 3

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

<section class="section-3 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-3-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h2><?php print _lang('About Us', 'templates/bamboo'); ?></h2>
        <p><?php print _lang('High-quality design and interior design.<br /> Here you will find original furniture ideas and unique products. <br />Look for individual tips and orders.', 'templates/bamboo'); ?></p>
        <div class="m-t-50">
            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Read More" class="inline-block cloneable m-l-10 m-r-10"/>
        </div>
    </div>
</section>
