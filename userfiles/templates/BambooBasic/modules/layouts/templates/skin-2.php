<?php

/*

type: layout

name: Home Banner

position: 2

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-0';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-7 d-flex <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-2-<?php print $params['id'] ?>" rel="module">
    <div class="container align-self-center align-items-center">
        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="<?php print template_url(); ?>assets/img/sections/home.png" alt=""/>
            </div>

            <div class="col-lg-12 m-t-60 text-center allow-drop">
                <p><?php print _lang('+359  001  22  445', 'templates/bamboo'); ?></p>
                <p><?php print _lang('hello@droptienda.email', 'templates/bamboo'); ?></p>
                <div class="m-t-50">
                    <a href="#" class="safe-element arrow-down"><i class="mw-micon-Arrow-Down"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
