<?php

/*

type: layout

name: Menu

position: 9

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>


<div class="<?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-9-<?php print $params['id'] ?>" rel="module">
    <section class="section-3">
        <div class="container allow-drop">
            <h4><?php print _lang('Tasty and healthy', 'templates/theplace'); ?></h4>
            <h2><?php print _lang('Our menu', 'templates/theplace'); ?></h2>
            <p><?php print _lang('Our menu is prepared by the special advice of Cheff Manchev. All the products we use to prepare the dishes are environmentally friendly, healthy and delicious.', 'templates/theplace'); ?></p>
        </div>
    </section>

    <section class="section-8">
        <div class="container allow-drop">
            <div class="row menu nodrop">
                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">Mussales soup</span></div>
                    <div class="price">$ 23.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">Sicilian meatballs</span></div>
                    <div class="price">$ 25.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">ITALIAN SPAGHETTI</span></div>
                    <div class="price">$ 12.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">SEAFOOD SALAD</span></div>
                    <div class="price">$ 17.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">BEEF BURGER</span></div>
                    <div class="price">$ 10.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">ROAST CHIKEN</span></div>
                    <div class="price">$ 23.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">STUFFED STRAWBERRY</span></div>
                    <div class="price">$ 15.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>

                <div class="col-md-6 item cloneable">
                    <div class="title"><span class="safe-element">GRILLED FISH</span></div>
                    <div class="price">$ 37.00</div>
                    <p>Lorem Ipsum has been the industry's standard dummy text</p>
                </div>
            </div>

            <div class="m-t-50 text-center">
                <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-lg" text="See our menu" class="d-inline-block cloneable m-l-10 m-r-10"/>
            </div>
        </div>
    </section>
</div>
