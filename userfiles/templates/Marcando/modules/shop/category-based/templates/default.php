<?php

/*

type: layout

name: Default V2

description: Default Version 2

*/
?>
<link rel="stylesheet" href="<?php print template_url(); ?>modules/shop/products_style.css" type="text/css"/>
<?php 
    $show_fields = [];
    $settings = getProductModuleSettings($params['id']);
    $hide_paging = true;
    $per_page_items = 6;
    $query = DB::table('group_product')
                ->leftJoin('product', 'group_product.product_id', '=', 'product.id')
                ->leftJoin('product_media',function($joining){

                    $joining->on('group_product.product_id', '=', 'product_media.rel_id');
                    $joining->where('product_media.position' , 0);

                })
                ->leftJoin('offers',function($joining){

                    $joining->on('group_product.product_id', '=', 'offers.product_id');
                    $joining->where('offers.is_active' , 1);

                });
    if(isset($settings['data-hide-paging']) and $settings['data-hide-paging']->value == 'y'){
        $hide_paging = false;
    }
    if(isset($settings['data-limit'])){
        $per_page_items = $settings['data-limit']->value;
    }

    if(isset($settings['categories']) and !empty($settings['categories']->value)){
        $categories = $settings['categories']->value;
        $query = $query->leftJoin('categories_items',function($joining){
                            $joining->on('group_product.product_id', '=', 'categories_items.rel_id');
                    })
                    ->where('categories_items.parent_id' , $categories)
                    ->where('categories_items.rel_type' , 'product');
    }

    $order_by = 'product.position';
    $ordering = 'desc';
    if(isset($settings['position'])){
        $order_data = $settings['position']->value;
        $order_data = explode(" ", $order_data);
        $order_by = 'product.' . $order_data[0];
        $ordering = $order_data[1];
    }
    $paging_param = sha1($params['id']);
    if(isset($_GET[$paging_param])){
        $data = $query->where('group_product.group_id', 1)->orderBy($order_by, $ordering)->select('group_product.product_id as content_id', 'product.title as title', 'product.url as url', 'product.vk_price as price', 'product.quantity as quantity', 'product.tax_type as tax_type','product_media.webp_image as webp_image','product_media.resize_image as resize_image','product_media.filename as filename' , 'offers.offer_price as offer_price', 'offers.expires_at as expires_at', 'offers.created_at as created_at')->distinct('group_product.product_id')->simplePaginate($per_page_items, ['*'], $paging_param, $_GET[$paging_param]);
        $count = $query->where('group_product.group_id', 1)->select('group_product.product_id as content_id')->distinct('group_product.product_id')->count();
    }else{
        $data = $query->where('group_product.group_id', 1)->orderBy($order_by, $ordering)->select('group_product.product_id as content_id', 'product.title as title', 'product.url as url', 'product.vk_price as price', 'product.quantity as quantity', 'product.tax_type as tax_type','product_media.webp_image as webp_image','product_media.resize_image as resize_image','product_media.filename as filename' ,'offers.offer_price as offer_price', 'offers.expires_at as expires_at', 'offers.created_at as created_at')->distinct('group_product.product_id')->simplePaginate($per_page_items);
        $count = $query->where('group_product.group_id', 1)->select('group_product.product_id as content_id')->distinct('group_product.product_id')->count();
    }
    $title_character_limit = 255;
    if(isset($settings['data-title-limit'])){
        $title_character_limit = $settings['data-title-limit']->value;
    }
    $pages_count = 0;
    $pages_count_found = $count/$per_page_items;
    if(is_int($pages_count_found)){
        $pages_count = (int)$pages_count_found;
    } else{
        $pages_count = (int)$pages_count_found + 1;
    }
    $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    $is_logged = is_logged();

    if(is_admin()){
        $shop_category_header_ignore = (array)json_decode($GLOBALS['custom_shop_category_header_ignore']) ?? [];
        $showHeader = category_hide_or_show(); ?>
        <div id="hide_shop" style="display:flex;align-items:center" class="<?php print $showHeader['button']??'';?>">
            <p style="margin-bottom:0px;margin-right:10px;">Category show in header :</p>
            <input type="checkbox" data-toggle="toggle" data-size="mini" name="shop" id="shop_cat" data-on="Off" data-off="On" value="<?php (in_array(PAGE_ID,$shop_category_header_ignore)) ? print 0 : print PAGE_ID ;?>" <?php (in_array(PAGE_ID,$shop_category_header_ignore)) ? print "checked" : "" ;?>>

        </div>

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
        
    <?php } ?>

