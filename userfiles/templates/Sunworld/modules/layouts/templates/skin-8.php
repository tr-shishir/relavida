<?php

/*

type: layout

name: Left Image - Right Text

position: 8

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

<section class="section-5 <?php print $layout_classes; ?> fx-particles edit safe-mode nodrop" field="layout-skin-8-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 img-holder" style="background-image: url('<?php print template_url(); ?>assets/img/section-5/bg2.png');"></div>

            <div class="col-12 col-lg-6 right-side allow-drop">
                <h3><i class="mw-micon-solid-Like-2 safe-element"></i> <?php print _lang('Social Media Management', 'templates/active'); ?></h3>
                <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
            </div>
        </div>
    </div>
</section>