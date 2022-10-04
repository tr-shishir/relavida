<?php

/*

type: layout

name: Menu with Description Dropdown

description: Navigation bar

*/

?>

<style>
    .custom_hover_menu span.expandCat {
        display: none !important;
    }
    @media (min-width: 1000px){
        #header-menu li>ul li a.dropdown-toggle::after {
            margin-left: 0 !important;
        }
    }

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
    .navigation .menu .list > li >a>span.menu-description {
        display: none;
    }
    .navigation .menu .dropdown-menu {
        padding: 20px 10px;
    }

    .navigation .menu .menu-with-description .dropdown-menu .menu-description {
        display: block;
        color: inherit;
        font-size: 12px;
        text-align: justify;
    }

    .menu-with-description .dropdown-menu .menu-description{
        font-weight: 400;
        opacity: .8;
    }
    #main-navigation .menu-with-description li ul li {
        width: auto;
        margin-bottom: 10px;
    }

    #main-navigation .menu-with-description li>ul li a.dropdown-toggle::after {
        position: absolute;
        top: 0;
        right: 5px;
    }

    #main-navigation .menu-with-description li ul li>ul{
        left: 100% !important;
        top: 0 !important;
    }

    #main-navigation .menu-with-description ul li ul li>a {
        min-width: 250px;
        max-width: 250px;
        white-space: normal !important;
        word-break: break-word;
    }

    #main-navigation .menu-with-description li ul li>ul{
        width: fit-content;
    }

    .module-menu .dropdown-menu{
        top: 100% !important;
    }
    #main-navigation .menu-with-description ul li ul li:hover >a,
    #main-navigation .menu-with-description ul li ul li>a:hover {
        background-color: #969696 !important;
        color: #000 !important;
    }

    .navigation .menu .list>li>a{
        padding: 15px 0 !important;
    }

    .navigation .menu .list{
        padding: 0 !important;
    }

    #main-navigation li:hover >.dropdown-menu {
        display:block;
    }

    #main-navigation .menu-with-description ul li ul li>a>span {
        display: block;
    }

    #main-navigation .menu-with-description ul li ul li>a>span.menu-description {
        font-weight: 400;
        font-size: 13px;
    }

    .active > .dropdown-menu {
        display: none;
    }
    .menu-with-description>ul>li>a span.menu-description {
        display: none;
    }
</style>
<?php
$menu_filter['ul_class'] = 'list';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = '';
$menu_filter['a_class'] = '';

$menu_filter['li_submenu_class'] = 'dropdown';
$menu_filter['li_submenu_a_class'] = 'dropdown-toggle';

$menu_filter['link'] = '<a itemprop="url" data-item-id="{id}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {a_class}"  href="{url}" {tooltip}><span>{title}</span><span class="menu-description">{description}</span></a>';
$menu_filter['li_submenu_a_link'] = '<a itemprop="url" data-item-id="{id}" href="{url}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {li_submenu_a_class}" aria-haspopup="true" aria-expanded="false" {tooltip}>{title} <span class="caret"></span><span class="menu-description">{description}</span></a>';

$mt = menu_tree($menu_filter);

?>
<div class="add_more_nav custom_hover_menu navbar_new menu-with-description">
<?php
    if ($mt != false) {
        print ($mt);
    } else {
        print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
    }
?>
</div>
