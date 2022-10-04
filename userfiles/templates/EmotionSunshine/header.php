<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" <?php print lang_attributes(); ?>>
<head>

    <title>{content_meta_title}</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <meta property="og:title" content="{content_meta_title}"/>
    <meta name="keywords" content="{content_meta_keywords}"/>
    <meta name="description" content="{content_meta_description}"/>
    <meta property="og:type" content="{og_type}"/>
    <meta property="og:url" content="{content_url}"/>
    <meta property="og:image" content="{content_image}"/>
    <meta property="og:description" content="{og_description}"/>
    <meta property="og:site_name" content="{og_site_name}"/>






    <script>
        mw.require('icon_selector.js');
        mw.lib.require('bootstrap4');
        mw.lib.require('bootstrap_select');

        mw.iconLoader()
            .addIconSet('fontAwesome')
            .addIconSet('iconsMindLine')
            .addIconSet('iconsMindSolid')
            .addIconSet('mwIcons')
            .addIconSet('materialIcons');
    </script>

    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker();
        });
    </script>

    <?php
    print (template_head(true));
    //Seo data for google anaylytical
    $is_installed_status = Config::get('microweber.is_installed');
    (@$is_installed_status) ? basicGoogleAnalytical() : '';
    //end code
    ?>

    <!-- Plugins Styles -->
    <link href="<?php print template_url(); ?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet"/>

    <link href="<?php print template_url(); ?>assets/js/libs/swiper/css/swiper.min.css" rel="stylesheet"/>


    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/material_icons/material_icons.css" type="text/css"/>
    <link href="<?php print template_url(); ?>assets/css/custom.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/offcanvasnav.css">
    <link href="<?php print template_url(); ?>assets/css/raising.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/newstyle.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/responsive.css" rel="stylesheet"/>
    <link href="<?php print template_url(); ?>assets/css/raising-responsive.css" rel="stylesheet"/>

    <link href="<?php print template_url(); ?>assets/css/typography.css" rel="stylesheet"/>


    <!-- Owl Carousel -->
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/owl.theme.green.css">
    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>
    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <?php print get_template_stylesheet(); ?>
    <?php include('template_settings.php'); ?>
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
</head>
<body class="<?php print helper_body_classes(); ?>" style="padding-top: 0">
<input type="hidden" id="page_id_for_layout_copy" value="<?=PAGE_ID;?>">
<div class="main">
    <div class="navigation-holder">
        <nav class="navigation">
            <div class="container-fluid">
            <?php
                    $hide_header_page_id = DB::table('header_show_hides')->select('id')->where('page_id',PAGE_ID)->first();
                    if($hide_header_page_id){
                        $headerShowCss = "none";
                    }else{
                        $headerShowCss = "block";
                    }
                    $shop_cat = $GLOBALS['shop_data'][0]['id'];
                    $blog_cat = $GLOBALS['blog_data'][0]['id'];
                    $active = intval($GLOBALS['custom_active_category']);
                    if (!empty($active)) {
                        $showHeader = header_cate_status();
                    }
                ?>
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <div class="navbar-main" style="display:<?php print $headerShowCss; ?>;">
                        <div class="row">
                            <div class="col-md-4 for-mobile-2nd-row">
                                <div class="header-search">
                                    <!-- <form class="d-flex flex-nowrap search-header-form" action="<?php print site_url(); ?>search" method="get">
                                        <input type="search" id="keywords" name="keywords" placeholder="<?php _lang("Wonach suchen Sie?"); ?>"/>
                                    </form> -->
                                    <div class="product-autocomplete-search-wrapper">
                            <style>
                                #mw-notifications-holder {
                                    color: #fff !important;
                                }
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

                                option.optiontitle {
                                    color: #fffdfd !important;
                                }

                                option.optiondivider {
                                    color: #fdf4f4;
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
                                    margin-right: 6px;
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
                                .member-nav .search .dropdown-menu:before {
                                    position: absolute;
                                    top: -7px;
                                    width: 15px;
                                    height: 15px;
                                    background: #ffffff;
                                    transform: rotate(
                                45deg);
                                    content: "";
                                    left: 222px;
                                }


                                button#js-hamburger {
                                    top: 20px;
                                }

                                .product-search-box {
                                    border-bottom: 1px solid #c0c0c0;
                                    max-width: 320px;
                                }

                                .product-search-box select#category_list {
                                    border: none;
                                    border-right: 1px solid #c0c0c0;
                                }

                                .product-search-box input#productSearchInput {
                                    height: 32px;
                                    border: none;
                                    padding-left: 10px;
                                }
                                option.optiontitle {
                                    color: #000 !important;
                                }

                                .product-search-box button.btn {
                                    position: absolute;
                                    right: -26px;
                                    top: 2px;
                                    z-index: 9;
                                    color:#c0c0c0;
                                }


                                @media screen and (max-width: 767px) {

                                    .product-search-box form#formSearch {
                                        position: relative;
                                    }

                                    .product-search-box .autocomplete {
                                        width: 100% !important;
                                    }

                                    .product-search-box button.btn {
                                        right: 0;
                                    }

                                    .product-search-box select#category_list {
                                        width: 100%;
                                        border-bottom: 1px solid #c0c0c0;
                                        border-right: 0px;
                                        padding: 0px 6px;
                                        text-align: left;
                                    }

                                    .header-search {
                                        padding-top: 0px !important;
                                        margin-top: 0px;
                                    }

                                    button#js-hamburger {
                                        top: 95px;
                                    }

                                    .menu-logo-secondary {
                                        justify-content: flex-start;
                                        margin-left: 30px;
                                    }
                                    .navbar-main {
                                        position: relative;
                                        z-index: 9;
                                    }
                                }
                            </style>
                        </div>
                            <div class="product-search-box">
                                <form autocomplete="off" id="formSearch" action="<?php print site_url(); ?>search" method="get">
                                    <select class="searchCategoryDropdown" name="category_list" id="category_list">

                                    </select>
                                    <div class="autocomplete" style="width:300px;">
                                        <input id="productSearchInput" type="text" name="keywords" placeholder="<?php _lang("Wonach suchen Sie?"); ?>">
                                        <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
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
                                if (!val) {
                                    return false;
                                }
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
                                        $(inp).closest("form").submit();
                                    }
                                }
                                setTimeout(function() {
                                    $('#productSearchInputautocomplete-list').on('click', function() {
                                        $(inp).closest("form").submit();
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
                            document.addEventListener("click", function(e) {

                                closeAllLists(e.target);
                            });
                        }
                    </script>
                                </div>
                            </div>
                            <div class="col-md-4 for-mobile-1st-row">
                                <div class="menu-logo-secondary edit" field="header_secondary_logo" rel="global">
                                    <img src="<?php print template_url(); ?>assets/image/raise-logo.png" alt="raise pioneer">
                                </div>
                            </div>
                            <div class="col-md-4 for-mobile-3rd-row">
                                <ul class="member-nav">
                                    <li class="member-nav-cart">
                                        <p href="#" class="preloader-cart-icon" onclick="carttoggolee('cart')">
                                            Mein Warenkorb
                                        </p>
                                    </li>
                                    <?php if (get_option('enable_wishlist', 'shop')) : ?>
                                        <li class="member-nav-wishlist">
                                            <a href="#" data-toggle="modal" data-target="#wishlistModal">
                                                Meine Wunschliste
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="dropdown member-nav-admin">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><?php if (user_id()): ?><?php print user_name(); ?><?php else: ?><?php echo _e('Einloggen'); ?><?php endif; ?></span></a>
                                        <ul class="dropdown-menu">
                                            <?php if (user_id()): ?>
                                                <li><a href="#" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                                                <li><a href="#" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                                            <?php else: ?>
                                                <li><a href="#" data-toggle="modal" data-target="#loginModal" id="login_register"><?php _lang("Anmeldung", 'templates/bamboo'); ?></a></li>
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="header-cat <?php print  @$showHeader['header'] ?? 'hide'; ?>" >
                                    <div class="header-categories">
                                        <?php if (@$shop_cat == @$active ){
                                            ?>
                                            <module type="shop_categories" content-id="<?php print $active; ?>"/>
                                            <?php
                                        }else{
                                            ?>
                                            <module type="categories" content-id="<?php print $active; ?>"/>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="responsive-menu">
                        <div class="res-menu-wrapper">
                            <div class="hamburger-menu-wrapper">
                                <!-- <nav id="js-nav" class="nav">
                                    <module type="menu" id="header-menu" template="navbar"/>
                                </nav> -->
                                <!-- Hamburger Button -->
                                <button id="js-hamburger" class="hamburger" type="button">
                                    <span id="js-top-line" class="top-line"></span>
                                    <span id="js-center-line" class="center-line"></span>
                                    <span id="js-bottom-line" class="bottom-line"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
        <!-- Off Canvas Nav Start -->
    <div class="offCanvasNav hideOffCanvas">
        <div class="fullwidth-offcanvas-menu">

            <span class="closeOffcanvas"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="offCanvas-menu-row offcanvasModifiedForMobile">

            </div>
            <div class="offCanvas-menu-row row">
                <div class="col-md-6 et_pb_column ofcanvas-menu-left">

                    <div class="raising-main-menu">
                        <div class="oCmenuHead">
                            <div class="edit" field="offcanvas_menu_heading" rel="global">
                                <h3>Menu</h3>
                            </div>
                        </div> <!-- .et_pb_text -->


                        <module type="menu" id="header-menu" template="navbar"/>
                    </div>

                    <div class="raising-category-menu">
                        <div class="oCmenuHead">
                            <div class="edit" field="offcanvas_cat_heading" rel="global">
                                <h3>Kategorien</h3>
                            </div>
                        </div> <!-- .et_pb_text -->


                        <div class="edit" field="cat_content_change" rel="content">
                            <module type="shop_categories" content-id="<?php print PAGE_ID; ?>" />
                        </div>
                    </div>
                </div> <!-- .et_pb_column -->
                <div class="col-md-6 et_pb_column ofcanvas-menu-right">
                    <div class="edit" field="ofcanvas_menu_logo" rel="global">
                        <module type="logo" class="off-canvas-logo" />
                    </div>
                    <div class="rasing-ocs-wrapper">
                        <!-- <form class="menu-search" action="<?php print site_url(); ?>search" method="get">
                            <input type="search" placeholder="Suchen" id="keywords" name="keywords"/>
                        </form> -->
                    </div>
                    <ul class="raising-menu-social edit" field="menu_social" rel="global">
                        <module type="social_links" />
                    </ul>
                    <div class="et_pb_text">
                        <div>
                            <h3 class="edit" rel="global" field="acc_heading">Account</h3>
                        </div>
                    </div>
                    <div class="main-menu-item">
                        <div>
                            <p><a href="#" class="preloader-cart-icon" onclick="carttoggolee('cart')">Mein Warenkorb</a></p>
                        </div>
                    </div>
                    <?php if (get_option('enable_wishlist', 'shop')) : ?>
                        <div class="main-menu-item">
                            <div>
                                <p><a href="#" data-toggle="modal" data-target="#wishlistModal">Meine Wunschliste</a></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="menu-contact-info">
                        <div class="cInfo edit" field="menu_contact" rel="global">
                            <h4>Lorem Ipsum</h4>
                            <p>Lorem<br> IpsumSS9</p>
                            <p><span>+0000000000000</span><br>
                                info@abc.xyz.de</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(window).on("load", function(){
            $(".raising-category-menu ul.mw-cats-menu>li:has(ul)").addClass("hasSubCat");
            // $(".raising-category-menu ul.nav.nav-list>li:has(ul)").addClass("hasSubCat");
            $(".raising-category-menu .module-categories>.well>ul.nav.nav-list>li:has(ul)").addClass("hasSubCat");

            $("li.hasSubCat>a").after("<span class='subMenuToggle'></span>");


            $(".subMenuToggle").on("click", function(){
                $(this).parent().toggleClass("showOfcanSub");
                //alert("Hello");
            });
        });


        $(".toggle-sub-menu").on("click", function(){
            $(this).parent().toggleClass("show_SubOffMenu");
            $(this).toggleClass("minus-icon");


        });

        $(".hamburger").on("click", function(){
            $(".offCanvasNav").removeClass("hideOffCanvas");
            $("body").addClass("scrollOff")
        });
        $(".closeOffcanvas").on("click", function(){
            $(".offCanvasNav").addClass("hideOffCanvas");
            $("body").removeClass("scrollOff")
        });





    </script>
    <!-- /Off Canvas Menu END -->
    <script>
	  $(document).ready(function(){
		  $('.js-example-basic-multiple').select2();
	  });
  </script>
    <?php
        $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    ?>
    <script type="text/javascript">

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

        function remove_cart_data(id){
            <?php if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0){?>
            $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                mw.cart.remove(id)
                mw.reload_module('shop/cart/quick_checkout');

            });
        <?php }else{
            ?>
            mw.cart.remove(id)
            <?php
        } ?>

        }



    </script>
    <!-- <script>
        $(document).ready(function(){
            const hamburgerBtn = document.getElementById("js-hamburger");
            const topLine = document.getElementById("js-top-line");
            const centerLine = document.getElementById("js-center-line");
            const bottomLine = document.getElementById("js-bottom-line");
            const nav = document.getElementById("js-nav");

            hamburgerBtn.addEventListener("click", () => {
                topLine.classList.toggle("active");
                centerLine.classList.toggle("active");
                bottomLine.classList.toggle("active");
                nav.classList.toggle("show");
            });
        });
    </script> -->

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
    $(document).ready(function () {
        $("#login_register").on("click",function(){
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


        $('.js-show-register-window').on('click', function () {
            $('.js-login-window').hide();
            $('.js-register-window').show();
            mw.load_module('captcha/templates/skin-1', '#captcha_register');
        })
        $('.js-show-login-window').on('click', function () {

            $('.js-register-window').hide();
            $('.js-login-window').show();
            mw.load_module('captcha', '#captcha_login');
        })

        $(".header-cat .nav>li>ul>li").has("ul").addClass("sub-cat");
    });

    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 85) {
            $('#header-logo').addClass('logo-fixed');
            $('.hamburger-menu-wrapper').addClass('menu-fixed');
        } else {
            $('#header-logo').removeClass('logo-fixed');
            $('.hamburger-menu-wrapper').removeClass('menu-fixed');
        }
    });

    $(document).ready(function () {
            $('.header-cat ul').removeClass('nav');
            $('.header-cat ul').removeClass('nav-list');
            $('.header-cat ul li').removeClass('has-sub-menu');
            $('.header-cat ul').removeClass('active-parent');
            $('.header-cat ul li').removeClass('active-parent');
            $('.header-cat ul li a').removeClass('active-parent');

            $('.header-cat .well>ul').addClass('sm sm-simple sm-luminous');
            $('.header-cat .well>ul').smartmenus();



            $.get("<?= url('api/v1/get_category_for_search') ?>", function(res) {
                if (res.success) {
                    $("#category_list").html(res.data)
                    $("#productSearchInput").on('click', function() {



                        var selectItem = $("#category_list").val();
                        if (selectItem == 'all') {
                            $.post("<?= url('api/v1/get_content_by_category') ?>", {
                                cat_id: selectItem
                            }, (res) => {
                                if (res.success) {
                                    var availableTags = res.data;
                                    autocomplete(document.getElementById("productSearchInput"), availableTags);
                                }
                            });
                        } else {
                            var cat_id = selectItem;
                            $.post("<?= url('api/v1/get_content_by_category') ?>", {
                                cat_id: cat_id
                            }, (res) => {
                                if (res.success) {
                                    var availableTags = res.data;
                                    autocomplete(document.getElementById("productSearchInput"), availableTags);
                                }
                            });
                        }
                    });
                    $('#productSearchInput').keydown(function(event) {
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if (keycode == '13') {
                            $(document.getElementById("productSearchInput")).closest("form").submit();
                        }
                    });
                }
            });

        });
