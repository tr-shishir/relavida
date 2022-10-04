<?php
// var_dump($data);var_dump($settings);die();
?>
<div class="col-md-<?php echo $settings['field_size']; ?> no-padd">
    <div class="mw-ui-field-holder">

        <?php if($settings['show_label']): ?>
            <label class="control-label">
                <!-- Adresse -->
                <?php if ($settings['required']): ?>
                    <span style="color: red;">*</span>
                <?php endif; ?>
            </label>
        <?php endif; ?>





        <div class="module module-custom-fields" data-mw-title="Custom fields"
             id="shipping-info-address-cart-checkout-shop-shipping-shop-shipping-gateways-country" data-for="module"
             default-fields="address" input-class="field-full form-control" data-skip-fields="country"
             data-type="custom_fields" parent-module-id="cart-checkout-shop-shipping-shop-shipping-gateways-country"
             parent-module="shop/shipping/gateways/country"><input type="hidden" name="for_id"
                                                                   value="cart-checkout-shop-shipping-shop-shipping-gateways-country"
                                                                   wtx-context="5F068772-F445-4234-9818-6BE25BB5B206">
            <input type="hidden" name="for" value="module" wtx-context="0C013BC6-10AC-42B3-8E2E-1F4FD0C4C573">
            <div class="row">


                <div class="col-md-12 no-padd" contenteditable="false">
                    <div class="mw-ui-field-holder">
					<div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="billing_zip">Name </label>
                                    <span style="color: red;">*</span>
                                    <input type="text" name="shipping_name" class="form-control" id="shipping_name" aria-describedby="emailHelp" value="<?php if (isset($user)) {
                                        print $user['first_name'].' '.$user['last_name'];
                                    }elseif (@mw()->user_manager->session_get("first_name") != null || @mw()->user_manager->session_get("last_name") != null){
                                        print mw()->user_manager->session_get("first_name").' '.mw()->user_manager->session_get("last_name");
                                    }?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="control-group" style="margin-bottom: 10px;">

                                    <label class="control-label">Postleitzahl <span style="color: red;">*</span> </label>

                                    <input type="text" class="form-control input-required" name="Address[zip]" id="zip" data-custom-field-id="1"
                                        wtx-context="3527ADEA-82DC-4388-9789-A1445B3857E1"  value="<?php if (@mw()->user_manager->session_get("zip") != null){
                                        print mw()->user_manager->session_get("zip");
                                    } ?>" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group" style="margin-bottom: 10px;">

                                <label class="control-label">Stadt <span style="color: red;">*</span> </label>

                                <input type="text" class="form-control input-required" name="Address[city]" id="city" data-custom-field-id="1"
                                    wtx-context="EEAE35A0-7872-4188-B888-331AEAC9A9E3"  value="<?php if (@mw()->user_manager->session_get("city") != null){
                                    print mw()->user_manager->session_get("city");
                                } ?>" required>

                                </div>
                            </div>
                        </div>

                        <div class="control-group" style="margin-bottom: 10px;">

                            <!-- <label class="control-label ">Bundesland </label> -->

                            <input type="hidden" class="form-control" name="Address[state]" id="state" data-custom-field-id="1"
                                   wtx-context="268FD460-6B51-4516-8B21-70B126A7F8BC" value="<?php if (@mw()->user_manager->session_get("state") != null){
                                    print mw()->user_manager->session_get("state");
                                }else{
                                print '';
                            } ?>" >

                        </div>

                        <div class="control-group" style="margin-bottom: 10px;">

                            <label class="control-label">Straße und Hausnummer <span style="color: red;">*</span></label>

                            <input type="text" class="form-control input-required" name="Address[address]" id="address" data-custom-field-id="1"
                                   wtx-context="98B0C40D-FCD4-4DB9-8271-5FF62FFC9A07"  value="<?php if (@mw()->user_manager->session_get("address") != null){
                                print mw()->user_manager->session_get("address");
                            } ?>" required>

                        </div>



                    </div>
                </div>


            </div>
        </div>


        <?php if ($data['help']): ?>
            <span class="help-block"><?php echo $data['help']; ?></span>
        <?php endif; ?>
    </div>
</div>
