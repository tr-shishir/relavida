<style>
.icon-holder {
    background: whitesmoke;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}
.select-settings a:hover .icon-holder{
    background-color: #074A74 !important;
}
</style>

<div class="card bg-none style-1 mb-0">
    <div class="card-header px-0">
        <h5><i class="mdi mdi-shopping text-primary mr-3"></i> <strong><?php _e("IT Recht Kanzlei settings"); ?></strong></h5>
        <div>

        </div>
    </div>
    <div class="card-body pt-3 px-0">
        <div class="card style-1 mb-3">
            <div class="card-body pt-3 px-5">
                <div class="row select-settings">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="<?php print admin_url(); ?>view:shop/load_module:token_url" class="d-flex my-3">
                            <div class="icon-holder"><img src="<?php print modules_url(); ?>default.png" style="height:20px;width:20px;" alt=""></div>
                            <div class="info-holder">
                                <span class="text-primary font-weight-bold"><?php _e('Token Url'); ?></span><br/>
                                <small class="text-muted"><?php _e('Token url settings'); ?></small>
                            </div>
                        </a>
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
                </div>
            </div>
        </div>
    </div>
</div>
