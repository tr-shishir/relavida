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
    </script>

    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
            mw.iconLoader()
            .addIconSet('fontAwesome')
            .addIconSet('iconsMindLine')
            .addIconSet('iconsMindSolid')
            .addIconSet('mwIcons')
            .addIconSet('materialIcons');
        });
    </script>
    <?php
    print(template_head(true));
    //Seo data for google anaylytical
    $is_installed_status = Config::get('microweber.is_installed');
    (@$is_installed_status) ? basicGoogleAnalytical() : '';
    //end code
    ?>

    <!-- Plugins Styles -->
    <link href="<?php print template_url(); ?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" />

    <link href="<?php print template_url(); ?>assets/js/libs/swiper/css/swiper.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/material_icons/material_icons.css" type="text/css" />
    <link href="<?php print template_url(); ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?php print template_url(); ?>assets/css/main-style.css" rel="stylesheet" />
    <link href="<?php print template_url(); ?>assets/css/responsive.css" rel="stylesheet" />

    <?php print get_template_stylesheet(); ?>


    <script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/meanmenu/jquery.meanmenu.min.js"></script>

    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>

    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/plugins/meanmenu/meanmenu.min.css" />
    <?php if(isset(get_content_by_id(CONTENT_ID)['url']) && get_content_by_id(CONTENT_ID)['url'] == 'shop'): ?>
        <?php if(is_logged()): ?>
            <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
            <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet"/>
            <script type="text/javascript" src="<?php print template_url(); ?>assets/js/jquery-ui.js"></script>
        <?php endif; ?>
    <?php else: ?>
        <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
        <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php print template_url(); ?>assets/js/jquery-ui.js"></script>
    <?php endif; ?>
    <?php include('template_settings.php'); ?>
</head>

