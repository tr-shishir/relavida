<?php

/*

type: layout

name: Default

description: Default

*/


?>


<?php

if (isset($params['content-id'])) {
    $product = get_content_by_id($params["content-id"]);
    $title = $product['title'];
} else {
    $title = _e("Product", true);
}

$update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;


?>
<style>
    .item-price span{
        font-size: 24px !important;
    }
    .item-price{
        text-align: center;
        margin-bottom: 8px;
    }
    .item-cart{
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-direction: column;
    }

    .item-cart .item-cart-button {
        margin-top: 10px;
    }

    .product-base-price{
        text-align:center;
    }

    span#product-base-price {
        font-size: 14px !important;
        font-weight: 600;
    }

</style>

<?php
use Illuminate\Support\Facades\DB;

$productUpsellingData = DB::table('product_upselling_item')->where('product_id',content_id())->get();
$newqs = DB::table('product_upselling_item')->where('product_id',content_id())->first();
$offer = \MicroweberPackages\Offer\Models\Offer::getByProductId(content_id());
$data_show = Config::get('custom.isShow');
$data_value = Config::get('custom.value');
$quatity = DB::table("content_data")->where('content_id', content_id())->where('field_name', 'qty')->first();
$data_product = get_content_by_id(CONTENT_ID);
$pro_id = (content_id());
$sub = DB::table('subscription_status')->where('product_id', $pro_id)->get()->all();
// if (!empty($sub)) {
//     dd($sub);
// }

?>

<br class="mw-add-to-cart-spacer"/>
<!--        <div class="product-des">-->
<!--            <p>-->
<!--            --><?php //if(get_content_by_id($for_id)['description'] != null) { echo get_content_by_id($for_id)['description']; } ?><!--</p>-->
<!--        </div>-->
<module type="custom_fields" data-content-id="<?php print intval($for_id); ?>" data-skip-type="price" id="cart_fields_<?php print $params['id'] ?>"/>
<?php if (is_array($data)): ?>
    <div class="price">
        <?php if($data_show == "show" && $data_value == "null") : ?>
            <div>
                <p style="text-align: right; font-size: 16px; color: #1E6BE5;">verfügbare Menge: <?php print $quatity->field_value; ?></p><br>
            </div>
        <?php elseif($data_show == "show" && $data_value != "null") :
            if($data_value == '' ) : ?>
                <div>
                    <p style="text-align: right; font-size: 16px; color: #1E6BE5;">Jetzt bestellen, nur noch <?php print $quatity->field_value; ?> auf Lager</p><br>
                </div>
            <?php else : ?>
                <div>
                    <p style="text-align: right; font-size: 16px; color: #1E6BE5;"><?php print str_replace('[stock]', $quatity->field_value, $data_value); ?></p><br>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php $i = 1;
        $productVariants = DB::table('product_variants')->where('user_id',user_id())->where('content_id',content_id())->first();
        $drmVarianteds = DB::table('variants')->where('rel_id', content_id())->get()->toArray();
        foreach ($data as $key => $v):
            $v = normalPrice($v);
            $v = roundPrice($v + taxPrice($v,null,CONTENT_ID));

