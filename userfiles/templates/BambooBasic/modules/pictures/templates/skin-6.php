<?php

/*


*/

?>

<style type="text/css">
    .elevatezoom .elevateHover {
        display: none;
    }

    .mfp-figure figure {
        position: relative;
    }

    .mfp-figure .eh-content {
        position: absolute;
        left: 0;
        height: auto;
        width: 100%;
        top: 50%;
        transform: translateY(-50%);
        text-align: center;
        background-color: #ffffff8a;
        padding: 15px;
        opacity: 0;
        transition: .5s ease;
    }
    .mfp-figure figure:hover .eh-content {
        opacity: 1;
    }

    .shop-inner-page .elevatezoom #elevatezoom-gallery a {
        position: relative;
    }

    .gallery-lists-caption {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        height: 100%;
        width: 100%;
        background-color: #000;
    }
</style>

<?php if (is_array($data)): ?>
    <div class="elevatezoom">
        <div class="elevatezoom-holder">
            <span class="helper"></span>
            <?php foreach ($data as $key => $item): ?>
                <?php if ($key == 0): ?>
                    <img id="elevatezoom" class="main-image" src="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>"/>
                    <div class="elevateHover">
                        <div class="eh-content">
                            <?php
                                @$insta_des = $item['insta_details']->insta_img_description;
                                if($insta_des != null):?>
                                    <?php if ($item['id'] == $item['insta_details']->media_id): ?>
                                        <p id="instaDescription<?php echo $item['id']; ?>"><?php echo $insta_des;  ?></p>
                                    <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div id="elevatezoom-gallery">
            <?php foreach ($data as $item): ?>
                <a class="product-thumbnail-list" href="<?php print thumbnail($item['filename'], 1920, 1920); ?>" id="elevatezoom" data-image="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>" style="background-image: url('<?php print thumbnail
                ($item['filename'], 200, 200); ?>');" image-id="<?php if(isset($item['image_id']) && $item['image_id']){echo $item['image_id'];} ?>">
                    <div class="gallery-lists-caption">
                        <?php
                        @$insta_des = $item['insta_details']->insta_img_description;
                        if($insta_des != null):?>
                            <?php if ($item['id'] == $item['insta_details']->media_id): ?>
                                <p><?php print $insta_des;  ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div id="elevatezoom-gallery" class="js-popup-gallery mobile-view">
            <?php foreach ($data as $item): ?>
                <a href="<?php print thumbnail($item['filename'], 1920, 1920); ?>" id="elevatezoom" data-image="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>" style="background-image: url('<?php print thumbnail
                ($item['filename'], 200, 200); ?>');" image-id="<?php if(isset($item['image_id']) && $item['image_id']){echo $item['image_id'];} ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    $('#elevatezoom').on('click', function(){
        let captionContent = $(".elevatezoom-holder .elevateHover").html();
        setTimeout(function(){
            $('.mfp-figure figure').append(captionContent);
            $('button.mfp-arrow').on('click', function(){
                var viewedimglink = $(".mfp-gallery .mfp-image-holder .mfp-figure img").attr('src');
                var glCaptionForArrowClick = $('a[href="'+viewedimglink+'"]>.gallery-lists-caption').html();
                $('.eh-content').html(glCaptionForArrowClick);
                
                if ($(".eh-content p").length > 0) {
                    $('.eh-content').show();
                }else{
                    $('.eh-content').hide();
                }
            });
        }, 500);
    });

    $('.gallery-lists-caption').on('click', function(){ 
        var glCaption = $(this).html();
        $('.eh-content').html(glCaption);
        
        if ($(".eh-content p").length > 0) {
            $('.eh-content').show();
        }else{
            $('.eh-content').hide();
        } 
    });
</script>
