<script>
    mw.lib.require('slick');
</script>
<script>
    $(document).ready(function () {
        $('.slickSlider', '#<?php print $params['id'] ?>').slick({
            dots: false,
            arrows: false,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
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
                    breakpoint: 585,
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

        $('.slickNext', '#<?php print $params['id'] ?>').on('click', function () {
            $('.slickSlider', '#<?php print $params['id'] ?>').slick('slickNext');
        });

        $('.slickPrev', '#<?php print $params['id'] ?>').on('click', function () {
            $('.slickSlider', '#<?php print $params['id'] ?>').slick('slickPrev');
        });

    });
</script>

<div class="team-card-holder">
    <style scoped="scoped">
        .module-teamcard .slickSlider {
            width: 90%;
            margin: 0 auto;
        }

        .module-teamcard .slickPrev,
        .module-teamcard .slickNext {
            position: absolute;
            margin-top: 250px;
            background-repeat: no-repeat;
            width: 26px;
            height: 53px;
            border: 0;
            outline: none;
        }

        .module-teamcard .slickPrev {
            left: 25px;
            background: url('<?php print template_url(); ?>modules/teamcard/img/arrow-left.png');
        }

        .module-teamcard .slickNext {
            right: 25px;
            background: url('<?php print template_url(); ?>modules/teamcard/img/arrow-right.png');
        }

        .module-teamcard .team-card-item {
            margin: 0;
            display: block;
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
        }

        .module-teamcard .team-card-item .team-card-item-image {
            height: 250px;
            display: block;
        }

        .module-teamcard .team-card-item .team-card-item-image img {
            max-height: 250px;
            max-width: 90%;
            margin: auto;
        }

        .module-teamcard .team-card-item .team-card-item-name {
            display: block;
            font-size: 24px;
            text-align: center;
            padding: 10px 15px;
            color: #3b3b3b;
            display: block;
        }

        .module-teamcard .team-card-item .team-card-item-position {
            color: #fd8a30;
            font-size: 14px;
            font-weight: 500;
            display: block;
            margin-bottom: 10px;
        }

        .module-teamcard .team-card-item .team-card-item-bio {
            color: #3b3b3b;
            font-size: 14px;
            display: block;
        }

        .module-teamcard .team-card-item .item-content {
            background-color: white;
            color: #9A9A9A;
            font-size: 13px;
            margin: 20px auto;
            vertical-align: middle;
            padding: 10px 0;
            border: 1px solid #d8d8d8;
            padding: 20px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        @media screen and (max-width: 767px) {
            .module-teamcard .slickPrev {
                left: 5px;
            }

            .module-teamcard .slickNext {
                right: 5px;
            }
        }

        @media screen and (min-width: 1366px) {
            .module-teamcard .team-card-item:hover .item-content {
                border: 1px solid #f9a011;
                -webkit-box-shadow: 0 0 8px #f9a011;
                box-shadow: 0 0 8px #f9a011;
                z-index: 1;
                position: relative;
                -webkit-border-radius: 2px;
                -moz-border-radius: 2px;
                border-radius: 2px;
                -webkit-transform: scale(1.1, 1.1);
                -moz-transform: scale(1.1, 1.1);
                -ms-transform: scale(1.1, 1.1);
                -o-transform: scale(1.1, 1.1);
                transform: scale(1.1, 1.1);
            }
        }

    </style>
    <div class="module-teamcard">
        <button type="button" class="slickPrev"></button>
        <button type="button" class="slickNext"></button>

        <ul class="slickSlider">
            <?php
            $count = 0;
            foreach ($data as $slide) {
                $count++;
                ?>
                <li class="team-card-item col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="item-content">
                        <span class="team-card-item-image"><img src="<?php print $slide['file']; ?>" alt=""/></span>
                        <span class="team-card-item-name"><?php print array_get($slide, 'name'); ?></span>
                        <span class="team-card-item-position"> <?php print array_get($slide, 'role'); ?></span>
                        <span class="team-card-item-bio"> <?php print array_get($slide, 'bio'); ?></span>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
 
