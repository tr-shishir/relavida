<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" <?php print lang_attributes(); ?>>

<head>

    <title>{content_meta_title}</title>
    <?php if (Config::get('custom.disableGoggleIndex') == 1) : ?>
        <meta name="robots" content="noimageindex,nomediaindex" />
    <?php endif; ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta property="og:title" content="{content_meta_title}" />
    <meta name="keywords" content="{content_meta_keywords}" />
    <meta name="description" content="{content_meta_description}" />
    <meta property="og:type" content="{og_type}" />
    <meta property="og:url" content="{content_url}" />
    <meta property="og:image" content="{content_image}" />
    <meta property="og:description" content="{og_description}" />
    <meta property="og:site_name" content="{og_site_name}" />
    <script>
        mw.require('icon_selector.js');
        mw.lib.require('bootstrap4');
        mw.lib.require('bootstrap_select');

        mw.iconLoader()
            .addIconSet('fontAwesome')
            .addIconSet('iconsMindLine')
            .addIconSet('iconsMindSolid')
            .addIconSet('materialDesignIcons')
            .addIconSet('mwIcons')
            .addIconSet('materialIcons');
    </script>

    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
    <?php
    //Seo data for google anaylytical
    print(template_head(true));
    $is_installed_status = Config::get('microweber.is_installed');
    if (!empty($is_installed_status)) {
        if (function_exists('basicGoogleAnalytical')) {
            basicGoogleAnalytical();
        }
    }
    //end code
    ?>

    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/main-style.css" type="text/css" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/responsive.css" type="text/css" />
    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>
    <script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/meanmenu/jquery.meanmenu.min.js"></script>
    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <link href="<?php print template_url(); ?>dist/main.min.css" rel="stylesheet" />
    <?php print get_template_stylesheet(); ?>
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/typography.css" type="text/css" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/plugins/meanmenu/meanmenu.min.css" />
    <?php if(isset(get_content_by_id(CONTENT_ID)['url']) && get_content_by_id(CONTENT_ID)['url'] == 'shop'): ?>
        <?php if(is_logged()): ?>
            <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
            <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
            <script type="text/javascript" src="<?php print template_url(); ?>assets/js/jquery-ui.js"></script>
        <?php endif; ?>
    <?php else: ?>
        <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
        <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
        <script type="text/javascript" src="<?php print template_url(); ?>assets/js/jquery-ui.js"></script>
    <?php endif; ?>
    <?php include('template_settings.php'); ?>
</head>

<body class="<?php print helper_body_classes(); ?> <?php print $sticky_navigation; ?> ">
    <input type="hidden" id="page_id_for_layout_copy" value="<?= PAGE_ID; ?>">
    <?php
    $hide_header_page_id = DB::table('header_show_hides')->select('id')->where('page_id', PAGE_ID)->first();
    if ($hide_header_page_id) {
        $headerShowCss = "none";
    } else {
        $headerShowCss = "flex";
    }
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
    $blog_cat = $GLOBALS['blog_data'][0]['id'];
    $active = intval($GLOBALS['custom_active_category']);
    if (!empty($active)) {
        $showHeader = header_cate_status();
    }
    ?>
    <div class="main">
        <div class="navigation-holder <?php print $header_style; ?><?php if ($search_bar == 'false') : ?> no_search_bar <?php endif; ?>">
            <?php if ($header_style == 'header_style_1') : ?>
                <?php include('partials/header/header_style_1.php'); ?>
            <?php elseif ($header_style == 'header_style_2') : ?>
                <?php include('partials/header/header_style_2.php'); ?>
            <?php elseif ($header_style == 'header_style_3') : ?>
                <?php include('partials/header/header_style_3.php'); ?>
            <?php elseif ($header_style == 'header_style_4') : ?>
                <?php include('partials/header/header_style_4.php'); ?>
            <?php elseif ($header_style == 'header_style_5') : ?>
                <?php include('partials/header/header_style_5.php'); ?>
            <?php elseif ($header_style == 'header_style_6') : ?>
                <?php include('partials/header/header_style_6.php'); ?>
            <?php elseif ($header_style == 'header_style_7') : ?>
                <?php include('partials/header/header_style_7.php'); ?>
            <?php elseif ($header_style == 'header_style_8') : ?>
                <?php include('partials/header/header_style_8.php'); ?>
            <?php elseif ($header_style == 'header_style_9') : ?>
                <?php include('partials/header/header_style_9.php'); ?>
            <?php else : ?>
                <?php include('partials/header/header_style_1.php'); ?>
            <?php endif; ?>
        </div>

        <?php
        $url =  url_segment();
        $last_url =  end($url);
        $last_url = (!empty($last_url)) ? $last_url : 'home';
        $pages = DB::table('content')->select('id')->where('content_type', 'page')->where('url', $last_url)->first();

        if (!isset($pages)) {
            dt_url_redirect_redirectUrl();
        }
        ?>


        <script>
            $(document).ready(function() {
                $('.header-cat ul').removeClass('nav');
                $('.header-cat ul').removeClass('nav-list');
                $('.header-cat ul li').removeClass('has-sub-menu');
                $('.header-cat ul').removeClass('active-parent');
                $('.header-cat ul li').removeClass('active-parent');
                $('.header-cat ul li a').removeClass('active-parent');

                $('.header-cat .well>ul').addClass('sm sm-simple sm-luminous');
                $('.header-cat .well>ul').smartmenus();

            });
        </script>

