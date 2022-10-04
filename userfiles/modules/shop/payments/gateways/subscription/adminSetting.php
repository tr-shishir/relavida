<?php 
    $clientId = get_option('client_id', 'paypal_subscription_payment');
    $secretId = get_option('client_secret', 'paypal_subscription_payment');
    $testMode  = get_option('test_mode', 'paypal_subscription_payment_mode');
    $switch = get_option('subscription_payment', 'paypal_subscription_switch');
?>
<style>
    .modal-subscription{
        border: 1px solid whote;
        border-radius: 10px;
    }
    .modal-header-subscription{
        padding: 6px 25px;
        display: flex;
        align-items: center;
        position: relative;
        top: 0;
        z-index: 2;
        border-bottom: 1px solid #D9DADB;
        min-height: 43px;
        background-color: #4592ff;
        color: #fff;
    }
    .cls-btn{
        position: absolute;
        top: 7px;
        right: 7px;
        width: 32px;
        height: 28px;
        text-align: center;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s;
        border: 1px solid white;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }
    .cls-btn hover{
        background-color: #ffffff;
        color: #4592ff;
    }
</style>

<div class="dragable-item card style-1 mb-3 " id="module-db-id-84">
    <div class="card-body py-3">
        <div class="row d-flex align-items-center">
            <div class="col cursor-move-holder">
                <a href="javascript:;" class="btn btn-link text-dark"><i class="mdi mdi-cursor-move ui-sortable-handle"></i></a>
            </div>

            <div class="col pl-0 js-change-method-status" style="max-width: 60px;">
                <div class="form-group m-0">
                    <div class="custom-control custom-switch m-0">
                        <input onclick="showHide()" type="checkbox" class="mw_option_field custom-control-input" id="ccheckbox-payment_gw" name="payment_gw" data-option-group="payments" data-id="shipping_gw_shop/shipping/gateways/country" <?php if($switch and $switch == "on") : ?> checked <?php endif; ?> >
                            <label class="custom-control-label" for="ccheckbox-payment_gw"></label>
                    </div>
                </div>
            </div>

            <div class="col pl-0">
                <img src="<?php echo site_url('userfiles/modules/shop/payments/gateways/paypal/paypal.svg'); ?>" alt="" class="d-none"/>

                <h4 class="gateway-title font-weight-bold mb-0"><?php _e('Paypal Subscription'); ?></h4>

                <span><?php _e('Paypal Express'); ?></span>
                <small class="text-muted">
                    <span class="text-primary js-method-on"> </span>
                </small>
            </div>

            <div class="col text-right">
                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><?php _e('Settings'); ?></button>
            </div>
        </div>


        <div class="modal fade modal-subscription" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header-subscription">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php _e('Paypal Subscription'); ?></h5>
                    <button type="button" class="close cls-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="mw-dialog-container"  id="setting-modal">
                    <form id="pm1632564257579">
                        <h5 class="mb-0"><?php _e('Enter your Paypal Subscription data here'); ?>
                        </h5>
                        <small class="text-muted mb-3 d-block"><?php _e('Without this data, your customer cannot pay via Paypal Express'); ?></small>
                        <div class="mb-3 float-right">
                            <img src="<?php echo site_url('userfiles/modules/shop/payments/gateways/paypal/paypal.svg'); ?>" style="width: 40px; margin-top: -70px;">
                        </div>
                        <div class="mw-set-payment-gw-options">
                            <div class=" module module-shop-payments-gateways-paypal " id="cart-checkout-shop-payments-shop-payments-gateways-paypal" data-mw-title="Paypal Express" view="admin" data-type="shop/payments/gateways/paypal" parent-module-id="cart-checkout-shop-payments" parent-module="shop/payments/admin">
                            

                                <div class="form-group">
                                    <label class="control-label d-block"><?php _e('Test mode'); ?></label>

                                    <div class="custom-control custom-radio d-inline-block mr-2">
                                        <input type="radio" id="subscription_mode1" name="subscription_mode" class="mw_option_field custom-control-input mw-options-form-binded" <?php if(!$testMode or $testMode != "no") : ?> checked <?php endif; ?> onclick="testModeOn()">
                                        <label class="custom-control-label" for="subscription_mode1"><?php _e('Yes'); ?></label>
`                                    </div>

                                    <div class="custom-control custom-radio d-inline-block mr-2">
                                        <input type="radio" id="subscription_mode2" name="subscription_mode" class="mw_option_field custom-control-input mw-options-form-binded" <?php if($testMode and $testMode == "no") : ?> checked <?php endif; ?>  onclick="testModeOff()">
                                        <label class="custom-control-label" for="subscription_mode2"><?php _e('No'); ?></label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php _e('Client ID'); ?>: </label>
                                    <input type="text" class="form-control" onchange="addClientId()" name="client_id" id="client_id" placeholder="<?php _e('paypalaGFR'); ?>" <?php if(isset($clientId)): ?> value="<?php echo $clientId; ?>" <?php endif; ?>>
                                    <span id="clientId" style="color:red;"></span>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php _e('secret'); ?>: </label>
                                    <input type="text" class="form-control" onchange="addClientSecret()" name="secret" id="secret" placeholder="<?php _e('paypal@example.com'); ?>"<?php if(isset($secretId)): ?> value="<?php echo $secretId; ?>" <?php endif; ?>>
                                    <span id="secretId" style="color:red;"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                
                </div>
            </div>
         </div>


    </div>
</div>


<script>
    function showHide(){
        if(document.getElementById('ccheckbox-payment_gw').checked){
            $.post("<?=api_url('subscription_payment_on')?>", {
            }).then((res, err) => {
                console.log(res, err);
            })
        } else{
            $.post("<?=api_url('subscription_payment_off')?>", {
            }).then((res, err) => {
                console.log(res, err);
            })
        }
        mw.notification.success("Your changed save successfully");

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
        mw.notification.success("Your changed save successfully");

      }

      function testModeOff(){
        $.post("<?=api_url('testModeOff')?>", {
            }).then((res, err) => {
                console.log(res, err);
            });
        mw.notification.success("Your changed save successfully");

      }
  </script>