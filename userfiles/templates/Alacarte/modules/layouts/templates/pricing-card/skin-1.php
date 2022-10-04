<?php

/*

type: layout

name: Pricing Card With Table

position: 29

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

<section class="section <?php echo $layout_classes; ?> edit safe-mode nodrop" field="layout-pricing-card-skin-1-<?php print $params['id'] ?>" rel="module">
    <div class="container">
       <module type="pricing_card"/>
    </div>
</section>
