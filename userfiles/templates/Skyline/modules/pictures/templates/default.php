<?php

/*

type: layout

name: Default

description: Slick Pictures List Template

*/

?>

<style>
    .nk-box-1 {
        padding: 20px;
        width: 100%;
        height: 400px;
    }

    img.nk-img-fit {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media screen and (max-width: 768px) {
        .nk-box-1 {
            padding: 0px;
        }
    }
</style>
<?php if (is_array($data)) : ?>


    <script>
        mw.lib.require('slick');
    </script>

    <script>
        mw.moduleCSS("<?php print $config['url_to_module']; ?>css/slick.css");
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            if ($('.slickSlider', '#<?php print $params['id'] ?>').hasClass('slick-initialized')) {
                console.log('initialized');
            } else {
                console.log('not initialized');
            }

            //d($('.slickSlider', '#<?php print $params['id'] ?>').slick('unslick'))
            //  d($('.slickSlider', '#<?php print $params['id'] ?>').slick('getSlick').slick('getSlick'));

            $('.slickSlider', '#<?php print $params['id'] ?>').slick({
                dots: false,
                arrows: false,
                infinite: false,
                speed: 200,
                slidesToShow: 3,
                slidesToScroll: 3,
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });


            //            $('.slickNext', '#<?php //print $params['id'] 
                                            ?>//').on('click', function () {
            //                $('.slickSlider', '#<?php //print $params['id'] 
                                                    ?>//').slick('slickNext');
            //            });
            //
            //            $('.slickPrev', '#<?php //print $params['id'] 
                                            ?>//').on('click', function () {
            //                $('.slickSlider', '#<?php //print $params['id'] 
                                                    ?>//').slick('slickPrev');
            //            });

        });
    </script>

    <?php if (!$no_img) : ?>
        <div class="mw-module-images">
            <div class="bg-white">
                <br /><br />
                <div class="container">
                    <div class="nk-carousel-2 nk-carousel-x4 nk-carousel-no-margin nk-carousel-all-visible">
                        <div class="nk-carousel-inner">
                            <div class="slickSlider">
                                <?php $count = -1;
                                foreach ($data as $item) : ?>
                                    <?php $count++; ?>
                                    <div class="client client-<?php print $item['id']; ?>">
                                        <div>
                                            <div class="nk-box-1">
                                                <img src="<?php print thumbnail($item['filename'], 500, 333); ?>" alt="" class="nk-img-fit">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <br /><br />
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>