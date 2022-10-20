<?php
/*

  type: layout

  name: Quick Checkout

  description: Quick Checkout

 */
?>

<script src="<?php print modules_url(); ?>admin/sweetalert/sweetalert.min.js"></script>
<style>
    .bundle-cart-heading strong{
        margin-left: 5px;
        font-size: 18px;
        font-weight: bold;
    }

    .bundle-cart{
        margin-bottom: 30px;
        box-shadow: 0 0 5px 2px #d9d9d9;
        padding: 5px;
    }

    .dropdown-menu.shopping-cart {
        min-width: 25rem;
    }

    /* cart-modal */
    .cart-modal-primary i {
        font-size: 80px;
        margin: 25px 0;
    }

    .cart-modal-primary h4 {
        font-size: 40px;
        color: #757575;
        font-weight: 800;
    }

    .cart-modal-primary p {
        font-size: 30px;
        margin-bottom: 50px;
    }

    .cart-modal-primary h5 {
        font-size: 28px;
        font-weight: 600;
        margin: 35px 0;
    }
    .cart-modal-primary a {
        font-size: 25px;
        font-weight: 700;
        letter-spacing: 1px;
        width: 50%;
        color: #fff;
        text-decoration: none;
    }


    @media screen and (max-width:767px){
    .cart-modal-primary h4 {
        font-size: 25px;
    }

    .cart-modal-primary p {
        font-size: 21px;
    }

    .cart-modal-primary h5 {
        font-size: 19px;
    }

    .cart-modal-primary a {
        font-size: 18px;
        width: 100%;
    }
    }
    @media screen and (max-width:526px){
        .cart-modal-primary i {
        font-size: 50px;
        margin: 20px 0;
    }

    .cart-modal-primary h4 {
        font-size: 19px;
    }

    .cart-modal-primary p {
        font-size: 15px;
        margin-bottom:30px;
    }

    .cart-modal-primary h5 {
        font-size: 15px;
        margin: 18px 0;
    }

    .cart-modal-primary a {
        font-size: 14px;
        width: 100%;
    }
    }

    @media screen and (max-width:414px){
    .cart-modal-primary h4 {
        margin-bottom: 10px;
    }
    }


    .blankCartBox {
        position: relative;
    }
    .checkoutloader:before {
        position: absolute;
        content: '';
        height: 100%;
        width: 100%;
        background-color: #fff;
        z-index: 1;
    }
    .checkoutloader:after {
        position: absolute;
        content: '';
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 60px;
        height: 60px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        z-index: 9;
        top: 50%;
        right: 50%;
        transform: translate(50%,-50%);
    }
    .checkoutloaderWith5opacity:before {
      opacity: .5;
    }
    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .product-cart-modal{
        position: relative;
    }
</style>

<?php $total = 0;

$bumbs = true;
// mw()->user_manager->session_del('bundle_product_checkout');

?>

