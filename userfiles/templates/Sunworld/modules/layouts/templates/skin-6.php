<?php

/*

type: layout

name: Simple Title with Text and Button

position: 6

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

<div data-bg-contain="" class="edit safe-mode nodrop" field="layout-skin-6-<?php print $params['id'] ?>" rel="module">
    <section class="section-31 background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/section-31/bg.png'); background-color: #282627;">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <h2>Theme For Your Next Project</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            <br/><br/>
            <br/><br/>

            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Contact Us" class="fx-particles-2"/>
        </div>
    </section>
</div>