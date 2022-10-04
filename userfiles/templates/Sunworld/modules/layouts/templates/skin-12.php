<?php

/*

type: layout

name: Video with Text

position: 12

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-80';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-80';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-20 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-12-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row flexbox-container">
            <div class="col-12 col-lg-7 img-holder">
                <div class="div-table">
                    <div class="div-table-cell">
                        <div class="m-helper">
                            <div class="decoration"></div>
                            <div class="mw-waves-btn inverse">
                                <div class="w-btn">
                                    <a class="popup-vimeo" href="https://vimeo.com/279249292"><i class="fa fa-play"></i></a>
                                </div>
                                <div class="waves-holder">
                                    <div class="waves wave-1"></div>
                                    <div class="waves wave-2"></div>
                                    <div class="waves wave-3"></div>
                                </div>
                            </div>
                            <div class="img">
                                <div class="h" style="background-image: url('<?php print template_url(); ?>assets/img/section-20/image.png');"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5 right-side allow-drop">
                <h3><?php print _lang('We love what we do!', 'templates/active'); ?></h3>
                <p><?php print _lang('One minute video of our best product', 'templates/active'); ?></p>
                <br/>
                <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry. The industry\'s standard dummy text ever since the 1500s.', 'templates / active'); ?></p>
                <br/> <br/>

                <module type="btn" template="bootstrap" button_style="btn-default" text="<?php print _lang('Learn More', 'templates/active'); ?>"/>
            </div>
        </div>
    </div>
</section>