<?php

/*

type: layout

name: Info Box

position: 10

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-80';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-80';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-38 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-10-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6">
                <div class="info allow-drop">
                    <h2><?php print _lang('Explore the research and technology that makes Droptienda great.', 'templates/active'); ?></h2>
                </div>
                <div class="box allow-drop">
                    <h3><?php print _lang('Research', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="img-holder" style="background-image: url('<?php print template_url(); ?>assets/img/section-38/bg.png')"></div>
            </div>
        </div>
    </div>
</section>