<?php


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


<div data-parallax="" data-overlay="5" data-overlay-black="" class="edit safe-mode nodrop" field="layout-skin-10-<?php print $params['id'] ?>" rel="module">
    <section class="section-4 background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/flour.jpg');">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <h6 class="fx-deactivate"><?php print _lang('Reservation online', 'templates/theplace'); ?></h6>
            <h2 class="fx-deactivate"><?php print _lang('Reservations', 'templates/theplace'); ?></h2>
            <p class="fx-deactivate"><?php print _lang('Our menu is prepared by the special advice of Cheff Manchev. <br /> All the products we use to prepare the dishes are environmentally friendly, <br /> healthy and delicious.', 'templates/theplace'); ?></p>
            <br/><br/>
        </div>
    </section>
</div>
