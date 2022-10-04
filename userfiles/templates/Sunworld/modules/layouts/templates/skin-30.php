
<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-100';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-42 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-30-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-5">
                <div class="row">
                    <div class="col-12 allow-drop">
                        <h2 class="m-b-30"><?php print _lang('Hello.', 'templates/active'); ?></h2>
                        <h2 class="m-b-10"><?php print _lang('Share the future with us.<br/>Feel free to get in touch.', 'templates/active'); ?></h2>
                        <h3 class="m-b-20"><?php print _lang('Send us your email.', 'templates/active'); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 offset-md-1 right-side">
                <div class="bg-holder"></div>
                <div class="company-badge"><img src="<?php print template_url(); ?>assets/img/section-42/badge.png"></div>

                <div class="box shadow allow-drop">

                    <h2 class="m-b-30"><?php print _lang('Find Us.', 'templates/active'); ?></h2>
                    <h3 class="m-b-30"><?php print _lang('Active Technologies.', 'templates/active'); ?></h3>

                    <div class="information nodrop">
                        <div class="row cloneable">
                            <div class="col-12 allow-drop">
                                <label><?php print _lang('E-mail', 'templates/active'); ?></label>
                                <p><?php print _lang('touch@yourcompany.com', 'templates/active'); ?></p>
                            </div>
                        </div>

                        <div class="row cloneable">
                            <div class="col-12 allow-drop">
                                <label><?php print _lang('Phone', 'templates/active'); ?></label>
                                <p><?php print _lang('+359 123 456 789', 'templates/active'); ?></p>
                            </div>
                        </div>

                        <div class="row cloneable">
                            <div class="col-12 allow-drop">
                                <label><?php print _lang('Address', 'templates/active'); ?></label>
                                <p><?php print _lang('Sofia, Bulgaria<br />bul. Cherni Vrah 47 A', 'templates/active'); ?></p>
                            </div>
                        </div>

                        <div class="row cloneable">
                            <div class="col-12 allow-drop">
                                <label><?php print _lang('Company Number', 'templates/active'); ?></label>
                                <p><?php print _lang('3344556677', 'templates/active'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>