<?php if (is_array($data)) :
    $upsellingCount=DB::table("selected_product_upselling_item")->where('user_id',user_id())->pluck('id')->count();
    $checkoutBumbs = DB::table('checkout_bumbs')->where('show_cart',1)->pluck('product_id')->toArray();
    $update_global_bundle_discount_condition = get_option('update_global_bundle_discount_condition','update_global_bundle_discount_condition') ?? 0;
    $value_need_to_reduce = 0;

    if($upsellingCount > 0){
        $serviceTag='withService';
    }else{
        $serviceTag='withoutService';
    }
    ?>
	<div class="product-cart-modal">

    <?php
    // dd(mw()->user_manager->session_get('bundle_product_checkout'));
    if( @mw()->user_manager->session_get('bundle_product_checkout') ){
        $all_bundle_details = mw()->user_manager->session_get('bundle_product_checkout');

        foreach($all_bundle_details as $key => $bundle_details){
            if(isset($bundle_details['bundle_products'])){
                $ids_m_qty = [];
                $ids_bundle = collect($bundle_details['bundle_products'])->pluck('product_id')->toArray();
                $id_qty = collect($bundle_details['bundle_products'])->pluck('product_qty')->toArray();
                $ids_qty = array_combine($ids_bundle, $id_qty);
                $m_qty = collect($bundle_details['bundle_products'])->pluck('minimum_p')->toArray();
                $ids_m_qty = array_combine($ids_bundle, $m_qty);
                $bundle_data=collect($data)->whereIn('rel_id',$ids_bundle)->toArray();
                $data=collect($data)->whereNotIn('rel_id',$ids_bundle)->toArray();
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
                    <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table table-responsive cart-table <?php print($serviceTag) ?>" >
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
                                <th style="width:50px">Bild</th>
                                <th class="mw-cart-table-product" style="max-width:100px !important">Produktname</th>
                                <?php if(!isset($_GET['slug'])) { ?>
                                    <th style="width:164px">Menge</th>
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
                            // $total = cart_sum();
                            $tax_data=collect($bundle_data);

                            $tax_rels = $tax_data->pluck('rel_id');

                            $default_tax = single_tax($tax_rels);
                            if(!isset($_GET['slug'])){
                                $i = 0;
                                foreach ($bundle_data as $item) :
                                    if(DB::table('checkout_bumbs')->where('product_id',$item['rel_id'])->where('show_cart',1)->get()->count()){
                                        $bumbs = false;
                                    }
                                    //$total += $item['price']* $item['qty'];

                                    ?>
                                    <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?> bundle-id-<?php print $bundle_details['id']; ?> bundle-id-tr-<?php print $bundle_details['id']; ?>">
                                        <td><?php  if (isset($item['item_image']) and $item['item_image'] != false): ?>
                                                <?php $p = $item['item_image']; ?>
                                            <?php else:

                                                $p = get_picture($item['rel_id']);

                                                ?>
                                            <?php endif; ?>
                                            <?php if ($p != false): ?>
                                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                                            <?php endif; ?></td>
                                        <td class="mw-cart-table-product"><?php print $item['title'] ?>
                                            <?php if (isset($item['custom_fields'])): ?>
                                                <?php print $item['custom_fields'] ?>
                                            <?php endif ?>
                                        </td>
                                        <?php if(!isset($_GET['slug'])) {
                                        ?>
                                            <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                                            <td class="product-quantity_number">
                                                <div class="input-group">
                                                    <input type="button" value="-" class="button-minus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_minus'.$item['id'] : print 'minus'.$item['id'];?>">
                                                    <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                                    <input type="button" value="+" class="button-plus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_plus'.$item['id'] : print 'plus'.$item['id'];?>">
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                                        <script>

                                            $("#b_plus<?=$item['id']?>").on('click', function(e) {
                                                if(<?=$bundle_details['bundle_option']?> == 1){
                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                    currentVal = parseInt(currentVal)+1;
                                                    mw.cart.qty(id,currentVal);
                                                }else{
                                                    if(<?php if(isset($ids_qty[$item['rel_id']])){ print (int)$ids_qty[$item['rel_id']]; } ?> <= $("#qty<?=$item['id']?>").val()){
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)+1;
                                                        mw.cart.qty(id,currentVal);
                                                    }else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)+1;
                                                        mw.cart.qty(id,currentVal);
                                                    }
                                                }
                                            });
                                            $("#b_minus<?=$item['id']?>").on('click', function(e) {
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
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        remove_cart_data(id);
                                                                        mw.reload_module('shop/checkout');
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
                                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    currentVal = parseInt(currentVal)-1;
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    remove_cart_data(id);
                                                                    mw.reload_module('shop/checkout');
                                                                }
                                                            });
                                                    } else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
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
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        mw.cart.qty(id,currentVal);
                                                                        mw.reload_module('shop/checkout');
                                                                    });
                                                                } else {
                                                                    mw.reload_module('shop/cart/quick_checkout');
                                                                }
                                                        });
                                                    }else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
                                                    }

                                                }

                                            });

                                            $("#plus<?=$item['id']?>").on('click', function(e) {
                                                var currentVal = $("#qty<?=$item['id']?>").val()
                                                var id = $("#id_val<?=$item['id']?>").val();
                                                currentVal = parseInt(currentVal)+1;
                                                mw.cart.qty(id,currentVal);
                                            });
                                            $("#minus<?=$item['id']?>").on('click', function(e) {
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
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        remove_cart_data(id);
                                                                        mw.reload_module('shop/checkout');
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
                                                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                                                    var id = $("#id_val<?=$item['id']?>").val();
                                                                    currentVal = parseInt(currentVal)-1;
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    remove_cart_data(id);
                                                                    mw.reload_module('shop/checkout');
                                                                }
                                                            });
                                                    } else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
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
                                                                    // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        mw.cart.qty(id,currentVal);
                                                                        mw.reload_module('shop/checkout');
                                                                    });
                                                                } else {
                                                                    mw.reload_module('shop/cart/quick_checkout');
                                                                }
                                                            });
                                                    }else{
                                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                                        var id = $("#id_val<?=$item['id']?>").val();
                                                        currentVal = parseInt(currentVal)-1;
                                                        mw.cart.qty(id,currentVal);
                                                    }

                                                }

                                            });
                                        </script>
                                        <td class="mw-cart-table-price">
                                            <?php
                                                $key = sha1($item['rel_id'] . "_" . user_id() . "_" . session_id() . "_upselling");
                                                if(array_key_exists($key, $GLOBALS)){
                                                    $selectedUpselling = $GLOBALS[$key];
                                                }else{
                                                    $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $value['rel_id'] )->where('user_id',user_id())->get();
                                                    $GLOBALS = array_merge($GLOBALS, array(
                                                        $key => $selectedUpselling
                                                    ));
                                                }
                                                $servicePrice = 0;
                                                if($selectedUpselling->count()){
                                                    foreach($selectedUpselling as $selectValue){
                                                        $servicePrice = $servicePrice + $selectValue->service_price;
                                                    }
                                                    $servicePrice = $servicePrice + taxPrice($servicePrice);
                                                    $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);

                                                    print currency_format(roundPrice($item['price']));
                                                }
                                                else{
                                                    $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);
                                                    print currency_format(roundPrice($item['price']));
                                                }
                                                $total = $total + ((roundPrice($item['price']) +$servicePrice) * $item['qty']);
                                            ?>
                                        </td>
                                        <?php if($upsellingCount > 0): ?>
                                            <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                                        <?php endif; ?>
                                        <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) +$servicePrice) * $item['qty']); ?></td>

                                        <td style="text-align:center;"><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash" href="javascript:bundle_remove_cart_data('<?php print $item['id'] ?>','<?php print $bundle_details['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                                                                    data = {
                                                                        key:'bundle_product_checkout',
                                                                        key1 :<?php print $bundle_details['id']; ?>
                                                                    };
                                                                    $.post("<?php print url('api/v1/remove_session') ?>",data,function(){}).then(function(){
                                                                        sessionStorage.setItem('cart_update_for_bundle_product', 'false');
                                                                        mw.cart.remove(id)
                                                                        mw.reload_module('shop/cart/quick_checkout');
                                                                    });
                                                                } else {
                                                                    mw.reload_module('shop/cart');
                                                                }
                                                            });
                                                    }
                                            }
                                        </script>
                                    </tr>
                                <?php $i++; endforeach;
                            }else{
                                foreach ($data as $dataaaa) : ?>


                                <tr class="mw-cart-item mw-cart-item-<?php print $dataaaa['id'] ?>">
                                    <td><?php  if (isset($dataaaa['item_image']) and $dataaaa['item_image'] != false): ?>
                                            <?php $p = $dataaaa['item_image']; ?>
                                        <?php else:

                                                $p = get_picture($dataaaa['id']);
                                            ?>
                                        <?php endif;
                                        //                            @dump($p);?>
                                        <?php if ($p != false): ?>
                                            <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $dataaaa['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                                        <?php endif; ?></td>
                                    <td class="mw-cart-table-product"><?php print $dataaaa['title'] ?>
                                        <?php if (isset($dataaaa['custom_fields'])): ?>
                                            <?php print $dataaaa['custom_fields'] ?>
                                        <?php endif ?></td>



                                        <td class="mw-cart-table-price"><?php
                                            $dataaaa['price'] = $dataaaa['price'] + taxPrice($dataaaa['price'],null,$dataaaa['id']);
                                            print currency_format($dataaaa['price']); ?></td>

                                    </tr>

                                <?php endforeach;
                            } ?>

                        </tbody>
                    </table>

                    <div class="bundle-discount">
                        <p style="margin-bottom:10px;text-align:left;font-size: 18px;color: green;"><strong class="text_q_c_o">Ersparnis: <?php
                            // $taxam = 0; $tax= mw()->tax_manager->get();
                            // !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                            // $total = $total + ($taxam*$total)/100;
                            // print currency_format($bundle_details['offer_discount']);

                            // $value_need_to_reduce = $value_need_to_reduce+$bundle_details['offer_discount'];

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

    if (is_array($data) && !empty($data)) :
    ?>
        <table class="table <?php if($upsellingCount <= 0): ?>upsellingCartTable<?php endif; ?> table-bordered table-striped mw-cart-table mw-cart-table-medium mw-cart-big-table table-responsive cart-table <?php print($serviceTag) ?>" >
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
                    <th style="width:50px">Bild</th>
                    <th class="mw-cart-table-product" style="max-width:100px !important">Produktname</th>
                    <?php if(!isset($_GET['slug'])) { ?>
                        <th style="width:164px">Menge</th>
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
                // $total = cart_sum();
                $tax_data=collect($data);

                $tax_rels = $tax_data->pluck('rel_id');

                $default_tax = single_tax($tax_rels);
                if(!isset($_GET['slug'])){
                    foreach ($data as $item) :
                        if(in_array($item['rel_id'], $checkoutBumbs)){
                            $bumbs = false;
                        }
                        //$total += $item['price']* $item['qty'];

                        ?>
                        <tr class="mw-cart-item mw-cart-item-<?php print $item['id'] ?>">
                            <td><?php  if (isset($item['item_image']) and $item['item_image'] != false): ?>
                                    <?php $p = $item['item_image']; ?>
                                <?php else:

                                    $p = get_picture($item['rel_id']);

                                    ?>
                                <?php endif; ?>
                                <?php if ($p != false): ?>
                                    <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $item['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                                <?php endif; ?></td>
                            <td class="mw-cart-table-product"><?php print $item['title'] ?>
                                <?php if (isset($item['custom_fields'])): ?>
                                    <?php print $item['custom_fields'] ?>
                                <?php endif ?>
                            </td>
                            <?php if(!isset($_GET['slug'])) { ?>
                                <input type="hidden" min="1" id="id_val<?=$item['id']?>" class="input-mini form-control input-sm" value="<?php print $item['id'] ?>"/>

                                <td class="product-quantity_number">
                                    <div class="input-group">
                                        <input type="button" value="-" class="button-minus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_minus'.$item['id'] : print 'minus'.$item['id'];?>">
                                        <input type="number" step="1" max="" value="<?php print $item['qty'] ?>" name="quantity" id="qty<?=$item['id']?>" class="quantity-field" onchange="mw.cart.qty('<?php print $item['id'] ?>', this.value)">
                                        <input type="button" value="+" class="button-plus" data-field="quantity" id="<?php (isset(mw()->user_manager->session_get('bundle_product_checkout')[0]) && $update_global_bundle_discount_condition == 0) ? print 'b_plus'.$item['id'] : print 'plus'.$item['id'];?>">
                                    </div>
                                </td>
                            <?php } ?>
                            <?php /* <td><?php print currency_format($item['price']); ?></td> */ ?>

                            <script>

                                $("#b_plus<?=$item['id']?>").on('click', function(e) {
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
                                                // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                                                    mw.cart.qty(id,currentVal);
                                                    mw.reload_module('shop/checkout');
                                                });
                                            } else {
                                                mw.reload_module('shop/cart');
                                            }
                                        });

                                });
                                $("#b_minus<?=$item['id']?>").on('click', function(e) {

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
                                                // mw.notification.success('<?php //_e('You have changed the product quantity. So now the further process will be managed from general cart.'); ?>');
                                                $.post("<?php print url('api/v1/remove_session') ?>",{ key:'bundle_product_checkout'},function(){}).then(function(){
                                                    mw.cart.qty(id,currentVal);
                                                    mw.reload_module('shop/checkout');
                                                });
                                            }
                                            else {
                                                mw.reload_module('shop/cart');
                                            }
                                        });
                                });

                                $("#plus<?=$item['id']?>").on('click', function(e) {
                                    var currentVal = $("#qty<?=$item['id']?>").val()
                                    var id = $("#id_val<?=$item['id']?>").val();
                                    currentVal = parseInt(currentVal)+1;
                                    mw.cart.qty(id,currentVal);
                                });
                                $("#minus<?=$item['id']?>").on('click', function(e) {
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
                                                    mw.reload_module('shop/checkout');
                                                }
                                            });
                                    } else{
                                        var currentVal = $("#qty<?=$item['id']?>").val()
                                        var id = $("#id_val<?=$item['id']?>").val();
                                        currentVal = parseInt(currentVal)-1;
                                        mw.cart.qty(id,currentVal);
                                    }
                                });
                            </script>
                            <td class="mw-cart-table-price">
                                <?php
                                    $key = sha1($item['rel_id'] . "_" . user_id() . "_" . session_id() . "_upselling");
                                    if(array_key_exists($key, $GLOBALS)){
                                        $selectedUpselling = $GLOBALS[$key];
                                    }else{
                                        $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $item['rel_id'] )->where('user_id',user_id())->get();
                                        $GLOBALS = array_merge($GLOBALS, array(
                                            $key => $selectedUpselling
                                        ));
                                    }
                                    $servicePrice = 0;
                                    if($selectedUpselling->count()){
                                        foreach($selectedUpselling as $selectValue){
                                            $servicePrice = $servicePrice + $selectValue->service_price;
                                        }
                                        $servicePrice = $servicePrice + taxPrice($servicePrice);
                                        $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);

                                        print currency_format(roundPrice($item['price']));
                                    }
                                    else{
                                        $item['price'] = $item['price'] + taxPrice($item['price'],null,$item['rel_id']);
                                        print currency_format(roundPrice($item['price']));
                                    }
                                    $total = $total + ((roundPrice($item['price']) +$servicePrice) * $item['qty']);
                                ?>
                            </td>
                            <?php if($upsellingCount > 0): ?>
                                <td class="mw-cart-table-price"><?php print currency_format($servicePrice); ?></td>
                            <?php endif; ?>
                            <td class="mw-cart-table-price"><?php print currency_format((roundPrice($item['price']) +$servicePrice) * $item['qty']); ?></td>

                            <td style="text-align:center;"><a title="<?php _e("Remove"); ?>" style="color:red;" class="icon-trash" href="javascript:remove_cart_data('<?php print $item['id'] ?>');"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php endforeach;
                }else{
                    foreach ($data as $dataaaa) : ?>


                    <tr class="mw-cart-item mw-cart-item-<?php print $dataaaa['id'] ?>">
                        <td><?php  if (isset($dataaaa['item_image']) and $dataaaa['item_image'] != false): ?>
                                <?php $p = $dataaaa['item_image']; ?>
                            <?php else:

                                    $p = get_picture($dataaaa['id']);
                                ?>
                            <?php endif;
                            //                            @dump($p);?>
                            <?php if ($p != false): ?>
                                <img height="70" class="img-polaroid img-rounded mw-order-item-image mw-order-item-image-<?php print $dataaaa['id']; ?>" src="<?php print thumbnail($p, 70, 70); ?>"/>
                            <?php endif; ?></td>
                        <td class="mw-cart-table-product"><?php print $dataaaa['title'] ?>
                            <?php if (isset($dataaaa['custom_fields'])): ?>
                                <?php print $dataaaa['custom_fields'] ?>
                            <?php endif ?></td>



                            <td class="mw-cart-table-price"><?php
                                $dataaaa['price'] = $dataaaa['price'] + taxPrice($dataaaa['price'],null,$dataaaa['id']);
                                print currency_format($dataaaa['price']); ?></td>

                        </tr>

                    <?php endforeach;
                } ?>

            </tbody>
        </table>
    <?php endif; ?>
    </div>