//        uvp
//            if(isset($offer) && !empty($offer)){
//                $v = $offer->offer_price;
//            }

            ?>

            <?php if (!isset($in_stock) or $in_stock == false) {(function_exists('show_email_when_stockout')) ? print show_email_when_stockout(@$data_product['drm_ref_id']??0,$data_product['url'],$data_product['title'],$data_product['ean']) : '' ; }?>
            <?php if(isset($sub) and count($sub) > 0) $subscription_status = ""; else $subscription_status = "d-none"; ?>
            <div class="price mb-4 form-group">
                <input type="radio" id="otb" name="otb" class="mr-2 <?= $subscription_status ?>" onclick="itemShow()" checked>
                <label class="<?= $subscription_status ?>">Einmalige Lieferung</label><br>
                <input type="hidden" name="uId" id="uId" value="<?php print user_id(); ?>">
                <input type="hidden" name="valueSub" id="valueSub" value="0">
                <?php if (count($sub) > 0) : ?>
                    <input type="radio" id="item" name="otb" class="mr-2" onclick="itemShow()">
                    <label>Abo, automatische Lieferung</label><br><br>
                    <div id="isShow" style="display:none;">
                        <input type="hidden" name="pId" id="pId" value="<?php print $pro_id; ?>">
                        <label>Gewünschter Lieferintervall</label>
                        <select type="text" class="form-control" id="subId" name="subId" placeholder="select the product tittle" onchange="check_select()">
                            <option value="">Select One</option>
                            <?php
                            if (count($sub) == 1) {
                                foreach ($sub as $option) {
                                    $sub_item = DB::table('subscription_items')->where('id', $option->sub_id)->first();
                                    ?>
                                    <option value="<?php echo $sub_item->id ?>" selected><?php $sub_info = explode(" ", $sub_item->sub_interval);
                                        print $sub_info[0] . ' ';
                                        _e($sub_info[1]); ?></option>
                                    <?php
                                }
                            }
                            elseif (count($sub) > 1) {
                                foreach ($sub as $option) {
                                    $sub_item = DB::table('subscription_items')->where('id', $option->sub_id)->first();
                                    ?>
                                    <option value="<?php echo $sub_item->id ?>"><?php $sub_info = explode(" ", $sub_item->sub_interval);
                                        print $sub_info[0] . ' ';
                                        _e($sub_info[1]); ?></option>
                                    <?php
                                }
                            } else {
                                printf("<option value=''>No Product Found</option>");
                            }
                            ?>
                        </select>
                        <span id="selectMsg" style="color:red ;"></span>
                        <!-- <label for="cycles">Number of cycles you want to subscribe</label> -->
                        <input type="hidden" id="cycles" class="form-control" placeholder="please enter number only" value="0">
                        <span id="typeMsg" style="color:red ;"></span>
                    </div>
                <?php endif ?>
            </div>

            <script>
                function itemShow() {
                    if (document.getElementById('item').checked == true) {
                        document.getElementById("isShow").style.display = "";
                        document.getElementById("valueSub").value = "1";
                        document.getElementById("subId").required = true;
                        // document.getElementById("cycles").required = true;
                        // var sub_total = $('#sub-total').val();
                        // if(sub_total != 1){
                        //     $('#addCartBtn').prop('disabled', true);
                        // }
                        check_select();
                    } else {
                        document.getElementById("isShow").style.display = "none";
                        document.getElementById("valueSub").value = "0";
                        document.getElementById("subId").required = false;
                        // document.getElementById("cycles").required = false;
                        $('#addCartBtn').prop('disabled', false);
                    }
                }

                function check_select() {
                    var interval = $('#subId').val() ?? null;
                    if (interval == null || interval == "") {
                        $('#addCartBtn').prop('disabled', true);
                    } else{
                        $('#addCartBtn').prop('disabled', false);
                    }
                }

            </script>


            <div class="mw-price-item">
                <div class="upselling-item" >
                    <?php if(!empty($newqs)){ ?>
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th scope="col">Angebot personalisieren</th>
                                <th scope="col">Preis</th>
                            </tr>
                            </thead>
                            <?php foreach($productUpsellingData as $pitem):  ?>
                                <?php $UpsellingData = DB::table('product_upselling')->where('id',$pitem->item_id)->get(); ?>
                                <?php if($UpsellingData->count()):  ?>
                                <tbody>
                                <tr>
                                    <?php $itemstatus = DB::table("selected_product_upselling_item")->where('service_id',$UpsellingData[0]->id)->where('product_id', content_id() )->where('user_id',user_id())->get(); ?>
                                    <?php if($itemstatus->count()): ?>
                                        <?php
                                        $sPrice = $itemstatus[0]->service_price + taxPrice($itemstatus[0]->service_price);
                                        if($productVariants){
                                            $v = $productVariants->varianted_price + $sPrice;
                                        }else{
                                            $v = $v + $sPrice;
                                        }

                                        ?>
                                        <td>
                                            <div class="additional-checkbox">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" checked id="<?php print $UpsellingData[0]->id; ?>" value="<?php print $UpsellingData[0]->servicePrice;  ?>"> <?php print $UpsellingData[0]->serviceName;  ?></label>
                                                </div>
                                            </div>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <div class="additional-checkbox">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" id="<?php print $UpsellingData[0]->id; ?>" value="<?php print $UpsellingData[0]->servicePrice;  ?>"> <?php print  $UpsellingData[0]->serviceName;  ?></label>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                            <span><?php
                                                $upsellingPrice = $UpsellingData[0]->servicePrice;
                                                $upsellingPriceWithOuttax = $upsellingPrice;
                                                $upsellingPrice = $upsellingPrice + taxPrice($upsellingPrice);
                                                print currency_format($upsellingPrice);
                                                ?></span>
                                    </td>
                                </tr>
                                </tbody>
                            <?php endif; ?>

                                <script type="text/javascript">
                                    var total=0;
                                    $(document).ready(function(){
                                        productPrice=parseFloat($('#totalPrice').val());
                                    });
                                    $('#<?php print $UpsellingData[0]->id;  ?>').click(function() {
                                        if($('#<?php print $UpsellingData[0]->id;  ?>').is(':checked')){
                                            productPrice=parseFloat($('#totalPrice').val());
                                            var service_price = parseFloat($('#<?php print $UpsellingData[0]->id; ?>').val());
                                            total = total + service_price;
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('addproductUpselling')?>",
                                                data:{ total : total,product_id : <?php print content_id(); ?>,service_id : <?php print $pitem->item_id; ?>,service_price : service_price, productPrice : productPrice },
                                                success: function(response) {
                                                    // console.log("");
                                                    $("#totalAmount").text(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });

                                        }
                                        else{
                                            productPrice=parseFloat($('#totalPrice').val());
                                            var service_price = parseFloat('<?php print $UpsellingData[0]->servicePrice; ?>');
                                            total =total - service_price;
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('deleteproductUpselling')?>",
                                                data:{ total : total,product_id : <?php print content_id(); ?>,service_id : <?php print $pitem->item_id; ?>, productPrice : productPrice },
                                                success: function(response) {
                                                    // console.log("");
                                                    $("#totalAmount").text(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                    });
                                </script>

                            <?php endforeach; ?>

                        </table>
                    <?php } ?>
                </div>
                <!-- start varianted code -->
                <?php if($drmVarianteds){ ?>

                    <input type="hidden" class="form-control" id="drm_variant_id" name="drm_variant_id" >
                    <label style="font-size: 18px;font-family: 'Circular-Loom';"> Varianted Option</label>
                    <select id="varianted_option" class="form-select" name="varianted_price" aria-label="Default select example" style="height: 35px;border: 1px solid #d9d9d9;border-radius: 5px;">
                        <?php
                        if($drmVarianteds){ ?>
                            <option value="<?php print currency_format($v) ?>">Select Variant Option</option>
                            <?php foreach($drmVarianteds as $drmVarianted){

                                $total_price = $drmVarianted->price + taxPrice($drmVarianted->price);?>

                                <option value="<?php print($total_price) ?>" data-id="<?php print($drmVarianted->drm_ref_id);?>" data-stock="<?php print($drmVarianted->stock);?>">
                                    <?php
                                    //                                                if($drmVarianted->color){
                                    //                                                    print ('Color ('.$drmVarianted->color.')');
                                    //                                                }if($drmVarianted->size){
                                    //                                                    print (' - Size ('.$drmVarianted->size.')');
                                    //                                                }if($drmVarianted->materials){
                                    //                                                    print (' - material ('.$drmVarianted->materials.')');
                                    //                                                }
                                    print ($drmVarianted->title);
                                    ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                <?php } ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#varianted_option").on('change',function(){
                            let price = $(this).find('option:selected').val();
                            $.ajax({
                                type: "POST",
                                url: "<?=api_url('variantWithUpselling')?>",
                                data:{product_id : <?php print content_id(); ?> },
                                success: function(response) {
                                    upsellingPrice = response.message;
                                    var total = parseFloat(price) + parseFloat(upsellingPrice);
                                    $("#totalAmount").html(total.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }));
                                    $("#totalPrice").val(price);
                                },
                                error: function(response){
                                    $("#totalAmount").html( parseFloat(price).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }));
                                    $("#totalPrice").val(price);
                                }
                            });


                            // let price = $(this).find('option:selected').val();
                            // var upsellingPrice = "<?php if(empty($upsellingPrice)){ echo '';}else{ echo $upsellingPrice;} ?>"

                            // if(upsellingPrice){
                            //     var total = parseFloat(price) + parseFloat(upsellingPrice);
                            //     $("#totalAmount").html(total.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }))
                            // }else{
                            //     $("#totalAmount").html( parseFloat(price).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }))
                            // }

                        })
                    });
                    $("#varianted_option").on("change", function(){
                        var dataid = $("#varianted_option option:selected").attr('data-id');
                        document.getElementById("drm_variant_id").value = dataid;
                    });
                    $("#varianted_option").on("change", function(){
                        var stock = $("#varianted_option option:selected").attr('data-stock');
                        var stock_button = "<i class='fa fa-cart-plus' aria-hidden='true'></i>Out of stock";
                        var Add_button = "<i class='fa fa-cart-plus' aria-hidden='true'></i>in den Warenkorb";
                        if(stock == 0){
                            document.getElementById("addCartBtn").innerHTML = stock_button;
                            document.getElementById("addCartBtn").disabled = true;
                        }else{
                            document.getElementById("addCartBtn").innerHTML = Add_button;
                            document.getElementById("addCartBtn").disabled = false;
                        }
                    });
                </script>

                <!-- end varianted code -->
                <div class="item-price">
                    <?php if(floatval($data['price']) > 0): ?>
                        <?php

                        $keyslug_class = str_slug(strtolower($key));


                        // $key = $price_offers[$key]['offer_price'];

                        ?>

                        <?php if (is_string($key) and trim(strtolower($key)) == 'price'): ?>

                            <span class="mw-price-item-key mw-price-item-key-<?php print ($keyslug_class); ?>" style="font-size: 16px;font-weight:600;text-transform:capitalize;">
                            Preis:
                        </span>
                        <?php else: ?>
                            <span class="mw-price-item-key mw-price-item-key-<?php print ($keyslug_class); ?>" style="font-size: 16px;font-weight:600;text-transform:capitalize;">
                            <?php print $key; ?>:
                        </span>
                        <?php endif; ?>


                        <!--                                        //offer price-->
                        <?php

                        if (isset($offer['price']['offer_price'])) {
                            $val4 = $offer['price']['price'];
                            $val4 = normalPrice($val4);
                            // $val4 = $val4 + taxPrice($val4);
                            if (isset($in_stock) && $in_stock != false) {
                            ?>

                            <div class="dt-old-price">
                                <p><?php print currency_format(roundPrice($val4)); ?></p>
                            </div>

                            <?php
                            }
                        }?>

                        <span class="mw-price-item-value" id="totalAmount"><?php print currency_format($v); ?></span>
                        <?php if(!empty($data_product['item_unit']) && !empty($data_product['item_weight'])): ?>
                            <?php
                                if($data_product['item_unit'] == 'Gram' || $data_product['item_unit'] == 'Milliliter'){
                                    $product_base_price = (1000/(float)$data_product['item_weight'])*$v;
                                }elseif($data_product['item_unit'] == 'Centimeter'){
                                    $product_base_price = (100/(float)$data_product['item_weight'])*$v;
                                }else{
                                    $product_base_price = (1/(float)$data_product['item_weight'])*$v;
                                }
                                //base unit set for product
                                if($data_product['item_unit'] == 'Gram' || $data_product['item_unit'] == 'Kilogram'){
                                    $item_unit = 'Kilogram';
                                }elseif($data_product['item_unit'] == 'Milliliter' || $data_product['item_unit'] == 'Liter'){
                                    $item_unit = 'Liter';
                                }elseif($data_product['item_unit'] == 'Centimeter' || $data_product['item_unit'] == 'Meter'){
                                    $item_unit = 'Meter';
                                }
                            ?>
                            <span id="product-base-price">(<?php print currency_format($product_base_price);  ?> / <?php print $item_unit; ?>)</span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <input type="hidden" id="totalPrice" value="<?php print $v; ?>">
                </div>
                <div class="product-tax-text" style="">

                    <?php if($v > 0): ?>
                        <span class="edit">
                            inkl. <?php (is_logged()) ? print (int)taxRateCountry(user_id(),CONTENT_ID) : print taxRate(CONTENT_ID)?>% MwSt.
                        </span>
                        <span data-toggle="modal" data-target="#termModal" style="margin-left:5px;display:inline-block;">
                            zzgl. Versand
                        </span>
                    <?php endif; ?>
                    <?php
                    $is_checked = get_option('handlingtime', 'handlingtime_show_hide');
                    if(isset($data_product['delivery_days']) and !empty($data_product['delivery_days']) and $data_product['delivery_days'] != 0):
                        if(isset($is_checked) and $is_checked == 1) :
                            if(function_exists('handling_time')): ?>
                                <br><span class="">
                            <?php print handling_time($data_product['delivery_days']); ?>
                        </span>
                            <?php endif; endif; endif;  ?>
                </div>

                <div class="item-cart">
                    <?php if (is_logged()) { ?>
                        <?php if (get_option('enable_wishlist', 'shop')) : ?>
                            <div style="" class="product-inner-wishlist">
                                <span class="material-icons wishlist-logo" id="wishlist_item_icon">favorite_border</span>
                                <label for="wishlist-select"></label>
                                <select id="wishlist-select" class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                </select>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                    <div class="item-cart-button">
                        <?php if (!isset($in_stock) or $in_stock == false) : ?>
                            <button class="btn btn-default pull-right" type="button" disabled="disabled"
                                    onclick="Alert('<?php print addslashes(_e('This item is out of stock and cannot be ordered', true)); ?>');">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <?php _e("Out Of Stock"); ?>
                            </button>
                        <?php elseif(!(floatval($data['price']) > 0)): ?>
                            <button class="btn btn-default" onclick="priceModal(); price_on_request_product_id_get(<?php print CONTENT_ID; ?>,'<?=$data_product['title']?>')"><?php _e('Price On Request'); ?></button>
                        <?php else: ?>
                            <button class="btn btn-default add-cart-btn product-cart-icon" id="addCartBtn" type="button"
                                    onclick="mw.cart.add('.mw-add-to-cart-<?php print $params['id'] ?>','<?php print $v ?>', '<?php print $title; ?>','subscription'); <?php if(isset(mw()->user_manager->session_get('bundle_product_checkout')[0]['bundle_option']) && $update_global_bundle_discount_condition == 0) { ?>carttoggole();<?php }else{ ?>carttoggolee();<?php } ?>">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                <?php _e($button_text !== false ? $button_text : "in den Warenkorb"); ?>
                            </button>
                        <?php endif; ?>
                    </div>
                    <!--Seo related all function are here added by zunaid and requirements from stefan  -->
                    <?php
                    if (function_exists('dt_google_analytical_product_script')) {
                        dt_google_analytical_product_script(content_id(), $v);
                    }


                    if (function_exists('dt_google_analytical_view_item')) {
                        dt_google_analytical_view_item(content_id(), $v);
                    }

                    // End here seo all function

                    if (isset($offer['price']['offer_price']) && $offer['price']['expires_at'] != 0) {
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





                <?php $i++; ?>


            </div>
        <?php if ($i > 1) : ?>
        <br/>
        <?php endif; ?>
            <?php $i++; endforeach; ?>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function(){
        $('.js-example-basic-multiple').select2();
        $('#price-on-request-modal').on('show.bs.modal', function (e) {
            $(".zoomContainer").css("z-index","0");
        })
        $('#price-on-request-modal').on('hide.bs.modal', function (e) {
            $(".zoomContainer").css("z-index","3");
        })
    });
</script>
<script type="text/javascript">
    <?php if (is_logged()) { ?>

    $(document).ready(() => {

        let $wishlist_input = $("#wishlist-select");

        $.get(`<?= api_url('get_wishlist_sessions'); ?>`, result => {

            $wishlist_input.empty();
            $wishlist_input.append('<option disabled value="null"></option>');

            let pId = `<?= $params['id']; ?>`;
            pId = pId.split('-');
            pId = pId[pId.length - 1];

            const selected = [];
            if(result!='false'){
                result.forEach(function (session) {
                    $wishlist_input.append('<option id="wishlist-select-' + session['id'] + '" value=' + session['id'] + '>' + session['name'] + '</option>');
                    session['products'].forEach(function (prod) {
                        if (parseInt(prod['product_id']) === parseInt(pId)) {
                            selected.push(session.id.toString())
                        }
                    })
                });
            }
            if(selected.length){
                $("#wishlist-select").val(selected).trigger("change");
                $('#wishlist_item_icon').text('favorite');
            }

        });
    });
    // wishlist_details();

    // function wishlist_details() {
    //     if (wishlist.length === 0) {
    //         $(".wishlist-logo").text("favorite_border");
    //     }
    //     else{
    //         $("#wishlist-logo").text("favorite");
    //     }
    // }

    let wishlist = $("#wishlist-select");
    wishlist.on('select2:select', function (e) {
        let data = e.params.data;
        let pId = `<?= $params['id']; ?>`;
        pId = pId.split('-');
        pId = pId[pId.length - 1];
        $.post("<?php print api_url('add_wishlist_sessions'); ?>", {productId: pId, sessionId: data.id}, () => {
        }).then(res => {
            $('#wishlist_item_icon').text('favorite');
            let selected_item = $("#wishlist-select").val();
            if(!selected_item.length){

                $('#wishlist_item_icon').text('favorite_border');
            }
        });
    });

    wishlist.on('select2:unselect', function (e) {
        let data = e.params.data;
        let pId = `<?= $params['id']; ?>`;
        pId = pId.split('-');
        pId = pId[pId.length - 1];
        $.post("<?php print api_url('remove_wishlist_sessions'); ?>", {productId: pId, sessionId: data.id}, () => {
        }).then(res => {
            let selected_item = $("#wishlist-select").val();
            if(!selected_item.length){
                $('#wishlist_item_icon').text('favorite_border');
            }
        });
    });
    <?php } ?>




</script>

<div class="edit" field="products-secondery-descriptions" rel="content">
    <module type="layouts" template="empty"/>
</div>
