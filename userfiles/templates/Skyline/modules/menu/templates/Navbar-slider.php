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
    .slider_navbar_cutom {
        display: block;
        position: relative;
        width: 716px;
        margin-left: 20px;
    }  
    .slick-slider-custom .slick-track>.slick-slide {
        display: inline-block !important;
        float: unset !important;
        padding: 5px 12px;
        vertical-align: middle !important;
        text-align: center;
    }
    .slider_navbar_cutom ul li:hover > ul {
        display: block !important;
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
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 1100px;
        display: block !important;
        flex-wrap: unset !important;
        align-items: unset !important;
        justify-content: unset !important;  
        margin-left: 53px;
    }
    #main-navigation .list a {
        font-size: 18px;
        white-space: break-spaces !important;
        word-break: break-word !important;
        line-height: 16px;
        position: relative;
        width: 100%;
    }
    #main-navigation li:hover > a.dropdown-toggle::after {
        transform: rotate(-90deg);
    }


li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu{
    left: unset !important;
    right: 100% ;
}


li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
    right: 0;
}



li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu ul.dropdown-menu {
    left: 100%;
    right: unset;
}

/* .slider_navbar_cutom .dropdown-toggle::after {
    margin-top: 10px;
    margin-right: -10px !important;
} */
@media (max-width: 1400px){
    .slider_navbar_cutom .dropdown-toggle::after {
        margin-top: 10px;
        margin-right: 1px !important;
    }
}
@media (max-width: 1550px) and (min-width: 1399px){
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 850px;
    }
}
@media (max-width: 1366px) and (min-width: 1281px){
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 800px;
    }
    #main-navigation .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset !important;
        right: 100% ;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu,
    li.slick-slide.slick-current.slick-active + li.slick-active + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }

}
@media (max-width: 1280) and (max-width: 1100px)) {
    ul.list.slick-slider-custom {
        width: 675px !important;
    }
}
@media (max-width: 1280px) and (min-width: 1201px){
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 630px;
    }
    #main-navigation .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active li.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active  + li.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
    #main-navigation ul li ul li > a {
        font-size: 14px;
    }
}
@media (max-width: 1200px) and (min-width: 1025px){
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 600px;
    }
    #main-navigation .list a {
        font-size: 18px;
    }
    li.slick-slide.slick-current.slick-active + li.slick-active:hover ul.dropdown-menu{
        left: unset;
        right: 100%;
    }


    li.slick-slide.slick-current.slick-active + li.slick-active:hover>ul.dropdown-menu{
        right: 0;
    }
    #main-navigation ul li ul li > a {
        font-size: 14px;
    }
}
@media (max-width: 1024px) and (min-width: 1000px){
    .navigation #main-navigation .list{
        padding: 15px 0;
        width: 430px;
    }
    #main-navigation .list a {
        font-size: 16px;
    }
    #main-navigation ul li ul li > a {
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
    .navigation #main-navigation .list{
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
        #main-navigation .list .slick-track>li.depth-0 > a.dropdown-toggle::after {
            float: unset;
            display: inline-block !important;
            margin: 0 !important;
            padding: 0 !important;
            vertical-align: middle !important;
        }

        
        .slick-slider-custom li ul > li > a.dropdown-toggle::after {
            position: absolute;
            top: 3px !important;
            right: 3px !important;
        }
        /* a.dropdown-toggle::after {
            float: right;
            display: block;
            margin-top: 0 !important;
            margin-right: 0 !important;

        } */
        ul.list.slick-slider-custom {
            width: 675px !important;
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
<div class="slider_navbar_cutom">
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
</div>

<script>
$(document).ready(function() {
    // window.onload = (event) => {
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
    // };

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
                        breakpoint: 1367,
                        settings: {
                            slidesToShow: 3,slidesToScroll: 1,infinite: false,dots: false
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