<?php

/*

type: layout

name: Product List 1

description: Product List 1 layout

*/
?>
<link rel="stylesheet" href="<?php print template_url(); ?>modules/shop/products_style.css" type="text/css"/>
<?php
$update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
$is_logged = is_logged();
if (isset($_GET['wishlist_id'])) {
    $ids = array(0);
    $pro_ids = DB::table('wishlist_session_products')->where('wishlist_id', '=', $_GET['wishlist_id'])->pluck('product_id')->toArray();


    ?>

    <form action="<?php print api_url('share_wishlist'); ?>" class="form-inline" id="wishlist_short_url_form">
        <div class="form-group" style="margin-bottom: 20px;">
            <?php foreach($pro_ids as $pro_id): ?>
            <input type="hidden" name="products[]" value="<?= $pro_id; ?>">
                <?php endforeach; ?>
            <input  type="hidden" name="user_id" value="<?= user_id(); ?>">

            <button type="button" class="btn btn-primary" id="clickBtn">Wunschliste teilen</button>
        </div>
    </form>
    <input onClick="this.select();" type="text" class="form-control share_input-text" id="input_text" >


    <?php

        // $data = collect($data)->whereIn('content_id', $pro_ids)->toArray();
        $data = DB::table('products')->whereIn('content_id',$pro_ids)->get()->toArray();
    }

    if (isset($_GET['slug'])) {

        $products = DB::table('wishlist_link')->where('slug', $_GET['slug'])->first()->products_id;
        $data = DB::table('products')->whereIn('content_id',$pro_ids)->get()->toArray();
    }
if (CATEGORY_ID != false) {
    $cat = DB::table('categories')->where('id', CATEGORY_ID)->first();
    $cat_img = array(
        'rel_type'  => "categories",
        'rel_id' => $cat->id
    );
    $media_cat = get_pictures($cat_img);
}


?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cat->show_category == null || $cat->show_category == 0 || $cat->show_category == 1 || $cat->show_category == false) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($data)):
        $user_country_name = user_country(user_id());
        if($user_country_name){
            $tax_rate_list = DB::table('tax_rates')->where('country','LIKE','%'.$user_country_name.'%')->first();
        }else{
            $tax= mw()->tax_manager->get();
            $tax_rate_list = DB::table('tax_rates')->where('country','LIKE','%'.$tax['0']['name'].'%')->first();
        }
        if(isset($tax_rate_list)){
            $original_tax = $tax_rate_list->charge;
            $reduced_tax = $tax_rate_list->reduced_charge;
        }else{
            $original_tax = null;
            $reduced_tax = null;
        }
    ?>
<div class="nk-portfolio-list product-row nk-isotope nk-isotope-3-cols">
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
            <div class="nk-isotope-item">
                <div class="nk-portfolio-item nk-portfolio-item-square nk-portfolio-item-info-style-1">
                    <a href="<?php print url($item['url']); ?>" class="nk-portfolio-item-link" itemprop="url"></a>
                    <div class="nk-portfolio-item-image">
                        <?php if ($show_fields == false or in_array('thumbnail', $show_fields)): ?>
                            <div class="image lazy" style="background-image:url('<?php print $item['image']; ?>'); background-size: cover;">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="">
                        <div>
                            <div class="product-title-wrapper">
                                <?php if ($show_fields == false or in_array('title', $show_fields)): ?>
                                    <h2 class="product-title h3" itemprop="name"><?php print character_limiter($item['title'], 35); ?></h2>
                                <?php endif; ?>
                            </div>

                            <?php if ($show_fields == false or in_array('price', $show_fields)): ?>
                                <div class="product-price">
                                    <strong>
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
                                    <?php if ($show_fields == false or in_array('price', $show_fields)): ?>
                                        <div class="price">
                                            <?php if (isset($item['price'])) { ?>
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
                                                    <span><?php print currency_format(roundPrice($val1)); ?></span>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </div>
                                    <?php endif; ?>
                                    </strong>
                                </div>
                                <br/>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="product-des">
                    <div class="product-tax-text" style="">
                        <?php if (isset($item['price']) && normalPrice($item['price']) > 0): ?>
                            <span class="edit">
                                inkl. <?php print $taxrate; ?>% MwSt.
                            </span>
                            <span data-toggle="modal" data-target="#termModal" style="margin-left:5px;display:inline-block;">
                                zzgl. Versand
                            </span>
                        <?php endif; ?>
                    </div>
                    <?php if ($is_logged) { ?>
                        <?php if (get_option('enable_wishlist', 'shop')) : ?>
                            <div class="product-wishlist">
                                <span class="material-icons wishlist-logo" id="wishlist-logo-<?= $item['content_id']; ?>">
                                    favorite
                                </span>
                                <label for="wishlist-select-<?= $item['content_id']; ?>"></label>
                                <select class="js-example-basic-multiple wishlist-select-<?= $item['content_id']; ?>"

                                        name="states[]" multiple="multiple">
                                </select>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </div>
                <div class="product-button">
                    <?php if ($show_fields == false or in_array('add_to_cart', $show_fields)): ?>
                        <div class="add-to-cart">
                            <?php if (!isset($in_stock) or $in_stock == false) :?>
                                <button title="<?php _e('Out Of Stock'); ?>" class="btn btn-success cart-disable-btn" type="button" disabled="disabled">
                                    <i class="material-icons left">remove_shopping_cart</i>
                                </button>
                            <?php elseif(isset($item['price']) && (floatval($item['price']) > 0)): ?>
                                <button title="in den Warenkorb" class="btn btn-success product-cart-icon" type="button" onclick="<?php if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) { ?>carttoggole('.shop-products .item-<?php print $item['content_id'] ?>');<?php }else{ ?>carttoggolee('.shop-products .item-<?php print $item['content_id'] ?>');<?php } ?>">
                                    <i class="material-icons left">shopping_cart</i>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($item['price']) && !(floatval($item['price']) > 0) && $in_stock): ?>
                        <div class="price-on-request-btn">
                            <button onclick="priceModal(); price_on_request_product_id_get(<?php print $item['content_id']; ?>,'<?php print $item['title']; ?>');"   class="btn btn-success" ><?php _e('Price On Request'); ?></button>
                        </div>
                    <?php endif; ?>
                    <?php if (is_admin()): ?>
                        <div class="product-quickout">
                            <a title="<?php _e('Checkout'); ?>" class="btn btn-primary copy-url product-quickcheckout-icon" data-id="<?php echo $item['content_id']; ?>" data-lang="<?= url_segment(0); ?>" >
                                <span class="material-icons">
                                    content_copy
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                        if (isset($offer['price']['offer_price']) && $offer['price']['expires_at'] != 0) {
    //                        dd($offer);
                        if(\Carbon\Carbon::now()->diffInSeconds($offer['price']['created_at'], false) > 0) {
                            $remaining = \Carbon\Carbon::parse($offer['price']['created_at'])->diffInSeconds($offer['price']['expires_at'], false);
                        }else{
                            $remaining = \Carbon\Carbon::now()->diffInSeconds($offer['price']['expires_at'], false);
                        }
                        $remaining = $remaining > 0 ? $remaining : 0;
                        $counter = Config::get('custom.counter');
                        if (isset($in_stock) && $in_stock != false) {
                        ?>



                        <div class="dt-countdown-style-<?=$counter?>"><!-- "dt-countdown-style-1" This Number Will Be Dynamic Based On Select Design From backend -->
                            <div class="dt-cdown-box">
                                <div class="dt_t_countdown_data" data-end="<?=$remaining?>"></div>
                            </div>
                        </div>


                    <?php }
                    }
                    ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)): ?>
    <module type="pagination" template="bootstrap4" pages_count="<?php echo $pages_count; ?>" paging_param="<?php echo $paging_param; ?>"/>
