<?php

/*

type: layout

name: Simple Title with Text

position: 3

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-3 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-3-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h4><?php print _lang('Tasty and healthy', 'templates/theplace'); ?></h4>
        <h2><?php print _lang('Our Story', 'templates/theplace'); ?></h2>
        <p><?php print _lang('Our reputable restaurant is ready to satisfy even your most sophisticated taste. Top cooks from all over the world visit and cook for you your best specialties for a week. Come and enjoy delicious delicacies.', 'templates/theplace'); ?></p>
        <div class="m-t-50">
            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Business Consulting" class="inline-block cloneable m-l-10 m-r-10"/>
            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Tailor Mode Solutions" class="inline-block cloneable m-l-10 m-r-10"/>
        </div>
    </div>
</section>
