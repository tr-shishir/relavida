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
<style>
    .module-breadcrumb {
    position: relative;
}


.shop-inner-page .module-breadcrumb nav ol.breadcrumb {
    position: relative;
    z-index: 9;
}
.breadcrumb-bg-div {
    position: absolute;
    height: 100%;
    width: 100%;
}

.breadcumb-for-shop-inner {
    position: relative;
}

.breadcumb-for-shop-inner nav {
    background-image: none !important;
}
.breadcumb-for-shop-inner .module-breadcrumb {
    max-width: 1140px;
    margin: 0px auto;
}
.breadcrumb-bg-div img.shop_inner_bg {
    height: 100% !important;
    width: 100%;
    object-fit: cover;
}
</style>
<div class="edit shop-main-wrapper" rel="content" field="marcando_shop_content">

    <div class="breadcumb-for-shop-inner">
        <div class="breadcrumb-bg-div edit" rel="module" field="shop_page_breadcumb_img">
            <img src="<?php print template_url(); ?>assets/image/shop-breadcrumb.jpg" alt="" class="shop_inner_bg" >
        </div>
        <module type="layouts" template="shop-breadcumb"/>
    </div>
    <module type="layouts" template="shop-main-layout"/>
</div>

<?php include template_dir() . "footer.php"; ?>
