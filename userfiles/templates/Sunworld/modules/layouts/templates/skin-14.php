<?php

/*

type: layout

name: Testimonials

position: 14

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-30';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-80';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-13 inverse <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-14-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <module type="testimonials"/>
    </div>
</section>
