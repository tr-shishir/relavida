<?php

/*

type: layout

name: Slider Navbar

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

    .slick-slider-custom .slick-track>.slick-slide {
        display: inline-block !important;
        float: unset !important;
        padding: 5px 12px;
        vertical-align: middle !important;
    }
    .slick-prev:before, .slick-next:before {
        color: #007bff !important;
    }
    .slick-slider .slick-disabled {
        opacity : 0;
        pointer-events:none;
    }
    .slick-list.draggable {
        overflow: unset !important;
        clip-path: inset( -100vw 0 -100vw 0 );
    }
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 1100px;
        display: block !important;
        flex-wrap: unset !important;
        align-items: unset !important;
        justify-content: unset !important;
        margin-left: 53px;
    }
    #header_menu .list a {
        font-size: 20px;
        white-space: break-spaces !important;
        word-break: break-word !important;
        text-decoration: none;
        color: #fff;
    }
    #header_menu .list a {
        font-size: 20px;
        white-space: break-spaces !important;
        word-break: break-word !important;
        text-decoration: none;
        color: #fff;
    }
    .navigation.sticky #header_menu .list a,
    .navigation-holder.not-transparent .navigation:not(.sticky) #header_menu .list a{
        color: #000;
    }
    #header_menu ul li ul li>a {
        color: #fff;
    }
    .navigation #header_menu .list li.active a{
        color:#007bff !important;
    }

li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu {
    left: unset;
    right: 100%;
}


li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu {
    right: 0;
}



li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu {
    left: 100%;
    right: unset;
}

@media (max-width: 1550px){
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 850px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu {
        left: unset;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }

}

@media (max-width: 1398px){
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 800px;
    }
    #header_menu .list a {
        font-size: 18px;
    }
}
@media (max-width: 1367px) {
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 800px;
        margin-left: 53px !important;
    }

    .header-inverse .navigation .menu .list a {
        font-size: 16px;
    }
 
    #header-menu ul li ul li > a {
        font-size: 16px;
    }
    #header_menuli ul li{
        width: 100%;
        padding: 0;
        min-width: 160px;
    }

}
@media (max-width: 1350px) {
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu {
        left: unset;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active +  li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active +  li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
}
@media (max-width: 1280px){
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 630px;
    }
}
@media (max-width: 1200px){
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 600px;
    }
}
@media (max-width: 1024px){
    .navigation #header_menu .list{
        padding: 15px 0;
        width: 430px;
    }
    li.slick-slide.slick-current.slick-active  + li.slick-active:hover ul.dropdown-menu{
        left: unset;
        right: 100%;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
    .navigation .navbar-header {
        display: block !important;
    }
}

@media (max-width: 999px){
    .navigation .menu .list li a{
        width: 100% !important;
    }
}
@media (min-width: 1000px){
    #header_menu li.depth-0 > a.dropdown-toggle::after {
        float: unset;
        display: inline-block !important;
        margin-left: 0 !important;
        /* height: 0px;
        position: absolute; */
    }
    #header_menu li ul li:hover>a {
        background-color: #fff;
        color: #000;
    }
    
    #header_menu li ul li{
        width: 100%;
        padding: 0;
        min-width: 180px;
    }
    #header_menu ul li ul li>a {
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
        text-transform: capitalize;
        line-height: 20px;
    }
}
</style>
<?php
$menu_filter['ul_class'] = 'list slick-slider-custom';
$menu_filter['ul_class_deep'] = 'dropdown-menu';
$menu_filter['li_class'] = 'element';
$menu_filter['a_class'] = '';

$menu_filter['li_submenu_class'] = 'dropdown';
$menu_filter['li_submenu_a_class'] = 'dropdown-toggle';

$menu_filter['link'] = '<a itemprop="url" data-item-id="{id}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {a_class}"  href="{url}" {tooltip}><span>{title}</span></a>';
$menu_filter['li_submenu_a_link'] = '<a itemprop="url" data-item-id="{id}" href="{url}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {li_submenu_a_class}" aria-haspopup="true" aria-expanded="false" {tooltip}>{title} <span class="caret"></span></a>';

$mt = menu_tree($menu_filter);
?>
<div class="row">
    <div class="col-md-12">
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
$(document).ready(function() {
    window.onload = (event) => {
        if($(window).width() > 991){
            $(".slick-slider-custom").slick({
                infinite: false,
                initialSlide: 0,
                centerMode: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                dots: false,
                responsive: [
                    {
                        breakpoint: 1555,
                        settings: {
                            slidesToShow: 5,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1350,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1281,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 2,slidesToScroll: 1
                        }
                    }
                ]

            });
        }
    };

    $(window).on('resize', function(){
        setTimeout(function(){
            $('.slick-slider-custom')[0].slick.refresh();
        }, 500);
        $(".slick-slider-custom").slick({
                infinite: false,
                initialSlide: 0,
                centerMode: false,
                slidesToShow: 6,
                slidesToScroll: 2,
                dots: false,
                responsive: [
                    {
                        breakpoint: 1555,
                        settings: {
                            slidesToShow: 5,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1350,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1281,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 2,slidesToScroll: 1
                        }
                    }
                ]

        });
    });
});
</script>
