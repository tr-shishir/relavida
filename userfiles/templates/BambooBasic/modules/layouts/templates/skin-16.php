<?php

/*

type: layout

name: Information with Parallax

position: 16

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

<div data-parallax="" data-overlay="5" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-16-<?php print $params['id'] ?>" rel="module">
    <section class="section-4 background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/banner.jpg'); background-position:center center;">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <h2 class="fx-deactivate"><?php print _lang('New Sofa Collection', 'templates/bamboo'); ?></h2>
            <p class="fx-deactivate"><?php print _lang('See our new collection of sofas', 'templates/bamboo'); ?></p>
            <br/><br/>

            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-md" text="<?php print _lang('Buy Now', 'templates/bamboo'); ?>" class="fx-particles-2"/>
        </div>
    </section>
</div>