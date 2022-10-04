<link rel="stylesheet" href="<?php print modules_url(); ?>tiny-slider.css">
<script src="<?php print modules_url(); ?>tiny-slider.js"></script>

<style>
    .product-bundle-slider {
        position: relative;
        overflow: hidden;
    }

    .product-bundle-slider.pb-not-slider .single-bundle {
        margin: 10px;
        flex: 1;
    }

    .single-bundle {
        position: relative;
        border: 1px solid #ebebeb;
        display: inline-block;

        border-radius: 5px;
        overflow: hidden;
    }

    .single-bundle .sb-box {
        padding: 15px;
    }

    .single-bundle.tns-item .sb-box {
        border: 1px solid #ebebeb;
        border-radius: 5px;
        overflow: hidden;
    }

    .single-bundle.tns-item {
        border: none;
    }

    .single-bundle .sb-img {
        position: relative;
        border: 1px solid #ededed;
        border-radius: 5px;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
    }

    .single-bundle .sb-img input[type="checkbox"] {
        position: absolute;
        bottom: 4px;
        left: 4px;
        z-index: 9;
        cursor: pointer;
        height: 20px;
        width: 20px;
    }

    .single-bundle .sb-text {
        position: relative;
    }

    .single-bundle .sb-text h4,
    .single-bundle .sb-text h4 a {
        font-size: 18px;
        line-height: 22px;
        display: block;
        margin: 10px auto;
        color: #000;
    }

    .single-bundle .sb-text ul {
        position: relative;
        padding: 0;
        list-style-type: none;
    }

    .single-bundle .sb-text ul li {
        color: #585858;
        font-size: 14px;
        line-height: 18px;
    }

    .sb-price {
        position: relative;
    }

    .sb-price span {
        display: inline-block;
        position: relative;
        font-size: 24px;
        margin: 5px auto;
        color: #000;
    }

    .sb-price p {
        color: #000;
        font-size: 16px;
        position: relative;
        line-height: 22px;
    }

    .product-bundle-area .tns-nav {
        display: none;
    }

    .product-bundle-area {
        position: relative;
        padding-bottom: 50px;
    }

    .product-bundle-area .tns-controls {
        position: absolute;
        bottom: -40px;
        width: 100%;
        text-align: center;
    }

    .product-bundle-total {
        position: relative;
        min-height: 390px;
        background-color: #f5f5f5;
        border-radius: 5px;
        text-align: center;
        height: 100%;
    }

    .product-bundle-total .pbt-box {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        width: 100%;
    }

    .product-bundle-total .pbt-box h4 {
        font-weight: 600;
        font-size: 18px;
        margin: 5px 0;
    }

    .product-bundle-total .pbt-box button {
        width: auto;
    }

    .single-bundle .sb-img img {
        object-fit: contain;
        height: 100%;
        width: 100%;
    }

    .single-bundle .sb-text h4 {
        min-height: 45px;
        word-break: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .bundel-product-modal .modal-dialog {
        margin-top: 50px;
        max-width: 80% !important;
    }

    .bundel-product-modal .modal-header {
        background: #037bff;
        color: #fff;
        text-align: center;
    }

    .bundel-product-modal .modal-content {
        border-color: transparent !important;
    }

    .bundel-modal-product {
        height: 500px;
        overflow-y: scroll;
    }

    .bundel-modal-product::-webkit-scrollbar {
        width: 2px;
    }

    .bundel-modal-product::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .bundel-modal-product::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid slategrey;
    }

    .bundel-product-modal .single-bundle .sb-img {
        height: 150px;
    }

    .bundel-product-modal .single-bundle {
        width: 80%;
        margin-bottom: 20px;
    }

    .bundle-product-slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: 1px solid #ccc;
        padding: 5px 10px;
        font-size: 16px;
        z-index: 99;
    }

    .bundle-product-slider-arrow.prev-btn {
        left: -16px;
    }

    .bundle-product-slider-arrow.next-btn {
        right: -14px;
    }

    .single-bundle.unchecked-item {
        opacity: .4;
    }

    .product-bundle-slider>a {
        display: block;
    }

    .product-bundle-slider.pb-not-slider {
        display: flex;
    }

    .price-linethrough {
        text-decoration: line-through;
        color: red !important;
    }

    .price-final {
        color: green;
    }

    .total-offer-hide,
    .total-discount-hide {
        display: none;
    }

    .total-price-not-line-through span {
        text-decoration: none;
        color: #000;
    }

    .bundle-product-tax span {
        font-size: inherit;
        text-decoration: underline;
        cursor: pointer;
    }

    .bundle-product-title{
        text-decoration: none;
        color: #000;
    }

    .bundle-product-title:hover{
        text-decoration: none;
        color: #0069d9;
    }

    @media screen and (max-width: 1200px) {
        .product-bundle-total {
            margin-top: 50px;
            height: auto;
        }
    }

    @media (max-width: 1024px) {
        .product-bundle-slider.pb-not-slider .single-bundle {
            width: 30%;
        }

        .product-bundle-slider.pb-not-slider{
            flex-wrap:wrap;
        }
        .bundle-product-slider-arrow.next-btn {
            right: 0;
            background-color: #fff;
        }

        .bundle-product-slider-arrow.prev-btn {
            left: 0;
            background-color: #fff;
        }
    }

    @media (max-width: 768px) {
        .product-bundle-slider.pb-not-slider .single-bundle {
            width: 45%;
        }

    }

    @media (max-width: 525px) {
        .product-bundle-slider.pb-not-slider .single-bundle {
            width: 100%;
        }

        .product-bundle-slider.pb-not-slider{
            flex-wrap:unset;
            flex-direction:column;
        }

    }
