<?php

/*

type: layout

name: Tabs

position: 22

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-10';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-10 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-22-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="tabs"/>
    </div>
</section>