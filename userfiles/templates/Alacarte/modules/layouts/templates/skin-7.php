<?php

/*

type: layout

name: Heading Dark

position: 7

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

<div data-parallax="" data-overlay="1" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-7-<?php print $params['id'] ?>" rel="module">
    <section class="section-6 d-flex background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/main-home.jpg');">
        <div class="container align-self-center <?php print $layout_classes; ?>">
            <div class="row">
                <div class="col-12 allow-drop">
                    <h5 class="fx-deactivate"><?php print _lang('Wine and Dinner', 'templates/theplace'); ?></h5>
                    <h2 class="fx-deactivate"><?php print _lang('Restaurant', 'templates/theplace'); ?></h2>
                    <p class="fx-deactivate"><?php print _lang('The favorite place for steaks.<br />Mature minimum of 28 days in appropriate conditions.', 'templates/theplace'); ?></p>
                    <br/><br/>

                    <module type="btn" template="bootstrap" button_style="btn-primary" button_size="btn-lg" text="<?php print _lang('Make Reservation', 'templates/theplace'); ?>" class="fx-particles-2"/>
                </div>
            </div>
        </div>
    </section>
</div>