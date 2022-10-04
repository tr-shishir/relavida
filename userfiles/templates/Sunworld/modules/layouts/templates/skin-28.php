<?php

/*

type: layout

name: Info Box

position: 28

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-0';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-40 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-28-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 left-side">
                <div class="info allow-drop">
                    <h2><?php print _lang('About Us.', 'templates/active'); ?></h2>
                    <p><?php print _lang('We are a team of talanled developers, designers and entreprenues with one thing in common: we are passionate about the web/app development industry and want to improve the current workflow which is to often tedious and repetitive.', 'templates/active'); ?></p>
                </div>
                <div class="box allow-drop">
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
                    <p><?php print _lang('It has survived not only five centuries, but also the leap into electronic typesetting.', 'templates/active'); ?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="img-holder shadow" style="background-image: url('<?php print template_url(); ?>assets/img/section-38/bg2.png')"></div>
            </div>
        </div>
    </div>
</section>