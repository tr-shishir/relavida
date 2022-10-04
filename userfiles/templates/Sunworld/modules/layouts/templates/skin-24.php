<?php

/*

type: layout

name: Call To Action

position: 24

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

<section class="section-14 <?php print $layout_classes; ?> fx-deactivate edit safe-mode nodrop" field="layout-skin-24-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h2><?php print _lang('Let\'s Start Together', 'templates / active'); ?></h2>
        <p><?php print _lang('Contrary to popular belief, Lorem Ipsum is not simply random text.', 'templates/active'); ?><br/><br/></p>

        <module type="btn" template="bootstrap" button_style="btn-primary" button_size="btn-lg" text="Contact Us"/>
    </div>
</section>