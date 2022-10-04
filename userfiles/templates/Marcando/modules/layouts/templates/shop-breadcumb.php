<div class="page-breadcumb-container shop-breadcumb">
    <div class="container">
        <div class="page-breadcumb-container-content">
            <?php if(!empty(get_content("layout_file=layouts__shop.php&id=".PAGE_ID))) : ?>
                <div class="shop-breadcumb-header">
                    <?php if(CATEGORY_ID){ ?>
                        <h1><?php (isset(get_category_by_id(CATEGORY_ID)['title'])) ? print (get_category_by_id(CATEGORY_ID)['title']) : "" ; ?></h1>
                    <?php } else{ ?>
                        <h1 class="edit" rel="content" field="shop_breadcumb_header">Shop</h1>

                    <?php } ?>
                </div>
                <module type="breadcrumb"/>
            <?php endif; ?>
        </div>
    </div>
</div>