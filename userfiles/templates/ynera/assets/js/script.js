$(document).ready(function () {
    $(".home-product-slider").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow:
            "<button type='button' class='slick-prev'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
        nextArrow:
            "<button type='button' class='slick-next'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 525,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });

    // $('.about-us-testimonial-list').slick({
    //     infinite: true,
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     arrows: false,
    //     dots:true
    // });

    // const headerSearch = document.getElementsByClassName("header-search");
    // document.onclick = function (e) {
    //     if (e.target.class !== "header-search") {
    //         headerSearch.classList.remove("show");
    //     }
    //     console.log(e.target.id);
    // };

    // STICKY HEADER
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 150) {
            $(".navbar-wrapper").addClass("sticky");
            $(".header-top").addClass("hide");
        } else {
            $(".navbar-wrapper").removeClass("sticky");
            $(".header-top").removeClass("hide");
        }
    });
});
