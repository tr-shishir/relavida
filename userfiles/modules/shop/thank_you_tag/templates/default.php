<?php

/*

type: layout

name: Thank YouTag

description: Default

*/
?>
<style>
.thank-you-tag .thank-you-col .product{
    box-shadow: 0px 0px 8px -5px rgba(0,0,0,0.75);
    transition: .5s ease;
}

.thank-you-tag .thank-you-col .product:hover {
    box-shadow: 0px 0px 12px -2px rgba(0,0,0,0.75);
}
.thank-you-tag .description {
    margin-top: 20px;
    padding-left: 10px;
    padding-bottom: 10px;
}
.thank-you-tag .image{
    border:0 !important;
}
.thank-you-tag .description h2 {
    color: #000;
    min-height: 75px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.thank-you-tag .price {
    text-align: left !important;
    margin-bottom: 10px;
}

.thank-you-tag .thank-you-tag-cartbtn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff !important;
}

.thank-you-tag .thank-you-tag-cartbtn span {
    margin-right: 5px;
}

.direct-checkout-message .modal-dialog{
    margin-top:100px !important;
}
</style>
<?php

use Illuminate\Support\Facades\DB;

$tn = $tn_size;
if (!isset($tn[0]) or ($tn[0]) == 150) {
    $tn[0] = 350;
}
if (!isset($tn[1])) {
    $tn[1] = $tn[0];
}


?>

