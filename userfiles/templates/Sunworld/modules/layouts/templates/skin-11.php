<?php

/*

type: layout

name: Services With Icon

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

<section class="section-34 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-11-<?php print $params['id'] ?>" rel="module">
    <div class="container boxes-wrapper">
        <div class="row icon-section">
            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Support safe-element"></i></span>
                    <h3><?php print _lang('Unique and Modern', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dum`my text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Smartphone-3 safe-element"></i></span>
                    <h3><?php print _lang('Easy to Customize', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dum`my text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Mouse-2 safe-element"></i></span>
                    <h3><?php print _lang('Multipurpose Layout', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Shopping-Cart safe-element"></i></span>
                    <h3><?php print _lang('Unique and Modern', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Add-User safe-element"></i></span>
                    <h3><?php print _lang('Easy to Customize', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>

            <div class="col-12 col-lg-4 single-box cloneable">
                <div class="flex-column icon-style allow-drop">
                    <span class="background-on-icon safe-element"><i class="mw-micon-Like safe-element"></i></span>
                    <h3><?php print _lang('Multipurpose Layout', 'templates/active'); ?></h3>
                    <p><?php print _lang('It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 'templates/active'); ?></p>
                    <br/>
                    <module type="btn" template="bootstrap" button_style="btn-default" text="Learn More"/>
                </div>
            </div>
        </div>

    </div>
</section>