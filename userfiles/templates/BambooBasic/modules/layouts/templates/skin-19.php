<?php

/*

type: layout

name: Cards

position: 19

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
$cards_module_shadow = get_option('Cards','cards_module_shadow');
if(!$cards_module_shadow || $cards_module_shadow == "false"){
    $cards_module_shadow = "cards-module-no-shadow";
}
?>
<style>
    .cards-module-no-shadow .blog-posts .post {
        -webkit-box-shadow: unset;
        box-shadow: unset;
    }

    .cards-module-small-shadow .blog-posts .post {
        -webkit-box-shadow: 0 0px 3px 3px rgb(191 191 191 / 30%);
        box-shadow: 0 0px 3px 3px rgb(191 191 191 / 30%);
    }


    .cards-module-medium-shadow .blog-posts .post {
        -webkit-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.75);
    }

    .cards-module-large-shadow .blog-posts .post {
        -webkit-box-shadow: 0px 0px 20px 2px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 20px 2px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 20px 2px rgba(0,0,0,0.75);
    }
    .card-modules-skin-19-single.width50percent {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .card-modules-skin-19-single.width50percent .post {
        max-width: 100%;
    }
</style>
<section class="section <?php print $layout_classes; ?> edit safe-mode nodrop <?php print $cards_module_shadow; ?>" field="layout-skin-19-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-10 mx-auto">
                <div class="row blog-posts blog-posts-skin-19">

                    <div class="card-modules-skin-19-single m-b-40 col-12 col-sm-6 col-md-4 col-lg-4 cloneable">
                        <a href="javascript:;">
                            <div class="post">
                                <div class="image" style="background-image: url('<?php print template_url(); ?>assets/img/sections/hero.jpg');"></div>
                                <div class="description allow-drop">
                                    <h3>Bamboo Company</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card-modules-skin-19-single m-b-40 col-12 col-sm-6 col-md-4 col-lg-4 cloneable">
                        <a href="javascript:;">
                            <div class="post">
                                <div class="image" style="background-image: url('<?php print template_url(); ?>assets/img/sections/hero.jpg');"></div>
                                <div class="description allow-drop">
                                    <h3>Bamboo Company</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card-modules-skin-19-single m-b-40 col-12 col-sm-6 col-md-4 col-lg-4 cloneable">
                        <a href="javascript:;">
                            <div class="post">
                                <div class="image" style="background-image: url('<?php print template_url(); ?>assets/img/sections/hero.jpg');"></div>
                                <div class="description allow-drop">
                                    <h3>Bamboo Company</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row element">
            <div class="col-12 col-xl-10 mx-auto">
                <div class="m-t-50 text-center allow-drop">
                    <module type="btn" template="bootstrap" button_style="btn-default" button_size="btn-md" text="Price List" class="inline-block cloneable m-l-10 m-r-10"/>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(window).on('load', function(){
    $(document).ready(function() {
        if($('[field="layout-skin-19-<?php print $params['id'] ?>"] .card-modules-skin-19-single').length == 2){
            $('[field="layout-skin-19-<?php print $params['id'] ?>"] .card-modules-skin-19-single').addClass('width50percent');
        }else{
            $('[field="layout-skin-19-<?php print $params['id'] ?>"] .card-modules-skin-19-single').removeClass('width50percent');
        }

    });
});
</script>