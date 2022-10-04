<?php

/*

type: layout
content_type: dynamic
name: Shop
is_shop: y
description: Showcase shop items in a sylish grid arrangement.
position: 2
*/

?>

<?php include template_dir() . "header.php"; ?>

<div class="x-edit shop-main-page" rel="content" field="new-world_content">
    <module type="layouts" template="skin-9"/>
    <div class="edit shop-main-page-product" rel="content" field="shop_main_content">
        <module type="layouts" template="skin-11"/>
    </div>
</div>

<?php include template_dir() . "footer.php"; ?>
