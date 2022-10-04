$(window).load(function () {



    // Simple way to enable the 'placeholder' attribute for browsers that doesn't support it
    if ('placeholder' in document.createElement('input') === false) {
        mw.$("[placeholder]").each(function () {
            var el = $(this), p = el.attr("placeholder");
            el.val() == '' ? el.val(p) : '';
            el.bind('focus', function (e) {
                el.val() == p ? el.val('') : '';
            });
            el.bind('blur', function (e) {
                el.val() == '' ? el.val(p) : '';
            });
        });
    }


    /* Fixed shop cart */

    if (typeof _shop === 'boolean') {
        var header = document.getElementById('header');
        $(window).bind("scroll", function () {
            var cart = mw.$(".mw-cart-small", header)[0];
            var cart_module = mw.tools.firstParentWithClass(cart, 'module');
            if ($(window).scrollTop() > $(header).outerHeight()) {
                $(cart_module).addClass("mw-cart-small-fixed");
            }
            else {
                $(cart_module).removeClass("mw-cart-small-fixed");
            }
        });
    }
});


TempateFunctions = {
    contentHeight: function () {

        /**************************************
         Minimum height for the Main Container
         **************************************/
        if (self !== top) {
            return false;
        }

        var content = document.getElementById('content-holder'),
            footer = document.getElementById('footer'),
            header = document.getElementById('header');

        $(content).css('minHeight', $(window).height() - $(header).outerHeight(true) - $(footer).outerHeight(true));

    }
}


$(document).ready(function () {

    TempateFunctions.contentHeight();
    if (typeof(mw.msg.product_added) == "undefined") {
        mw.msg.product_added = "Your product is added to the shopping cart";
    }

    // $(window).bind('mw.cart.add', function () {
    //     var modal_html = ''
    //         + '<div id="mw-product-added-popup-holder"> '
    //         + '<h4>' + mw.msg.product_added + '</h4>'
    //         + '<div id="mw-product-added-popup" class="text-center" style="width:210px;"> '
    //         + ' </div>';
    //     +' </div>';
    //     Alert(modal_html)
    //     mw.load_module('shop/cart', '#mw-product-added-popup', false, {template: 'popup'});
    //
    //
    // });

    $(window).bind('mw.cart.add', function(event, data){

        $("#shoppingCartModal").modal("show");

    });

});

$(window).bind('load resize', function (e) {

    TempateFunctions.contentHeight();

});

$(document).ready(function () {
    $('.nk-navbar-full-toggle').on('click', function () {
        $('nav.nk-navbar').addClass('open');
    });

    $('.nk-nav-close').on('click', function () {
        $('nav.nk-navbar').removeClass('open');
    });
});
$(document).ready(function () {
    $('.add_more_nav .list.menu_1').collapseNav({
        responsive: 1, //Automatically count the possible buttons in the navigation
        number_of_buttons: 4, //Allowable number of buttons in the navigation. Works only if 'responsive' = 0
        more_text: 'More', //The text on the Drop Down Button
        mobile_break: 992, //With this resolution and higher the script will be init
        li_class: 'dropdown',
        li_a_class: 'dropdown-toggle',
        li_ul_class: 'dropdown-menu',
        caret: '<span class="caret"></span>'
    });
})

$(document).ready(function () {
    var homeSlider = $('.slider-new-layout');
    if (homeSlider.length > 0) {
    homeSlider.each(function () {
    var el = $(this);
    el.slick({
    centerMode: false,
    centerPadding: '0px',
    slidesToShow: 1,
    arrows: true,
    autoplay: false,
    autoplaySpeed: 2000,
    dots: false
    });
    });
    }
    });