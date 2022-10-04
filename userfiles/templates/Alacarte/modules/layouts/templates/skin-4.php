<?php

/*

type: layout

name: Simple Title with Text and Buttons

position: 4

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

<section class="section-7 d-flex <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-4-<?php print $params['id'] ?>" rel="module">
    <div class="container align-self-center">
        <div class="row">
            <div class="col-lg-7 col-xl-6 offset-xl-1 allow-drop pb-5">
                <h4><?php print _lang('Tasty and healthy', 'templates/theplace'); ?></h4>
                <h2><?php print _lang('Products', 'templates/theplace'); ?></h2>
                <p><?php print _lang('We use only selected products to maintain the high level of our cuisine. The best and fresh spices contribute to the taste of the dishes we make and their right combination is a guarantee of excellent results.', 'templates/theplace'); ?></p>
                <div class="m-t-50">
                    <module type="btn" template="bootstrap" button_style="btn-primary" button_size="btn-lg" text="View Our Blog"/>
                </div>
            </div>

            <div class="col-lg-5 col-xl-5 text-center allow-drop">
                <img src="<?php print template_url(); ?>assets/img/sections/vegetables.png" alt="" />
            </div>
        </div>
    </div>
</section>
