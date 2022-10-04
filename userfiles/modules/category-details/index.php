<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
<style>
    .single-slider-item-image.tns-item {
        height: 300px;
        background-size: cover !important;
        background-position: center !important;
    }

    .tns-nav {
        display: none;
    }

    .tns-controls {
        position: absolute;
        z-index: 999;
        height: 100%;
        width: 100%;
    }

    .tns-outer [data-controls="prev"] {
        top: 50%;
        position: absolute;
        border: 0px !important;
        left: 10px;
        transform: translateY(-50%);
        padding-left: 5px;
        padding-right: 5px;
    }

    .tns-outer [data-controls="next"] {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        border: 0;
        padding-left: 5px;
        padding-right: 5px;
    }

    .tns-outer {
        position: relative;
    }

    .category-details {
        margin: 20px 0;
    }

    .category-details p {
        margin-top: 10px;
        text-align: justify;
        font-size: 16px;
    }

    span.catRead {
        position: relative;
        display: inline-block;
        cursor: pointer;
        font-weight: 800;
        text-decoration: underline;
    }

    .cat-desc.cat-dectriiption-read-more p {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* number of lines to show */
        -webkit-box-orient: vertical;
    }

    [data-action='stop'],
    [data-action='start'] {
        display: none;
    }
</style>
<?php
$cat = DB::table('categories')->where('id', CATEGORY_ID)->first();
$cat_img = array(
    'rel_type'  => "categories",
    'rel_id' => $cat->id
);
$media_cat = get_pictures($cat_img);
?>
<div class="category-details">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <div class="single-slider-item">
                <?php if ($media_cat != false) : ?>
                    <?php foreach ($media_cat as $mediaslider) : ?>
                        <div class="single-slider-item-image" style="background: url('<?php print $mediaslider['filename'] ?>" alt="category img');">
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="cat-desc">
        <p><?php print $cat->description ?></p>
    </div>
</div>

<script>
    var slider = tns({
        container: '.single-slider-item',
        items: 1,
        autoplay: true,
        controlsText: ["<i class='fa fa-arrow-circle-left' ></i>", "<i class='fa fa-arrow-circle-right'></i>"]
    });








    $(document).ready(function() {
        var categoryDescriptionWords = $('.cat-desc p').html().split(' ');
        // alert(categoryDescriptionWords.length);

        if (categoryDescriptionWords.length > 90) {
            $('.cat-desc').addClass('cat-dectriiption-read-more');
            $('.cat-desc').append('<span class="catRead">read more...</span>')
        }

        $('.catRead').on('click', function() {
            $('.cat-desc').toggleClass('cat-dectriiption-read-more');
            if ($(this).text() == "read more...") {
                $(this).text("read less...");
                $('.description-short .typography-area').html(full_text);
            } else {
                $(this).text("read more...");
                $('.readmore-btn-enabled.description-short .typography-area').html(splittedWord);
            };
        });


        // var splittedWord = full_text.split(/\s+/).slice(0,30).join(" ");
    });
</script>