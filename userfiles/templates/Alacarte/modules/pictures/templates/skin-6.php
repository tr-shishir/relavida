<?php

/*

 

*/

?>

<?php if (is_array($data)): ?>
    <div class="elevatezoom">
        <div class="elevatezoom-holder">
            <span class="helper"></span>
            <?php foreach ($data as $key => $item): ?>
                <?php if ($key == 0): ?>
                    <img id="elevatezoom" class="main-image" src="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>"/>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div id="elevatezoom-gallery" class="js-popup-gallery">
            <?php foreach ($data as $item): ?>
                <a href="<?php print thumbnail($item['filename'], 1920, 1920); ?>" id="elevatezoom" data-image="<?php print thumbnail($item['filename'], 800, 800); ?>" data-zoom-image="<?php print thumbnail($item['filename'], 1920, 1920); ?>" style="background-image: url('<?php print thumbnail
                ($item['filename'], 200, 200); ?>');"></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>