<?php



event_bind('mw.admin.shop.settings.menu', function ($data) {
    print ' <div class="col-12 col-sm-6 col-lg-4">
                <a href="?group=shipping" class="d-flex my-3">
                            <div class="icon-holder">
                                <img src="'.modules_url().'admin-logo/shop-settings/11.png" alt="">
                            </div>

                    <div class="info-holder">
                        <span class="text-primary font-weight-bold">' . _e('Versandeinstellungen', true) . '</span><br/>
                        <small class="text-muted">' . _e('Delivery methods and suppliers', true) . '</small>
                    </div>
                </a>
            </div>';
});