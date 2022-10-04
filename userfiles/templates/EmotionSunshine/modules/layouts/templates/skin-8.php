<?php

/*

type: layout

name: Gallery

position: 8

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-0';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-0';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section sec-padd-50 x-edit safe-mode nodrop" field="layout-skin-8-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <module type="pictures" template="skin-4"/>
            </div>
        </div>
    </div>
</section>
