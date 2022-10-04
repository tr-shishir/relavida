<?php

/*

type: layout

name: Features with icon

position: 7

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

<section class="section-13 edit safe-mode nodrop" field="layout-skin-7-<?php print $params['id'] ?>" rel="module">
    <div class="container <?php print $layout_classes; ?> allow-drop">
        <h2 class="fx-deactivate m-b-0"><?php print _lang('Why to use our products?', 'templates/guesthouse'); ?></h2>
        <p>There is a lot of gratitude for this, but we give you three main ones</p>
        <br/>
        <br/>
        <br/>
        <div class="features nodrop">
            <div class="feature cloneable">
                <div class="image">
                    <i class="mw-micon-Forest safe-element"></i>
                </div>
                <div class="title">
                    <p>Material</p>
                </div>
                <div class="description">
                    <p>Carefully selected environmentally friendly materials.</p>
                </div>
            </div>

            <div class="feature cloneable">
                <div class="image">
                    <i class="mw-micon-Chair safe-element"></i>
                </div>
                <div class="title">
                    <p>Design</p>
                </div>
                <div class="description">
                    <p>Design that inspires, diversifies and feels comfortable.</p>
                </div>
            </div>

            <div class="feature cloneable">
                <div class="image">
                    <i class="mw-micon-Like-2 safe-element"></i>
                </div>
                <div class="title">
                    <p>Quality</p>
                </div>
                <div class="description">
                    <p>Carefully selected environmentally friendly materials.</p>
                </div>
            </div>
        </div>
    </div>
</section>