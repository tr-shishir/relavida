<?php

/*

type: layout

name: Simple Title with Text and Buttons

position: 4

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

<section class="section-2 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-4-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h2><?php print _lang('Our Solutions', 'templates/active'); ?></h2>
        <p><?php print _lang('Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
        <p class="m-t-50">
            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Business Consulting" class="inline-block cloneable m-l-10 m-r-10"/>
            <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Tailor Mode Solutions" class="inline-block cloneable m-l-10 m-r-10"/>
        </p>
    </div>
</section>
