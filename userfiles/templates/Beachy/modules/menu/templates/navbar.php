<?php

/*

type: layout

name: Navbar

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
<style>
    .custom_hover_menu span.expandCat {
        display: none !important;
    }

    .leftSubmenu ul li ul.dropdown-menu {
        left: auto;
        right: 100%;
    }
    .leftSubmenu ul li a.dropdown-toggle::after{
        transform: unset !important;
    }
    #header-menu li ul li:hover>a {
        background-color: #fff;
        color: #000;
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
<?php
$menu_filter['ul_class'] = 'list';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = '';
$menu_filter['a_class'] = '';

$menu_filter['li_submenu_class'] = 'dropdown';
$menu_filter['li_submenu_a_class'] = 'dropdown-toggle';

$menu_filter['link'] = '<a itemprop="url" data-item-id="{id}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {a_class}"  href="{url}" {tooltip}><span>{title}</span></a>';
$menu_filter['li_submenu_a_link'] = '<a itemprop="url" data-item-id="{id}" href="{url}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {li_submenu_a_class}" aria-haspopup="true" aria-expanded="false" {tooltip}><span class="name">{title}</span> <span class="caret"></span></a>';

$mt = menu_tree($menu_filter);
?>
<div id="header-menu">
    <div class="add_more_nav custom_hover_menu navbar_new">
        <?php
        if ($mt != false) {
            print ($mt);
        } else {
            print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
        }
        ?>
    </div>
</div>