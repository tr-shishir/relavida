<?php

/*

type: layout
content_type: dynamic
name: Shop
is_shop: y
description: Showcase shop items in a sylish grid arrangement.
position: 4
*/


?>
<?php include template_dir() . "header.php"; ?>

<div class="edit shop-main-page" rel="content" field="active_content">
    <module type="layouts" template="skin-19"/>
    <module type="layouts" template="skin-13"/>
    <div class="edit" rel="content" field="shop_main_content">
        <module type="layouts" template="skin-20"/>
    </div>
    <module type="layouts" template="skin-34"/>
</div>

<?php include template_dir() . "footer.php"; ?>