<?php endif; ?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cat->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>

<script type="text/javascript">
    <?php if ($is_logged) { ?>
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
                    $("#wishlist-logo-"+didd).text("favorite");
                    $("#wishlist-btn-"+didd).text("favorite");
            }
                else{
                    $("#wishlist-logo-"+didd).text("favorite_border");
                    $("#wishlist-btn-"+didd).text("favorite_border");
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
            $("#wishlist-logo-<?php echo $item['content_id'];?>").text("favorite_border");
            $("#wishlist-btn-<?= $item['content_id']; ?>").text("favorite_border");
        }
    });

    $(".wishlist-select-<?php echo $item['content_id'];?>").on('select2:select', function (e) {
        addProduct(<?php echo $item['content_id'];?>, e.params.data.id)
        $("#wishlist-logo-<?php echo $item['content_id'];?>").text("favorite");
        $("#wishlist-btn-<?= $item['content_id']; ?>").text("favorite");
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

console.log(name);
// console.log(id);


$("#exampleInputEmailedit").val(name);
$("#exampleInputEmailedithide").val(name);
});


$(document).on('click','#delete_sss', function(){

let name = $(this).data('name');

console.log(name);
// console.log(id);
$.post("<?php print api_url('delete_wishlist_sessions'); ?>", {name: name}, function (sessions) {
                if (sessions === 'false') {
                    // emailHelp.show();
                    location.reload();

                } else {
                    location.reload();
                }
            });


});


</script>
<script>

    $(document).ready(function(){

        function copyTextToClipboard(text) {
            var textArea = document.createElement("textarea");

            //
            // *** This styling is an extra step which is likely not required. ***
            //
            // Why is it here? To ensure:
            // 1. the element is able to have focus and selection.
            // 2. if the element was to flash render it has minimal visual impact.
            // 3. less flakyness with selection and copying which **might** occur if
            //    the textarea element is not visible.
            //
            // The likelihood is the element won't even render, not even a
            // flash, so some of these are just precautions. However in
            // Internet Explorer the element is visible whilst the popup
            // box asking the user for permission for the web page to
            // copy to the clipboard.
            //

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
        /* Get the text field */
        // var copyText = document.getElementsByClassName(class);
        var copyText = document.getElementsByClassName(className);
        // console.log(copyText);
        /* Select the text field */
        copyText[0].select();

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        // alert("Copied the text: " + copyText[0].value);
    }
       $(document).on('click','.copy-url',function() {
            // event.preventDefault();
            let id = $(this).data('id');
            let lang = $(this).data('lang');
            $.ajax({
                method: 'POST',
                url: "<?php print api_url('guest_checkout'); ?>",
                data: {iid: id, lang: lang},
                success: function(response){
                    if (response.success) {
                        // $('.clipboard-data-'+id).val(response.url);
                        // console.log(response.url);
                        copyTextToClipboard(response.url);
                        // copyClipBoardText('clipboard-data-'+id);

                    }
                }
            });
            // $.post("<?php print api_url('guest_checkout'); ?>", {iid: id, lang: lang}, (res) => {
            //     console.log(res);
            // });
        });

    });
</script>