</script>
<?php if (user_id()): ?>
    <script>
        $(document).ready(function () {
            $('#ordersModal').on('shown.bs.modal', function (e) {
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


<!--Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <?php (!isset($_GET['slug'])) ? include template_dir() . 'layouts' . DS . "wishlist.php" : ''; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
      </div>
    </div>
  </div>
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

    $('button#js-hamburger').on('click', function(){
        $(".product-search-box").prependTo($(".rasing-ocs-wrapper"));

    });

    $('span.closeOffcanvas').on('click', function(){
        $(".product-search-box").prependTo($(".header-search"));
    });



    $(window).on('load', function(){
        $('.for-mobile-2nd-row .header-search .product-search-box .autocomplete').append('<span class="mobileSearchtoggle"></span>');
        $('.for-mobile-2nd-row .header-search .product-search-box .autocomplete .mobileSearchtoggle').on('click', function(){
            $('.for-mobile-2nd-row .header-search .product-search-box .autocomplete').addClass('showInputForMobile');
            $(this).removeClass('mobileSearchtoggle');
            $('.for-mobile-3rd-row').css('margin-top', '40px');
        });

        if ($(window).width() < 1099) {

            $('.ofcanvas-menu-right .rasing-ocs-wrapper').prependTo('.offcanvasModifiedForMobile');
            $('.ofcanvas-menu-right .off-canvas-logo').prependTo('.offcanvasModifiedForMobile');

        }



    });
</script>