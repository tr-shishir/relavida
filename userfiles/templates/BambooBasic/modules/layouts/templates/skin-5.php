<?php

/*

type: layout

name: Testimonials

position: 5

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-100';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-4 inverse <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-5-<?php print $params['id'] ?>" rel="module">

    <div class="container align-self-center">
        <h1 class="m-b-0">What our clients says?</h1>
        <p>A real testimonials from real customers</p>

        <module type="testimonials" template="skin-2"/>
    </div>
</section>

