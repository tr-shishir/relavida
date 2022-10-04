<?php



event_bind('mw.admin.shop.settings.menu', function ($data) {
    print ' <div class="col-12 col-sm-6 col-lg-4">
                <a href="?group=payments" class="d-flex my-3">
                            <div class="icon-holder">
                                <img src="'.modules_url().'admin-logo/shop-settings/2.png" alt="">
                            </div>

                    <div class="info-holder">
                        <span class="text-primary font-weight-bold">' . _e('Zahlungsanbieter', true) . '</span><br/>
                        <small class="text-muted">' . _e('Select and set up a payment provider', true) . '</small>
                    </div>
                </a>
            </div>';
});