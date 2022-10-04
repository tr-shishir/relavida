<?php

/*

type: layout

name: Services With Image

position: 11

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

<section class="section-34 service-image-section <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-11-<?php print $params['id'] ?>" rel="module">
    <div class="container boxes-wrapper">
        <div class="row icon-section">
            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                        <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Unique and Modern', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dum`my text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                    <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Easy to Customize', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dum`my text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                    <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Multipurpose Layout', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                    <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Unique and Modern', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                    <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Easy to Customize', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element">
                    <img src="<?php print template_url(); ?>assets/image/preisvergleich-export.png" alt="">
                    </span>
                    <h3><?php print _lang('Multipurpose Layout', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>
        </div>

    </div>
</section>