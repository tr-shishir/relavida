<?php

/*

type: layout

name: Cart Bumbs
description: Default

*/
?>


<?php
   use Illuminate\Support\Facades\DB;
?>


<div class="cart-bumbs" id="shop-content-<?php print CONTENT_ID; ?>">
    <div class="cart_bumbs-text edit" field="cart_bumbs_editableText" rel="content">
        <module type="text"/>
    </div>
    <?php
     if (!empty($data)):

        $temp = DB::table("checkout_bumbs")->select('product_id')->first();
        $data = collect($data)->where('id',$temp->product_id);
     ?>
        <div class="shop-products">
            <?php foreach ($data as $item):  ?>
            <?php


            ?>
                <?php if($temp): ?>
                    <?php $categories = content_categories($item['id']); ?>

                    <?php
                    $itemCats = '';
                    if ($categories) {
                        foreach ($categories as $category) {
                            $itemCats .= $category['title'] . ', ';
                        }
                    }
                    ?>

                    <div class="product cart-bumbs-product item-<?php print $item['id'] ?>">
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
                        <div class="cart-bumbs-product-photo">
                            <?php if ($show_fields == false or in_array('thumbnail', $show_fields)): ?>
                                <div class="image">
                                    <img src="<?php print thumbnail($item['image']); ?>" alt="">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="cart-bumbs-product-description">
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
                                                $val1 = $val1 + taxPrice($val1,null,$item['id']);
                                                $title1 = $item['title'];
                                                $price1 = $val1;
                                                ?>
                                                <span><?php print currency_format(roundPrice($val1)); ?></span>
                                            <?php } ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="cart-bumbs-cartButton" >
                                            <a href="#" class="btn btn-primary thank-you-cartbtn" onclick="mw.cart.add('.shop-products .item-<?php print $item['id'] ?>');">
                                                in den Warenkorb
                                            </a>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


<script>
    mw.on('mw.cart.add', function (event, data) {

    })

</script>
