<div class="container">
    <div class="row">
        <div class="col-md-12">
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
            <module type="shop/products"/>
        </div>
    </div>
</div>