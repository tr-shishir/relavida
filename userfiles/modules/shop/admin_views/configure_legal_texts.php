<style>
.icon-holder {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.icon-holder img {
    height: 30px !important;
    width: 30px !important;
    object-fit: cover;
}
.info-holder {
    width: 80% !important;
    display: block;
}
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

.legal-texts-with-toggle{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
/* .it-legals-link{
    pointer-events: none;
}
.protected-legals-link{
    pointer-events: none;
} */


</style>

<div class="card bg-none style-1 mb-0">
    <div class="card-header px-0">
        <h5><i class="mdi mdi-shopping text-primary mr-3"></i> <strong><?php _e("Configure legal texts settings"); ?></strong></h5>
        <div>

        </div>
    </div>
    <div class="card-body pt-3 px-0">
        <div class="card style-1 mb-3">
            <div class="card-body pt-3 px-5">
                <div class="row select-settings">
                    <?php
                        $it_recht_value =  'itrecht';
                        $protected_shop_value = 'protectedshop';
                        $active_legal_option = get_option('active_legal_option_name', 'active_legal_option_name') ?? null;
                        if($active_legal_option == $it_recht_value){
                            $it_recht = true;
                            $proitected_shop= false;
                        }else if($active_legal_option == $protected_shop_value){
                            $proitected_shop = true;
                            $it_recht = false;
                        }else{
                            $it_recht = false;
                            $proitected_shop= false;
                        }
                        // dump($active_legal_option);
                    ?>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="legal-texts-with-toggle">
                            <a href="<?php print admin_url(); ?>view:shop/load_module:token_url" class="d-flex my-3 it-legals-link" <?php if(!$it_recht): ?> style="pointer-events: none;" <?php endif; ?>>
                                <div class="icon-holder"><img src="<?php print modules_url(); ?>shop/admin_views/it_recht.jpg" style="height:20px;width:20px;" alt=""></div>
                                <div class="info-holder">
                                    <span class="text-primary font-weight-bold"><?php _e('IT-Recht Kanzlei (Rechtstexte)'); ?></span><br/>
                                    <small class="text-muted"><?php _e('IT Recht Kanzlei settings'); ?></small>
                                </div>
                            </a>
                            <div>
                                <label class="thank-switch">
                                    <input type="radio" onclick="onlegalstext('<?php print $it_recht_value; ?>')" <?php if($it_recht): ?> checked <?php endif; ?> name="active_legal_option" >
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="legal-texts-with-toggle">
                            <a href="https://drm.software/admin/shop_setting?id=10" target="_blank" class="d-flex my-3 protected-legals-link" <?php if(!$proitected_shop): ?> style="pointer-events: none;" <?php endif; ?>>
                                <div class="icon-holder"><img src="<?php print modules_url(); ?>admin-logo/shop-settings/protected-shop.png" style="height:20px;width:20px;" alt=""></div>
                                <div class="info-holder">
                                    <span class="text-primary font-weight-bold"><?php _e('Protected Shops'); ?></span><br/>
                                    <small class="text-muted"><?php _e('Protected Shops Settings'); ?></small>
                                </div>
                            </a>
                            <div>
                                <label class="thank-switch">
                                    <input type="radio" onclick="onlegalstext('<?php print $protected_shop_value; ?>')" <?php if($proitected_shop): ?> checked <?php endif; ?> name="active_legal_option" id="protect-stop">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__privacy" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Datenschutz'); ?></span><br/>
                                <small class="text-muted"><?php _e('Datenschutz settings'); ?></small>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__payment-info" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Payment information'); ?></span><br/>
                                <small class="text-muted"><?php _e('Payment information settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__battg-info" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('BattG information'); ?></span><br/>
                                <small class="text-muted"><?php _e('Information according to BattG settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__agb" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('AGB'); ?></span><br/>
                                <small class="text-muted"><?php _e('AGB settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__cancellation-policy" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Cancellation policy'); ?></span><br/>
                                <small class="text-muted"><?php _e('Cancellation policy with cancellation form settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__imprint" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Impressum'); ?></span><br/>
                                <small class="text-muted"><?php _e('Impressum settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:legals__elektrog-info" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('ElektroG Note'); ?></span><br/>
                                <small class="text-muted"><?php _e('Note according to ElektroG settings'); ?></small>
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/action:cookie_consent_manager" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>shop/admin_views/consent_manager.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Cookie Consent Manager'); ?></span><br/>
                                <small class="text-muted"><?php _e('Cookie consent manager settings'); ?></small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function onlegalstext(data){
        if(data == '<?php print $it_recht_value; ?>'){
            $('.it-legals-link').css('pointer-events', 'auto');
            $('.protected-legals-link').css('pointer-events', 'none');
            $.ajax({
                type: "POST",
                url: "<?=api_url('active_legal_option_save')?>",
                data:{ data }
            });
        }else if(data == '<?php print $protected_shop_value; ?>'){
            $('.it-legals-link').css('pointer-events', 'none');
            $.ajax({
                type: "POST",
                url: "<?=api_url('producted_shop_legal_document')?>",
                data:{ data },
                success: function(response) {
                    if(response.message == 'success'){
                        $('.protected-legals-link').css('pointer-events', 'auto');
                        mw.notification.success("Protected shop has been connected");
                    }else{
                        $('#protect-stop').prop('checked', false);
                        mw.tools.confirm("<?php _ejs("The protected shop isn't connected at this moment. To configure the protected shop please go to the shop settings of the Dropmatix then come back to Droptienda again and turn on the toggle button of protected shop. Do you want to go to the Dropmatix shop settings now"); ?>?", function () {
                            window.open("https://drm.software/admin/shop_setting?id=10", "_blank");
                        });
                    }
                }
            });
        }
    }
</script>
