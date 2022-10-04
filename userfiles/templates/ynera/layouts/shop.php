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

<div class="edit shop-main-wrapper" rel="content" field="marcando_content">
    <module type="layouts" template="shop-breadcumb"/>
    <module type="layouts" template="shop-main-layout"/>
</div>

<?php include template_dir() . "footer.php"; ?>
