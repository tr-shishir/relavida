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
    .video-section {
        position: relative;
        z-index: -1 !important;
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
        overflow: unset !important;
        clip-path: inset( -100vw 0 -100vw 0 );
    }
    .slide_navbar .list {
        padding: 15px 0;
        width: 750px;
        display: block !important;
        flex-wrap: unset !important;
        align-items: unset !important;
        justify-content: unset !important;
    }
    .slide_navbar .list a {
        font-size: 17px;
        white-space: break-spaces;
        word-break: break-word;
        line-height: 16px;
    }
    .slide_navbar ul li ul li>a {
        color: #fff !important;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu {
        left: unset !important;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu {
        right: 0;
    }



    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu {
        left: 100%;
        right: unset !important;
    }

@media (max-width: 1550px){
    .slide_navbar .list {
        padding: 15px 0;
        width: 700px;
    }
}
@media (max-width: 1520px){
    .active_navbar{
        margin-left: 49px;
    }
}
@media (max-width: 1400px){
    .slide_navbar .list {
        padding: 15px 0;
        width: 700px;
    }
    .slide_navbar .list a {
        font-size: 16x;
    }

}
@media (max-width: 1280px){
    .slide_navbar .list {
        padding: 15px 0;
        width: 500px;
    }
    .slide_navbar .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100%;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0 !important;
    }
    .slide_navbar ul li ul li > a {
        font-size: 14px;
    }
     
}
@media (max-width: 1200px){
    .slide_navbar .list {
        padding: 15px 0;
        width: 450px;
    }
    .slide_navbar .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active  + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100%;
    }
    li.slick-slide.slick-current.slick-active  + li.slick-active:hover>ul.dropdown-menu{
        right: 0 !important;
    }
    .slide_navbar ul li ul li > a {
        font-size: 14px;
    }
}
@media (max-width: 1024px){
    .slide_navbar .list {
        padding: 15px 0;
        width: 430px;
    }
    .slide_navbar .list a {
        font-size: 16px;
    }
    .slide_navbar ul li ul li > a {
        font-size: 14px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active  + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active +  li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
    .navigation .navbar-header {
        display: block !important;
    }
    .slide_navbar.list {
        padding: 15px 0;
        width: 677px !important;
        margin-right: 33px !important;
    }
}

@media (max-width: 999px){
    .slide_navbar .list li a{
        width: 100% !important;
    }
}
@media (min-width: 1000px){
    #header-menu li.depth-0 > a.dropdown-toggle::after {
        float: unset;
        display: inline-block !important;
        margin: 0 !important;
        padding: 0 !important;
        vertical-align: unset !important;
        bottom: 0px !important;
        height: 7px;
    }
    #header-menu li:hover > a.dropdown-toggle::after {
        transform: rotate(-90deg);
    }
    #header-menu li>ul li a.dropdown-toggle::after {
        margin-left: 0 !important;
        position: absolute;
        top: 3px;
        right: 4px;
    }
    #header-menu ul li ul li a:hover {
        background: #fff;
        color: #000 !important;
    }
    #header-menu ul li ul li>a {
        color: #fff;
        padding: 10px 15px 10px 10px !important;
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
$menu_filter['li_submenu_a_link'] = '<a itemprop="url" data-item-id="{id}" href="{url}" class="menu_element_link {active_class} {exteded_classes} {nest_level} {li_submenu_a_class}" aria-haspopup="true" aria-expanded="false" {tooltip}>{title}</a>';

$mt = menu_tree($menu_filter);
?>
<div class="slide_navbar active_navbar">

<?php
if ($mt != false) {
    print ($mt);
} else {
    print lnotif("There are no items in the menu <b>" . $params['menu-name'] . '</b>');
}
?>
</div>


<script>
$(document).ready(function() {
    window.onload = (event) => {
        if($(window).width() > 991){
            $(".slick-slider-custom").slick({
                infinite: false,
                initialSlide: 0,
                centerMode: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                responsive: [
                    {
                        breakpoint: 1550,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1367,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1281,
                        settings: {
                            slidesToShow: 3,slidesToScroll: 1
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
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: false,
                responsive: [
                    {
                        breakpoint: 1550,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1367,
                        settings: {
                            slidesToShow: 4,slidesToScroll: 1,infinite: false,dots: false
                        }
                    },
                    {
                        breakpoint: 1281,
                        settings: {
                            slidesToShow: 3,slidesToScroll: 1
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