</style>

<?php

use App\Models\Bundle_product;

$bundle_id = get_option('bundle_id', $params['id']);
$bundle = DB::table('bundles')->where('id', $bundle_id)->first();
$symbol = mw()->shop_manager->currency_symbol();
$is_admin = is_admin() ?? 0;
$status = $status1 = $status2 = true;
?>

<div class="main-<?php print $params['id'] ?>" field="<?php print $params['id'] ?>" rel="module">
    <?php if ($bundle_id) :
        if ($bundle) :
            $products = Bundle_product::where('bundle_id', $bundle_id)
                ->whereHas('content', function ($query) {
                    $query->where('content_type', 'product')->where('is_deleted', 0)->where('is_active', 1);
                })
                ->with('content', 'media', 'contentData')->get();
        if($bundle->bundle_option == 0){
            foreach($products as $item_product){
                if (isset($item_product->contentData->where('field_name', 'qty')->first()->field_value) and $item_product->contentData->where('field_name', 'qty')->first()->field_value != 'nolimit' and intval($item_product->contentData->where('field_name', 'qty')->first()->field_value) == 0) {
                    $status = false;
                    break;
                }
                $status1 = category_is_hide_for_bundle($item_product->product_id);
                if(!$status1) break;
                if (isset($item_product->contentData->where('field_name', 'qty')->first()->field_value) and $item_product->contentData->where('field_name', 'qty')->first()->field_value != 'nolimit' and intval($item_product->contentData->where('field_name', 'qty')->first()->field_value) < $item_product->minimum_p) {
                    $status2 = false;
                    break;
                }
            }
        }
        if($status and $status1 and $status2):
    ?>
            <div class="product-bundle-area">
                <div class="container">
                    <div class="edit" field="bundle_<?php print $bundle_id ?>" rel="module">
                        <h3 style="text-transform:uppercase;margin-bottom:20px;"><?= $bundle->title; ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="product-bundle-slider <?= 'product-bundle-slider-' . $params['id'] ?>">
                                <?php
                                if ($products) : ?>
                                    <?php
                                    $taxrate = (is_logged()) ? (int)taxRateCountry(user_id()) : taxRate();
                                    foreach ($products as $product) :
                                        if(!$product->content){ continue; }
                                        if (isset($product->contentData->where('field_name', 'qty')->first()->field_value) and $product->contentData->where('field_name', 'qty')->first()->field_value != 'nolimit' and intval($product->contentData->where('field_name', 'qty')->first()->field_value) == 0) {
                                            continue;
                                        }
                                        if(!category_is_hide_for_bundle($product->product_id)) continue;
                                        if (isset($product->contentData->where('field_name', 'qty')->first()->field_value) and $product->contentData->where('field_name', 'qty')->first()->field_value != 'nolimit' and intval($product->contentData->where('field_name', 'qty')->first()->field_value) < $product->minimum_p) {
                                            continue;
                                        }
                                        $all_prices = get_product_prices($product->product_id, true);
                                        $price = $all_prices[0]['value_plain'] + taxPrice($all_prices[0]['value_plain'], null, $product->product_id);
                                        $total_price = $price * $product->product_qty; ?>

                                        <div class="single-bundle single-bundle-<?=$bundle_id?> <?= 'single-bundle-' . $params['id'] ?>">
                                            <div class="sb-box">
                                                <div class="sb-img">
                                                    <img src="<?= $product->media[0]->filename; ?>" alt="">
                                                    <input class="" type="checkbox" name="<?= 'b_pro_' .$bundle_id. $params['id'] ?>" value="<?= $total_price; ?>" id="" checked>
                                                    <input type="hidden" id="product_id" class="b_p_ids" name="product_id" value="<?= $product->product_id; ?>">
                                                    <input type="hidden" class="b_p_qty_ids" name="product_qty" value="<?= $product->product_qty; ?>">
                                                </div>
                                                <div class="sb-text">
                                                    <a class="bundle-product-title" href="{SITE_URL}<?= $product->content->url ?>"><h4><?= $product->content->title; ?></h4></a>
                                                    <ul>
                                                        <li><?php _e('Offer quantity'); ?>: <?= $product->product_qty; ?></li>
                                                        <span style="color:red;">
                                                            <?php
                                                            $in_stock = true;
                                                            if (isset($product->contentData->where('field_name', 'qty')->first()->field_value) and $product->contentData->where('field_name', 'qty')->first()->field_value != 'nolimit' and intval($product->contentData->where('field_name', 'qty')->first()->field_value) == 0) {
                                                                print "Out of stock";
                                                            }
                                                            ?>
                                                        </span>
                                                        <!-- <li><?php // _e('Unit price'); ?>: <?php // $price ?></li> -->
                                                    </ul>

                                                    <div class="sb-price">
                                                        <span><?= currency_format(roundPrice($total_price)); ?></span>
                                                        <p class="bundle-product-tax">inkl. <?= taxRate($product->product_id) ?? $taxrate; ?>% MwSt. <span data-toggle="modal" data-target="#termModal">zzgl. Versand</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button class="bundle-product-slider-arrow prev-btn" id="prev-<?=$params['id'] ?>"><i class='fa fa-angle-left'></i></button>
                            <button class="bundle-product-slider-arrow next-btn" id="next-<?=$params['id'] ?>"><i class='fa fa-angle-right'></i></button>
                        </div>
                        <div class="col-xl-3">
                            <div class="product-bundle-total total-<?php print $params['id']; ?>">
                                <div class="pbt-box">
                                    <p><?php _e('Calculation details'); ?></p>
                                    <div id="bundle-total-discount-<?php print $params['id']; ?>">
                                        <h6 style="font-size:24px;"><b><?php _e('Discount'); ?>: </b>
                                            <span style="color:green;font-weight:700;display:inline-block;">
                                                <?php print $bundle->discount;
                                                if ($bundle->discount_type == "percentage") {
                                                    print ' %';
                                                } else {
                                                    print ' ' . $symbol;
                                                } ?>
                                            </span>
                                        </h6>
                                    </div>
                                    <div id="bundle-total-price-<?php print $params['id']; ?>">
                                        <h4><?php _e('Price'); ?>: <span class="price-linethrough" id="<?= 'total_' . $params['id'] ?>"></span> <span class="price-linethrough"><?= $symbol; ?></span> </h4>
                                    </div>
                                    <div id="bundle-offer-price-<?php print $params['id']; ?>">
                                        <h4><?php _e('Offer Price'); ?>: <span class="price-final" id="<?= 'discount_' . $params['id'] ?>"></span> <span class="price-final"><?= $symbol; ?></span> </h4>
                                    </div>
                                    <button class="btn btn-primary product-cart-icon" id="<?= 'update_cart_' . $params['id'] ?>"><?php _e('BUY TOGETHER'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <?php if ($is_admin) : ?>
                    <?php if(!$status): ?>
                        <div id="one-product-alert" class="alert alert-danger" role="alert">
                            <p class="text-center" style="font-size: 14px;"><?php _e('Bundle will not be visible here because one of the products of this bundle is out of stock'); ?>.</p>
                        </div>
                    <?php elseif(!$status1): ?>
                        <div id="one-product-alert" class="alert alert-danger" role="alert">
                            <p class="text-center" style="font-size: 14px;"><?php _e('This Bundle will not be visible here because one of the products category is hidden'); ?>.</p>
                        </div>
                    <?php elseif(!$status2): ?>
                        <div id="one-product-alert" class="alert alert-danger" role="alert">
                            <p class="text-center" style="font-size: 14px;"><?php _e('The bundle is not visible to the shop visitors at the moment, because the stock level of one or more of the bundle’s products is currently lower than your specified minimum order quantity. It will automatically become visible as soon as the stock is sufficient again'); ?>.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; endif;?>
        <?php else : ?>
            <?php if ($is_admin) : ?>
                <div id="one-product-alert" class="alert alert-danger" role="alert">
                    <p class="text-center"><?php _e('Please add a bundle from edit option'); ?>!</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php else : ?>
        <?php if ($is_admin) : ?>
            <div id="one-product-alert" class="alert alert-danger" role="alert">
                <p class="text-center"><?php _e('Please add a bundle from edit option'); ?>!</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    <?php if ($bundle_id) :
        if ($bundle) : ?>
            $(document).ready(function() {
                var total_price = 0.0;
                var bundle_in_cart = "<?php (isset(mw()->user_manager->session_get("bundle_product_checkout")[0])) ? print 1 : print 2 ; ?>";
                var discount_price = 0.0;
                var discount_type = '<?= $bundle->discount_type; ?>';
                var bundle_option = '<?= $bundle->bundle_option; ?>';
                var bundle_setting_option = '<?= get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0; ?>';
                var number_of_unchecked_item = 0;
                var discount_apply = 1;
                var product_id = [];
                var product_qty = [];
                $("input:checkbox[name=<?= 'b_pro_' .$bundle_id. $params['id'] ?>]:checked").each(function() {
                    total_price += parseFloat($(this).val());
                    $(this).parents('.single-bundle-<?=$bundle_id?>').removeClass('unchecked-item');
                    $(this).siblings('.b_p_ids').each(function() {
                        product_id.push($(this).val());
                    });
                    $(this).siblings('.b_p_qty_ids').each(function() {
                        product_qty.push($(this).val());
                    });

                });

                $("input:checkbox[name=<?= 'b_pro_' .$bundle_id. $params['id'] ?>]:not(:checked)").each(function() {
                    $(this).parents('.single-bundle-<?=$bundle_id?>').addClass('unchecked-item');
                });

                if (discount_type == 'percentage') {
                    discount_price = total_price - ((total_price * <?= $bundle->discount; ?>) / 100);
                } else {
                    if (total_price >= <?= $bundle->discount; ?>) {
                        discount_price = total_price - <?= $bundle->discount; ?>;
                    }
                }
                $("#<?= 'total_' . $params['id'] ?>").text(total_price.toFixed(2));
                $("#<?= 'discount_' . $params['id'] ?>").text(discount_price.toFixed(2));
                $("#<?= 'c_total_' . $params['id'] ?>").text(total_price.toFixed(2));
                $("#<?= 'c_discount_' . $params['id'] ?>").text(discount_price.toFixed(2));



                $('input[name=<?= 'b_pro_' .$bundle_id. $params['id'] ?>]').click(function() {
                    total_price = 0.0;
                    discount_price = 0.0;
                    product_id = [];
                    product_qty = [];
                    $("input:checkbox[name=<?= 'b_pro_' .$bundle_id. $params['id'] ?>]:checked").each(function() {
                        total_price += parseFloat($(this).val());
                        $(this).parents('.single-bundle-<?=$bundle_id?>').removeClass('unchecked-item');
                        $(this).siblings('.b_p_ids').each(function() {
                            product_id.push($(this).val());
                        });
                        $(this).siblings('.b_p_qty_ids').each(function() {
                            product_qty.push($(this).val());
                        });
                    });

                    number_of_unchecked_item = 0;
                    $("input:checkbox[name=<?= 'b_pro_' .$bundle_id. $params['id'] ?>]:not(:checked)").each(function() {
                        $(this).parents('.single-bundle-<?=$bundle_id?>').addClass('unchecked-item');
                        number_of_unchecked_item++;
                    });

                    if (bundle_option == 1) {
                        discount_apply = 1;
                        if (discount_type == 'percentage') {
                            discount_price = total_price - ((total_price * <?= $bundle->discount; ?>) / 100);
                        } else {
                            if (total_price >= <?= $bundle->discount; ?>) {
                                discount_price = total_price - <?= $bundle->discount; ?>;
                            }
                        }
                    } else {
                        discount_apply = 0;
                        $("#bundle-total-discount-<?php print $params['id']; ?>").addClass("total-discount-hide");
                        $("#bundle-total-price-<?php print $params['id']; ?>").addClass("total-price-not-line-through");
                        $("#bundle-offer-price-<?php print $params['id']; ?>").addClass("total-offer-hide");

                        $("#c-bundle-total-discount-<?php print $params['id']; ?>").addClass("total-discount-hide");
                        $("#c-bundle-total-price-<?php print $params['id']; ?>").addClass("total-price-not-line-through");
                        $("#c-bundle-offer-price-<?php print $params['id']; ?>").addClass("total-offer-hide");

                        if (number_of_unchecked_item == 0) {
                            discount_apply = 1;
                            $("#bundle-total-discount-<?php print $params['id']; ?>").removeClass("total-discount-hide");
                            $("#bundle-total-price-<?php print $params['id']; ?>").removeClass("total-price-not-line-through");
                            $("#bundle-offer-price-<?php print $params['id']; ?>").removeClass("total-offer-hide");

                            $("#c-bundle-total-discount-<?php print $params['id']; ?>").removeClass("total-discount-hide");
                            $("#c-bundle-total-price-<?php print $params['id']; ?>").removeClass("total-price-not-line-through");
                            $("#c-bundle-offer-price-<?php print $params['id']; ?>").removeClass("total-offer-hide");
                            if (discount_type == 'percentage') {
                                discount_price = total_price - ((total_price * <?= $bundle->discount; ?>) / 100);
                            } else {
                                if (total_price >= <?= $bundle->discount; ?>) {
                                    discount_price = total_price - <?= $bundle->discount; ?>;
                                }
                            }
                        }
                    }
                    $("#<?= 'total_' . $params['id'] ?>").text(total_price.toFixed(2));
                    $("#<?= 'discount_' . $params['id'] ?>").text(discount_price.toFixed(2));
                    $("#<?= 'c_total_' . $params['id'] ?>").text(total_price.toFixed(2));
                    $("#<?= 'c_discount_' . $params['id'] ?>").text(discount_price.toFixed(2));
                });

                $('#<?= 'update_cart_' . $params['id'] ?>').click(function() {
                    if (bundle_setting_option == 0) {
                        if($('.js-shopping-cart-quantity').html() > 0){
                            var dialog = confirm("You have product in your cart. If you Add the Bundel then you won't get the bundle offer! Do you still want to Add the?");
                            if (dialog) {
                                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){

                                    if (product_id.length) {
                                        $.each(product_id, function( index, value ) {
                                            if(product_qty[index] > 0){
                                                mw.cart.add_item_bundle(value,product_qty[index])
                                            }
                                        });
                                        mw.reload_module('shop/cart/quick_checkout');
                                        mw.reload_module('shop/cart');
                                        mw.reload_module('shop/checkout');
                                        $("#cartModal").modal('show');

                                    } else {
                                        mw.notification.warning('Please choose at least one product!');
                                    }

                                });
                            }else{
                                $(".<?= 'cart-modal_' . $params['id'] ?>").hide();
                                $(".<?= 'cart-modal_' . $params['id'] ?>").removeClass();
                                mw.reload_module('bundle_product');

                            }
                        }else{
                            if (product_id.length) {
                                    sessionStorage.setItem('cart_update_for_bundle_product', 'true');
                                    $.post("<?= api_url('cart_update_for_bundle_product') ?>", {
                                        product_id: product_id,
                                        bundle_id: '<?= $bundle->id; ?>',
                                        bundle_discount: '<?= $bundle->discount; ?>',
                                        discount_apply: discount_apply,
                                    },function(data){
                                        $.each(product_id, function( index, value ) {
                                            mw.cart.add_item_bundle(value,product_qty[index])
                                        });
                                    }).then(function(){
                                        mw.reload_module('shop/cart');
                                        mw.reload_module('shop/checkout');
                                        $("#cartModal").modal('show');
                                    });

                            } else {
                                mw.notification.warning('Please choose at least one product!');
                            }
                        }
                    }else{
                        if (product_id.length) {
                            $.post("<?= api_url('cart_update_for_bundle_product') ?>", {
                                product_id: product_id,
                                bundle_id: '<?= $bundle->id; ?>',
                                bundle_discount: '<?= $bundle->discount; ?>',
                                discount_apply: discount_apply,
                            },function(data){
                                $.each(product_id, function( index, value ) {
                                    mw.cart.add_item_bundle(value,product_qty[index])
                                });
                            }).then(function(){
                                mw.reload_module('shop/cart');
                                mw.reload_module('shop/checkout');
                                $("#cartModal").modal('show');
                            });


                        } else {
                            mw.notification.warning('Please choose at least one product!');
                        }
                    }


                });

                $('#close').click(function() {
                    mw.reload_module('bundle_product');
                });

                $('.<?= 'product-bundle-slider-' . $params['id'] ?>').addClass('pb-not-slider');
                $("#prev-<?=$params['id'] ?>").addClass("hide");
                $("#next-<?=$params['id'] ?>").addClass("hide");
                if ($('.<?= 'single-bundle-' . $params['id'] ?>').length > 4) {
                    $("#prev-<?=$params['id'] ?>").removeClass("hide");
                    $("#next-<?=$params['id'] ?>").removeClass("hide");
                    $('.<?= 'product-bundle-slider-' . $params['id'] ?>').removeClass('pb-not-slider');
                    var slider = tns({
                        container: '.<?= 'product-bundle-slider-' . $params['id'] ?>',
                        items: 5,
                        gutter: 15,
                        slideBy: 1,
                        prevButton: "#prev-<?=$params['id'] ?>",
                        nextButton: "#next-<?=$params['id'] ?>",
                        autoplay: false,
                        mouseDrag: true,
                        loop: false,
                        responsive: {
                            320: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            1366: {
                                items: 3
                            },
                            1440: {
                                items: 4
                            }
                        }
                    });
                }
            });

            $(document).ready(function(){
                if(jQuery(".single-bundle-<?php echo $params['id']; ?>").length == 0){
                    if(jQuery('*').hasClass("total-<?php echo $params['id']; ?>")){
                        if(<?php echo $is_admin; ?> == 1){
                            jQuery(".main-<?php echo $params['id']; ?>").html(`<div id="one-product-alert" class="alert alert-danger" role="alert">
                                                                                    <p class="text-center" style="font-size: 14px;"><?php _e('The bundle is not visible to the shop visitors at the moment, because the stock level of one or more of the bundle’s products is currently lower than your specified minimum order quantity. It will automatically become visible as soon as the stock is sufficient again'); ?>.</p>
                                                                                </div>`);
                        }
                    }
                }
            });
        <?php endif; ?>
    <?php endif; ?>
</script>
