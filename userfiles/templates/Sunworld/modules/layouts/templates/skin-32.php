<?php

/*

type: layout

name: Just Title and Text

position: 32

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<div data-bg-contain="" class="edit safe-mode nodrop" field="layout-skin-32-<?php print $params['id'] ?>" rel="module">
    <section class="section-31 background-image-holder" style="background-color: #282627;">
        <div class="container <?php print $layout_classes; ?> allow-drop">
            <h2><?php print _lang('In Our Blog...', 'templates/active'); ?></h2>
            <p><?php print _lang('Here you will find the latest thigs we are doing.<br/>Subscribe for more news and features.', 'templates/active'); ?></p>
        </div>
    </section>
</div>
