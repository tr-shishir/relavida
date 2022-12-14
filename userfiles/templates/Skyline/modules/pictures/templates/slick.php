<?php

/*

type: layout

name: Slick

description: Slick Pictures List Template

*/

?>

<style>
    .mw-module-images .slickSlider .slick-pictures-item {
        height: 350px;
        outline: none;
        display: inline-block;
        padding: 10px;
        overflow: hidden;
    }

    .mw-module-images .slickSlider .slick-pictures-item .thumbnail-wrapper .thumbnail img {
        height: 100%;
        max-height: 100%;
        -webkit-filter: grayscale(90%);
        filter: grayscale(90%);
        width: 100%;
        object-fit: cover;
        transition: 0.3s ease all;
    }

    .mw-module-images .slickSlider .slick-pictures-item:hover .thumbnail-wrapper .thumbnail img {
        max-height: 100%;
        -webkit-filter: grayscale(0%);
        filter: grayscale(0%);
        transform: scale(1.2);
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
                slidesToShow: 6,
                slidesToScroll: 6,
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 585,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
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
            <div class="slickSlider">
                <?php $count = -1;
                foreach ($data as $item) : ?>
                    <?php $count++; ?>
                    <div class="slick-pictures-item slick-pictures-item-<?php print $item['id']; ?>">
                        <div class="thumbnail-wrapper">
                            <div class="thumbnail">
                                <img src="<?php print thumbnail($item['filename'], 300); ?>" />
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
<?php endif; ?>