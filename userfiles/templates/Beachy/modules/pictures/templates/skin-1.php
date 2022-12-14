<?php

/*

type: layout

name: Slick Brands

description: Slick Brands

*/

?>

<style>
    .slide.item {
        height: 400px;
    }

    .slick-gal-2 img {
        padding: 0 6px;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .slick-gallery .slick-next {
        right: 45px;
        z-index: 99;
    }

    .slick-gallery .slick-prev {
        left: 45px;
        z-index: 99;
    }
</style>
<script>
    /* ###################### Slick   ###################### */
    $(document).ready(function() {
        if ($('<?php print '#' . $params['id']; ?> .slick-brands').length > 0) {
            $('<?php print '#' . $params['id']; ?> .slick-brands').each(function() {
                var el = $(this);
                el.slick({
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 5,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    dots: false,
                    responsive: [{
                        breakpoint: 1200,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '0px',
                            slidesToShow: 3
                        }
                    }, {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '0px',
                            slidesToShow: 2
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '0px',
                            slidesToShow: 1
                        }
                    }]
                });
            });
        }
    });
</script>
<?php if (is_array($data)) : ?>
    <?php $rand = uniqid(); ?>


    <div class="slick-brands slick-gal-2">
        <?php $count = -1;
        foreach ($data as $item) : ?>
            <?php $count++; ?>
            <div class="slide item pictures picture-<?php print $item['id']; ?>" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;">
                <img src="<?php print thumbnail($item['filename'], 300, 300, true); ?>" alt="">
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        gallery<?php print $rand; ?> = [
            <?php foreach ($data  as $item) : ?> {
                    image: "<?php print(thumbnail($item['filename'], 300)); ?>",
                    description: "<?php print $item['title']; ?>"
                },
            <?php endforeach;  ?>
        ];
    </script>
<?php endif; ?>