<?php
 else: ?>
    <div class="col-12 blankCartBox">
            <div class="cart-modal-primary text-center">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <h4 class="edit" field="empty_cart_first_part" rel="global">Ihr Warenkorb ist noch leer.</h4>
                <p class="lead"></p>
                <hr>
                <?php if(!is_logged()):
                ?>
                    <h5 class="edit" field="empty_cart_second_part" rel="global" >Mit Ihrem Kundenkonto einkaufen?</h5>
                    <a class="btn btn-secondary btn-lg"  data-dismiss="modal" id="login_Modal" href="" data-toggle="modal" data-target="#loginModal">Jetzt anmelden</a>
                <?php endif;
                ?>
            </div>
    </div>
<?php endif; ?>

<?php if (is_ajax()) : ?>

    <script>
        $(document).ready(function () {
            //  cartModalBindButtons();

        });
    </script>

<?php endif; ?>

<?php if(!empty($checkoutBumbs)): ?>
    <?php if($bumbs): ?>
    <module type="shop/Checkout_Bumbs" template="cart_bumbs" />
    <?php endif; ?>
<?php endif;
if(!empty(mw()->user_manager->session_get('bundle_product_checkout'))) {
    $discount_for_bundle = collect(mw()->user_manager->session_get('bundle_product_checkout'))->first();
        if (isset($discount_for_bundle['discount_type'])) {
            if ($discount_for_bundle['discount_type'] == "percentage") {
                $discount_type = 'percentage';
                $discount_value = $discount_for_bundle['discount'];
            } else {
                $discount_type = 'fixed_amount';
                $discount_value = $discount_for_bundle['discount'];
            }
            if ($discount_type == 'precentage' or $discount_type == 'percentage') {
                // Discount with precentage
                $discount_sum = ($total * ($discount_value / 100));
                $totall = $total - $discount_sum;
            } else if ($discount_type == 'fixed_amount') {
                // Discount with amount
                $discount_sum = $discount_value;
                $totall = $total - $discount_value;
            }
            ?>
                <script>
                    $("#bundle_offer").val(true);
                    $("#bundle_offer_total").val("<?=$totall?>");
                    if(sessionStorage.getItem('delete_cart')=="true"){
                        $(".text_q_c_o").html(`Offer Amount: <br class="d-none d-sm-block"> <?=currency_format($totall)?>`);
                    }
                </script>
            <?php
        }

    ?>

    <?php

    }
    ?>

