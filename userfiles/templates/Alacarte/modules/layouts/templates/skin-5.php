<?php

/*

type: layout

name: Simple Title with Text and Buttons

position: 5

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

<div data-parallax="" data-overlay="5" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-5-<?php print $params['id'] ?>" rel="module">
    <section class="section-4 background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/flour.jpg');">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <h2 class="fx-deactivate"><?php print _lang('Welcome to Our Kitchen', 'templates/theplace'); ?></h2>
            <p class="fx-deactivate"><?php print _lang('We will be glad to meet you', 'templates/theplace'); ?></p>
            <br/><br/>

            <module type="btn" template="bootstrap" button_style="btn-primary" button_size="btn-md" text="<?php print _lang('Meet Us', 'templates/theplace'); ?>" class="fx-particles-2"/>
        </div>
    </section>
</div>