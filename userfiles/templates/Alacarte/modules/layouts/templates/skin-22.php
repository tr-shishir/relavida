<?php

/*

type: layout

name: Product With Sidebar

position: 22

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section <?php print $layout_classes; ?> safe-mode nodrop" field="layout-skin-22-<?php print $params['id'] ?>" rel="module">
<div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "shop_sidebar.php" ?>
            </div>
            <div class="col-md-9">
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
                <module type="shop/products" hide_paging="true" limit="6" col_count="3" />
            </div>
        </div>
    </div>
</section>