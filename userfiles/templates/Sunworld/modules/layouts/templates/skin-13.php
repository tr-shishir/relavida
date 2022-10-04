<?php

/*

type: layout

name: Simple Title

position: 3

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-10';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-10';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-2 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-13-<?php print $params['id'] ?>" rel="module">
    <div class="container allow-drop">
        <h2><?php print _lang('Some Title', 'templates/active'); ?></h2>
    </div>
</section>
