<?php

/*

type: layout

name: Left Text - Right Image

position: 7

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-0';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-0';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-4 <?php print $layout_classes; ?> fx-particles edit safe-mode nodrop" field="layout-skin-7-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 left-side allow-drop">
                <h3><i class="mw-micon-solid-Leafs-2 safe-element"></i> <?php print _lang('Design and Development', 'templates/active'); ?></h3>
                <p><?php print _lang('Mean Quality in the design and development. We are here to change the way you publish in the web. Use this theme pepared for your needs and connected to the best open source
                    drag and drop website builder and CMS Droptienda. Trust of Quality support and features that you
                    allways want.', 'templates/active'); ?></p>

                <p><br/><strong><?php print _lang('Discover our best ever services', 'templates/active'); ?></strong><br/><br/></p>

                <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="<?php print _lang('Click Here', 'templates/active'); ?>" class="fx-particles-1"/>
            </div>

            <div class="col-12 col-lg-6 img-holder" style="background-image: url('<?php print template_url(); ?>assets/img/section-4/bg.png');"></div>
        </div>
    </div>
</section>