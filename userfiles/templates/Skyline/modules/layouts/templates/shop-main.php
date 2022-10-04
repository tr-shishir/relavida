<div class="shop-main shop-main-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                <?php if(!empty(get_content("layout_file=layouts__shop.php&id=".PAGE_ID))) : ?>
                <div class="shop-breadcumb">
                    <div class="shop-breadcumb-header allow-drop">
                        <?php if(CATEGORY_ID){ ?>
                            <h1><?php (isset(get_category_by_id(CATEGORY_ID)['title'])) ? print (get_category_by_id(CATEGORY_ID)['title']) : "" ; ?></h1>
                        <?php } else{ ?>
                            <h1 class="edit" rel="content" field="shop_breadcumb_header">Shop</h1>

                        <?php } ?>
                    </div>
                    <module type="breadcrumb"/>
                </div>
                <?php endif; ?>
                <module type="shop/products" limit="18" description-length="70"/>
            </div>

        </div>
    </div>
</div>