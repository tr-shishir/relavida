<?php

/*

type: layout

name: Google Maps

position: 31

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-30';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-30';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="edit safe-mode nodrop <?php print $layout_classes; ?>" field="layout-skin-31-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid p-0">
        <module type="google_maps"/>
    </div>
</section>