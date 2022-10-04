<style>
    
.mw-dialog-holder{
    width: 80% !important;
}
</style>

    <div class="dragable-item card style-1 mb-3 bg-primary-opacity-1" id="module-db-id">
        <div class="card-body py-3">
            <div class="row d-flex align-items-center">
                <?php 
                    $clientId = get_option('client_id', 'paypal_subscription_payment');
                    $secretId = get_option('client_secret', 'paypal_subscription_payment');
                    $testMode  = get_option('test_mode', 'paypal_subscription_payment_mode');
                    $switch = get_option('subscription_payment', 'paypal_subscription_switch');
    ?>
                <div class="col pl-0 js-change-method-status" style="max-width: 60px;">
                    <div class="form-group m-0">
                        <div class="custom-control custom-switch m-0">
                            <input  onclick="showHide()" type="checkbox" class="mw_option_field custom-control-input" id="ccheckbox-payment_gw" name="payment_gw_subscription" data-option-group="payments" data-id="shipping_gw_shop/shipping/gateways/country" <?php if($switch and $switch == "on") : ?> checked <?php endif; ?> >
                            <label class="custom-control-label" for="ccheckbox-payment_gw"></label>
                        </div>
                    </div>
                </div>

                <div class="col pl-0">
                    <img src="<?php echo site_url('userfiles/modules/shop/payments/gateways/paypal/paypal.svg'); ?>" alt="" class="d-none"/>

                    <h5 class="gateway-title font-weight-bold mb-0"><?php _e('Paypal Subscription'); ?></h5>
                    <span><?php _e('Paypal Express'); ?></span>
                    <small class="text-muted">
                        <span class="text-primary js-method-on"> </span>
                    </small>
                </div>

                <div class="col text-right">
                    <button type="button" onclick="paymentModalShow();" class="btn btn-outline-primary btn-sm"><?php _e('Settings'); ?></button>
                </div>
            </div>
        </div>
    </div>

    
<div class="mw-dialog-container" style="max-height: 907px; display: none; border: 1px solid gray; border-radius: 10px; padding: 10px 15px;" id="setting-modal">
    <form id="pm1632564257579">
        <h5 class="mb-0"><?php _e('Enter your Paypal Subscription data here'); ?>
        <div class="mb-3 float-right" style="color:red; font-size: 20px;">
            <i class="far fa-window-close" onclick="closeModal()"></i>
        </div>
        </h5>
        <small class="text-muted mb-3 d-block"><?php _e('Without this data, your customer cannot pay via Paypal Express'); ?></small>

        <div class="mw-set-payment-gw-options">
            <div class=" module module-shop-payments-gateways-paypal " id="cart-checkout-shop-payments-shop-payments-gateways-paypal" data-mw-title="Paypal Express" view="admin" data-type="shop/payments/gateways/paypal" parent-module-id="cart-checkout-shop-payments" parent-module="shop/payments/admin">
            

                <div class="form-group">
                    <label class="control-label d-block"><?php _e('Test mode'); ?></label>

                    <div class="custom-control custom-radio d-inline-block mr-2">
                        <input type="radio" id="subscription_mode1" name="subscription_mode1" class="mw_option_field custom-control-input mw-options-form-binded" <?php if(!$testMode or $testMode != "no") : ?> checked <?php endif; ?> onclick="testModeOn()">
                        <label class="custom-control-label" for="subscription_mode1"><?php _e('Yes'); ?></label>
                    </div>

                    <div class="custom-control custom-radio d-inline-block mr-2">
                        <input type="radio" id="subscription_mode2" name="subscription_mode2" class="mw_option_field custom-control-input mw-options-form-binded" <?php if($testMode and $testMode == "no") : ?> checked <?php endif; ?>  onclick="testModeOff()">
                        <label class="custom-control-label" for="subscription_mode2"><?php _e('No'); ?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php _e('Client ID'); ?>: </label>
                    <input type="text" class="form-control" onchange="addClientId()" name="client_id" id="client_id" placeholder="paypalaGFR" <?php if(isset($clientId)): ?> value="<?php echo $clientId; ?>" <?php endif; ?>>
                    <span id="clientId" style="color:red;"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php _e('secret'); ?>: </label>
                    <input type="text" class="form-control" onchange="addClientSecret()" name="secret" id="secret" placeholder="paypal@example.com"<?php if(isset($secretId)): ?> value="<?php echo $secretId; ?>" <?php endif; ?>>
                    <span id="secretId" style="color:red;"></span>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
    function showHide(){
        if(document.getElementById('ccheckbox-payment_gw').checked){
            $('#setting-modal').show();
            $.post("<?=api_url('subscription_payment_on')?>", {
            }).then((res, err) => {
                console.log(res, err);
            })
        } else{
            $('#setting-modal').hide();
            $.post("<?=api_url('subscription_payment_off')?>", {
            }).then((res, err) => {
                console.log(res, err);
            })
        }
    } 
      function paymentModalShow()
      {
        $('#setting-modal').show();
      }

      function closeModal(){
        $('#setting-modal').hide();
      }

      function addClientId(){
          var id = $('#client_id').val();
          $.post("<?=api_url('addClientIdPaypalSubscription')?>", {
            id : id
            }).then((res, err) => {
                console.log(res, err);
            })
            mw.notification.success("Your changed save successfully");
      }

      function addClientSecret(){
          var id = $('#secret').val();
          $.post("<?=api_url('addClientSecretPaypalSubscription')?>", {
            id : id
            }).then((res, err) => {
                console.log(res, err);
            });
            mw.notification.success("Your changed save successfully");
      }

      function testModeOn(){
        $.post("<?=api_url('testModeOn')?>", {
            }).then((res, err) => {
                console.log(res, err);
            });
      }

      function testModeOff(){
        $.post("<?=api_url('testModeOff')?>", {
            }).then((res, err) => {
                console.log(res, err);
            });
      }
  </script>