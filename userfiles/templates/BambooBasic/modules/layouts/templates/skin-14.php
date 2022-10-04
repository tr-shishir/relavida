<?php

/*

type: layout

name: Big Home Banner

position: 3

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-10';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-100';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<div data-parallax="" data-overlay="3" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-14-<?php print $params['id'] ?>" rel="module">
    <section class="section-6 d-flex background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/hero.jpg');">
        <div class="container align-self-center <?php print $layout_classes; ?>">
            <div class="row">
                <div class="col-12 allow-drop">
                    <h5 class="fx-deactivate"><?php print _lang('The Modern Home', 'templates/bamboo'); ?></h5>
                    <h2 class="fx-deactivate"><?php print _lang('Is a Mission', 'templates/bamboo'); ?></h2>
                    <p class="fx-deactivate"><?php print _lang('Find out our new collection', 'templates/bamboo'); ?></p>
                    <br/><br/>

                    <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="<?php print _lang('Buy Now', 'templates/bamboo'); ?>" class="fx-particles-2"/>
                </div>
            </div>
        </div>
    </section>
</div>