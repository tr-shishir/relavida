<?php

/*

type: layout

name: Thank You- 3

description: Default

*/
?>
<?php

use Illuminate\Support\Facades\DB;

$tn = $tn_size;
if (!isset($tn[0]) or ($tn[0]) == 150) {
    $tn[0] = 350;
}
if (!isset($tn[1])) {
    $tn[1] = $tn[0];
}
$activeThemeQuantity = DB::table("thank_you_pages")->where('is_active',1)->orderBy('template_name','asc')->get();

?>
<?php if (!empty($data)): ?>
    <div class="edit" field="thank_you_page_top_three" rel="content">
    <module type="text"/>

</div>
    <div class="shop-products related-products thank-you-row">
        <?php foreach ($data as $item):  ?>
           <?php
           $temp = DB::table("thank_you_pages")->where('template_name','3')->where('product_id',$item['id'])->get();
           ?>
            <?php if($temp->count()): ?>
                <?php $categories = content_categories($item['id']); ?>

                <?php
                $itemCats = '';
                if ($categories) {
                    foreach ($categories as $category) {
                        $itemCats .= $category['title'] . ', ';
                    }
                }
                ?>

                <div class="thank-you-col item-<?php print $item['id'] ?>" data-masonry-filter="<?php print $itemCats; ?>" itemscope
                    itemtype="<?php print $schema_org_item_type_tag ?>">
                    <div class="product related-product product-style">
                        <?php if (is_array($item['prices'])): ?>
                            <?php foreach ($item['prices'] as $k => $v): ?>
                                <input type="hidden" name="price" value="<?php print $v ?>"/>
                                <input type="hidden" name="content_id" value="<?php print $item['id'] ?>"/>
                                <?php break; endforeach; ?>
                        <?php endif; ?>
                        <!-- <div class="product-label sale">Verkauf</div> -->

                        <?php
                        $checkout_session = 'test';
                        ?>

                        <?php if ($show_fields == false or in_array('thumbnail', $show_fields)): ?>
                            <div class="image">
                                <img src="<?php print thumbnail($item['image'],400 ,400); ?>" alt="">
                            </div>
                        <?php endif; ?>
                        <a href="<?php print $item['link'] ?>">
                            <div class="description">
                                <?php if ($show_fields == false or in_array('title', $show_fields)): ?>
                                    <h2><?php print $item['title'] ?></h2>
                                <?php endif; ?>

                                <?php if ($show_fields == false or in_array('price', $show_fields)): ?>
                                    <div class="price">
                                        <?php if (isset($item['prices']) and is_array($item['prices'])) { ?>
                                            <?php
                                            $vals2 = array_values($item['prices']);
                                            $val1 = array_shift($vals2);
                                            $taxam = 0; $tax= mw()->tax_manager->get();
                                            !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                                            $val1 = $val1 + ($taxam*$val1)/100;
                                            $title3 = $item['title'];
                                            $price3 = $val1;
                                            ?>
                                            <span><?php print currency_format(roundPrice($val1)); ?></span>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                               <div class="thank-you-cartButton">

                                    <?php if($GLOBALS['3'] == $activeThemeQuantity->count()): ?>
                                        <a data-toggle="modal" data-target="#thankYou-redirect" class="btn btn-primary thank-you-cartbtn" onclick="mw.cart.add('.shop-products .item-<?php print $item['id'] ?>'); theme3(); totalPrice();"><span class="material-icons">shopping_basket</span>
                                        JETZT KAUFEN
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn-primary thank-you-cartbtn" onclick="mw.cart.add('.shop-products .item-<?php print $item['id'] ?>');  theme3()"><span class="material-icons">shopping_basket</span>
                                        JETZT KAUFEN
                                        </a>
                                    <?php endif; ?>
                               </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
    <div class="edit" field="thank_you_page_bottom_three" rel="content">
    <module type="text"/>

    </div>
<?php endif; ?>

<script>

function theme3(){



        var old_products = localStorage.getItem('products');
        var item={name: '<?php print  $title3 ?>', price: '<?php print  $price3 ?>', sprice: '<?php print  currency_format($price3) ?>'};
        if (old_products === null) {
            var products = [];
            products.push(item)
            localStorage.setItem('products', JSON.stringify(products));
        } else {
            old_products = JSON.parse(old_products);
            old_products.push(item);
            localStorage.setItem('products',JSON.stringify(old_products));
        }
    }
</script>
