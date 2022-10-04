<?php

/*

type: layout

name: Default

description: Default

*/
?>
<style>
    .ems-shipping-logo{
        display: inline-block;
    }
    .ems-shipping-logo img{
        height:20px;
        width:40px;
    }

    .gateway-selector li >label{
        display:flex;
        align-items:center;
    }
    .payment-name p{
        margin-left:20px;
        font-size:16px;
    }

    .gateway-selector img {
        height: 70px;
        width: 70px;
    }

    .gateway-selector>div{
        margin-bottom: 20px;
    }

    .discount-button a {
        color: #000;
        font-weight: 700;
        text-decoration: underline;
    }

    .discount-button a:hover {
        color: #309bff;
    }

    input#act_button {
        color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        font-size: 20px;
        padding: 8px 15px;
    }


    input#act_button:hover {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
</style>
<div class="shipping-sys well checkout-box-shadow-style" style="margin-bottom:20px">
    <h3 class="heading">
        Versandart
    </h3>
    <hr/>
    <div class="shipping-sys-inner">
        <form action="">
            <div class="form-group">
                <label class="mw-ui-check" style="display:flex;">
                    <input type="radio" value="" name="shipping" checked="checked"/><span></span>
                    Versandkosten betragen:	&nbsp; <span id="shipping-info-module"><module type="shop/shipping" view="cost" /></span>
                </label>
            </div>
            <!-- <div class="form-group" style="display:flex;justify-content:space-between;align-items:center">
                    <label class="mw-ui-check">
                        <input type="radio" value="" name="shipping"/><span></span>
                        EMS(Express Mail Service) : <b>€18.00</b>
                    </label>
                    <span class="ems-shipping-logo">
                        <img src="<?php print template_url(); ?>assets/image/ems-logo.jpg" alt="">
                    </span>
                </div> -->

        </form>
    </div>
</div>
<div class="well checkout-box-shadow-style">
    <?php if (count($payment_options) > 0): ?>
        <h3 style="margin-top:0 " class="nodrop" rel_id="<?php print $params['id'] ?>">
            Zahlungsart
        </h3>
        <hr>
        <ul name="payment_gw" class="gateway-selector field-full mw-payment-gateway mw-payment-gateway-<?php print $params['id']; ?>" id="payment-gateway-list">
            <?php $count = 0;
            foreach ($payment_options as $key => $payment_option) : $count++;
            if(!is_admin()){
                if($payment_option['name'] == 'Test Payment'){
                    continue;
                }
            }?>
                <div style="display:flex;align-items:center">
                    <li>
                        <label class="mw-ui-check tip" data-tipposition="top-left" data-tip="<?php print  $payment_option['name']; ?>">

                            <input onchange="payment_option_select(<?=$payment_option['id'];?>)" type="radio" <?php if ($count == 1): ?> checked="checked"<?php elseif(isset($_COOKIE['selected_payment_id']) and $_COOKIE['selected_payment_id'] == $payment_option['id']) :?> checked="checked" <?php endif; ?> value="<?php print  $payment_option['gw_file']; ?>" name="payment_gw"/><span></span>
                            <?php if (isset($payment_option['icon']) and trim($payment_option['icon']) != '' and !stristr($payment_option['icon'], 'default.png')) : ?>
                                <span style="width: 80px;">
                                <div class="edit" field="payment_image_edit<?=$payment_option['id']?>" rel="content">
                                    <img src="<?php print  $payment_option['icon']; ?>" alt=""/>
                                </div>
                            </span>
                            <?php else : ?>
                                <span><?php print  _e($payment_option['name']); ?></span>
                            <?php endif; ?>


                        </label>
                    </li>
                    <div class="payment-name edit" field="text_edit<?=$payment_option['id']?>" rel="content">
                        <p>Payment Option Name</p>
                    </div>

                </div>
            <?php  endforeach; ?>
        </ul>
    <?php endif; ?>


    <div id="mw-payment-gateway-selected-<?php print $params['id']; ?>">
        <?php //var_dump($payment_options); ?>
        <?php if (isset($payment_options[0])): ?>
            <module type="<?php print $payment_options[0]['gw_file'] ?>"/>
        <?php endif; ?>
    </div>

</div>

<div class="discount-button">
    <?php if (is_module('shop/coupons')): ?>
        <a onclick="mw.tools.open_module_modal('shop/coupons');"
           href="javascript:;">Gutschein einlösen </a>

    <?php endif; ?>

</div>

<script>
    function payment_option_select(payment_id){
        $.post("<?= api_url('payment_option_select') ?>", {
            payment_id: payment_id,
        });
    }

    $('[data-tip="Test Payment"] input').on('change', function(){

            $.post("<?= url('/') ?>/api/v1/order-limit-check", { data:true }, (res) => {
                if(!res.data){
                    mw.notification.warning('Your test order limit has expired!');
                    mw.reload_module('shop/payments');
                }
            });

    });
</script>
