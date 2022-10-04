<?php

/*

 

*/

?>


<?php if (is_array($data)): ?>
    <?php $rand = uniqid(); ?>

    <?php foreach ($data as $count => $item): ?>
        <?php if ($count == 0): ?>
            <div class="heading-image" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;" style="background-image: url('<?php print thumbnail($item['filename'], 1920, 800, true); ?>');"></div>
        <?php endif; ?>
    <?php endforeach; ?>
    <script>
        gallery<?php print $rand; ?> = [
                <?php foreach($data  as $item): ?>{image: "<?php print (thumbnail($item['filename'], 1920)); ?>", description: "<?php print $item['title']; ?>"},
            <?php endforeach;  ?>
        ];
    </script>
<?php endif; ?>