<?php

/*

type: layout

name: Left text - Right Image

position: 6

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

<section class="section-5 <?php print $layout_classes; ?> fx-particles edit safe-mode nodrop" field="layout-skin-6-<?php print $params['id'] ?>" rel="module" style="">
    <div class="container">
        <div class="row features">
            <div class="col-sm-6 col-lg-3 cloneable">
                <div class="feature">
                    <div class="image">
                        <div class="holder">
                            <img src="<?php print template_url(); ?>assets/img/sections/feature_1.png" alt=""/>
                        </div>
                    </div>
                    <h6>Fresh ingredients</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 cloneable">
                <div class="feature">
                    <div class="image">
                        <div class="holder">
                            <img src="<?php print template_url(); ?>assets/img/sections/feature_2.png" alt=""/>
                        </div>
                    </div>
                    <h6>Healthy Meals</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 cloneable">
                <div class="feature">
                    <div class="image">
                        <div class="holder">
                            <img src="<?php print template_url(); ?>assets/img/sections/feature_3.png" alt=""/>
                        </div>
                    </div>
                    <h6>Mediteranean taste</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 cloneable">
                <div class="feature">
                    <div class="image">
                        <div class="holder">
                            <img src="<?php print template_url(); ?>assets/img/sections/feature_4.png" alt=""/>
                        </div>
                    </div>
                    <h6>Eating Well</h6>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
            </div>
        </div>
    </div>
</section>