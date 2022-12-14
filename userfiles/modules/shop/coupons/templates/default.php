<?php
/*
type: layout
name: Default
description: Default coupon template
*/
?>



<?php

//d($applied_coupon_data);


$applied_code = '';
?>

<div class="checkout-page">
    <div class="box-container">
        <div class="bootstrap3ns">
            <div class="mw-coupons-module">
                <?php if(isset($applied_coupon_data['coupon_code'])): ?>
                <div class="coupon_code_apply_wrapper" >

                <p>Sie verwenden einen Gutscheincode <i title="<?php print $applied_coupon_data['coupon_code']  ?>"><?php print $applied_coupon_data['coupon_name']  ?></i> <a href="javascript:$('.coupon_code_apply_wrapper').toggle(); void(0);">(change)</a> </p>
                </div>
               <?php endif; ?>


                <div class="coupon_code_apply_wrapper" <?php if(isset($applied_coupon_data['coupon_code'])): ?>  style="display: none"    <?php endif; ?>  >


                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Gutschein-Code eingeben und Rabatt erhalten</h4>
                            <hr/>
                            <div class="js-coupon-code-messages"></div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-6">
                            <input type="text" name="coupon_code" class="form-control js-coupon-code" placeholder="Gutschein-Code eingeben"/>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" style="margin-left:10px;" class="btn btn-primary js-apply-coupon-code">Code einlösen</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
