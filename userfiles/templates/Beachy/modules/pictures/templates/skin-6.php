<?php

/*


*/

?>

<?php if (is_array($data)): ?>
    <div class="elevatezoom">
        <div class="square">
            <div class="content">
                <div class="elevatezoom-holder">
                    <?php foreach ($data as $key => $item): ?>
                        <?php if ($key == 0): ?>
                            <img id="elevatezoom" class="main-image" src="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>"/>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="elevatezoom-gallery" class="js-popup-gallery">
            <?php foreach ($data as $item): ?>
                <a href="<?php print thumbnail($item['filename'], 1920, 1920); ?>" id="elevatezoom" data-image="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>" style="background-image: url('<?php print thumbnail
                ($item['filename'], 200, 200); ?>');" image-id="<?php if(isset($item['image_id']) && $item['image_id']){echo $item['image_id'];} ?>"></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>