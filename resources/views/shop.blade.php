<?php include('./userfiles/templates/Marcando/header.php');
?>
<script src="http://localhost/performance/5a3edecd-b93b-42e9-9707-5a079d3891ce/apijs_combined?mwv=1.2.0"></script>
<link rel="stylesheet" href="<?php print template_url(); ?>modules/shop/products_style.css" type="text/css"/>
<?php
    $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    $is_logged = is_logged();
    if (CATEGORY_ID != false) {
        $cat = DB::table('categories')->where('id', CATEGORY_ID)->first();
        $cat_img = array(
            'rel_type'  => "categories",
            'rel_id' => $cat->id
        );
        $media_cat = get_pictures($cat_img);
    }
?>



<?php if (!empty($data) && !isset($_GET['slug']) && !isset($_GET['wishlist_id'])):

        $tax_rate_list = $GLOBALS['tax'];

         if(isset($tax_rate_list)){
             $original_tax = $tax_rate_list->charge;
             $reduced_tax = $tax_rate_list->reduced_charge;
         }else{
             $original_tax = null;
             $reduced_tax = null;
         }
        // $userGroupInfo = user_group_info();
        // if(isset($userGroupInfo) && !empty($userGroupInfo) && isset($userGroupInfo['has_net_price']) && $userGroupInfo['has_net_price'] == 0){
        //     $tax_rate = $userGroupInfo['has_net_price'];
        //     $original_tax = $userGroupInfo['has_net_price'];
        //     $reduced_tax = $userGroupInfo['has_net_price'];
        // }

    ?>
        <div class="row shop-products">
        <?php foreach ($data as $item):
                $item = collect($item)->toArray();
                if($item['image']){
                    $image_link = $item['image'];
                }else{
                    $image_link = '';
                }
                $in_stock = false;
                if($item['quantity'] > 0 || $item['quantity'] == 'nolimit') {
                    $in_stock = true;
                }

                if($item['tax_type'] == '2'){
                    $taxrate =  $reduced_tax;
                }else{
                    $taxrate = $original_tax;
                }
            ?>

            <div class="col-md-4 item-<?php print $item['content_id'] ?>">
                <div class="product-sample-wrapper">

                    <input type="hidden" name="price" value="<?php print $item['price'] ?>"/>
                    <input type="hidden" name="content_id" value="<?php print $item['content_id'] ?>"/>

                    <div class="product-sample-inner">
                        <?php if ($show_fields == false or in_array('thumbnail', $show_fields)): ?>
                            <div class="product-sample-image">
                                <a href="<?php print url($item['url']); ?>">
                                    <img src="<?php print $item['image']; ?>" alt="">
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_fields == false or in_array('title', $show_fields)): ?>
                            <div class="product-sample-content">
                                <a href="<?php print url($item['url']); ?>" class="product-sample-title">
                                    <h5><?php print $item['title'] ?>
                                    </h5>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="product-tax-text">
                            <?php if (isset($item['price']) && normalPrice($item['price']) > 0): ?>
                                <span class="edit">
                                inkl. <?php print $taxrate; ?>% MwSt.
                                </span>
                                <span data-toggle="modal" data-target="#termModal">
                                    zzgl. Versand
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ($is_logged) { ?>
                            <?php if (get_option('enable_wishlist', 'shop')) : ?>
                                <div class="product-wishlist">
                                    <span class="material-icons wishlist-logo wishlist-logo-<?= $item['content_id']; ?>">
                                        favorite
                                    </span>
                                    <label for="wishlist-select-<?= $item['content_id']; ?>"></label>
                                    <select id="" class="wishlist-select-<?= $item['content_id']; ?> js-example-basic-multiple"

                                            name="states[]" multiple="multiple">
                                    </select>
                                </div>
                            <?php endif; ?>
                        <?php } ?>
                        <div class="product-price">
                            <?php
                                $offer = \MicroweberPackages\Offer\Models\Offer::getByProductId($item['content_id']);
                                if (isset($offer['price']['offer_price'])) {
                                    $val4 = normalPrice($item['price']);
                                    if (isset($in_stock) && $in_stock != false) { ?>

                                    <div class="dt-old-price">
                                        <p><?php print currency_format(roundPrice($val4)); ?></p>
                                    </div>

                                <?php
                                    }
                                } ?>
                            <?php if ($show_fields == false or in_array('price', $show_fields)):?>
                                <?php if (isset($item['price'])): ?>
                                    <?php
                                        if(isset($offer['price']['offer_price'])){
                                            $val1 = normalPrice($offer['price']['offer_price']);
                                            $val1 = $val1 + product_tax_amount($val1,$taxrate);
                                        }else{
                                            $val1 = normalPrice($item['price']);
                                            $val1 = $val1 + product_tax_amount($val1,$taxrate);
                                        }

                                    ?>
                                    <?php if($val1 > 0): ?>
                                        <h6 class="product-sample-price"><?php print currency_format(roundPrice($val1)); ?></h6>
                                    <?php else: ?>
                                        <h6 class="product-sample-price"><?php _e('Price On Request'); ?></h6>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>


                        <div class="product-sample-hover-right">
                            <?php if (is_admin()): ?>
                                <a class="quick-checkout-btn copy-url" data-id="<?php echo $item['content_id']; ?>" data-lang="<?= url_segment(0); ?>">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?php print url($item['url']); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="product-sample-hover-bottom">
                            <?php if (!isset($in_stock) or $in_stock == false) :?>
                                 <a href="javascript:;" disabled="disabled" class="btn btn-primary product-cart-icon cart-disable">
                                    <i class="material-icons">remove_shopping_cart</i><?php _e("Out Of Stock"); ?>
                                </a>
                            <?php elseif(isset($item['price']) && !(floatval($item['price']) > 0)): ?>
                                <a href="javascript:;" title="<?php _e('Price On Request'); ?>" onclick="priceModal(); price_on_request_product_id_get(<?php print $item['content_id']; ?>,'<?php print $item['title']; ?>');"   class="btn btn-primary" ><?php _e('Price On Request'); ?></a>
                            <?php else: ?>

                                <a href="javascript:;" onclick="<?php if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) { ?>carttoggole('.shop-products .item-<?php print $item['content_id'] ?>');<?php }else{ ?>carttoggolee('.shop-products .item-<?php print $item['content_id'] ?>');<?php } ?>" class="btn btn-primary product-cart-icon"><i class="material-icons ">shopping_cart</i> in den Warenkorb</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                        if (isset($offer['price']['offer_price']) && $offer['price']['expires_at'] != 0) {
                            //                        dd($offer);
                            if (\Carbon\Carbon::now()->diffInSeconds($offer['price']['created_at'], false) > 0) {
                                $remaining = \Carbon\Carbon::parse($offer['price']['created_at'])->diffInSeconds($offer['price']['expires_at'], false);
                            } else {
                                $remaining = \Carbon\Carbon::now()->diffInSeconds($offer['price']['expires_at'], false);
                            }
                            $remaining = $remaining > 0 ? $remaining : 0;
                            $counter = Config::get('custom.counter');
                            if (isset($in_stock) && $in_stock != false) {
                        ?>

                        <div class="dt-countdown-style-<?= $counter ?>">
                            <!-- "dt-countdown-style-1" This Number Will Be Dynamic Based On Select Design From backend -->
                            <div class="dt-cdown-box">
                                <div class="dt_t_countdown_data" data-end="<?= $remaining ?>"></div>
                            </div>
                        </div>

                    <?php }
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
{!! $data->links('pagination::bootstrap-4') !!}

<?php endif; ?>
<input type="hidden" name="category_status" id="shop_<?=PAGE_ID?>" data-<?=PAGE_ID?>="shop" value="<?=PAGE_ID?>">

<script>
    $('#shop_cat').change(function (){
        var shop_id = $('#shop_cat').val();
        var page_id = <?=PAGE_ID?>


        $.post('<?= url('/') ?>/api/v1/not_show', { shop_cat: shop_id,page_id: page_id }, (res) => {
            if($(this).prop( 'checked')){
                mw.notification.success('Category off in header');
                $('#shop_cat').val('0');
                $('.header-cat').hide();
            }else if($(this).prop('checked',false)){
                mw.notification.success('Category on in header');
                $('#shop_cat').val('<?=PAGE_ID?>');
                $('.header-cat').attr('style','display: block !important;');

            }
        });

    });
</script>
<?php include('./userfiles/templates/Marcando/footer.php');