<body class="<?php print helper_body_classes(); print 'member-nav-inverse ' . $header_style . ' ' . $sticky_navigation;  if(defined('IS_HOME')){ print ' homepage'; }?> " >

    <input type="hidden" id="page_id_for_layout_copy" value="<?= PAGE_ID; ?>">
    <?php

    ?>
    <div class="main">
        <?php
            $hide_header_page_id = DB::table('header_show_hides')->select('id')->where('page_id', PAGE_ID)->first();
            if ($hide_header_page_id) {
                $headerShowCss = "none";
            } else {
                $headerShowCss = "block";
            }
            $shop_cat = $GLOBALS['shop_data'][0]['id'];
            $blog_cat = $GLOBALS['blog_data'][0]['id'];
            $active = intval($GLOBALS['custom_active_category']);
            if (!empty($active)) {
                $showHeader = header_cate_status();
            }
        ?>
        <header class="header" style="display:<?php print $headerShowCss; ?>;">
            <div class="header-top">
                <div class="container">
                    <div class="logo">
                        <module type="logo" class="logo" id="header-logo" />
                    </div>
                    <div class="menu">
                        <module type="menu" id="header-menu" template="navbar" />
                    </div>
                    <div class="header-top-text edit" field="header_top_text" rel="global">
                        <span>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            HOTLINE 12-888-88-87
                        </span>
                    </div>
                </div>
            </div>
            <div class="header-category">
                <div class="smartheader-cat header-cat <?php print  @$showHeader['header'] ?? 'hide'; ?>">
                    <div class="header-categories">
                        <?php if (@$shop_cat == @$active) {
                        ?>
                            <module type="shop_categories" content-id="<?php print $active; ?>" />
                        <?php
                        }
                        if (@$blog_cat == @$active) {
                        ?>
                            <module type="categories" content-id="<?php print $active; ?>" />
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="header-search">

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
                        </script>
                        <style>
                            .autocomplete {
                                    position: relative;
                                    display: inline-block;
                                }

                                .product-autocomplete-search-wrapper input {
                                    border: 1px solid transparent;
                                    background-color: #f1f1f1;
                                    padding: 10px;
                                    font-size: 16px;
                                }

                                .product-autocomplete-search-wrapper input[type=text] {
                                    background-color: #f1f1f1;
                                    width: 100%;
                                }

                                .product-autocomplete-search-wrapper input[type=submit] {
                                    background-color: DodgerBlue;
                                    color: #fff;
                                    cursor: pointer;
                                }

                                .autocomplete-items {
                                    position: absolute;
                                    border: 1px solid #d4d4d4;
                                    border-bottom: none;
                                    border-top: none;
                                    z-index: 99;
                                    top: 100%;
                                    left: 0;
                                    right: 0;
                                }

                                .autocomplete-items div {
                                    padding: 10px;
                                    cursor: pointer;
                                    background-color: #fff;
                                    border-bottom: 1px solid #d4d4d4;
                                }

                                .autocomplete-items div:hover {
                                    background-color: #e9e9e9;
                                }

                                .autocomplete-active {
                                    background-color: DodgerBlue !important;
                                    color: #ffffff;
                                }

                                .product-search-box {
                                    position: relative;
                                }

                                select#category_list {
                                    width: 150px;
                                    height: 32px;
                                    display: inline-block;
                                }

                                .product-search-box .autocomplete {
                                    width: 150px !important;

                                }
                                .product-search-box .autocomplete input {
                                    width: 100%;
                                }
                                span.searchClose {
                                    height: 30px;
                                    display: inline-block;
                                }
                                .autocomplete-items {
                                    min-width: 258px;
                                }

                                .autocomplete-items div {
                                    font-size: 14px;
                                    line-height: 18px;
                                }


                            #productSearchInputautocomplete-list {
                                position: absolute;
                                background-color: #fff;
                                padding: 10px;
                            }

                            #productSearchInputautocomplete-list>div {
                                cursor: pointer;
                            }
                            .product-search-box {
                                position: relative;
                            }

                            .product-search-box form#formSearch {
                                width: 100%;
                                display: block;
                                position: relative;
                            }

                            .product-search-box select#category_list {
                                width: 30%;
                                display: inline-block;
                                float: left;
                                height: 40px;
                                border: 1px solid #41544a;
                                margin-right: -1px;
                                padding: 0px 10px;
                            }

                            .product-search-box .autocomplete {
                                width: 70% !important;
                                display: inline-block;
                                position: relative;
                            }

                            .product-search-box .autocomplete input#productSearchInput {
                                width: 100%;
                                border: 1px solid #41544a;
                                height: 40px;
                                padding: 5px 10px;
                            }

                            .product-search-box button.btn {
                                background-color: #41544A;
                                position: absolute;
                                right: 0;
                                top: 0;
                                height: 40px;
                                border-radius: 0px;
                                color: #fff;
                            }
                        </style>
                        <!-- <form class="search-header-form" action="<?php print site_url(); ?>search" method="get">
                            <input type="search" class="form-control" placeholder="" id="keywords" name="keywords" />
                            <button class="btn" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form> -->

                        <div class="product-search-box">
                            <form autocomplete="off" id="formSearch" action="<?php print site_url(); ?>search" method="get">
                                <select class="searchCategoryDropdown" name="category_list" id="category_list">

                                </select>
                                <div class="autocomplete" style="width:300px;">
                                    <input id="productSearchInput" type="text" name="keywords" placeholder="<?php _e('Search Here'); ?>">
                                </div>
                                <button class="btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <script>
                                    function autocomplete(inp, arr) {
                                        /*the autocomplete function takes two arguments,
                                        the text field element and an array of possible autocompleted values:*/
                                        var currentFocus;
                                        /*execute a function when someone writes in the text field:*/
                                        inp.addEventListener("input", function(e) {
                                            var a, b, i, val = this.value;
                                            /*close any already open lists of autocompleted values*/
                                            closeAllLists();
                                            if (!val) { return false;}
                                            currentFocus = -1;
                                            /*create a DIV element that will contain the items (values):*/
                                            a = document.createElement("DIV");
                                            a.setAttribute("id", this.id + "autocomplete-list");
                                            a.setAttribute("class", "autocomplete-items");
                                            /*append the DIV element as a child of the autocomplete container:*/
                                            this.parentNode.appendChild(a);
                                            /*for each item in the array...*/
                                            for (i = 0; i < arr.length; i++) {
                                                /*check if the item starts with the same letters as the text field value:*/
                                                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                                    /*create a DIV element for each matching element:*/
                                                    b = document.createElement("DIV");
                                                    /*make the matching letters bold:*/
                                                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                                                    b.innerHTML += arr[i].substr(val.length);
                                                    /*insert a input field that will hold the current array item's value:*/
                                                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                                                    /*execute a function when someone clicks on the item value (DIV element):*/
                                                    b.addEventListener("click", function(e) {
                                                        /*insert the value for the autocomplete text field:*/
                                                        inp.value = this.getElementsByTagName("input")[0].value;
                                                        /*close the list of autocompleted values,
                                                        (or any other open lists of autocompleted values:*/
                                                        closeAllLists();
                                                    });
                                                    a.appendChild(b);
                                                }
                                            }
                                        });
                                        /*execute a function presses a key on the keyboard:*/
                                        inp.addEventListener("keydown", function(e) {
                                            var x = document.getElementById(this.id + "autocomplete-list");
                                            if (x) x = x.getElementsByTagName("div");
                                            if (e.keyCode == 40) {
                                                /*If the arrow DOWN key is pressed,
                                                increase the currentFocus variable:*/
                                                currentFocus++;
                                                /*and and make the current item more visible:*/
                                                addActive(x);
                                            } else if (e.keyCode == 38) { //up
                                                /*If the arrow UP key is pressed,
                                                decrease the currentFocus variable:*/
                                                currentFocus--;
                                                /*and and make the current item more visible:*/
                                                addActive(x);
                                            } else if (e.keyCode == 13) {
                                                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                                                e.preventDefault();
                                                if (currentFocus > -1) {
                                                    /*and simulate a click on the "active" item:*/
                                                    if (x) x[currentFocus].click();
                                                    $(inp).closest( "form" ).submit();
                                                }
                                            }
                                            setTimeout(function(){
                                                $('#productSearchInputautocomplete-list').on('click', function(){
                                                    $(inp).closest( "form" ).submit();
                                                });
                                            }, 10);
                                        });
                                        function addActive(x) {
                                            /*a function to classify an item as "active":*/
                                            if (!x) return false;
                                            /*start by removing the "active" class on all items:*/
                                            removeActive(x);
                                            if (currentFocus >= x.length) currentFocus = 0;
                                            if (currentFocus < 0) currentFocus = (x.length - 1);
                                            /*add class "autocomplete-active":*/
                                            x[currentFocus].classList.add("autocomplete-active");
                                        }
                                        function removeActive(x) {
                                            /*a function to remove the "active" class from all autocomplete items:*/
                                            for (var i = 0; i < x.length; i++) {
                                                x[i].classList.remove("autocomplete-active");
                                            }
                                        }
                                        function closeAllLists(elmnt) {
                                            /*close all autocomplete lists in the document,
                                            except the one passed as an argument:*/
                                            var x = document.getElementsByClassName("autocomplete-items");
                                            for (var i = 0; i < x.length; i++) {
                                                if (elmnt != x[i] && elmnt != inp) {
                                                    x[i].parentNode.removeChild(x[i]);
                                                }
                                            }
                                        }
                                        /*execute a function when someone clicks in the document:*/
                                        document.addEventListener("click", function (e) {

                                            closeAllLists(e.target);
                                        });
                                    }


                                </script>
                    </div>
                    <div class="header-member">
                        <ul>
                            <li class="header-member-user">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <ul class="header-user-dropdown">
                                        <?php if (user_id()) : ?>
                                            <li><a href="" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                                            <li><a href="" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                                        <?php else : ?>
                                            <li><a href="" data-toggle="modal" data-target="#loginModal" class="login_register"><?php _lang("Anmeldung"); ?></a></li>
                                        <?php endif; ?>

                                        <?php if (is_admin()) : ?>
                                            <li><a href="<?php print admin_url() ?>">Adminbereich</a></li>
                                        <?php endif; ?>

                                        <?php if (user_id()) : ?>
                                            <li><a href="<?php print api_link('logout') ?>">Ausloggen</a></li>
                                        <?php endif; ?>
                                    </ul>
                            </li>
                            <?php if ($shopping_cart == 'true') : ?>
                            <li class="header-member-cart preloader-cart-icon" onclick="carttoggolee('cart')">
                                <span class="cart-icon">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </span>
                                <span id="shopping-cart-quantity" class="cart-quantity js-shopping-cart-quantity">
                                    <?php print cart_sum(false); ?>
                                </span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="navbar-mobile-part">

                <div class="navbar-mobile-top">
                    <div class="navbar-mobile-logo">
                        <module type="logo" class="logo" id="header-logo" />
                    </div>
                    <div class="navbar-mobile-member">
                        <ul class="">
                            <li class="search">
                                <button class="mobile-search" type="button" id="dropdown_search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-search"></i>
                                </button>

                            <div class="navbar-mobile-search hide">
                                <style>
                                    .navbar-mobile-search {
                                        position: fixed;
                                        width: 100%;
                                        background-color: #0c1923;
                                        left: 0;
                                        top: 41px;
                                        padding: 10px;
                                    }

                                    .navbar-mobile-search select#category_list {
                                        width: 100%;
                                        border-radius: 5px;
                                    }

                                    .navbar-mobile-search .autocomplete {
                                        width: 100% !important;
                                        margin: 5px auto;
                                    }

                                    .navbar-mobile-search .autocomplete input#productSearchInput {
                                        height: 40px;
                                        border-radius: 5px;
                                        border: 1px solid #fff;
                                    }

                                    .navbar-mobile-search button.btn {
                                        width: calc(100% - 25px);
                                    }

                                    .navbar-mobile-search span.searchClose {
                                        height: 40px;
                                        right: -1px;
                                        width: 18px;
                                        padding-top: 10px;
                                        background-color: #f00;
                                        color: #fff;
                                        position: relative;
                                        top: 0px;
                                        border-radius: 3px;
                                        text-align: center;
                                        font-size: 13px;
                                        line-height: 18px;
                                    }

                                    button.mobile-search {
                                        padding: 8px 8px !important;
                                    }

                                    button.mobile-search i.fa.fa-search {
                                        color: #fff;
                                        margin-top: 0px;
                                    }
                                    .navbar-mobile-search:before {
                                        position: fixed;
                                        content: '';
                                        height: 100%;
                                        width: 100%;
                                        background-color: #000;
                                        left: 0;
                                        top: 0;
                                        z-index: -1;
                                        opacity: .65;
                                    }
                                    .navbar-mobile-search .product-search-box.mobile-search-box button.btn {
                                        position: relative;
                                        background-color: #7cb238 !important;
                                    }
                                    .navbar-mobile-part .navbar-mobile-member li {
                                        list-style-type: none;
                                    }
                                </style>

                            </div>
                            <script>
                                $('.mobile-search').on('click', function() {
                                    $('.navbar-mobile-search').removeClass('hide');
                                    $('.product-search-box').show();
                                    $('.product-search-box').addClass('mobile-search-box');
                                    $('.product-search-box').appendTo('.navbar-mobile-search');


                                    $('.navbar-mobile-search .product-search-box.mobile-search-box form').append('<span class="searchClose">X</span>');
                                    $('.mobile-search-box span.searchClose').on('click', function() {
                                        $('.product-search-box').hide();
                                        $('.navbar-mobile-search').addClass('hide');
                                        $('span.searchClose').remove();
                                    })
                                });
                            </script>
                            </li>
                            <li class="dropdown btn-cart">
                                <a href="#" class="dropdown-toggle preloader-cart-icon" onclick="carttoggolee('cart')">
                                    <span class="material-icons cart-icon">shopping_cart</span>
                                    <span id="shopping-cart-quantity" class="js-shopping-cart-quantity">(<?php print cart_sum(false); ?>)</span>
                                </a>
                            </li>
                            <li class="dropdown btn-member">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><?php if (user_id()): ?><?php print user_name(); ?><?php else: ?><?php echo _e('Einloggen'); ?><?php endif; ?> <span class="caret"></span></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (user_id()): ?>
                                        <li><a href="#" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                                    <?php else: ?>
                                        <li><a href="#" data-toggle="modal" data-target="#loginModal" class="login_register"><?php _lang("Anmeldung", 'templates/bamboo'); ?></a></li>
                                    <?php endif; ?>

                                    <?php if (is_admin()): ?>
                                        <li><a href="<?php print admin_url() ?>">Adminbereich</a></li>
                                    <?php endif; ?>

                                    <?php if (user_id()): ?>
                                        <li><a href="<?php print api_link('logout') ?>">Ausloggen</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                        <div class="header-top-text edit" field="header_top_text" rel="global">
                            <span>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                HOTLINE 12-888-88-87
                            </span>
                        </div>
                    </div>
                </div>
                <div class="nav-for-mobile">
                    <module type="menu" id="header-menu-mobile" template="navbar" />
                </div>
            </div>

        </header>
        <?php
            $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
        ?>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
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
                            if(add_cart_id != null){
                                if(Number.isInteger(parseInt(add_cart_id))){
                                    mw.cart.add_item(add_cart_id);
                                }else{
                                    mw.cart.add(add_cart_id);
                                }
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
                            if(add_cart_id != null){
                                if(Number.isInteger(parseInt(add_cart_id))){
                                    mw.cart.add_item(add_cart_id);
                                }else{
                                    mw.cart.add(add_cart_id);
                                }
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
            $(document).ready(function() {
                $(".header-member-user").on('click', function(){
                    $(".header-user-dropdown").toggleClass("show");
                });

                $('.nav-for-mobile .navbar_new ul').removeClass();
                $('.nav-for-mobile .navbar_new li').removeClass();
                $('.nav-for-mobile .navbar_new li a').removeClass();

                // Mean Menu JS
                $('.nav-for-mobile .navbar_new').meanmenu({
                    meanScreenWidth: "1024",
                    meanMenuContainer: '.nav-for-mobile'
                });
            });
        </script>

        <!-- Login Modal -->
        <div class="modal login-modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="js-login-window">
                            <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                            <module type="users/login" id="loginModalModuleLogin" />
                            <!-- <div type="users/login" id="loginModalModuleLogin"></div> -->
                        </div>

                        <div class="js-register-window" style="display:none;">
                            <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                            <div id="loginModalModuleRegister">

                            </div>

                            <p class="or"><span>oder</span></p>

                            <div class="act login">
                                <a href="#" class="js-show-login-window"><span><i class="fa fa-backward" style="margin-right: 10px;" aria-hidden="true"></i>Zurück zur Anmeldung</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Cart Modal -->
        <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="checkout-product">
                            <module type="shop/cart" template="quick_checkout" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>
            </div>
        </div>




        <script>
            $(document).ready(function() {
                $(".login_register").on("click",function(){
                    mw.load_module('users/register', '#loginModalModuleRegister');
                });

                $('#loginModal').on('show.bs.modal', function(e) {
                    // $('#loginModalModuleLogin').reload_module();
                    mw.reload_module('users/register');
                    mw.load_module('captcha', '#captcha_login');

                })

                <?php if (isset($_GET['mw_payment_success'])) { ?>
                    $('#js-ajax-cart-checkout-process').attr('mw_payment_success', true);

                <?php } ?>

                $('.js-show-register-window').on('click', function() {
                    $('.js-login-window').hide();
                    $('.js-register-window').show();
                    mw.load_module('captcha/templates/skin-1', '#captcha_register');
                })
                $('.js-show-login-window').on('click', function() {

                    $('.js-register-window').hide();
                    $('.js-login-window').show();
                    mw.load_module('captcha', '#captcha_login');
                })

            });

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
        <?php if (user_id()) : ?>
            <script>
                $(document).ready(function() {
                    $('#ordersModal').on('shown.bs.modal', function(e) {
                        mw.reload_module('#user_orders_modal')
                    });
                });
            </script>
            <!-- Orders Modal -->
            <div class="modal fade my-orders-modal" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="ordersModalLabel">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content" style="overflow: unset;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">
                            <div type="users/orders" id="user_orders_modal"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php
        $url =  url_segment();
        $last_url =  end($url);
        $last_url = (!empty($last_url)) ? $last_url : 'home';
        $pages = DB::table('content')->select('id')->where('content_type', 'page')->where('url', $last_url)->first();

        if (!isset($pages)) {
            dt_url_redirect_redirectUrl();
        }
        ?>
