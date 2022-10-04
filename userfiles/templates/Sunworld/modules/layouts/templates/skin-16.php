<?php

/*

type: layout

name: Simple Title with Text, Button and Parallax

position: 16

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-100';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<div data-parallax="" data-overlay="5" data-overlay-black="" background-position="center top" class="edit safe-mode nodrop" field="layout-skin-16-<?php print $params['id'] ?>" rel="module">
    <section class="section-31 background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/section-31/bg.jpg'); background-color: #282627;">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <i class="mw-micon-solid-Coffee"></i>
            <br/>
            <br/>
            <h2><?php print _lang('Want to See More?', 'templates/active'); ?></h2>
            <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br/>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
            <br/><br/>
            <br/>

            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Get More" class="fx-particles-2"/>
        </div>
    </section>
</div>