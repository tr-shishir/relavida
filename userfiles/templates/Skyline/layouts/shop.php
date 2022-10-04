<?php

/*

type: layout
content_type: dynamic
name: Shop
is_shop: y
description: shop layout
position: 4
*/


?>
<?php include template_dir() . "header.php"; ?>
<div class="allow-drop" rel="content" field="snow_content">
    <div class="edit" rel="content" field="snow_shop_main_content">
        <module type="layouts" template="shop-main"/>
    </div>
</div>

<?php include template_dir() . "footer.php"; ?>