<div class="products-amount">
    <div class="row">
    <input type="hidden" id="bundle_offer" value="false">
    <input type="hidden" id="bundle_offer_total" value="">

        <?php if (is_array($data)): ?>
            <div class="col-sm-6 total">
                <p style="margin-bottom:10px;text-align:left"><strong class="text_q_c_o"><?php _e("Gesamtbetrag: "); ?>  <?php
                        // $taxam = 0; $tax= mw()->tax_manager->get();
                        // !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
                        // $total = $total + ($taxam*$total)/100;
                        if($value_need_to_reduce > 0){
                            $total -= $value_need_to_reduce;
                            if($total > 0) print currency_format($total);
                            else print currency_format(0);

                        }else{
                            print currency_format($total);
                        }
                        ?></strong></p>
                <div class="product-tax-text" style="display:flex;align-items:center;font-size: 12px;">

                    <span class="edit">
                        inkl. <?php print (int)$default_tax; ?>% MwSt.
                    </span>
                    <span data-toggle="modal" data-target="#termModal" style="margin-left:5px;display:inline-block;">
                        zzgl. Versand
                    </span>
                </div>
            </div>
            <div class="col-sm-6" style="text-align: right;">
                <a href="<?php echo site_url('checkout') ?>" class="btn btn-primary btn-md btn-block">zur Kasse</a>
            </div>
        <?php endif; ?>
    </div>

</div>


<script>

    $(".icon-trash").on("click", function(){
        sessionStorage.setItem('delete_cart',false);

        $(".text_q_c_o").html(`Gesamtbetrag: <br class="d-none d-sm-block"> <?=currency_format($total)?>`);

        // preloader added
        if($(".product-cart-modal tbody tr").length == 1 ) {
            $(".product-cart-modal").addClass('checkoutloader');
            $(".products-amount").css("opacity","0");
        } else{
            $(".product-cart-modal").addClass('checkoutloader');
            $(".product-cart-modal").addClass('checkoutloaderWith5opacity');
            $(".products-amount").css("opacity",".5");
        }


     });

</script>
