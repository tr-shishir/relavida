<?php

/*

type: layout

name: Image with Features (Icons)

position: 17

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section-12 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-17-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="img-holder"><img src="<?php print template_url(); ?>assets/img/section-12/mockup.png"/></div>

        <div class="right-side">
            <div class="feature cloneable">
                <div class="icon"><i class="mw-micon-solid-Happy safe-element"></i></div>
                <div class="text allow-drop">
                    <h3><?php print _lang('Easy Customizable', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'templates/active'); ?></p>
                </div>
            </div>

            <div class="feature cloneable">
                <div class="icon"><i class="mw-micon-solid-Laptop-Phone safe-element"></i></div>
                <div class="text allow-drop">
                    <h3><?php print _lang('Fully Responsive', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'templates/active'); ?></p>
                </div>
            </div>

            <div class="feature cloneable">
                <div class="icon"><i class="mw-micon-solid-Pipette safe-element"></i></div>
                <div class="text allow-drop">
                    <h3><?php print _lang('Unlimited Color ORT', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'templates/active'); ?></p>
                </div>
            </div>

            <div class="feature cloneable">
                <div class="icon"><i class="mw-micon-solid-Like safe-element"></i></div>
                <div class="text allow-drop">
                    <h3><?php print _lang('Exellent Features', 'templates/active'); ?></h3>
                    <p><?php print _lang('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'templates/active'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>