<?php

/*

type: layout

name: Contact Information

position: 20

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

<section class="section-11 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-20-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 left-side" style="background-image: url('<?php print template_url(); ?>assets/img/sections/mages_section_2.png');">
                &nbsp;
            </div>

            <div class="col-lg-6 right-side">
                <div class="holder">
                    <div class="row m-b-20">
                        <div class="col-md-6 col-lg-12 col-xl-6 m-t-20 mx-auto m-b-10 m-t-10 allow-drop cloneable">
                            <h5 class="fx-deactivate"><?php print _lang('Phone Lines', 'templates/theplace'); ?></h5>
                            <p class="fx-deactivate"><?php print _lang('+359 878 123 456, 359 889 321 654', 'templates/theplace'); ?></p>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6 m-t-20 mx-auto m-b-10 m-t-10 allow-drop cloneable">
                            <h5 class="fx-deactivate"><?php print _lang('Address', 'templates/theplace'); ?></h5>
                            <p class="fx-deactivate"><?php print _lang('Sofia 1000, Bulgaria. Main Street 99', 'templates/theplace'); ?></p>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6 m-t-20 mx-auto m-b-10 m-t-10 allow-drop cloneable">
                            <h5 class="fx-deactivate"><?php print _lang('E-mail', 'templates/theplace'); ?></h5>
                            <p class="fx-deactivate"><?php print _lang('Reservations@theplace.email', 'templates/theplace'); ?></p>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6 m-t-20 mx-auto m-b-10 m-t-10 allow-drop cloneable">
                            <h5 class="fx-deactivate m-b-0"><?php print _lang('Social', 'templates/theplace'); ?></h5>
                            <module type="social_links" template="skin-1"/>
                        </div>
                    </div>

                    <module type="google_maps"/>
                </div>
            </div>
        </div>
    </div>
</section>