<?php
    $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
?>

<script>

    $(document).ready(function() {

        $.get("<?= url('api/v1/get_category_for_search') ?>", function (res) {
            if(res.success){
                $("#category_list").html(res.data)
                $("#productSearchInput").on('click',function(){



                    var selectItem = $("#category_list").val();
                    if(selectItem == 'all'){
                        $.post("<?= url('api/v1/get_content_by_category') ?>", {
                            cat_id: selectItem
                        },(res) => {
                            if(res.success){
                                var availableTags = res.data;
                                autocomplete(document.getElementById("productSearchInput"), availableTags);
                            }
                        });
                    }else{
                        var cat_id = selectItem;
                        $.post("<?= url('api/v1/get_content_by_category') ?>", {
                            cat_id: cat_id
                        },(res) => {
                            if(res.success){
                                var availableTags = res.data;
                                autocomplete(document.getElementById("productSearchInput"), availableTags);
                            }
                        });
                    }
                });
                $('#productSearchInput').keydown(function(event){
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if(keycode == '13'){
                        $(document.getElementById( "productSearchInput" )).closest( "form" ).submit();
                    }
                });
            }
        });



    });

    function carttoggole(add_cart_id) {
        // $("#cartModal").modal('show');
        <?php

        if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0){?>
            var dialog = confirm("<?php _e('If you increase the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>?");
            if (dialog) {
                $("#cartModal").modal('show');
                mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                    if(Number.isInteger(parseInt(add_cart_id))){
                        mw.cart.add_item(add_cart_id);
                    }else{
                        mw.cart.add(add_cart_id);
                    }
                    mw.reload_module('shop/cart/quick_checkout');

                });

            }
        <?php } ?>
    }

    function remove_cart_data(id){
        if(sessionStorage.getItem('cart_update_for_bundle_product') == 'true'){
            $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                sessionStorage.setItem('cart_update_for_bundle_product', 'false');
                mw.cart.remove(id)
                mw.reload_module('shop/cart/quick_checkout');

            });
        }else{
            <?php if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0){?>
                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                    mw.cart.remove(id)
                    mw.reload_module('shop/cart');
                    mw.reload_module('shop/cart/quick_checkout');

                });
            <?php }else{
                ?>
                mw.cart.remove(id)
                <?php
            } ?>
        }


    }



    function carttoggolee(add_cart_id) {
        if(add_cart_id == 'cart'){
            $("#cartModal").modal('show');
            return false;
        }
        if(sessionStorage.getItem('cart_update_for_bundle_product') == 'true'){
            var dialog = confirm("<?php _e('If you increase the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>?");
            if (dialog) {
                $("#cartModal").modal('show');

                sessionStorage.setItem('cart_update_for_bundle_product', 'false');
                mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                    if(Number.isInteger(parseInt(add_cart_id))){
                        mw.cart.add_item(add_cart_id);
                    }else{
                        mw.cart.add(add_cart_id);
                    }
                    mw.reload_module('shop/cart/quick_checkout');

                });

            }

        }else{
            if(Number.isInteger(parseInt(add_cart_id))){
                mw.cart.add_item(add_cart_id);
            }else{
                mw.cart.add(add_cart_id);
            }
        $("#cartModal").modal('show');

        }

    }

    $('.searchClose').on('click', function(){
        $('li.search.dropdown').removeClass('show');
        $('li.search.dropdown .dropdown-menu').removeClass('show');
    });
</script>

<div class="modal login-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="js-login-window">
                    <div class="icon"><i class="material-icons">person</i></div>
                    <module type="users/login" id="loginModalModuleLogin" />

                </div>

                <div class="js-register-window" style="display:none;">
                    <div class="icon"><i class="material-icons">exit_to_app</i></div>

                    <div id="loginModalModuleRegister">

                    </div>

                    <p class="or"><span>or</span></p>

                    <div class="act login">
                        <a href="#" class="js-show-login-window"><span><i class="fa fa-backward" style="margin-right: 10px;" aria-hidden="true"></i>Zurück zur Anmeldung</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
