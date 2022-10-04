<?php

/*

type: layout

name: Left Image - Right Text and Buttons

position: 9

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

<section class="section-37 <?php print $layout_classes; ?> fx-particles edit safe-mode nodrop" field="layout-skin-9-<?php print $params['id'] ?>" rel="module" style="">
    <div class="container-fluid">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-6 img-holder"><img src="<?php print template_url(); ?>assets/img/section-37/img.png"/></div>

            <div class="col-12 col-lg-6 right-side allow-drop">
                <h3>Best Social Application<br/> +1 Million Users</h3>
                <p>A mobile app is a program designer and developerd to run on devices such as smartphones and tablets</p>
                <br/>
                <br/>

                <div class="buttons">
                    <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Apple Store" class="inline-block cloneable"/>
                    <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="Google Play" class="inline-block cloneable"/>
                </div>
            </div>
        </div>
    </div>
</section>