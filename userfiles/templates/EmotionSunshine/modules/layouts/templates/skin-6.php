<?php

/*

type: layout

name: Left Text - Right Image

position: 6

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

<section class="section-8 sec-padd-50 edit safe-mode nodrop" field="layout-skin-6-<?php print $params['id'] ?>" rel="module">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 left-side">

                <div class="p-t-70 p-b-70 allow-drop">
                    <h3><?php print _lang("About the “Sunshine” brand", 'templates/Sunshine'); ?></h3>
                    <p><?php print _lang("Created in 2020, the Sunshine brand has won numerous awards for design interior and original products.", 'templates/Sunshine'); ?></p>
                    <p><?php print _lang("The high quality furniture and products we create are made of natural materials and their design is inspired by nature. Ecologically clean and beautiful, they will be an excellent addition to your home, giving it style, modern design and creativity. By trusting us, you can be sure that you have already invested nature in your home, office, store and other favorite places.", 'templates/Sunshine'); ?></p>
                    <p><?php print _lang("Contact our representatives and consultants to make an individual proposal for a design, an interface or simply an idea.", 'templates/Sunshine'); ?></p>
                </div>

            </div>

            <div class="col-lg-6 right-side background-image-holder" style="background-image: url('<?php print template_url(); ?>assets/img/sections/right-image.jpg');">

            </div>
        </div>
    </div>
</section>