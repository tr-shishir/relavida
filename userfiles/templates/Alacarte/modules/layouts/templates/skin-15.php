<?php

/*

type: layout

name: Heading with Image

position: 15

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

<div data-parallax="" data-overlay="3" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-15-<?php print $params['id'] ?>" rel="module">
    <section class="section-6 h-half d-flex background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/salmon_and_mashrooms.jpg');">
        <div class="container align-self-center">
            <div class="row">
                <div class="col-12 allow-drop">
                    <h5 class="fx-deactivate"><?php print _lang('Tasty and Healthy', 'templates/theplace'); ?></h5>
                    <h2 class="fx-deactivate"><?php print _lang('Our Menu', 'templates/theplace'); ?></h2>
                </div>
            </div>
        </div>
    </section>
</div>