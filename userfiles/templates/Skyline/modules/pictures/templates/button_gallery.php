<?php
/*
  
 */
?>

<?php if (is_array($data)): ?>
    <?php $rand = uniqid(); ?>

    <div class="mw-module-images<?php if ($no_img) { ?> no-image<?php } ?>">
        <div class="mw-pictures-clean" id="mw-gallery-<?php print $rand; ?>">
            <?php $count = -1;
            foreach ($data as $item): ?>
                <?php $count++; ?>
                <?php if ($count == 1): ?>
                    <a href="<?php print ($item['filename']); ?>" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;" class="btn btn-default ">View photos</a>
                <?php endif; ?>
    <?php endforeach; ?>
            <script>gallery<?php print $rand; ?> = [
    <?php foreach ($data as $item): ?>{image: "<?php print ($item['filename']); ?>", description: "<?php print $item['title']; ?>"},
    <?php endforeach; ?>
                ];</script>
        </div>
    </div>
<?php else : ?>
<?php endif; ?>