<div class="container safe-mode nodrop">
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="row justify-content-between">

                    <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
                    </div>

                <div class="col-sm-12 col-md-8 col-lg-9 col-xl-9">
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
                    <module type="shop/products" />
                </div>
            </div>
        </div>
    </div>
</div>