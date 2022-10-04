<?php

/*

type: layout

name: Product Slider with Info

position: 34

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

<section class="section-43 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-34-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 left-side">
                <div class="info allow-drop">
                    <h2><?php print _lang('Make more sales and <br class="hidden-xs"/>save more money.<br class="hidden-xs"/>Get your discount today.', 'templates/active'); ?></h2>
                </div>
                <div class="box allow-drop">
                    <h3><?php print _lang('Modern Watch on Sale', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
                </div>
            </div>

            <div class="col-12 col-lg-6" style="position: relative">
                <div class="img-holder shadow" style="position: relative;">
                    <module type="slider" template="slickslider-skin-2"/>
                </div>
            </div>
        </div>
    </div>
</section>