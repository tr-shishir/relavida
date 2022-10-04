<?php

/*

type: layout

name: Three per row

description: Skin-7

*/

?>


<style>
    .gal-main-picture img {
        width: 100%;
        height: 560px;
        object-fit: cover;
    }

    @media screen and (max-width: 1366px) {
        .gal-main-picture img {
            height: 450px;
        }
        
        @media screen and (max-width: 991px) {
        .gal-main-picture img {
            height: auto;
        }
    }
</style>

<?php if (is_array($data)) : ?>
    <?php $rand = uniqid(); ?>
    <div class="gallery-holder-2">
        <div class="row row-mx-10">
            <?php foreach ($data as $count => $item) : ?>
                <div class="col-lg-4 m-b-10 col-px-5">
                    <div class="item pictures gal-main-picture picture-<?php print $item['id']; ?>" onclick="mw.gallery(gallery<?php print $rand; ?>, <?php print $count; ?>);return false;">
                        <img src="<?php print thumbnail($item['filename'], 450, 320, true); ?>" alt="">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        gallery<?php print $rand; ?> = [
            <?php foreach ($data  as $item) : ?> {
                    image: "<?php print thumbnail($item['filename'], 1200); ?>",
                    description: "<?php print $item['title']; ?>"
                },
            <?php endforeach;  ?>
        ];
    </script>
<?php endif; ?>