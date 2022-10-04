<?php

/*

type: layout

name: Parallax Image

position: 16

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

<div data-parallax="" class="edit safe-mode nodrop" field="layout-skin-16-<?php print $params['id'] ?>" rel="module">
    <section class="section-6 h-third d-flex background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/main-home-5.jpg');">
        <div class="container align-self-center <?php print $layout_classes; ?> allow-drop">
            <div class="row">
                <div class="col-12 allow-drop">

                </div>
            </div>
        </div>
    </section>
</div>