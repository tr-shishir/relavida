<!DOCTYPE HTML>
<html prefix="og: http://ogp.me/ns#">

<head>
    <title>{content_meta_title}</title>
    <?php if (Config::get('custom.disableGoggleIndex') == 1) : ?>
        <meta name="robots" content="noimageindex,nomediaindex" />
    <?php endif; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="{content_meta_title}">
    <meta name="keywords" content="{content_meta_keywords}">
    <meta name="description" content="{content_meta_description}">
    <meta property="og:type" content="{og_type}">
    <meta property="og:url" content="{content_url}">
    <meta property="og:image" content="{content_image}">
    <meta property="og:description" content="{og_description}">
    <meta property="og:site_name" content="{og_site_name}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i%7cWork+Sans:400,500,700" rel="stylesheet" type="text/css">
    <script src="<?php print template_url(); ?>assets/js/jquery.smartmenus.min.js"></script>
    <link href="<?php print template_url(); ?>assets/css/sm-core-css.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/css/sm-simple.css" />
    <link rel="stylesheet" href="{TEMPLATE_URL}modules/layouts/templates/layouts.css" type="text/css" media="all">
    <?php $color_scheme = get_option('color-scheme', 'mw-template-snow'); ?>
    <?php if ($color_scheme != '' and $color_scheme != 'default') : ?>
        <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/<?php print $color_scheme; ?>.css" type="text/css" media="all">
    <?php endif; ?>



    <script>
        AddToCartModalContent = window.AddToCartModalContent || function(title) {
            var html = ''

                +
                '<section style="text-align: center;">' +
                '<h5>' + title + '</h5>' +
                '<p><?php _e("has been added to your cart"); ?></p>' +
                '<a href="javascript:;" onclick="mw.tools.modal.remove(\'#AddToCartModal\')" class="btn btn-default"><?php _e("Continue shopping"); ?></a> &nbsp;' +
                '<a href="<?php print checkout_url(); ?>" class="btn btn-warning"><?php _e("Checkout"); ?></a></section>';

            return html;
        }
    </script>
    <?php if(isset(get_content_by_id(CONTENT_ID)['url']) && get_content_by_id(CONTENT_ID)['url'] == 'shop'): ?>
        <?php if(is_logged()): ?>
            <script type="text/javascript" src="{TEMPLATE_URL}assets/js/jquery-ui.js"></script>
            <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
            <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
        <?php endif; ?>
    <?php else: ?>
        <script type="text/javascript" src="{TEMPLATE_URL}assets/js/jquery-ui.js"></script>
        <link href="<?php print template_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
        <script src="<?php print template_url(); ?>assets/js/select2.min.js"></script>
    <?php endif; ?>
    <script type="text/javascript" src="{TEMPLATE_URL}assets/js/main.js"></script>
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/combined.css" type="text/css" media="all">
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/main-style.css" type="text/css" media="all">
    <link rel="stylesheet" href="{TEMPLATE_URL}assets/css/responsive.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php print template_url(); ?>assets/plugins/meanmenu/meanmenu.min.css" />
    <?php print get_template_stylesheet(); ?>

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
    <script type="text/javascript" src="<?php print template_url(); ?>assets/plugins/meanmenu/jquery.meanmenu.min.js"></script>
    <?php
    print(template_head(true));
    //Seo data for google anaylytical
    $is_installed_status = Config::get('microweber.is_installed');
    (@$is_installed_status) ? basicGoogleAnalytical() : '';
    //end code
    ?>
</head>

<body class="<?php print helper_body_classes(); ?>">
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
    <header class="nk-header nk-header-opaque">
        <!--
    START: Navbar
