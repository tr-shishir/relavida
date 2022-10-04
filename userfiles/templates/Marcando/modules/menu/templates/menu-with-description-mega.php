<?php

/*

type: layout

name: Menu with Description Mega

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
    .menu .list > li >a>span.menu-description {
        display: none;
    }

    .menu .dropdown-menu {
        padding: 20px 10px;
    }

    .menu .menu-with-description .dropdown-menu .menu-description {
        display: block;
        font-weight: 400;
        opacity: .8;
        font-size: 12px;
        text-align: justify;
    }
    #header-menu .menu-with-description li ul li {
        width: auto;
        margin-bottom: 10px;
    }

    #header-menu .menu-with-description li>ul li a.dropdown-toggle::after {
        position: absolute;
        top: 0;
        right: 5px;
        color: #000 !important;
    }

    #header-menu .menu-with-description li ul li>ul{
        left: 104% !important;
    }

    #header-menu .menu-with-description ul li ul li>a {
        color: #fff;
        min-width: 250px;
        max-width: 250px;
        border:0;
    }
    #header-menu .menu-with-description li ul li>ul{
        width: fit-content;
    }
    .module-menu .dropdown-menu{
        top: 100% !important;
    }
    #header-menu .menu-with-description ul li ul li>a:hover {
        background-color: #969696 !important;
        color: #000 !important;
    }

    .menu .list>li>a{
        padding: 15px 0 !important;
    }

    .menu .list{
        padding: 0 !important;
    }

    .menu-with-description li.dropdown {
        position: unset;
    }

    .menu-with-description li.dropdown ul.dropdown-menu {
        width: 83%;
        right: 50%;
        transform: translate(10%,0%);
    }

    .menu-with-description li.dropdown ul.dropdown-menu li {
        width: 25% !important;
        display: inline-block;
    }

    #header-menu .menu-with-description li.dropdown ul.dropdown-menu li ul.dropdown-menu {
        left: unset !important;
        position: absolute;
        padding: 0px;
        top: 100% !important;
        border: 1px solid #fff;
        right: 0 !important;
        width: calc(100% - 20px);
    }

    #header-menu .menu-with-description li.dropdown ul.dropdown-menu li ul.dropdown-menu li {
        width: 100% !important;
    }
    #header-menu .menu-with-description ul li ul li>a {
        max-width: 100% !important;
        min-width: unset !important;
        padding: 8px 10px !important;
    }
    #header-menu .menu-with-description li ul li {
        vertical-align: top;
    }

    .menu-with-description li.dropdown ul.dropdown-menu li {
        text-align: left;
    }

    #header-menu .menu-with-description li.dropdown ul.dropdown-menu li ul.dropdown-menu li:last-child {
        margin-bottom: 0;
    }

    .menu-with-description ul li.dropdown:hover >ul {
        display: block;
        top: 59px !important;
    }
    #header-menu .menu-with-description li ul li {
        display: inline-block;
    }

    #header-menu .menu-with-description li ul li a {
        color: #000 !important;
        white-space: break-spaces;
        margin: 0px 5px;
    }
    .menu-with-description li.dropdown ul.dropdown-menu li:hover>ul.dropdown-menu {
        display: block;
        -webkit-box-shadow: 0px 0px 7px -1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 7px -1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 7px -1px rgba(0,0,0,0.75);
        max-width: 355px;
    }
    .menu-with-description ul li.dropdown>a {
        position: relative;
    }

    .menu-with-description ul li.dropdown>a:after {
        position: absolute;
        content: '+';
        font-size: 18px;
        right: -15px;
        top: 13px;
    }
    .mw-live-edit .menu-with-description ul li.dropdown:hover >ul {
    top: 110px !important;
}
.menu-with-description ul li ul li a span.caret {
    position: relative;
    width: 100%;
    display: block;
}

.menu-with-description ul li ul li a span.caret:after {
    position: absolute;
    content: '+';
    right: 0;
    top: -28px;
    width: 100%;
    text-align: right;
}
</style>
<?php
$menu_filter['ul_class'] = 'list';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = '';
$menu_filter['a_class'] = '';

$menu_filter['li_submenu_class'] = 'dropdown';
//$menu_filter['li_submenu_a_class'] = 'dropdown-toggle';

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
