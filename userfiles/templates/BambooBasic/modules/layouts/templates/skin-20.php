<?php

/*

type: layout

name: Title, Text, Image and Button

position: 20

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

<section class="section-15 <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-20-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="col-xl-11 mx-auto allow-drop">
            <h2><?php print _lang('About Bamboo Company', 'templates/bamboo'); ?></h2>
            <p><?php print _lang('Stain resistant fabrics made from up-cycled olefin fibres, without the use of any PFC<br /> chemicals; making them easy on your home and the environment. New fiberglass slat <br /> technology for long-term durability and support. High-density foam for comfort and<br /> longer lasting resilience.', 'templates/bamboo'); ?></p>
            <br />
            <br />
            <img src="<?php print template_url(); ?>assets/img/sections/about_us.jpg"/>
            <br />
            <br />

            <div class="m-t-50">
                <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-md" text="CONTACT US" class="inline-block cloneable m-l-10 m-r-10"/>
            </div>
        </div>
    </div>
</section>