-->
        <div class="navbar-mobile-part">
            <div class="navbar-mobile-top">
                <div class="navbar-mobile-logo">
                    <module type="logo" id="logo_header" default-text="Snow" class="nk-nav-logo" />

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
                                    }

                                    .navbar-mobile-search .autocomplete {
                                        width: 100% !important;
                                        margin: 5px auto;
                                    }

                                    .navbar-mobile-search .autocomplete input#productSearchInput {
                                        height: 32px;
                                        border-radius: 5px;
                                        border: 1px solid #fff;
                                    }

                                    .navbar-mobile-search button.btn {
                                        width: calc(100% - 25px);
                                    }

                                    .navbar-mobile-search span.searchClose {
                                        height: 32px;
                                        top: 0px;
                                        right: -1px;
                                        width: 18px;
                                        padding-top: 9px;
                                    }

                                    button.mobile-search {
                                        padding: 9px 10px !important;
                                        color: #000 !important;
                                    }

                                    button.mobile-search i.fa.fa-search {
                                        color: #000;
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
                                    .navbar-mobile-member {}

                                    .navbar-mobile-search {
                                        background-color: #fff;
                                        top: 60px;
                                    }

                                    .navbar-mobile-search .product-search-box.mobile-search-box {
                                        position: relative;
                                        margin: 0px auto;
                                        top: 0;
                                    }

                                    .navbar-mobile-search .product-search-box.mobile-search-box .autocomplete {
                                        width: 100% !important;
                                    }

                                    .navbar-mobile-search .product-search-box.mobile-search-box input#productSearchInput {
                                        width: 100%;
                                        border: 1px solid #000;
                                    }

                                    .navbar-mobile-search .product-search-box.mobile-search-box span.searchClose {
                                        width: 20px;
                                    }
                                </style>
                            </div>
                            <script>
                                $('.mobile-search').on('click', function() {
                                    $('.navbar-mobile-search').removeClass('hide');
                                    $('.product-search-box').show();
                                    $('.product-search-box').addClass('mobile-search-box');
                                    $('.product-search-box').appendTo('.navbar-mobile-search');
                                    $('.mobile-search-box span.searchClose').on('click', function() {
                                        $('.product-search-box').hide();
                                        $('.navbar-mobile-search').addClass('hide');
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><?php if (user_id()) : ?><?php print user_name(); ?><?php else : ?><?php echo _e('Einloggen'); ?><?php endif; ?> <span class="caret"></span></span></a>
                            <ul class="dropdown-menu">
                                <?php if (user_id()) : ?>
                                    <li><a href="#" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                                <?php else : ?>
                                    <li><a href="#" data-toggle="modal" data-target="#loginModal" class="login_register"><?php _lang("Anmeldung", 'templates/bamboo'); ?></a></li>
                                <?php endif; ?>

                                <?php if (is_admin()) : ?>
                                    <li><a href="<?php print admin_url() ?>">Adminbereich</a></li>
                                <?php endif; ?>

                                <?php if (user_id()) : ?>
                                    <li><a href="<?php print api_link('logout') ?>">Ausloggen</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="nav-for-mobile">
                <module type="menu" id="header-menu-mobile" template="navbar" />
            </div>
        </div>
        <nav class="nk-navbar nk-navbar-top nk-navbar-sticky" style="display:<?php print $headerShowCss; ?>;">
            <div class="container">
                <div class="nk-nav-table">
                    <module type="logo" id="logo_header" default-text="Snow" class="nk-nav-logo" />
                    <div class="main-menu">
                        <module type="menu" name="header_menu" id="main-navigation" template="navbar" />
                        <div class="header-cat <?php print  @$showHeader['header'] ?? 'hide'; ?>">
                            <div class="header-categories">
                                <?php if (@$shop_cat == @$active) {
                                ?>
                                    <module type="shop_categories" content-id="<?php print $active; ?>" />
                                <?php
                                } else {
                                ?>
                                    <module type="categories" content-id="<?php print $active; ?>" />
                                <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                    <ul class="nk-nav nk-nav-right nk-nav-icons">
                        <li class="single-icon hidden-lg-up">
                            <a href="#" class="nk-navbar-full-toggle">
                                <span class="nk-icon-burger">
                                    <span class="nk-t-1"></span>
                                    <span class="nk-t-2"></span>
                                    <span class="nk-t-3"></span>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="product-autocomplete-search-wrapper">
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
                                .product-search-box {
                                    width: 425px;
                                    border: 1px solid #000;
                                    padding: 10px;
                                    position: absolute;
                                    right: 0;
                                    top: 40px;
                                    background-color: #fff;
                                    border-radius: 5px;
                                    display: none;
                                }

                                .product-search-box input#productSearchInput {
                                    height: 32px;
                                    border: 1px solid #000;
                                }

                                .product-search-box button.btn {
                                    border: 1px solid #000;
                                    height: 32px;
                                    position: relative;
                                    vertical-align: top;
                                    font-size: 14px;
                                    line-height: 18px;
                                }

                                .product-search-box span.searchClose {
                                    height: 32px;
                                    border: 1px solid #000;
                                    vertical-align: top;
                                    border-radius: 3px;
                                    font-size: 14px;
                                    width: 15px;
                                    text-align: center;
                                    padding-top: 4px;
                                    cursor: pointer;
                                }

                                .product-search-box.show {
                                    display: block;
                                }


                                li.search.openSearch:before {
                                    position: fixed;
                                    width: 100%;
                                    height: 100%;
                                    content: '';
                                    left: 0;
                                    top: 0;
                                    background-color: #000;
                                    opacity: .5;
                                }
                            </style>
                        </div>
                    <div class="header-right">
                        <ul class="member-nav">
                            <li class="dropdown btn-member">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span><?php if (user_id()) : ?><?php print user_name(); ?><?php else : ?><?php echo _e('Einloggen'); ?><?php endif; ?> <span class="caret"></span></span></a>
                                <ul class="dropdown-menu">
                                    <?php if (user_id()) : ?>
                                        <li><a href="#" data-toggle="modal" data-target="#loginModal">Profil</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#ordersModal">Meine Bestellungen</a></li>
                                    <?php else : ?>
                                        <li><a href="#" data-toggle="modal" data-target="#loginModal" class="login_register"><?php _lang("Anmeldung", 'templates/bamboo'); ?></a></li>
                                    <?php endif; ?>

                                    <?php if (is_admin()) : ?>
                                        <li><a href="<?php print admin_url() ?>">Adminbereich</a></li>
                                    <?php endif; ?>

                                    <?php if (user_id()) : ?>
                                        <li><a href="<?php print api_link('logout') ?>">Ausloggen</a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <li class="dropdown btn-cart">
                                <a href="#" class="preloader-cart-icon" onclick="carttoggolee('cart')">
                                    <span class="material-icons cart-icon">
                                        shopping_cart
                                    </span>
                                    (<span id="shopping-cart-quantity" class="js-shopping-cart-quantity"><?php print cart_sum(false); ?></span>)
                                </a>
                            </li>
                            <li class="search dropdown">

                                <button class="btn-search dropdown-toggle" type="button" id="dropdown_search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-search"></i>
                                </button>
                                <!-- <div class="dropdown-menu" aria-labelledby="dropdown_search">
                                    <form class="d-flex flex-nowrap search-header-form" action="<?php print site_url(); ?>search" method="get">
                                        <input type="search" placeholder="" id="keywords" name="keywords" />
                                        <button class="btn" type="submit"> Suchen</button>
                                    </form>
                                </div> -->




                                <div class="product-search-box">
                                    <form autocomplete="off" id="formSearch" action="<?php print site_url(); ?>search" method="get">
                                        <select class="searchCategoryDropdown" name="category_list" id="category_list">

                                        </select>
                                        <div class="autocomplete" style="width:300px;">
                                            <input id="productSearchInput" type="text" name="keywords" placeholder="">
                                        </div>
                                        <button class="btn" type="submit"> Suchen</button>
                                        <span class="searchClose">X</span>
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
                            </li>

                        </ul>
                    </div>


                </div>
            </div>
        </nav>
        <!-- END: Navbar -->

    </header>


    <!--
START: Navbar Mobile
-->
    <nav class="nk-navbar nk-navbar-full nk-navbar-align-center" id="nk-nav-mobile">
        <div class="nk-navbar-bg">
            <div class="bg-image" style="background-image: url('<?php print template_url(); ?>assets/images/bg-menu.png')"></div>
        </div>
        <div class="nk-nav-table">
            <div class="nk-nav-row">
                <div class="container">
                    <div class="nk-nav-header">
                        <div class="nk-nav-logo">
                            <module type="logo" id="logo_header" default-text="Snow" class="nk-nav-logo" style="width: 200px;" />
                        </div>

                        <div class="nk-nav-close nk-navbar-full-toggle">
                            <span class="nk-icon-close"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-nav-row-full nk-nav-row">
                <div class="nano">
                    <div class="nano-content">
                        <div class="nk-nav-table">
                            <div class="nk-nav-row nk-nav-row-full nk-nav-row-center nk-navbar-mobile-content">
                                <module type="menu" name="header_menu" id="mobile-navigation" template="mobile-navbar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Navbar Mobile -->
    <?php
        $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.nav-for-mobile .navbar_new ul').removeClass();
            $('.nav-for-mobile .navbar_new li').removeClass();
            $('.nav-for-mobile .navbar_new li a').removeClass();

            // Mean Menu JS
            $('.nav-for-mobile .navbar_new').meanmenu({
                meanScreenWidth: "1024",
                meanMenuContainer: '.nav-for-mobile'
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
    <div class="modal" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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


    <div class="modal" id="termModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="termModal-content">
                        <module type="legals/shipping-info" />

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



            // mw.on('mw.cart.add', function (event, data) {
            //     $('#shoppingCartModal').modal('show');

            // })



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

            $(".header-cat .nav>li>ul>li").has("ul").addClass("sub-cat");

        })



        $(document).ready(function() {
            $('.header-cat ul').removeClass('nav');
            $('.header-cat ul').removeClass('nav-list');
            $('.header-cat ul li').removeClass('has-sub-menu');
            $('.header-cat ul').removeClass('active-parent');
            $('.header-cat ul li').removeClass('active-parent');
            $('.header-cat ul li a').removeClass('active-parent');

            $('.header-cat .well>ul').addClass('sm sm-simple sm-luminous');
            $('.header-cat .well>ul').smartmenus();



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

    $('button#dropdown_search').on('click', function(){
        $('.product-search-box').addClass('show');
        $('li.search').addClass('openSearch');
    });
    $('.searchClose').on('click', function(){
        $('li.search').removeClass('openSearch');
        $('.product-search-box').removeClass('show');
    });

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
        <div class="modal my-orders-modal" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="ordersModalLabel">
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

    <div class="nk-main">