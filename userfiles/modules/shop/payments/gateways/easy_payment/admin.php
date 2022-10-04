<?php must_have_access(); ?>

<div class="mb-3 float-right">
    <img src="<?php print $config['url_to_module'] ?>easy_payment.png" style="width: 40px; margin-top: -70px;"/>
</div>

<div class="form-group">
    <label class="control-label d-block"><?php _e("Mode"); ?></label>
    <div class="custom-control custom-radio d-inline-block mr-2">
        <input type="radio" id="easypay_testmode_on" name="easypay_testmode" onclick="testStatus(this.value)" class="mw_option_field custom-control-input" data-option-group="payments" value="y" <?php if (get_option('easypay_testmode', 'payments') != 'n'): ?> checked="checked" <?php endif; ?>>
        <label class="custom-control-label" for="easypay_testmode_on"><?php _e("Test"); ?></label>
    </div>

    <div class="custom-control custom-radio d-inline-block mr-2">
        <input type="radio" id="easypay_testmode_off" name="easypay_testmode" onclick="testStatus(this.value)" class="mw_option_field custom-control-input" data-option-group="payments" value="n" <?php if (get_option('easypay_testmode', 'payments') == 'n'): ?> checked="checked" <?php endif; ?>>
        <label class="custom-control-label" for="easypay_testmode_off"><?php _e("Live"); ?></label>
    </div>
</div>

<div class="clearfix"></div>

<div id="test_on" <?php if (get_option('easypay_testmode', 'payments') != 'y'): ?> style="display:none;" <?php endif; ?>>
    <div class="form-group">
        <label class="control-label">Secret key: </label>
        <input type="text" class="mw_option_field form-control" name="easypay_test_api_key" placeholder="" data-option-group="payments" value="<?php print get_option('easypay_test_api_key', 'payments'); ?>">
    </div>

    <div class="form-group">
        <label class="control-label">Checkout key: </label>
        <input type="text" class="mw_option_field form-control" name="easypay_test_checkout_api_key" placeholder="" data-option-group="payments" value="<?php print get_option('easypay_test_checkout_api_key', 'payments'); ?>">
    </div>
</div>

<div id="test_off" <?php if (get_option('easypay_testmode', 'payments') == 'y'): ?> style="display:none;" <?php endif; ?>>
    <div class="form-group">
        <label class="control-label">Secret key: </label>
        <input type="text" class="mw_option_field form-control" name="easypay_api_key" placeholder="" data-option-group="payments" value="<?php print get_option('easypay_api_key', 'payments'); ?>">
    </div>

    <div class="form-group">
        <label class="control-label">Checkout key: </label>
        <input type="text" class="mw_option_field form-control" name="easypay_checkout_api_key" placeholder="" data-option-group="payments" value="<?php print get_option('easypay_checkout_api_key', 'payments'); ?>">
    </div>
</div>

