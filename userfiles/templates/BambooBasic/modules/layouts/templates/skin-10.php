<?php

/*

type: layout

name: Contact Form

position: 10

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-0';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>


<div data-bg-contain class="edit safe-mode nodrop" field="layout-skin-10-<?php print $params['id'] ?>" rel="module">
    <section class="section-14 inverse background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/contacts.png');">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <div class="row">
                <div class="col-lg-6 col-xl-4">
                    <div class="text-holder-left allow-drop">
                        <h2 class="fx-deactivate"><?php print _lang('Say Hello', 'templates/bamboo'); ?></h2>
                        <p class="fx-deactivate"><?php print _lang('Hi! We love to speak with you!', 'templates/bamboo'); ?></p>
                    </div>
                    <module type="contact_form"/>
                </div>

                <div class="col-lg-6 col-xl-4 offset-xl-1">
                    <div class="text-holder-right allow-drop">
                        <h1 class="fx-deactivate"><?php print _lang('Contact Us', 'templates/bamboo'); ?></h1>
                        <p class="fx-deactivate"><?php print _lang('Sofia, Bulgaria <br /> Cherni Vruh 47. Flor 8. Droptienda CMS', 'templates/bamboo'); ?></p>
                        <p class="fx-deactivate"><?php print _lang('+359 878 123 456 <br /> +359 987 654 321', 'templates/bamboo'); ?></p>
                        <p class="fx-deactivate"><?php print _lang('www.bamboo.website <br /> info@bamboo.email', 'templates/bamboo'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
