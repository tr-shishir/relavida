<?php

/*

type: layout

name: Big

description: Full width cart template

*/

?>
<script src="<?php print modules_url(); ?>admin/sweetalert/sweetalert.min.js"></script>
<style>
    label {
        display: inline-block;
        margin-bottom: .5rem;
        font-weight: 800;
        font-size: 16px;
    }
    .cell-cart-price-total-subtotal{
        font-weight:bold;
    }
    .checkout-total-table-row{
        justify-content:flex-end;
    }

    .checkout-total-table td {
        text-align: right;
    }

    .checkout-total-table {
        table-layout: fixed;
    }

    .checkout-total-table label {
        display: block;
        text-align: left;
        font-weight: inherit;
    }

    .cell-shipping-total,
    .cell-shipping-price {
        text-align: right;
    }

    .total_cost {
        font-weight: normal;
    }
    .checkout-total-table td label,
    .checkout-total-table td{
        font-size:16px !important;
    }
    .input-group.qtyw {
        position: relative;
        min-width: 150px;
    }

    @media screen and (max-width: 450px){
        .ch-checkbox{
            flex-direction: column;
            align-items: flex-start !important;
        }
    }
</style>
<div class="mw-cart mw-cart-big mw-cart-<?php print $params['id'] ?> <?php print  $template_css_prefix; ?>">
    <div class="mw-cart-title mw-cart-<?php print $params['id'] ?>">
        <h3 class="">
            Mein Warenkorb
        </h3>
    </div>
    <?php
    $bumbs = true;
    $shop_require_terms = get_option('shop_require_terms', 'website') ?? null;
    if(isset($_GET['slug'])) {

        $pro_ids = DB::table('quick_checkout')->where('slug', '=', $_GET['slug'])->first()->products_id;

        $data = \App\Models\Content::with('media','contentData','customField','categoryItem')
            ->where('content.id','=',$pro_ids)
            ->first()->toArray();

//dd($data['media']);
        $price = DB::table('custom_fields')
            ->join('custom_fields_values', 'custom_fields.id', '=', 'custom_fields_values.custom_field_id')
            ->where('custom_fields.rel_id', '=', $pro_ids)
            ->where('custom_fields.rel_type', '=', 'content')
            ->where('custom_fields.type', '=', 'price')
            ->first();
//        dd($price-);


    }

    $subProduct=null;
    $sub_interval=null;
    $u_id = user_id() ?? 0;
    if(session_id() == ''){
        session_start();
    }
    $u_session = session_id();
    $sub=DB::table('subscription_order_status')->where('order_id',null)->where('user_id', $u_id)->where('session_id', $u_session)->first();
    if ($sub!=null  && $data!=null) {
        $sub_interval = DB::table('subscription_items')->select('sub_interval')->where('id',$sub->subscription_id)->first();
        // dd($sub_interval->sub_interval);
        foreach ($data as $key) {
            if ($key['rel_id'] == $sub->product_id) {
                $subProduct= get_cart("rel_id=$sub->product_id");
                break;
            }

        }
    }
    if($subProduct!=null){
        // dd($subProduct);
        $data=$subProduct;
    }

    $module_id = explode('cart_checkout_',$params['id']);
    $module_id = end($module_id);
    $single_checkout_product = DB::table('single_checkout_products')->where('module_id', $module_id)->first();
    $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    $total = cart_sum();
    $value_need_to_reduce = 0;

    if($single_checkout_product){
        $single_product_cart = get_cart("rel_id=$single_checkout_product->product_id");
        $data=$single_product_cart;
    }
    $upsellingCount=DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count();
    if (is_array($data) && !empty($data)) :

        if( @mw()->user_manager->session_get('bundle_product_checkout') ){
            $all_bundle_details = mw()->user_manager->session_get('bundle_product_checkout');

            foreach($all_bundle_details as $key => $bundle_details){
                if(isset($bundle_details['bundle_products'])){
                    $ids_bundle = collect($bundle_details['bundle_products'])->pluck('product_id')->toArray();

                    $id_qty = collect($bundle_details['bundle_products'])->pluck('product_qty')->toArray();
                    $ids_qty = array_combine($ids_bundle, $id_qty);
                    $bundle_data=collect($data)->whereIn('rel_id',$ids_bundle)->toArray();

                    $m_qty = collect($bundle_details['bundle_products'])->pluck('minimum_p')->toArray();
                    $ids_m_qty = array_combine($ids_bundle, $m_qty);
                    $data=collect($data)
                    ->map(function($q) use ($ids_bundle){
                        if(in_array($q['rel_id'],$ids_bundle)){
                            $q['b'] = true;
                        }
                        return $q;
                    })
                    ->toArray();
                    if(empty($bundle_data)){

                        if(mw()->user_manager->session_get('bundle_product_checkout')){
                            $session_data_bundle = mw()->user_manager->session_get('bundle_product_checkout');
                            unset($session_data_bundle[$key]);
                            mw()->user_manager->session_set('bundle_product_checkout',$session_data_bundle);
                            ?>
                            <script>
                                $(".bundle-cart<?=$key?>").css("display:none;");
                                mw.reload_module('shop/cart');
                            </script>
                            <?php
                        }

                    }
                    ?>
                    <div class="bundle-cart  bundle-cart<?=$key?> bundle-div-id-<?php print $bundle_details['id']; ?>">
                        <div class="bundle-cart-heading">
                            <p style="margin-bottom:10px;text-align:left">
                                <b>Bundle:</b>
                                <strong class="text_q_c_o"><?=$bundle_details['title']?> <br class="d-none d-sm-block"></strong>
                            </p>
                        </div>
                        <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table cart-table checkout-page-cart-table" >
                            <colgroup>
                                <!-- <col width="80"> -->
                                <!-- <col width="200"> -->
                                <!-- <col width="100"> -->
                                <?php if(!isset($_GET['slug'])) { ?>
                                    <!-- <col width="140"> -->
                                <?php } ?>
                            </colgroup>
                            <thead>
                            <tr>
                                <th style="min-width:70px">Bild</th>
                                <th class="mw-cart-table-product" style="">Produktname</th>
                                <?php if(!isset($_GET['slug'])) { ?>
                                    <th style="width:200px">Menge</th>
                                <?php } ?>
                                <th>Preis</th>
                                <?php if($upsellingCount > 0): ?>
                                    <th>Servicepreis</th>
                                <?php endif; ?>
                                <th>Gesamt</th>
                                <th>Löschen</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(!isset($_GET['slug'])){
                                // dd($data);
                                // google tracking function is here
                                if(function_exists('dt_google_analytical_checkout')){
                                    dt_google_analytical_checkout($data);
                                }
                                //End google tracking function

                                $tx=collect($data);

                                $txx = $tx->pluck('rel_id');
                                //$tx[] = collect($data)->pluck('rel_id');
                                $default_tax = null;
                                if(count($data)){
                                    $default_tax = single_tax($txx);
                                }
                                $i = 0;
                                foreach ($bundle_data as $item) :

                                    if(DB::table('checkout_bumbs')->where('product_id',$item['rel_id'])->get()->count()){
                                        $bumbs = false;
                                    }
                                    // dd();
                                    // dd(get_content_by_id($item['rel_id']));

                                    //$total += $item['price']* $item['qty'];
                                    ?>
                                    <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?> bundle-id-<?php print $bundle_details['id']; ?> bundle-id-tr-<?php print $bundle_details['id']; ?>">
                                        <td><?php  if (isset($item['item_image']) and $item['item_image'] != false): ?>
                                                <?php $p = $item['item_image']; ?>
                                            <?php else:

                                                $p = get_picture($item['rel_id']);

                                                ?>
                                            <?php endif;?>
                                            <?php if ($p != false): ?>
                                                <img height="70"
                                                    class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>"
                                                    src="<?php print thumbnail($p, 70, 70); ?>" />
                                            <?php endif; ?></td>
                                        <td class="mw-cart-table-product">
                                            <p style="font-weight:bold;margin-bottom:10px;word-break: break-word;">
                                                <?php print $item['title'] ?>
                                                <?php if (isset($item['custom_fields'])): ?>
                                                    <?php print $item['custom_fields'] ?>
                                                <?php endif ?>

                                            </p>
                                            <p class="mw-cart-table-product-info">
                                        <span>
                                            <strong>Item Number:</strong> <?php if($item['rel_id'] != null){ print $item['rel_id']; }else{ print "XXX" ;}?>
                                        </span>
                                                <span>
                                            <strong>EAN:</strong> <?php if(get_content_by_id($item['rel_id'])['ean'] != null){ print get_content_by_id($item['rel_id'])['ean']; }else{ print "XXX" ; } ?>
                                        </span>
                                                <!-- <span>
                                                    <strong>Brand:</strong> xaoimi
                                                </span>
                                                <span>
                                                    <strong>Color:</strong> Red
                                                </span> -->
                                            </p>
                                        </td>
                                        <input type="hidden" min="1" id="p_id_val" class="input-mini form-control input-sm" value="<?php print $item['rel_id'] ?>"/>
                                        <input type="hidden" min="1" id="p_tax" class="input-mini form-control input-sm" value="<?php if(isset($default_tax)) print $default_tax ?>"/>

                                        <?php if(!isset($_GET['slug'])) {
                                            $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
                                            ?>
                                            <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                                            <td class="product-quantity_number">
                                                <div class="input-group">
                                                    <input type="button" value="-" class="button-minus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_minusss'.$item['id'] : print 'minusss'.$item['id'];?>">
                                                    <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                                    <input type="button" value="+" class="button-plus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_plusss'.$item['id'] : print 'plusss'.$item['id'];?>">
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php
                                        /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                                        <script>

                                            $("#b_plusss<?=$item['id']?>").on('click', function(e) {
                                                if(<?=$bundle_details['bundle_option']?> == 1){
                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                    currentVal = parseInt(currentVal)+1;
                                                    mw.cart.qty(id,currentVal);
                                                    $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                        if(res.success){
                                                            $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                            $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                            $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                            $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                            $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                        }
                                                    });
                                                }else{
                                                    if(<?php if(isset($ids_qty[$item['rel_id']])){ print (int)$ids_qty[$item['rel_id']]; } ?> <= $("#qty<?=$item['id']?>").val()){
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)+1;
                                                        mw.cart.qty(id,currentVal);
                                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                            if(res.success){
                                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                            }
                                                        });
                                                    }else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)+1;
                                                        mw.cart.qty(id,currentVal);
                                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                            if(res.success){
                                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                            }
                                                        });
                                                    }
                                                }


                                            });
                                            $("#b_minusss<?=$item['id']?>").on('click', function(e) {
                                                if(<?=$bundle_details['bundle_option']?> == 1){
                                                    if($('.bundle-id-<?php print $bundle_details['id']; ?>').length == 1 && <?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('You can keep the current quantity and still order with a discount, or remove the product / bundle from your cart'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove from cart'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    remove_cart_data(id);
                                                                    $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                                        if(res.success){
                                                                            $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                            $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                            $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                            $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                            $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                    }else if($('.bundle-id-<?php print $bundle_details['id']; ?>').length > 1 && <?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('You can keep the current quantity, or remove the product from your cart. In both cases you`ll still receive a bundle-discount.'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove from cart'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    remove_cart_data(id);
                                                                    $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                                        if(res.success){
                                                                            $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                            $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                            $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                            $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                            $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                    } else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
                                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                            if(res.success){
                                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                            }
                                                        });
                                                    }
                                                }else{
                                                    if(<?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('If you reduce the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Reduce quantity'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    currentVal = parseInt(currentVal)-1;
                                                                    mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        mw.cart.qty(id,currentVal);
                                                                        location.reload()
                                                                        mw.reload_module('shop/checkout');
                                                                    });
                                                                }
                                                                else {
                                                                    mw.reload_module('shop/cart/quick_checkout');
                                                                }
                                                            });
                                                    }else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
                                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                            if(res.success){
                                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                            }
                                                        });
                                                    }

                                                }
                                            });

                                            $("#plusss<?=$item['id']?>").on('click', function(e) {
                                                var currentVal = $("#qty<?=$item['id']?>").val()
                                                var id = $("#id_val<?=$item['id']?>").val();
                                                currentVal = parseInt(currentVal)+1;
                                                mw.cart.qty(id,currentVal);
                                                $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                if(res.success){
                                                    $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                    $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                    $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                    $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                    $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                }
                                            });
                                            });
                                            $("#minusss<?=$item['id']?>").on('click', function(e) {
                                                if(<?=$bundle_details['bundle_option']?> == 1){
                                                    if($('.bundle-id-<?php print $bundle_details['id']; ?>').length == 1 && <?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('You can keep the current quantity and still order with a discount, or remove the product / bundle from your cart'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove from cart'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    remove_cart_data(id);
                                                                    $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                                        if(res.success){
                                                                            $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                            $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                            $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                            $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                            $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                    }else if($('.bundle-id-<?php print $bundle_details['id']; ?>').length > 1 && <?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('You can keep the current quantity, or remove the product from your cart. In both cases you`ll still receive a bundle-discount.'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove from cart'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    remove_cart_data(id);
                                                                    $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                                        if(res.success){
                                                                            $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                            $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                            $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                            $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                            $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                    } else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
                                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                            if(res.success){
                                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                            }
                                                        });
                                                    }
                                                }else{
                                                    if(<?php if(isset($ids_m_qty[$item['rel_id']])){ print (int)$ids_m_qty[$item['rel_id']]; } ?> >= $("#qty<?=$item['id']?>").val()){
                                                        swal({
                                                            text: "<?php _e('The minimum order quantity of this item is'); ?>"+" <?php print (int)$ids_m_qty[$item['rel_id']].'. '; ?>"+"<?php _e('If you reduce the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Reduce quantity'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    currentVal = parseInt(currentVal)-1;
                                                                    mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        mw.cart.qty(id,currentVal);
                                                                        location.reload()

                                                                    });
                                                                }
                                                                else {
                                                                    mw.reload_module('shop/cart');
                                                                }
                                                            });
                                                    }

                                                }

                                            });
                                        </script>
                                        <td class="mw-cart-table-price">
                                            <?php

                                            $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                                            $servicePrice = 0;
                                            if($selectedUpselling->count()){
                                                foreach($selectedUpselling as $selectValue){
                                                    $servicePrice = $servicePrice + $selectValue->service_price;
                                                }
                                                $servicePrice = $servicePrice + taxPrice($servicePrice,null,$item['rel_id']);
                                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id'],$default_tax);

                                            }
                                            else{
                                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id'],$default_tax);
                                            }

                                            ?>
                                            <?php  print currency_format(roundPrice($item['price'])); ?></td>
                                        <?php if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0): ?>
                                            <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                                        <?php endif; ?>

                                        <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) + $servicePrice) * $item['qty']); ?></td>

                                        <td><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash"
                                            href="javascript:bundle_remove_cart_data('<?php print $item['id'] ?>','<?php print $bundle_details['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                            <script>
                                            function bundle_remove_cart_data(id, bid){
                                                if(<?=$bundle_details['bundle_option']?> == 1){
                                                    if($('.bundle-id-tr-'+bid).length == 1){
                                                        jQuery('.bundle-div-id-'+bid).remove();
                                                        data = {
                                                                key:'bundle_product_checkout',
                                                                key1 :bid
                                                            };
                                                            $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                remove_cart_data(id);
                                                                mw.reload_module('shop/checkout');
                                                            });
                                                        } else{
                                                            remove_cart_data(id);
                                                        }

                                                    }else{
                                                        swal({
                                                            text: "<?php _e('If you remove the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>"+".",
                                                            dangerMode: true,
                                                            buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove Quantity'); ?>"],
                                                            })
                                                            .then((willDelete) => {
                                                                if (willDelete) {
                                                                    mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        sessionStorage.setItem('cart_update_for_bundle_product', 'false');
                                                                        mw.cart.remove(id)
                                                                        location.reload();
                                                                    });
                                                                }
                                                                else {
                                                                    mw.reload_module('shop/cart');
                                                                }
                                                            });
                                                    }
                                            }
                                            </script>
                                    </tr>
                                <?php $i++; endforeach;
                            }else{?>


                                <tr class="mw-cart-item mw-cart-item-<?php print $data['id'] ?>">
                                    <td><?php  if (isset($data['item_image']) and $data['item_image'] != false): ?>
                                            <?php $p = $data['item_image']; ?>
                                        <?php else:

                                            $p = get_picture($data['id']);
                                            ?>
                                        <?php endif;
                                        //                            @dump($p);?>
                                        <?php if ($p != false): ?>
                                            <img height="70"
                                                class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $data['id']; ?>"
                                                src="<?php print thumbnail($p, 70, 70); ?>" />
                                        <?php endif; ?></td>
                                    <td class="mw-cart-table-product"><?php print $data['title'] ?>
                                        <?php if (isset($data['custom_fields'])): ?>
                                            <?php print $data['custom_fields'] ?>
                                        <?php endif ?></td>



                                    <td class="mw-cart-table-price"><?php print currency_format($price->value); ?></td>

                                </tr>

                            <?php } ?>

                            </tbody>
                        </table>

                        <div class="bundle-discount">
                            <p style="margin-bottom:10px;text-align:left;font-size: 18px;color: green;"><strong class="text_q_c_o">Ersparnis: <?php
                                // $taxam = 0; $tax= mw()->tax_manager->get();
                                // !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                                // $total = $total + ($taxam*$total)/100;
                                print currency_format($bundle_details['offer_discount']);
                                $value_need_to_reduce = $value_need_to_reduce+$bundle_details['offer_discount'];
                                ?></strong>
                            </p>
                        </div>
                    </div>

                    <?php
                }
            }
        }
        $all_or_not = collect($data)->where('b', '!=' , true)->toArray();

        ?>

        <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table cart-table checkout-page-cart-table" <?php if(empty($all_or_not)){
            ?>
            style="display:none;"
            <?php } ?>>
            <colgroup>
                <!-- <col width="80"> -->
                <!-- <col width="200"> -->
                <!-- <col width="100"> -->
                <?php if(!isset($_GET['slug'])) { ?>
                    <!-- <col width="140"> -->
                <?php } ?>
            </colgroup>
            <thead>
            <tr>
                <th style="min-width:70px">Bild</th>
                <th class="mw-cart-table-product" style="">Produktname</th>
                <?php if(!isset($_GET['slug'])) { ?>
                    <th style="width:200px">Menge</th>
                <?php } ?>
                <th>Preis</th>
                <?php if($upsellingCount > 0): ?>
                    <th>Servicepreis</th>
                <?php endif; ?>
                <th>Gesamt</th>
                <th>Löschen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!isset($_GET['slug'])){
                // dd($data);
                // google tracking function is here
                if(function_exists('dt_google_analytical_checkout')){
                    dt_google_analytical_checkout($data);
                }
                //End google tracking function

                $tx=collect($data);

                $txx = $tx->pluck('rel_id');
                //$tx[] = collect($data)->pluck('rel_id');
                $default_tax = null;
                if(count($data)){
                    $default_tax = single_tax($txx);
                }

                foreach ($data as $item) :

                    if(DB::table('checkout_bumbs')->where('product_id',$item['rel_id'])->get()->count()){
                        $bumbs = false;
                    }
                    // dd();
                    // dd(get_content_by_id($item['rel_id']));

                    //$total += $item['price']* $item['qty'];
                    ?>
                    <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?>" <?php if(isset($item['b']) && $item['b'] == true){ ?> style="display:none"<?php } ?>>
                        <td><?php  if (isset($item['item_image']) and $item['item_image'] != false): ?>
                                <?php $p = $item['item_image']; ?>
                            <?php else:

                                $p = get_picture($item['rel_id']);

                                ?>
                            <?php endif;?>
                            <?php if ($p != false): ?>
                                <img height="70"
                                     class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>"
                                     src="<?php print thumbnail($p, 70, 70); ?>" />
                            <?php endif; ?></td>
                        <td class="mw-cart-table-product">
                            <p style="font-weight:bold;margin-bottom:10px;word-break: break-word;">
                                <?php print $item['title'] ?>
                                <?php if (isset($item['custom_fields'])): ?>
                                    <?php print $item['custom_fields'] ?>
                                <?php endif ?>

                            </p>
                            <p class="mw-cart-table-product-info">
                        <span>
                            <strong>Item Number:</strong> <?php if($item['rel_id'] != null){ print $item['rel_id']; }else{ print "XXX" ;}?>
                        </span>
                                <span>
                            <strong>EAN:</strong> <?php if(get_content_by_id($item['rel_id'])['ean'] != null){ print get_content_by_id($item['rel_id'])['ean']; }else{ print "XXX" ; } ?>
                        </span>
                                <!-- <span>
                                    <strong>Brand:</strong> xaoimi
                                </span>
                                <span>
                                    <strong>Color:</strong> Red
                                </span> -->
                            </p>
                        </td>
                        <input type="hidden" min="1" id="p_id_val" class="input-mini form-control input-sm" value="<?php print $item['rel_id'] ?>"/>
                        <input type="hidden" min="1" id="p_tax" class="input-mini form-control input-sm" value="<?php if(isset($default_tax)) print $default_tax ?>"/>

                        <?php if(!isset($_GET['slug'])) {
                            $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
                            ?>
                            <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                            <td class="product-quantity_number">
                                <div class="input-group">
                                    <input type="button" value="-" class="button-minus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_minuss'.$item['id'] : print 'minuss'.$item['id'];?>">
                                    <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                    <input type="button" value="+" class="button-plus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_pluss'.$item['id'] : print 'pluss'.$item['id'];?>">
                                </div>
                            </td>
                        <?php } ?>
                        <?php
                         /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                        <script>
                            $("#b_pluss<?=$item['id']?>").on('click', function(e) {
                                swal({
                                    text: "<?php _e('If you increase the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>"+".",
                                    dangerMode: true,
                                    buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Increase quantity'); ?>"],
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            var currentVal = $("#qty<?=$item['id']?>").val()
                                            var id = $("#id_val<?=$item['id']?>").val();
                                            currentVal = parseInt(currentVal)+1;
                                            mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                            $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                                                mw.cart.qty(id,currentVal);
                                                mw.reload_module('shop/cart');
                                                $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                    if(res.success){
                                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                        $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                    }
                                                });
                                                location.reload();
                                            });
                                        }
                                    });
                            });
                            $("#b_minuss<?=$item['id']?>").on('click', function(e) {
                                swal({
                                    text: "<?php _e('If you reduce the product quantity then you won\'t get the bundle offer! Do you still want to increase the quantity'); ?>"+".",
                                    dangerMode: true,
                                    buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Reduce quantity'); ?>"],
                                    })
                                    .then((willDelete) => {
                                        if (willDelete) {
                                            var currentVal = $("#qty<?=$item['id']?>").val()
                                            var id = $("#id_val<?=$item['id']?>").val();
                                            currentVal = parseInt(currentVal)-1;
                                            mw.notification.success('<?php _e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                            $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                                                mw.cart.qty(id,currentVal);
                                                mw.reload_module('shop/cart');
                                                $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                    if(res.success){
                                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                        $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                    }
                                                });
                                                location.reload();
                                            });
                                        }
                                    });
                            });

                            $("#pluss<?=$item['id']?>").on('click', function(e) {

                                // console.log("fsdf");
                                var currentVal = $("#qty<?=$item['id']?>").val()
                                var id = $("#id_val<?=$item['id']?>").val();

                                currentVal = parseInt(currentVal)+1;
                                mw.cart.qty(id,currentVal);
                                mw.reload_module('shop/cart');
                                $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                    if(res.success){
                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                        $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                    }
                                });
                            });
                            $("#minuss<?=$item['id']?>").on('click', function(e) {
                                if($("#qty<?=$item['id']?>").val() == 1){
                                    swal({
                                        text: "<?php _e('Please use the trashcan icon to remove a product from the cart'); ?>",
                                        dangerMode: true,
                                        buttons: ["<?php _e('Keep Quantity'); ?>", "<?php _e('Remove Quantity'); ?>"],
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                var id = $("#id_val<?=$item['id']?>").val();
                                                remove_cart_data(id);
                                                mw.reload_module('shop/cart');
                                                $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                                    if(res.success){
                                                        $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                        $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                        $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                        $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                        $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                                    }
                                                });
                                            }
                                        });
                                    } else{
                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                        var id = $("#id_val<?=$item['id']?>").val();
                                        currentVal = parseInt(currentVal)-1;
                                        mw.cart.qty(id,currentVal);
                                        mw.reload_module('shop/cart');
                                        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$("#country_set").val(),product:$("#p_id_val").val(),taxr:$("#p_tax").val() }, (res) => {
                                            if(res.success){
                                                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                                                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                                                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                                                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                                                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                                            }
                                        });
                                    }
                            });
                        </script>
                        <td class="mw-cart-table-price">
                            <?php

                            $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                            $servicePrice = 0;
                            if($selectedUpselling->count()){
                                foreach($selectedUpselling as $selectValue){
                                    $servicePrice = $servicePrice + $selectValue->service_price;
                                }
                                $servicePrice = $servicePrice + taxPrice($servicePrice,null,$item['rel_id']);
                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id'],$default_tax);

                            }
                            else{
                                $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id'],$default_tax);
                            }

                            ?>
                            <?php  print currency_format(roundPrice($item['price'])); ?></td>
                        <?php if(DB::table("selected_product_upselling_item")->where('user_id',user_id())->get()->count() > 0): ?>
                            <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                        <?php endif; ?>

                        <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) + $servicePrice) * $item['qty']); ?></td>

                        <td><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash"
                               href="javascript:remove_cart_data('<?php print $item['id'] ?>');"><i class="fa fa-trash"
                                                                                                  aria-hidden="true"></i></a></td>
                    </tr>
                <?php endforeach;
            }else{?>


                <tr class="mw-cart-item mw-cart-item-<?php print $data['id'] ?>">
                    <td><?php  if (isset($data['item_image']) and $data['item_image'] != false): ?>
                            <?php $p = $data['item_image']; ?>
                        <?php else:

                            $p = get_picture($data['id']);
                            ?>
                        <?php endif;
                        //                            @dump($p);?>
                        <?php if ($p != false): ?>
                            <img height="70"
                                 class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $data['id']; ?>"
                                 src="<?php print thumbnail($p, 70, 70); ?>" />
                        <?php endif; ?></td>
                    <td class="mw-cart-table-product"><?php print $data['title'] ?>
                        <?php if (isset($data['custom_fields'])): ?>
                            <?php print $data['custom_fields'] ?>
                        <?php endif ?></td>



                    <td class="mw-cart-table-price"><?php print currency_format($price->value); ?></td>

                </tr>

            <?php } ?>

            </tbody>
        </table>

        <div>
            <?php if(DB::table('checkout_bumbs')->where('show_checkout',1)->get()->count()): ?>
                <?php if($bumbs): ?>
                    <module type="shop/Checkout_Bumbs" template="checkout_bumbs" />
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div style="margin-top:20px; line-height: 20px;" class="checkout-checkbox">
            <?php $terms=true; $terms2=true; $terms3=true; ?>
            <?php if ($terms): ?>
                <script>
                    $(document).ready(function () {

                        terms('#i_agree_with_terms_1');
                    });

                    function terms(id) {
                        $(id).click(function () {
                            let el = $('#i_agree_with_terms_1');
                            let el2 = $('#i_agree_with_terms_2');
                            let el3 = $('#i_agree_with_terms_3');
                            if (el.is(':checked') && el2.is(':checked')) {
                                $('#complete_order_button').removeAttr('disabled');
                            } else {
                                $('#complete_order_button').attr('disabled', 'disabled');

                            }
                        });
                    }

                </script>
                <style>
                    .mw-link-tip-edit{
                        display: none !important;
                    }
                </style>
                <div style="display:flex;justify-content:flex-end;" id="i_agree_with_terms_row">

                    <div class="ch-checkbox" style="display:flex;align-items:center">
                        <?php if ($shop_require_terms == 1) : ?>
                            <span class="edit" field="content1" rel="page1" style="margin-right: 5px;"><input class="form-check-input" type="checkbox" value="" id="agreeterm"><?php _e('Ich akzeptiere die'); ?></span>
                        <?php endif ?>
                        <div class="edit" field="checkout_term_agb" rel="content">
                            <a href="<?php print site_url('agb') ?>" target="_blank" style="color:#309be3;line-height:20px;">Allgemeinen Geschäftsbedingungen</a>
                        </div>
                    </div>

                </div>
            <?php endif; ?>


            <?php if ($terms2): ?>
                <script>
                    $(document).ready(function () {
                        terms('#i_agree_with_terms_2');
                    });

                </script>
                <div style="display:flex;margin-top:10px;justify-content:flex-end;" id="i_agree_with_terms_row">
                    <div class="ch-checkbox" style="display:flex;align-items:center">
                        <?php if ($shop_require_terms == 1) : ?>
                            <span class="edit" field="content2" rel="page2" style="margin-right: 5px;"><input class="form-check-input" type="checkbox" value="" id="agreecondition"><?php _e('Ich habe das'); ?></span>
                        <?php endif ?>
                        <div class="edit" field="checkout_term_widerrufsrecht" rel="content">
                            <a href="<?php print site_url('widerrufsrecht') ?>" target="_blank" style="color:#309be3">Widerrufsrecht zur
                                Kenntnis genommen</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- <?php if ($terms3): ?>
                                                <script>
                                                    $(document).ready(function () {
                                                        terms('#i_agree_with_terms_3');
                                                    });

                                                </script>

                                                <div class="mw-ui-row" id="i_agree_with_terms_row">
                                                    <label class="mw-ui-check">
                                                        <input type="checkbox" name="terms" id="i_agree_with_terms_3" value="1"
                                                            autocomplete="off" />
                                                        <span></span>
                                                        <span>
                                                            <?php _e('I agree with the third'); ?>
                                                            <a href="<?php print site_url('terms-and-condition-three') ?>"
                                                                target="_blank"><?php _e('Terms and Conditions'); ?></a>
                                                        </span>
                                                    </label>
                                                </div>
                                                <?php endif; ?> -->

        </div>

        <?php $shipping_options = mw('shop\shipping\shipping_api')->get_active(); ?>
        <?php



        $show_shipping_info = get_option('show_shipping', $params['id']);

        if ($show_shipping_info === false or $show_shipping_info == 'y') {
            $show_shipping_stuff = true;
        } else {
            $show_shipping_stuff = false;
        }
        if (is_array($shipping_options)) :?>

            <div class="row checkout-total-table-row">
                <div class="col-lg-6">
                    <h3 class="">
                        Bestellübersicht
                    </h3>
                    <table cellspacing="0" cellpadding="0"
                           class="table table-bordered table-striped mw-cart-table mw-cart-table-medium checkout-total-table"
                           width="100%">
                        <!-- <col width="">
                                    <col width="">
                                    <col width=""> -->
                        <tbody>
                        <!--            <tr --><?php //if (!$show_shipping_stuff) : ?><!-- style="display:none" --><?php //endif; ?>
                        <!--                <td class="cell-shipping-country"><label>-->
                        <!--                        --><?php //_e("Versand nach"); ?>
                        <!--                        :</label></td>-->
                        <!--                <td class="cell-shipping-country">-->
                        <!--                    <module type="shop/shipping" view="select" />-->
                        <!--                </td>-->
                        <!--            </tr>-->
                        <tr>

                        </tr>


                        <?php if ($cart_totals && !isset($_GET['slug'])) { ?>
                            <tr>
                                <td>
                                    <label for="">
                                        Warengesamtpreis
                                    </label>
                                </td>
                                <td class="cell-shipping-price cell-cart-price-total-total">
                                <?php (is_logged()) ? '' : print currency_format((float)$cart_totals['total']['value']-(float)@$cart_totals['shipping']['value']);?>
                                </td>
                            </tr>
                            <?php if (isset($cart_totals['discount'])) {?>
                                <tr>
                                    <td>
                                        <label for="">
                                            <?php _e('Discount'); ?>
                                        </label>
                                    </td>
                                    <td class="cell-shipping-price cell-cart-price-total-discount">
                                    <?php print currency_format((float)$cart_totals['discount']['value']);?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><label>
                                        <?php _e("Versandkosten"); ?>
                                        </label></td>
                                <td class="cell-shipping-price">
                                    <div class="mw-big-cart-shipping-price" style="display:inline-block">
                                        <module type="shop/shipping" view="cost" />
                                    </div>
                                </td>
                            </tr>

                            <?php if ($sub_interval!=null) { ?>
                                <tr>
                                    <td><label>
                                            <?php _e("Gewünschter Lieferintervall"); ?>
                                            :</label></td>
                                    <td class="cell-shipping-price">
                                        <?php  print $sub_interval->sub_interval; ?>
                                    </td>
                                </tr>
                            <?php } ?>


                            <tr>
                                <td>
                                    <label for="">
                                        <b>Gesamtpreis</b>
                                    </label>
                                </td>
                                <td class="cell-shipping-price cell-cart-price-total-subtotal">
                                    <?php  (is_logged()) ? '' : print $cart_totals['total']['amount']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="" class="tax_for_country">
                                        darin enthaltene MwSt. (<?php print  (is_logged()) ? (int)taxRateCountry(user_id())."%)" : taxRate()."%)"; ?>
                                    </label>
                                </td>
                                <td class="cell-shipping-price cell-cart-price-total-tax">
                                    <?php (is_logged()) ? '' : print $cart_totals['tax']['amount']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="">
                                        Nettobetrag
                                    </label>
                                </td>
                                <td class="cell-shipping-price cell-cart-price-total-netto">
                                <?php (is_logged()) ? '' : print currency_format((float)round($cart_totals['total']['value'],2)-(float)round(@$cart_totals['tax']['value']??0 , 2)); ?>
                                </td>
                            </tr>

                        <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>






        <?php endif;
        ?>
        <?php
        if (!isset($params['checkout-link-enabled'])) {
            $checkout_link_enanbled = get_option('data-checkout-link-enabled', $params['id']);
        } else {
            $checkout_link_enanbled = $params['checkout-link-enabled'];
        }
        ?>
        <?php if ($checkout_link_enanbled != 'n') : ?>
        <?php $checkout_page = get_option('data-checkout-page', $params['id']); ?>
        <?php if ($checkout_page != false and strtolower($checkout_page) != 'default' and intval($checkout_page) > 0) {
            $checkout_page_link = content_link($checkout_page) . '/view:checkout';
        } else {
            $checkout_page_link = site_url('checkout');
        }
        ?>
        <a class="btn  btn-warning pull-right" href="<?php print $checkout_page_link; ?>">
            <?php _e("Checkout"); ?>
        </a>
    <?php endif; ?>
    <?php else : ?>
        <h4 id="empty-cart-alert" class="alert alert-warning">
            <?php _e("Noch keine Artikel im Warenkorb"); ?>
        </h4>
    <?php endif;
    ?>
</div>
<?php if(isset($_GET['slug'])){?>
    <script>
        // if(sessionStorage.getItem("quick_cart") != "cart") {
        $(document).ready(function () {
            var i = 0;
            // const urlParams = new URLSearchParams(window.location.search);
            // console.log(sessionStorage.getItem("quick_cart"))

            mw.cart.add_item('<?php print $data["id"] ?>');
            // sessionStorage.setItem("quick_cart", "cart");

        });
        // }

    </script>
<?php } ?>

<script>
    // Get Checkedbox agreement
    <?php if ($shop_require_terms == 1) : ?>
    $("#complete_order_button").prop("disabled", true);
    $('#agreewarn').show();
    $('#agreeterm').click(function() {
        if ($('#agreecondition').is(":checked")) {
            if ($(this).is(":checked")) {
                $('#agreewarn').hide();
                $("#complete_order_button").prop("disabled", false);
            } else if ($(this).is(":not(:checked)")) {
                $("#complete_order_button").prop("disabled", true);
                $('#agreewarn').show();

            }
        } else {
            $("#complete_order_button").prop("disabled", true);
            $('#agreewarn').show();
        }
    });
    $('#agreecondition').click(function() {
        if ($('#agreeterm').is(":checked")) {
            if ($(this).is(":checked")) {
                $('#agreewarn').hide();
                $("#complete_order_button").prop("disabled", false);
            } else if ($(this).is(":not(:checked)")) {
                $("#complete_order_button").prop("disabled", true);
                $('#agreewarn').show();
            }
        } else {
            $("#complete_order_button").prop("disabled", true);
            $('#agreewarn').show();
        }
    });
    <?php else : ?>
    $(document).ready(function() {
        $('#agreewarn').hide();
    });
    <?php endif; ?>
    // End Get Checkedbox agreement

    $(document).ready(function() {
        $.post("<?= api_url('setShippingCountryToSession') ?>", { data:$('.country-rate').val() },function(res){
            if(res){
                mw.load_module('shop/shipping/cost', '#shipping-info-module',function(){
                    var updateShipping = $('.shipping_cost').first().text();
                    $('.shipping_cost').last().text(updateShipping);
                });
            }
        });
    });
    
    $('.country-rate').change(function (){
        // alert('ok');
        // return;
        $.post("<?= url('/') ?>/api/v1/cart_totals", { data:$(this).val(),product:$("#p_id_val").val() }, (res) => {
            console.log($(this).val())
            if(res.success){
            console.log(res.cart_totals.tax_rate.amount)

                $("#p_tax").val(res.cart_totals.tax_rate.amount)
                $('.cell-cart-price-total-subtotal').html(res.cart_totals.subtotal.amount)
                $('.cell-cart-price-total-tax').html(res.cart_totals.tax.amount)
                $('.cell-cart-price-total-total').html(res.cart_totals.total.amount)
                $('.cell-cart-price-total-netto').html(res.cart_totals.netto.amount)
                $('.tax_for_country').html('darin enthaltene MwSt. ('+res.cart_totals.tax_rate.amount+'%)');
                mw.load_module('shop/shipping/cost', '#shipping-info-module',function(){
                    var updateShipping = $('.shipping_cost').first().text();
                    $('.shipping_cost').last().text(updateShipping);
                });
            }
        });
    });

</script>
