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
                                        padding: 7px 0px !important;
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

                                    .navbar-mobile-search .product-search-box {
                                        margin: 0px auto;
                                        width: 100%;
                                    }

                                    .navbar-mobile-search .product-search-box input#productSearchInput {
                                        width: 100%;
                                    }

                                    .navbar-mobile-search .product-search-box .autocomplete {
                                        width: 100% !important;
                                    }

                                    .navbar-mobile-search {
                                        top: 70px;
                                    }

                                    .navbar-mobile-search span.searchClose {
                                        padding: 0px;
                                        height: 33px;
                                        top: 2px;
                                        border-radius: 2px;
                                        width: 21px;
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
<nav class="navigation" style="display:<?php print $headerShowCss; ?>;">
    <div class="container">
        <div class="navbar-header">
            <module type="logo" class="logo" id="header-logo" data-alt-logo="true" />
            <div class="menu-overlay">
                <div class="menu">
                    <div class="toggle-inside-menu">
                        <a href="javascript:;" class="js-menu-toggle mobile-menu-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>
                    <div class="menu_for_mobile">
                        <?php include('parts/mobile_search_bar.php'); ?>
                        <?php include('parts/mobile_profile_link.php'); ?>
                    </div>
                    <module type="menu" name="header_menu" id="header_menu" template="navbar" />
                </div>
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

                    option.optiondivider {
                        color: #000;
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
                        transform: rotate(45deg);
                        content: "";
                        left: 222px;
                    }

                    .product-search-box {
                            width: 405px;
                        }

                        .product-search-box select#category_list {
                            height: 36px;
                            position: relative;
                            border: 1px solid #000;
                            top: 1px;
                        }

                        .product-search-box  button.btn {
                            background-color: #4592ff;
                            height: 36px;
                            vertical-align: top;
                            top: 1px;
                            position: relative;
                            font-size: 13px;
                            color: #fff;
                            border: 1px solid #000;
                            left: -3px;
                        }

                        .product-search-box
                        input#productSearchInput {
                            height: 36px;
                            border: 1px solid #000;
                        }

                        span.searchClose {
                            background-color: #fff;
                            color: #000;
                            display: inline-block;
                            vertical-align: top;
                            position: relative;
                            top: 3px;
                            height: 33px;
                            width: 15px;
                            text-align: center;
                            font-size: 14px;
                            line-height: 31px;
                            cursor: pointer;
                        }

                        option.optiontitle {
                            color: #000 !important;
                        }
                        li.search.dropdown {
                            margin-left: 25px;
                        }
                </style>
            </div>
            <ul class="member-nav main-member-nav visible-search">
                <?php include('parts/desktop_profile_link.php'); ?>
                <?php include('parts/shopping_cart.php'); ?>
                <li class="search dropdown">
                                <button class="btn-search dropdown-toggle" type="button" id="dropdown_search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-search"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdown_search">
                                    <!-- <form class="d-flex flex-nowrap search-header-form" action="<?php print site_url(); ?>search" method="get">
                                            <select class="searchCategoryDropdown" name="category_list" id="category_list">

                                            </select>
                                            <input class="keywords" type="search" placeholder="" id="keywords" name="keywords" />
                                            <button class="btn" type="submit"> Suchen</button>
                                            <span class="searchClose">X</span>
                                        </form> -->

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
                            </li>
                <li class="ml-3">
                    <div class="toggle">
                        <a href="javascript:;" class="js-menu-toggle mobile-menu-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <?php include('parts/header_posts_holder.php'); ?>
</nav>
<script>
    $(document).ready(function() {
        $(".header-cat .nav>li>ul>li").has("ul").addClass("sub-cat");
    })
</script>
