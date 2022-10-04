<style>



.thank-switch {
    position: relative;
    display: inline-block;
    width: 30px;
    height: 17px;
    margin-right: 10px;
    margin-bottom: 0;
}

.thank-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
/* For thank-Switch checkbox End*/

</style>
<?php
$cur = get_option('currency', 'payments');
$curencies = mw()->shop_manager->currency_get();

use illuminate\Support\Facades\DB;

$roundprice = Config::get('custom.round_amount');
if(isset($roundprice)){
    $roundamount = $roundprice;
}else{
   $roundamount = 0;
}
?>
<script type="text/javascript">
    $(document).ready(function () {

        mw.options.form('.<?php print $config['module_class'] ?>', function () {
            mw.notification.success("<?php _ejs("Currency settings are saved."); ?>");
            mw.reload_module('shop/payments/currency_render')
        });
    });
</script>

<div class="card bg-none style-1 mb-0 card-settings">
    <div class="card-header px-0">
        <h5>
            <i class="mdi mdi-cart-outline text-primary mr-3"></i> <strong><?php _e("Shop General"); ?></strong>
        </h5>
        <div></div>
    </div>

    <div class="card-body pt-3 px-0">
        <div class="row">
            <div class="col-md-3 pt-5">
                <h5 class="font-weight-bold"><?php _e("Currency settings"); ?></h5>
                <small class="text-muted"><?php _e("Set the currency in which your store will operate"); ?></small>
            </div>

            <div class="col-md-9">
                <div class="card bg-light style-1 mb-3">
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-12">
                                <?php if (is_array($curencies)): ?>
                                    <div class="form-group mb-4">
                                        <label class="control-label"><?php _e("Set default currency"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Default currency with which you will accept payments"); ?></small>
                                        <select name="currency" class="mw_option_field selectpicker" data-width="100%" data-size="7" data-option-group="payments" data-reload="mw_curr_rend" data-live-search="true" data-size="5">
                                            <?php if (!$cur): ?>
                                                <option value="" disabled="disabled" selected="selected"><?php _e('Select currency'); ?></option>
                                            <?php endif; ?>
                                            <?php foreach ($curencies as $item): ?>
                                                <option value="<?php print $item[1] ?>" <?php if ($cur == $item[1]): ?> selected="selected" <?php endif; ?>><?php print $item[1] ?> <?php print $item[3] ?> (<?php print $item[2] ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <?php $currency_symbol_decimal = get_option('currency_symbol_decimal', 'payments'); ?>
                                <?php $cur_pos = get_option('currency_symbol_position', 'payments'); ?>

                                <div class="form-group mb-4">
                                    <label class="control-label"><?php _e("Currency symbol position"); ?></label>
                                    <small class="text-muted d-block mb-2"><?php _e("Where to display the currency symbol before, after or by default relative to the amount"); ?></small>

                                    <select name="currency_symbol_position" class="mw_option_field selectpicker" data-width="100%" data-option-group="payments" data-reload="mw_curr_rend">
                                        <option <?php if (!$cur_pos): ?> selected="selected" <?php endif; ?> value=""><?php _e('Default'); ?></option>
                                        <option <?php if ($cur_pos == 'before'): ?> selected="selected" <?php endif; ?> value="before"><?php _e('Before number'); ?></option>
                                        <option <?php if ($cur_pos == 'after'): ?> selected="selected" <?php endif; ?> value="after"><?php _e('After number'); ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label"><?php _e("Show Decimals"); ?></label>
                                    <select name="currency_symbol_decimal" class="mw_option_field selectpicker" data-width="100%" data-option-group="payments" data-reload="mw_curr_rend">
                                        <option <?php if (!$currency_symbol_decimal): ?> selected="selected" <?php endif; ?> value=""><?php _e('Always'); ?></option>
                                        <option <?php if ($currency_symbol_decimal == 'when_needed'): ?> selected="selected" <?php endif; ?> value="when_needed"><?php _e('When needed'); ?></option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <label class="control-label"><?php _e("Round Prices"); ?></label>
                                        <div class="">
                                        <?php if($roundamount > 0): ?>
                                            <label class="thank-switch">
                                                <input type="checkbox" onclick="round_price();" name="enable_round_price" id="enable_round_price"  checked>
                                                <span class="slider round"></span>
                                            </label>
                                        <?php else: ?>
                                            <label class="thank-switch">
                                            <input type="checkbox" onclick="round_price();"  name="enable_round_price" id="enable_round_price" >
                                                <span class="slider round"></span>
                                            </label>

                                        <?php endif; ?>

                                            <label  for="enable_round_price"><?php _e("Enable round prices"); ?></label>
                                        </div>
                                        <small class="text-muted d-block"><?php _e("Setup round prices and they will appear automatically in your cart"); ?></small>
                                    </div>
                                    <div>
                                        <select class="form-control" id="roundPrice">
                                            <?php for($i = 1 ; $i <100 ; $i++):  ?>
                                                <?php if($roundamount == $i): ?>
                                                    <option value="<?php echo $i ?>" selected ><?php echo $i ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $i ?>" ><?php echo $i ?></option>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <module type="shop/payments/currency_render" id="mw_curr_rend"/>
                                <div class="form-group">

                                    <label class="control-label"><?php _e("Show Wishlist"); ?> </label>
                                    <div class="custom-control custom-switch m-0">
                                        <input type="checkbox" class="custom-control-input wishlist-option" id="enable_wishlist" data-option-group="shop" data-value-checked="1" data-value-unchecked="0" <?php if (get_option('enable_wishlist', 'shop')) : ?>checked<?php endif; ?> />
                                        <label class="custom-control-label" for="enable_wishlist"><?php _e("Enable wishlist support"); ?></label>
                                    </div>
                                    <small class="text-muted d-block"><?php _e("Enable or Disable the Wishlist for product page"); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.wishlist-option').click(function() {
            var wishlist;
            if ($(this).prop("checked") == true) {
                wishlist = 1;
            } else if ($(this).prop("checked") == false) {
                wishlist = 0;
            }

            $.post("<?= api_url('set_wishlist_option') ?>", {
                wishlist: wishlist
            }).then((res, err) => {
                mw.notification.success(res);
            });

        });
    });

$("#roundPrice").change(function(){
    if($('#enable_round_price').is(':checked')){
            var selectedRoundprice = $("#roundPrice").val();
            $.ajax({
                type: "POST",
                url: "<?=api_url('activeRoundprice')?>",
                data:{ round_price : selectedRoundprice},
                success: function(response) {
                    mw.notification.success("Round amount saved successfully");
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }

});


function round_price(){
        if($('#enable_round_price').is(':checked')){
            var selectedRoundprice = $("#roundPrice").val();
            // console.log(selectedRoundprice);
            $.ajax({
                type: "POST",
                url: "<?=api_url('activeRoundprice')?>",
                data:{ round_price : selectedRoundprice},
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }else{
            $.ajax({
                type: "POST",
                url: "<?=api_url('deactiveRoundprice')?>",
                data:{ },
                success: function(response) {
                    // console.log(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.message);
                }
            });
        }
     }

</script>