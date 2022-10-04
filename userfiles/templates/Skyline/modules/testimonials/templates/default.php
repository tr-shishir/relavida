<?php

/*

type: layout

name: Default

description: Testimonials displayed in Slider

*/

?>

<script>
    mw.lib.require('bootstrap3ns');
</script>


<script>mw.module_css("<?php print $config['url_to_module'] ?>templates/templates.css", true);</script>
<script>mw.module_css("<?php print $config['url_to_module'] ?>templates/js/slick.css", true);</script>
<script>mw.require("<?php print $config['url_to_module'] ?>templates/js/slick.min.js", true);</script>
<script>
    $(document).ready(function () {
        $("#<?php print $params['id']; ?> .mw-testimonials-slider-2").slick({
            infinite: true,
            dots: true,
            arrows: false
        });
    })
</script>

<style>
    .mw-testimonials-slider-2 .mw-testimonials-item h5 {
        color: #fff;
        font-family: Work Sans, sans-serif;
        font-size: .96rem;
        font-weight: 500;
        font-style: normal;
        text-transform: uppercase;
    }

    .mw-testimonials-slider-2 p {
        font-size: 1.685rem;
        line-height: 1.45;
        margin-bottom: 1.15rem;
        color: #fff;
        font-family: Playfair Display, serif;
        font-style: italic;
        letter-spacing: 1px;
    }

    .mw-testimonials-slider-2 .slick-dots button {
        font-size: 0;
        background: white;
        border-radius: 10px;
        border: 1px solid #999;
        width: 10px;
        height: 10px;
        opacity: .4;
        transform: scale(.6);
        transition: opacity .4s, transform .4s;
    }

    .mw-testimonials-slider-2 .slick-dots .slick-active button {
        background: #fff;
        border-color: #fff;
        transform: scale(1);
        opacity: 1;
    }

    .mw-testimonials-slider-2 .slick-dots {
        bottom: 40px;
    }
</style>

<?php
$bgImage = get_option('bg-image', $params['id']);
if ($bgImage == false) {
    $wrapperStyle = 'background: #333;';
} else {
    $wrapperStyle = 'background-image: url(' . $bgImage . ');';
}
?>

<div class="mw-testimonials mw-testimonials-slider-2" style="<?php print $wrapperStyle; ?>">
    <?php $data = get_testimonials(); ?>
    <?php foreach ($data as $item): ?>
        <div class="mw-testimonials-item">
            <br/>
            <br/>
            <br/>
            <br/>
            <?php if ($item['client_picture'] != false): ?>
                <span class="mw-testimonials-item-image" style="background-image: url(<?php print $item['client_picture']; ?>);"></span>
            <?php endif; ?>
            <div class="mw-testimonials-item-content">
                <p><?php print $item['content']; ?></p>
                <br/>
                <?php if (isset($item['client_website'])) { ?>
                    <h4><a href="<?php print $item['client_website']; ?>" target="_blank"><?php print $item['name']; ?></a></h4>
                <?php } else { ?>
                    <h5><?php print $item['name']; ?></h5>
                <?php } ?>
            </div>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>
    <?php endforeach; ?>
</div>
