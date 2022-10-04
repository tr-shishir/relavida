<?php

/*

type: layout

name: New

description: Layout

position: 5

*/
?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = '';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = '';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<div class="nodrop safe-mode edit <?php print $layout_classes; ?>" field="layout-skin-11-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="mw-static-element mw-image-and-text" id="image-and-text-<?php print CONTENT_ID; ?>">
            <div class="mw-ui-row row">
                <div class="col-md-6">
                    <div class="mw-ui-col cloneable">
                        <div class="image">
                            <img src="<?php print elements_url() ?>images/default-2.png" alt=""/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mw-ui-col cloneable">
                        <div class="text">
                            <h1>Our Services</h1>
                            <p>Template layout is ready for edit in ream time with Droptienda.<br/>
                                How to Be Creative. Creativity is a skill that you can work on with time, training, and effort. There are many areas you can focus on to improve your overall creativity.
                            </p>
                            <div class="element">
                                <module type="btn" text="Button"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
