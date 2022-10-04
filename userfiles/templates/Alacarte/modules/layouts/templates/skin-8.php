<?php

/*

type: layout

name: Simple Title with Text

position: 8

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

<section class="section-2 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-8-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row cloneable">
            <div class="col-md-6">
                <img src="<?php print template_url(); ?>assets/img/sections/mages_section_1.png" alt=""/>
            </div>
            <div class="col-md-6">
                <img src="<?php print template_url(); ?>assets/img/sections/mages_section_2.png" alt=""/>
            </div>
        </div>

        <div class="row m-t-80 cloneable">
            <div class="col-12 text-center allow-drop">
                <h4>Chef John Doe</h4>
                <img src="<?php print template_url(); ?>assets/img/sections/sign.svg" alt="" style="max-width:200px;"/>
            </div>
        </div>
    </div>
</section>
