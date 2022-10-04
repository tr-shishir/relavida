<?php

/*

type: layout

name: Hero Video

position: 2

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-10';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-10';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-36 <?php print $layout_classes; ?> video-section edit safe-mode nodrop" field="layout-skin-2-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid p-0">
        <div class="content-holder video-holder">
            <module type="video-small" id="video-<?php print $params['id'] ?>" />
        </div>
        <div class="flex-column flex-center">
            <div class="content-holder flex-column allow-drop">
                <img src="<?php print template_url(); ?>assets/img/section-36/image.png" alt="">
                <h3 class="safe-element"><?php print _lang('Supporting Every Aspect of Your <br/><span>Individualized</span> Marketing Strategy.', 'templates/active'); ?></h3>
            </div>
        </div>
    </div>
</section>