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

<section class="section-2 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-3-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h2><?php print _lang('Some Title', 'templates/active'); ?></h2>
        <p><?php print _lang('Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'templates / active'); ?></p>
    </div>
</section>
