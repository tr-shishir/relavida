<style>
    .ems-shipping-logo {
        display: inline-block;
    }

    .ems-shipping-logo img {
        height: 20px;
        width: 40px;
    }

    .gateway-selector li>label {
        display: flex;
        align-items: center;
    }

    .payment-name p {
        margin-left: 20px;
        font-size: 16px;
    }

    .gateway-selector img {
        max-width: 70px;
        width: fit-content;
    }

    .gateway-selector>div {
        margin-bottom: 20px;
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
                    Versandkosten betragen:	&nbsp; <module type="shop/shipping" view="cost" />
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
<?php 
    $clientId = get_option('client_id', 'paypal_subscription_payment');
    $secretId = get_option('client_secret', 'paypal_subscription_payment');
    $switch = get_option('subscription_payment', 'paypal_subscription_switch') ?? "off";
?>
<!-- payment option is here -->
<div class="well checkout-box-shadow-style" style="min-height: 475.5px;">
    <h3 style="margin-top:0 " class="nodrop" rel_id="cart-checkout-shop-payments">
    Zahlungsart
    </h3>
    <hr>
    <ul name="payment_gw" class="gateway-selector field-full mw-payment-gateway mw-payment-gateway-cart-checkout-shop-payments" id="payment-gateway-list">
        <?php if($clientId && $secretId && $clientId != "" && $secretId != "") : ?>  
            <?php if($switch == "on"): ?>
                <div style="display:flex;align-items:center">
                    <li>
                        <label class="mw-ui-check tip" data-tipposition="top-left" data-tip="Paypal Express">

                            <input type="radio" checked="" value="shop/payments/gateways/subscription" name="payment_gw"><span></span>
                                <span style="width: 80px;">
                                <div class="edit" field="payment_image_edit82" rel="content">
                                    <img src="<?php echo site_url('userfiles/modules/shop/payments/gateways/paypal/paypal.svg'); ?>" alt="">
                                </div>
                            </span>
                        </label>
                    </li>
                    <div class="payment-name edit" field="text_edit82" rel="content">
                        <p class="element" id="element_1632207289382"><?php _e('Paypal Subscription'); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div style="display:flex;align-items:center">
                    <span style="color : red;"><?php _e('No payment method is active now'); ?></span>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="display:flex;align-items:center">
                <span style="color : red;"><?php _e('You must need to configure your paypal'); ?></span>
            </div>
        <?php endif; ?>
    </ul>
    <div id="mw-payment-gateway-selected-cart-checkout-shop-payments">
        <div class="module module-shop-payments-gateways-paypal" id="cart-checkout-shop-payments-shop-payments-gateways-paypal" data-mw-title="Paypal Express" data-type="shop/payments/gateways/paypal" parent-module-id="cart-checkout-shop-payments" parent-module="shop/payments">
            <div class="edit" field="payment_text_paypal" rel="content">
                <p class="alert alert-warning element" id="element_1632207289379"><small><strong> *<?php _e('Note'); ?> </strong><?php _e('When you order subscription product after if your cart has another product they will remain in your cart'); ?></small> </p>
            </div>
        </div>
    </div>
</div>
<div class="discount-button">
<?php if (is_module('shop/coupons')): ?>
    <a class="btn btn-default" onclick="mw.tools.open_module_modal('shop/coupons');"
        href="javascript:;">Gutschein einlösen </a>

<?php endif; ?>

</div>