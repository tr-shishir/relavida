<?php

/*

type: layout

name: Say Hello

position: 9

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

<section class="section-9 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-9-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto text-center">
                <h3>Say Hello to Us</h3>

                <img src="<?php print template_url(); ?>assets/img/logo-footer.png"/>
                <br/>
                <br/>
                <br/>
                <p>+359 001 22 445</p>
                <p>hello@droptienda.email</p>

                <module type="social_links" template="skin-1"/>
            </div>
        </div>
    </div>
</section>
