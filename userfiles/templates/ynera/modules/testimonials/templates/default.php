<?php

/*

type: layout

name: Default

description: Testimonials Default

*/

?>

<script>
    $(document).ready(function () {
        if ($('<?php print '#' . $params['id']; ?> .slick-testimonials').length > 0) {
            $('<?php print '#' . $params['id']; ?> .slick-testimonials').each(function () {
                var el = $(this);
                el.slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: false,
                    dots:true
                });
            });
        }
    });
</script>
<div class="about-us-testimonial-list slick-testimonials">
    <?php if (isset($data)): ?>
        <?php foreach ($data as $item) { ?>
            <div class="slide about-us-testimonial-item">
                <div class="slide-holder">
                    <span class="about-us-testimonial-item-icon">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </span>
                    <div class="about-us-testimonial-item-content">
                        <p><?php print $item['content']; ?></p>
                    </div>
                    <div class="about-us-testimonial-item-info">
                        <?php if ($item['client_picture']): ?>
                            <div class="about-us-testimonial-item-info-photo" style="background-image: url('<?php print thumbnail($item['client_picture'], 200, 200, true); ?>');"></div>
                        <?php endif; ?>
                        <div class="about-us-testimonial-item-info-content">
                            <h6><?php print $item['name']; ?></h6>
                            <span><?php if (isset($item["client_role"])): ?><?php if (isset($item["client_company"])): ?>, <?php endif; ?><?php print $item['client_role']; ?><?php endif; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php else: ?>

    <?php endif; ?>
</div>
