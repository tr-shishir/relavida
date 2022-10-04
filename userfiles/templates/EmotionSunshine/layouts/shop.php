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
<section class="shop-wrapper">
   <div class="row">
        <div class="col-md-12">
            <div class="shop-product-all-top">
                <div class="shop-all-top-text" field="shop_page_heading" rel="content">
                    <h4>Alle Produkte</h4>
                </div>
                <div class="shop-divider"></div>
            </div>
        </div>
    </div>
    <div class="edit shop-main-page-product" rel="content" field="emotion_shop_main_content">
        <module type="layouts" template="skin-25"/>
    </div>
</section>


<?php include template_dir() . "footer.php"; ?>
