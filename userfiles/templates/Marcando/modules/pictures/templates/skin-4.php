<?php

/*

type: layout

name: Skin-4

description: Skin-4

*/

?>
    <style>
        <?php print '#'.$params['id']; ?>
        .gallery-holder .col-holder {
            padding-right: 10px;
            padding-left: 10px;
        }

        <?php print '#'.$params['id']; ?>
        .gallery-holder .row {
            margin-right: -10px;
            margin-left: -10px;
        }

        <?php print '#'.$params['id']; ?>
        .gallery-holder .item {
            margin-bottom: 20px;
        }

        <?php print '#'.$params['id']; ?>
        .gallery-holder .right-side .item {
            max-width: calc(50% - 20px);
            float: left;
        }

        <?php print '#'.$params['id']; ?>
        .gallery-holder .right-side .item:nth-child(2),
        <?php print '#'.$params['id']; ?> .gallery-holder .right-side .item:nth-child(4) {
            margin-left: 20px;
        }

        @media screen and (max-width: 575px) {
        <?php print '#'.$params['id']; ?>
            .gallery-holder .right-side .item {
                max-width: calc(50% - 10px);
            }
        }
    </style>
<?php if (is_array($data)): ?>
    <?php $rand = uniqid(); ?>
    <div class="gallery-holder">
        <div class="row">
            <div class="col-holder col-sm-6">
                <?php foreach ($data as $count => $item): ?>
                    <?php if ($count == 0): ?>
                        <div class="item pictures picture-<?php print $item['id']; ?>" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;">
                            <img src="<?php print thumbnail($item['filename'], 1400, 1400, true); ?>" alt="">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="col-holder col-sm-6 right-side">
                <?php foreach ($data as $count => $item): ?>
                    <?php if ($count == 1 OR $count == 2 OR $count == 3 OR $count == 4): ?>
                        <div class="item pictures picture-<?php print $item['id']; ?>" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;">
                            <img src="<?php print thumbnail($item['filename'], 695, 700, true); ?>" alt="">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script>
        gallery<?php print $rand; ?> = [
                <?php foreach($data  as $item): ?>{image: "<?php print thumbnail($item['filename'], 1200); ?>", description: "<?php print $item['title']; ?>"},
            <?php endforeach;  ?>
        ];
    </script>
<?php endif; ?>