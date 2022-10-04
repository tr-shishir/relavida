<?php

/*

type: layout

name: Slider Navbar

description: Navigation bar

*/

?>
<style>
    .slick-slider-custom .slick-next{
        right: -10px;
    }

    .slick-slider-custom .slick-prev {
        left: 0px;
        z-index: 9999999;
    }

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
        overflow: unset !IMPORTANT;
        clip-path: inset( -100vw 0 -100vw 0 );
    }
    .navigation .menu .list {
        padding: 15px 0;
        width: 1100px;
    }
    .header-inverse .navigation .menu .list a {
        font-size: 20px;
        white-space: break-spaces;
        word-break: break-word;
        line-height: 17px;
    }
    #header-menu ul li ul li>a {
        color: #fff;
    }

    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu {
        left: unset !important;
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

@media (max-width: 1555px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 850px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
}
@media (max-width: 1400px){
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active  + li.slick-active  + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active  + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
}
@media (max-width: 1398px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 800px;
    }
    .header-inverse .navigation .menu .list a {
        font-size: 18px;
    }
}
@media (max-width: 1366px){
    #header-menu li ul li {
        width: 100%;
        padding: 0;
        min-width: 160px;
    }

}
@media (max-width: 1355px){
    #header-menu li ul li {
        width: 100%;
        padding: 0;
        min-width: 160px;
    }
    .navigation .menu .list {
        padding: 15px 0;
        width: 700px;
        margin-left: 8px;
    }

}
@media (max-width: 1349px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 675px;
        margin-left: 8px;
    }
    .header-inverse .navigation .menu .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active  + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100%;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
}
@media (max-width: 1280px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 630px;
    }
    .header-inverse .navigation .menu .list a {
        font-size: 16px;
    }

    #header-menu ul li ul li > a {
        font-size: 16px;
    }
}
@media (max-width: 1200px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 600px;
    }
}
@media (max-width: 1024px){
    .navigation .menu .list {
        padding: 15px 0;
        width: 430px;
    }

    .navigation .navbar-header {
        display: block !important;
    }
    .navigation .menu .list {
        padding: 15px 0;
        width: 677px !important;
        margin-right: 33px !important;
    }
}

@media (max-width: 999px){
    .navigation .menu .list li a{
        width: 100% !important;

    }
}
@media (min-width: 1000px){
    #header-menu li.depth-0 > a.dropdown-toggle::after {
    display: inline-block !important;
    /* margin: -10PX 0 0 !important; */
    padding: 0 !important;
    vertical-align: unset !important;
    bottom: 0px !important;
    height: 7px;
    float: none !important;
    }
    #header-menu li ul>li:hover>a{
        /* background-color: #fff; */
        /* color: #000; */
    }
    #header-menu li:hover > a.dropdown-toggle::after {
        transform: rotate(-90deg);
    }
    #header-menu li>ul li a.dropdown-toggle::after {
        margin-left: 0 !important;
        position: absolute;
        top: 2px;
        right: 6px;
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

if ($mt != false) {
    print ($mt);
} else {
    print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
}
?>
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
    });
});
</script>