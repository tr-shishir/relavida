<?php

/*

type: layout

name: Left text - Right Image

position: 27

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

<section class="section-35 <?php print $layout_classes; ?> fx-particles edit safe-mode nodrop" field="layout-skin-27-<?php print $params['id'] ?>" rel="module" style="">
    <div class="container-fluid">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 left-side allow-drop">
                <h3><i class="mw-micon-solid-Leafs-2 safe-element"></i> <?php print _lang('We use innovative technologies that save your time and money', 'templates/active'); ?></h3>
                <p><?php print _lang('Using our digital marketing services, improve your business performance in terms of better lead generation, engagement and enhanced ROI with a more customer centric approach.', 'templates/active'); ?></p>
            </div>
            <div class="col-12 col-lg-6 img-holder"><img src="<?php print template_url(); ?>assets/img/section-34/img.png"/></div>
        </div>
    </div>
</section>