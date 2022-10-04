<?php

/*

type: layout

name: Clickable Navbar

description: Navigation bar

*/

?>

<script>

    /*    $(document).ready(function () {
     $('ul.nav .dropdown').hover(function () {
     $(this).find('.dropdown-menu:first', this).stop(true, true).delay(200).fadeIn();
     }, function () {
     $(this).find('.dropdown-menu:first', this).stop(true, true).delay(200).fadeOut();
     });
     });*/

</script>
<?php
$menu_filter['ul_class'] = 'list';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = '';
$menu_filter['a_class'] = '';

$menu_filter['li_submenu_class'] = 'dropdown';
$menu_filter['li_submenu_a_class'] = 'dropdown-toggle';

$menu_filter['link'] = '<a itemprop="url" data-item-id="{id}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {a_class}"  href="{url}" {tooltip}><span>{title}</span></a>';
$menu_filter['li_submenu_a_link'] = '<a itemprop="url" data-item-id="{id}" href="{url}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {li_submenu_a_class}" aria-haspopup="true" aria-expanded="false" {tooltip}>{title} <span class="caret"></span></a>';

$mt = menu_tree($menu_filter);
?>
<div id="header-menu">
    <div class="new-navbar add_more_nav clickable_nav navbar_new">

        <?php
        if ($mt != false) {
            print ($mt);
        } else {
            print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
        }
        ?>
    </div>
</div>


<script>
    $(document).ready(function () {
        // alert('start');
        $(document).on("click", ".expandCat", function(){
            // event.preventDefault();
            // event.stopPropagation();

            $(this).parent().siblings().removeClass('expandTrue');
            $(this).parent().siblings().find('li').removeClass('expandTrue');
            $(this).parent().toggleClass('expandTrue');
        });

        $(document).on("click","ul#custom_nav>li>span.expandCat", function(){
            $("ul#custom_nav>li ul li").removeClass("expandTrue");
            //$("ul#custom_nav>li ul>li").removeClass("expandTrue");
        });

        $("#header-menu>ul").attr('id','custom_nav');
        $("#header-menu li:has(ul)").addClass('hasSubMenu');

        $("#header-menu li.hasSubMenu").append(
        "<span class='expandCat'><i class='fa fa-caret-down'></i></span>");


    });

    $(document).click((event) => {
        if (!$(event.target).closest('.hasSubMenu').length) {
            if($('.hasSubMenu').hasClass('expandTrue')){
                $('#header-menu .hasSubMenu').removeClass('expandTrue');
            }
        }
    });


</script>

<style>

@media screen and (min-width: 991px){
    .expandTrue> span.expandCat i {
        transform: rotate(-90deg) !important;
    }
    .main-menu li ul>li:hover > .expandCat > i {
        color: #fff;
        transition: .5s;
    }
    .clickable_nav ul li > a.dropdown-toggle::after {
        display: none;
    }
    #custom_nav li ul li a{
        white-space: normal !important;
        display: block;
        width: 100%;
        clear: both;
        font-weight: 400;
        text-align: inherit;
        text-decoration: none;
        white-space: nowrap;
        font-size: 17px;
        word-break: break-word !important;
        padding: 4px 14px 4px 10px !important;
    }
    #custom_nav  .has-sub-menu > a .caret,
    #custom_nav a.dropdown-toggle::after{
        display: none !important;
    }
    #header_menu ul li ul li>a.dropdown-toggle::after{
        visibility: hidden;
    }
    #header-menu li.hasSubMenu li .expandCat i {
        right: 3px !important;
        top: 6px !important;
    }

    #header-menu li.hasSubMenu .expandCat i {
        cursor: pointer;
        display: inline-block !important;
        position: absolute;
        top: 7px;
        right: 0px;
        font-size: 20px;
        height: auto;
        width: auto;
        /* background: red; */
        z-index: 9;
    }
    #custom_nav>li>ul.dropdown-menu{
        top: 30px !important;
    }
    #custom_nav li ul.dropdown-menu {
        opacity: unset !important;
        visibility: unset !important;
        transform: unset !important;
        display: none;
    }
    .expandTrue>ul{
        display: block !important;
    }
    #custom_nav .dropdown-menu.show {
        display: none !important;
    }
    #custom_nav li ul li span.expandCat {
        color: #fff;
    }
    #custom_nav li ul li:hover>span.expandCat {
        color: #000;
    }

    #custom_nav li ul li:hover>a {
        background-color: #fff;
        color: #000;
    }
}

@media screen and (max-width: 991px){
    span.expandCat {
        display: none;
    }
}
/* a[href=""].dropdown-toggle.menu_element_link,
a[href="#"].dropdown-toggle.menu_element_link,
a[href=""][class*="menu-item-parent-"] {
    pointer-events: auto !important;
} */

.leftSubmenu ul li ul.dropdown-menu {
    left: auto !important;
    right: 100% !important;
}
.leftSubmenu ul li a.dropdown-toggle::after{
    transform: unset !important;
}
.navbar_new ul.list>li:nth-last-child(2) ul li ul.dropdown-menu,
.navbar_new ul.list>li:last-child ul li ul.dropdown-menu {
    left: auto !important;
    right: 100% !important;
}
.navbar_new ul.list>li:nth-last-child(2) ul li a.dropdown-toggle::after,
.navbar_new ul.list>li:last-child ul li a.dropdown-toggle::after{
    transform: unset !important;
}
</style>