<?php

/*

 

*/

?>

<?php if (is_array($data)): ?>
    <div class="project-gallery js-popup-gallery">
        <?php foreach ($data as $item): ?>
            <a href="<?php print thumbnail($item['filename'], 1920, 1920); ?>"><img src="<?php print thumbnail($item['filename'], 800, 800); ?>" alt=""/></a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>