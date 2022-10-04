<?php

/*



*/

?>
<?php if (is_post()): ?>
    <?php include "skin-1.php"; ?>
<?php else : ?>
    <?php $rand = uniqid(); ?>

    <style>
        #mw-gallery-<?php print $rand; ?> .slider-container {
            position: relative;
            left: auto;
            top: auto;
            /*width: 780px;*/
            height: 580px;
            margin: 0 auto;
            text-align: center;
        }
    </style>

    <div>
        <div class="screenshots-slider popup-gallery" id="mw-gallery-<?php print $rand; ?>">
            <div class="slider-container" style="text-align: center;">
                <?php if (is_array($data)): ?>
                    <?php $cnt = count($data); ?>
                    <div class="slider-content">
                        <?php $count = -1;
                        foreach ($data as $item): ?>
                            <?php $count++; ?>
                            <?php if ($cnt > 2): ?>
                                <div class="slider-single">
                                    <a href="<?php print thumbnail($item['filename'], 1600, 1600); ?>" class="popup-img">
                                        <img class="slider-single-image"
                                             src="<?php print thumbnail($item['filename'], 1280, 900, true); ?>" alt=""/>
                                    </a>
                                </div>
                            <?php else: ?>
                                <br/>
                                <a href="<?php print thumbnail($item['filename'], 1600, 1600); ?>"
                                   class="popup-img <?php if ($count == 1): ?>hidden<?php endif; ?>">
                                    <img class="slider-single-image img-responsive"
                                         src="<?php print thumbnail($item['filename'], 1280, 900, true); ?>" alt=""/>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($cnt > 2): ?>
                        <a class="slider-left" href="javascript:void(0);"><i class="fa fa-angle-left"></i></a>
                        <a class="slider-right" href="javascript:void(0);"><i class="fa fa-angle-right"></i></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>