<?php if (!empty($data)): ?>
    <div class="row">
        <div class="col-md-12 edit" field="thank_you_tag_page_header" rel="content">
            <h1 style="text-align:center; margin-bottom:15px">Product recommendation based on tags</h1>
        </div>
    </div>
    <div class="shop-products row thank-you-tag">
    <?php
            $last_order_information = DB::table('cart_orders')->where('order_completed',1)->get('id')->last();
            if(isset($last_order_information)){
                $last_ordered_all_product = DB::table('cart')->where('order_id', $last_order_information->id)->get('rel_id');
            }
            $all_tags = array();
            $all_products_id = array();
            if($last_ordered_all_product){
                foreach($last_ordered_all_product as $last_ordered_product){
                    $product_tags = content_tags($last_ordered_product->rel_id, false);
                    if($product_tags){
                        $all_products_id[] = $last_ordered_product->rel_id;
                        foreach($product_tags as $product_tag){
                            if(!in_array($product_tag, $all_tags )){
                                $all_tags[] = $product_tag;
                            }
                        }
                    }
                }
            }
            // $thank_you_tag_page_id = DB::table('content')->where([
            //     ['layout_file', '=', 'layouts__thank_you.php'],
            //     ['is_active', '=', '1'],
            //     ['is_deleted', '=', '0'],
            //     ['url', '<>', 'thank-you'],
            // ])->get()->last();
            // dump($thank_you_tag_page_id);
            // if($thank_you_tag_page_id){
            // }
            $thank_you_page_tag =  content_tags(PAGE_ID, false);
            if($thank_you_page_tag){
                $all_tags = array_intersect($thank_you_page_tag, $all_tags);
            }else{
                $all_tags = null;
            }
            // dd($all_tags);

            $data = collect($data)->whereNotNull('tags')->filter(function ($item) use ($all_tags){
                $tags = $item['tags'];
                if(empty($tags)) return false;
                return collect($tags)->whereIn('name', $all_tags)->isNotEmpty();
            })->toArray();
        ?>
        <?php foreach ($data as $item): ?>
            <?php if(isset($last_ordered_all_product) && !in_array($item['id'], $all_products_id)): ?>
                <?php

                    $categories = content_categories($item['id']);
                    $in_stock = true;

                    if (isset($content_data['qty']) and $content_data['qty'] != 'nolimit' and intval($content_data['qty']) == 0) {
                        $in_stock = false;
                    }

                ?>


                <?php
                $itemCats = '';
                if ($categories) {
                    foreach ($categories as $category) {
                        $itemCats .= $category['title'] . ', ';
                    }
                }
                ?>

                <div class="thank-you-col col-md-3 item-<?php print $item['id'] ?>" data-masonry-filter="<?php print $itemCats; ?>" itemscope
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
                                            $title1 = $item['title'];
                                            $price1 = $val1;
                                            ?>
                                            <span><?php print currency_format(roundPrice($val1)); ?></span>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                               <div class="thank-you-cartButton" >
                                    <?php if (!isset($in_stock) or $in_stock == false) :?>
                                        <a class="btn btn-primary thank-you-tag-cartbtn cart-disable" onclick="mw.cart.add('.shop-products .item-<?php print $item['id'] ?>');"><span class="material-icons">shopping_basket</span>JETZT KAUFEN</a>
                                    <?php else: ?>
                                        <a class="btn btn-primary thank-you-tag-cartbtn" onclick="mw.cart.add('.shop-products .item-<?php print $item['id'] ?>');"><span class="material-icons">shopping_basket</span>JETZT KAUFEN</a>
                                    <?php endif; ?>
                               </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>

    mw.on('mw.cart.add', function (event, data) {

        var selector = sessionStorage.getItem('selector');
        selector = JSON.parse(selector);

        var callback = sessionStorage.getItem('callback');
        callback = JSON.parse(callback);

        var obj = sessionStorage.getItem('obj');
        obj = JSON.parse(obj);

        var form = sessionStorage.getItem('form');
        form = JSON.parse(form);
        $( document ).trigger( "checkoutBeforeProcess", form );



        setTimeout(function(){
            $.ajax({
                type: "POST",
                url: mw.settings.api_url + 'checkout',
                data: obj
            })
                .done(function (data) {

                    if(data.success) {
                        var html = data.success;
                        $('#payment_mathode').append('<div>' + html + '</div>');
                    }else if(data.error){
                        var html = data.error;
                        $('#payment_mathode').append('<div>' + html + '</div>');
                    }

                    if (typeof(data.redirect) != 'undefined') {

                        setTimeout(function () {
                            window.location.href = data.redirect;
                        }, 10)

                    }else{
                        $('.direct-checkout-message').show();
                        // window.location.href = "<?=url('/')?>";
                    }

                    console.log(data.success)
                    return true

                    html+= data.toString();
                    var data = sessionStorage.getItem('data');
                    data = JSON.parse(data);

                    mw.trigger('checkoutDone', data);
                    console.log(selector,callback,obj,form)

                    var data2 = data;



                    if (data != undefined) {
                        mw.$(selector + ' .mw-cart-data-btn').removeAttr('disabled');
                        mw.$('[data-type="shop/cart"]').removeAttr('hide-cart');


                        if (typeof(data2.error) != 'undefined') {
                            mw.$(selector + ' .mw-cart-data-holder').show();
                            if (typeof(data2.error.address_error) != 'undefined') {
                                var form_with_err = form;
                                var isModalForm = $(form_with_err).attr('is-modal-form')

                                if(isModalForm){
                                    mw.cart.modal.showStep(form_with_err, 'delivery-address');
                                }
                                mw.notification.error('Please fill your address details');

                            }

                            mw.response(selector, data2);
                        } else if (typeof(data2.success) != 'undefined') {


                            if (typeof callback === 'function') {
                                callback.call(data2.success);

                            } else if (typeof window[callback] === 'function') {
                                window[callback](selector, data2.success);
                            } else {

                                mw.$('[data-type="shop/cart"]').attr('hide-cart', 'completed');
                                mw.reload_module('shop/cart');
                                mw.$(selector + ' .mw-cart-data-holder').hide();
                                mw.response(selector, data2);
                            }


                            mw.trigger('mw.cart.checkout.success', data2);


                            if (typeof(data2.redirect) != 'undefined') {
                                // console.log(data2);
                                setTimeout(function () {
                                   window.location.href = data2.redirect;
                                }, 10)

                            }


                        } else if (parseInt(data) > 0) {
                            mw.$('[data-type="shop/checkout"]').attr('view', 'completed');
                            mw.reload_module('shop/checkout');
                        } else {
                            if (obj.payment_gw != undefined) {
                                var callback_func = obj.payment_gw + '_checkout';
                                if (typeof window[callback_func] === 'function') {
                                    window[callback_func](data, selector);
                                }
                                var callback_func = 'checkout_callback';
                                if (typeof window[callback_func] === 'function') {
                                    window[callback_func](data, selector);
                                }
                            }
                        }

                    }
                    mw.trigger('mw.cart.checkout', [data]);
                });

        }, 1500);
    })


    function closethismodal(){
        $('.direct-checkout-message').hide();
    }
</script>


<div class="modal direct-checkout-message" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body">
            <p>This product has been ordered successfully</p>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closethismodal()" class="btn btn-primary" data-dismiss="modal">Stay Here</button>
            <a type="button" href="<?=url('/')?>" class="btn btn-secondary" >Go To Home</a>
        </div>
    </div>
  </div>
</div>