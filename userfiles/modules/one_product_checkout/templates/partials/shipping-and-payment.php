<style>
    .well {
        min-height: auto !important;
    }
</style>

<div class="mw-ui-row shipping-and-payment mw-shop-checkout-personal-info-holder">
    <div class="mw-ui-col" style="width: 33%;">
        <div class="mw-ui-col-container">
            <?php if (is_logged()) { ?>
                <div class="well checkout-box-shadow-style" style="margin-bottom:30px">
                    <?php $user = get_user(); ?>
                    <h3 style="margin-top:0 " class="nodrop checkout-form-heading" rel_id="<?php print $params['id'] ?>">
                        Pers&ouml;nliche Informationen
                    </h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php _e("Vorname"); ?> <span style="color: red;">*</span>
                                </label>
                                <input name="first_name" class="field-full form-control input-required" id="first_name" type="text" value="<?php if (isset($user['first_name'])) {
                                                                                                                                                print $user['first_name'];
                                                                                                                                            } elseif (@mw()->user_manager->session_get("first_name") != null) {
                                                                                                                                                print mw()->user_manager->session_get("first_name");
                                                                                                                                            } ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php _e("Nachname"); ?> <span style="color: red;">*</span>
                                </label>
                                <input name="last_name" id="last_name" class="field-full form-control input-required" type="text" value="<?php if (isset($user['last_name'])) {
                                                                                                                                                print $user['last_name'];
                                                                                                                                            } elseif (@mw()->user_manager->session_get("last_name") != null) {
                                                                                                                                                print mw()->user_manager->session_get("last_name");
                                                                                                                                            } ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <?php _e("Email"); ?> <span style="color: red;">*</span>
                        </label>
                        <input name="email" id="email" class="field-full form-control input-required" type="text" value="<?php if (isset($user['email'])) {
                                                                                                                                print $user['email'];
                                                                                                                            } elseif (@mw()->user_manager->session_get("email") != null) {
                                                                                                                                print mw()->user_manager->session_get("email");
                                                                                                                            } ?>" required />
                    </div>
                    <div class="form-group">
                        <label>
                            <?php _e("Telefon"); ?>
                        </label>
                        <input name="phone" id="phone" class="field-full form-control" type="text" value="<?php if (isset($user['phone'])) {
                                                                                                                print $user['phone'];
                                                                                                            } elseif (@mw()->user_manager->session_get("phone") != null) {
                                                                                                                print mw()->user_manager->session_get("phone");
                                                                                                            } ?>" />
                    </div>
                </div>
            <?php } else { ?>

                <div class="well checkout-box-shadow-style" style="margin-bottom:30px; display:none;" id="guest_check">
                    <?php $user = get_user(); ?>
                    <h3 style="margin-top:0 " class="nodrop checkout-form-heading" rel_id="<?php print $params['id'] ?>">
                        Pers&ouml;nliche Informationen
                    </h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php _e("Vorname"); ?> <span style="color: red;">*</span>
                                </label>
                                <input name="first_name" class="field-full form-control input-required" id="first_name" type="text" value="<?php if (isset($user['first_name'])) {
                                                                                                                                                print $user['first_name'];
                                                                                                                                            } elseif (@mw()->user_manager->session_get("first_name") != null) {
                                                                                                                                                print mw()->user_manager->session_get("first_name");
                                                                                                                                            } ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?php _e("Nachname"); ?> <span style="color: red;">*</span>
                                </label>
                                <input name="last_name" id="last_name" class="field-full form-control input-required" type="text" value="<?php if (isset($user['last_name'])) {
                                                                                                                                                print $user['last_name'];
                                                                                                                                            } elseif (@mw()->user_manager->session_get("last_name") != null) {
                                                                                                                                                print mw()->user_manager->session_get("last_name");
                                                                                                                                            } ?>" required />
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label>
                            <?php _e("Email"); ?> <span style="color: red;">*</span>
                        </label>
                        <input name="email" id="email" class="field-full form-control input-required" type="text" value="<?php if (isset($user['email'])) {
                                                                                                                                print $user['email'];
                                                                                                                            } elseif (@mw()->user_manager->session_get("email") != null) {
                                                                                                                                print mw()->user_manager->session_get("email");
                                                                                                                            } ?>" required />
                    </div>
                    <div class="form-group">
                        <label>
                            <?php _e("Telefon"); ?>
                        </label>
                        <input name="phone" id="phone" class="field-full form-control" type="text" value="<?php if (isset($user['phone'])) {
                                                                                                                print $user['phone'];
                                                                                                            } elseif (@mw()->user_manager->session_get("phone") != null) {
                                                                                                                print mw()->user_manager->session_get("phone");
                                                                                                            } ?>" />
                    </div>
                </div>

                <div class="well checkout-box-shadow-style" style="margin-bottom:30px;" id="hideit">
                    <p>Für die Kasse als Gast klicken Sie bitte auf die Schaltfläche</p>
                    <button type="button" class="btn btn-info" onclick="guest_check()">weiter als Gast</button>

                    <hr>


                    <p>oder Melden Sie sich mit Ihren Daten an</p>
                    <a href="#" class="js-login-modal btn btn-login btn-primary" data-toggle="modal" data-target="#loginModal">Anmeldung</a>

                </div>

            <?php } ?>
            <?php if ($cart_show_shipping != 'n') : ?>
                <div class="well mw-shop-checkout-shipping-holder checkout-box-shadow-style">

                    <module type="shop/shipping" />

                </div>
            <?php endif; ?>
            <div class="mt-3" style="text-align:right;">
                <input type="checkbox" checked name="billing_checkbox" id="billing_checkbox">&nbsp;
                <label for="billing_checkbox">Lieferadresse entspricht der Rechnungsadresse</label>
            </div>
            <div class="billing_address mt-5" id="billing_address" style="display:none;">
                <div class="well mw-shop-checkout-shipping-holder checkout-box-shadow-style">

                    <module type="shop/billing" />

                </div>
            </div>
        </div>

    </div>


</div>


<script>
    function guest_check() {
        $('#hideit').css('display', 'none');
        $('#guest_check').css('display', 'block');
    }

    $('#billing_checkbox').click(function() {
        if (document.getElementById('billing_checkbox').checked) {
            $('#billing_address').css('display', 'none');
        } else {
            $('#billing_address').css('display', '');
        }
    });
</script>