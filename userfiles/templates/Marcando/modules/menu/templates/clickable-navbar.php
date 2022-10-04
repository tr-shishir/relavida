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
<style>
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

    
@media screen and (min-width: 991px){
    #header-menu .list>li.hasSubMenu>.expandCat i {
        cursor: pointer;
        display: inline-block !important;
        position: absolute;
        top: 5px;
        right: -14px;
        height: auto;
        width: auto;
        color: #fff;
        z-index: 9;
        font-size: 15px;
    }
    
    #custom_nav  .has-sub-menu > a .caret,
    #custom_nav a.dropdown-toggle::after{
        display: none !important;
    }

     
    #header-menu li.hasSubMenu > ul li > .expandCat > i{
        font-size: 20px;
        position: absolute; 
        cursor: pointer;
        color: #000;
        top: 14px;
        right: 4px;
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
    .expandTrue>span.expandCat>i {
        transform: rotate(-90deg);
    }
    #header-menu ul.list>li li.expandTrue {
        background: #fff;
    }

    #header-menu ul.list>li li.expandTrue>a {
        color: #000 !important;
        background: #fff !important;
    }

    #header-menu ul.list>li li.expandTrue>.expandCat>i {
        color: #000 !important;
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
</style>
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
<div class="new-navbar add_more_nav navbar_new">

    <?php
    if ($mt != false) {
        print ($mt);
    } else {
        print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
    }
    ?>
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

        $("#header-menu>.new-navbar>ul").attr('id','custom_nav');
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
 