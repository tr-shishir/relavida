<?php

/*

 

*/

?>

<?php if (is_array($data)): ?>
    <div class="product-gallery js-popup-gallery">
        <?php foreach ($data as $key => $item): ?>
            <a href="<?php print thumbnail($item['filename'], 1920, 1920); ?>" <?php if ($key > 0): ?> class="hidden-xs hidden-sm"<?php endif; ?> image-id="<?php if(isset($item['image_id']) && $item['image_id']){echo $item['image_id'];} ?>">
                <img src="<?php print thumbnail($item['filename'], 800, 800); ?>" alt=""/>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