<?php if (!empty($data) && !isset($_GET['slug']) && !isset($_GET['wishlist_id'])):
        $tax_rate_list = $GLOBALS['tax'] ?? false;

         if(isset($tax_rate_list) and !empty($tax_rate_list)){
             $original_tax = $tax_rate_list->charge;
             $reduced_tax = $tax_rate_list->reduced_charge;
         }else{
             $original_tax = null;
             $reduced_tax = null;
         }
    ?>
        <div class="row shop-products">
        <?php foreach ($data as $item):
                $item = collect($item)->toArray();

                $item['image'] = $item['webp_image'] ?? $item['resize_image'] ?? $item['filename'];
                $in_stock = false;
                if($item['quantity'] > 0 || $item['quantity'] == 'nolimit') {
                    $in_stock = true;
                }
                $item['url'] = "product/".$item['url'];

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
                                    <h5><?php print character_limiter($item['title'], $title_character_limit); ?>
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
                                if (isset($item['offer_price'])) {
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
                                        if(isset($item['offer_price'])){
                                            $val1 = normalPrice($item['offer_price']);
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
                        if (isset($item['offer_price']) && $item['expires_at'] != 0) {
                            //                        dd($offer);
                            if (\Carbon\Carbon::now()->diffInSeconds($item['created_at'], false) > 0) {
                                $remaining = \Carbon\Carbon::parse($item['created_at'])->diffInSeconds($item['expires_at'], false);
                            } else {
                                $remaining = \Carbon\Carbon::now()->diffInSeconds($item['expires_at'], false);
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
<?php endif; ?>

<input type="hidden" name="category_status" id="shop_<?=PAGE_ID?>" data-<?=PAGE_ID?>="shop" value="<?=PAGE_ID?>">

<?php if (isset($pages_count) and $pages_count > 1 and $hide_paging): ?>
    <module type="pagination" template="bootstrap4" pages_count="<?php echo $pages_count; ?>" paging_param="<?php echo $paging_param; ?>"/>
<?php endif;

if (CATEGORY_ID != false) {
    $cat = DB::table('categories')->where('id', CATEGORY_ID)->first();
    if ($cat->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; 
} ?>


<script type="text/javascript">

    <?php if ($is_logged && !isset($_GET['slug']) && !isset($_GET['wishlist_id'])) { ?>
        $(document).ready(function(){
            $('.js-example-basic-multiple').select2();
        });

        $(document).ready(() => {
            $.get(`<?= api_url('get_wishlist_sessions'); ?>`, result => {
                const selected = [];
                const list = [];
                if(result!='false'){
                    result.forEach(function (session) {
                        console.log(session);
                        list.push('<option value=' + session['id'] + '>' + session['name'] + '</option>');

                        session['products'].forEach(function (prod) {
                            if (selected[parseInt(prod['product_id'])] === undefined) {
                                selected[parseInt(prod['product_id'])] = [];
                            }
                            selected[parseInt(prod['product_id'])].push(session.id.toString())
                        })
                    });
                }

                <?php if (!empty($data)): ?>
                <?php foreach ($data as $item):
                        if(!is_array($item)){
                            $item = (array)$item;
                        }
                ?>
                var wishlistProduct = $(".wishlist-select-<?php echo $item['content_id'];?>");
                wishlistProduct.empty();
                wishlistProduct.append('<option disabled value="null"></option>');
                list.forEach(function (value) {
                    wishlistProduct.append(value);
                });

                var didd = <?php echo $item['content_id'];?>;
                wishlist_details(didd);

                <?php endforeach; ?>
                <?php endif; ?>

                selected.forEach(function (value, index) {
                    const wishlistProduct2 = $(".wishlist-select-" + index.toString());
                    wishlistProduct2.select2().val(value).trigger("change");
                });
                function wishlist_details(didd) {
                    if (selected[didd] && selected[didd].length > 0){
                        $(".wishlist-logo-"+didd).text("favorite");
                }
                    else{
                        $(".wishlist-logo-"+didd).text("favorite_border");
                    }
                }

            });
        });

        <?php if (!empty($data)): ?>
            <?php foreach ($data as $item):
                if(!is_array($item)){
                    $item = (array)$item;
                }
                ?>
                $(".wishlist-select-<?php echo $item['content_id'];?>").on('select2:unselect', function (e) {
                    removeProduct(<?php echo $item['content_id'];?>, e.params.data.id)
                    if ($(".wishlist-select-<?php echo $item['content_id'];?>").val().length == 0) {
                        $(".wishlist-logo-<?php echo $item['content_id'];?>").text("favorite_border");
                    }
                });

                $(".wishlist-select-<?php echo $item['content_id'];?>").on('select2:select', function (e) {
                    addProduct(<?php echo $item['content_id'];?>, e.params.data.id)
                    $(".wishlist-logo-<?php echo $item['content_id'];?>").text("favorite");
                });

            <?php endforeach; ?>
        <?php endif; ?>

        function removeProduct(productId, sessionId) {
            $.post("<?php print api_url('remove_wishlist_sessions'); ?>", {productId: productId, sessionId: sessionId}, () => {
            });
        }

        function addProduct(productId, sessionId) {
            $.post("<?php print api_url('add_wishlist_sessions'); ?>", {productId: productId, sessionId: sessionId}, () => {
            });
        }
    <?php } ?>

    function wishlist_filter(wId){
        $.post("<?php print site_url('en/shop'); ?>", {wishlist_id: wId}, () => {
        });
    }
    $("#input_text").hide();
    $("#clickBtn").on('click',function(){
        $("#clickBtn").hide();
        $("#clickBtn").parent().hide();
        $("#input_text").show();
        share_wishlist();
    });

    $(document).on('click','#input_text', function(){
        this.select();
        document.execCommand('copy');
    });
    
    function share_wishlist() {
        return $.post($('form#wishlist_short_url_form').attr('action'), $('form#wishlist_short_url_form').serialize(), (res) => {
            $('#input_text').val(res.url)
        });
    }

    $(document).on('click','#edit_sss', function(){
        let name = $(this).data('name');
        $("#exampleInputEmailedit").val(name);
        $("#exampleInputEmailedithide").val(name);
    });

    $(document).on('click','#delete_sss', function(){

        let name = $(this).data('name');

        $.post("<?php print api_url('delete_wishlist_sessions'); ?>", {name: name}, function (sessions) {
            if (sessions === 'false') {
                location.reload();

            } else {
                location.reload();
            }
        });

    });

    $(document).ready(function(){

        function copyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            // Place in the top-left corner of screen regardless of scroll position.
            textArea.style.position = 'fixed';
            textArea.style.top = 0;
            textArea.style.left = 0;

            // Ensure it has a small width and height. Setting to 1px / 1em
            // doesn't work as this gives a negative w/h on some browsers.
            textArea.style.width = '2em';
            textArea.style.height = '2em';

            // We don't need padding, reducing the size if it does flash render.
            textArea.style.padding = 0;

            // Clean up any borders.
            textArea.style.border = 'none';
            textArea.style.outline = 'none';
            textArea.style.boxShadow = 'none';

            // Avoid flash of the white box if rendered for any reason.
            textArea.style.background = 'transparent';


            textArea.value = text;

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            document.execCommand('copy');

        }

        function copyClipBoardText(className) {
            var copyText = document.getElementsByClassName(className);
            copyText[0].select();
            document.execCommand("copy");
        }
        $(document).on('click','.copy-url',function() {
                let id = $(this).data('id');
                let lang = $(this).data('lang');
                $.ajax({
                    method: 'POST',
                    url: "<?php print api_url('guest_checkout'); ?>",
                    data: {iid: id, lang: lang},
                    success: function(response){
                        if (response.success) {
                            copyTextToClipboard(response.url);
                        }
                    }
                });
        });


        //Update trial clock
        function updateDTTemplateTrialClock(el){
            let time_interval = setInterval(function() {
                let total = el.data('end');

                if(!total){
                    el.hide();
                    el.html('');
                    clearInterval(time_interval);
                    return;
                }

                const seconds = Math.floor( total % 60 );
                const minutes = Math.floor( (total/60) % 60 );
                const hours = Math.floor( (total/(60*60)) % 24 );
                const days = Math.floor( total/(60*60*24) );
                --total;

                el.data('end', total);
                el.css('padding', '10px 15px');
                el.html(`<div class="days-wrapper"><p>${days < 10? ' 0'+days : days}</p> <span class="su">Tage</span><span class="su-res">T</span></div> <div class="hours-wrapper"><p>${hours < 10?  '0'+hours : hours}</p><span class="su">Stunden</span><span class="su-res">S</span></div> <div class="minutes-wrapper"><p>${minutes < 10?  '0'+minutes : minutes}</p> <span class="su">Minuten</span><span class="su-res">M</span></div><div class="seconds-wrapper"><p>${seconds < 10?  '0'+seconds : seconds}</p><span class="su">Sekunden</span><span class="su-res">S</span></div>`);

            }, 1000);
        }

        function show_dt_template_trial_countdown(){
            if(!$('.dt_t_countdown_data').length) return;

            $('.dt_t_countdown_data').each(function() {
                let _st = $(this).data('end');
                if(_st){
                    updateDTTemplateTrialClock($(this))
                }
            });
        }

        $(document).ready(function(){
            show_dt_template_trial_countdown();
        })

    });
</script>
