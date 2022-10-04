<style>
    .refresh-btn{
        position: relative;
    }

    .refresh-btn span{
        margin-left: 2px;
    } 

    .refresh-btn-tooltip {
        position: absolute;
        top: -41px;
        right: 0;
        width: max-content;
        background-color: #555;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 10px;
        visibility: hidden;
        opacity: 0;
        transition: all .3s;
    }

    .refresh-btn:hover .refresh-btn-tooltip {
        visibility: visible;
        opacity: 1;
    }

    .refresh-btn-tooltip::after{
        content: "";
        position: absolute;
        top: 100%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
        transform: rotate(-2deg);
        right: 36px;
    }
</style>
<script>
    $(document).ready(function () {
        $('body .main > main').addClass('page-settings');
    });
</script>


<?php
$show_inner = false;
$show_inner_trigger = false;

if (isset($_GET['group']) and $_GET['group']) {
    $group = $_GET['group'];

    if ($group == 'general') {
        $show_inner = 'shop/payments/currency';
    } elseif ($group == 'coupons') {
        $show_inner = 'shop/coupons/admin';
    } elseif ($group == 'taxes') {
        $show_inner = 'shop/taxes/admin';
    } elseif ($group == 'payments') {
        $show_inner = 'shop/payments/admin';
    } elseif ($group == 'invoices') {
        $show_inner = 'shop/orders/settings/invoice_settings';
    } elseif ($group == 'shipping') {
        $show_inner = 'shop/shipping/admin';
    } elseif ($group == 'mail') {
        $show_inner = 'shop/orders/settings/setup_emails_on_order';
    } elseif ($group == 'other') {
        $show_inner = 'shop/orders/settings/other';
    }  elseif ($group == 'quantity') {
        $show_inner = 'shop/products/quantity_status';
    } elseif ($group == 'subProduct') {
        $show_inner = 'shop/subscriptionProduct/admin';
    } elseif ($group == 'tax_rates') {
        $show_inner = 'shop/tax_rates/admin';
    } elseif ($group == 'handlingtime') {
        $show_inner = 'shop/handlingtime/admin';
    } else {
        $show_inner = 'trigger';
        $show_inner_trigger = $group;
    }
}
?>

<?php event_trigger('mw.admin.shop.settings', $params); ?>

<?php if ($show_inner): ?>
    <?php if ($show_inner != 'trigger'): ?>
        <module type="<?php print $show_inner ?>"/>
    <?php else: ?>
        <?php event_trigger('mw.admin.shop.settings.' . $show_inner_trigger, $params); ?>
    <?php endif; ?>

    <?php return; ?>
<?php endif ?>

<div class="card bg-none style-1 mb-0">
    <div class="card-header px-0">
        <h5><i class="mdi mdi-shopping text-primary mr-3"></i> <strong><?php _e("Shop settings"); ?></strong></h5>
        <?php
            $total_setting_from_config = count(Config::get('admin_shop_menu'));
            $total_setting_from_db = 0;
            if(Schema::hasTable('admin_website_menu')) {
                $total_setting_from_db  = DB::table('admin_shop_menu')->count();   
            }
        ?>
        <?php if(isset($total_setting_from_config) and isset($total_setting_from_db) and $total_setting_from_config != $total_setting_from_db): ?>
            <button class="btn btn-primary refresh-btn" onclick="refresh_web_shop_settings()">
                <i class="mdi mdi-cog-refresh" aria-hidden="true"></i>
                <?php _e('Refresh'); ?>
                <span>(<?php echo ($total_setting_from_config-$total_setting_from_db); ?>)</span>
                <span class="refresh-btn-tooltip">
                <?php _e('You have new settings, refresh settings module'); ?>
                </span>
            </button>
            <?php endif; ?>
    </div>

    <?php
    if (Schema::hasTable('admin_shop_menu')) {
        $shop_setting_manus = DB::table('admin_shop_menu')->where('shortcut', 0)->orderBy('position', 'asc')->get()->toArray();
    }else{
        $shop_setting_manus = [];
    }

    ?>
    <div class="card-body pt-3 px-0">
        <div class="card style-1 mb-3">
            <div class="card-body pt-3 px-5">
                <div class="row select-settings" id="shop-setting-sortable" data-type="0">
                    <?php foreach( $shop_setting_manus as  $setting_manu): ?>
                        <?php
                            if($setting_manu->link){
                                $menu_link = $setting_manu->link;
                            }else if($setting_manu->mw_link){
                                $menu_link = '?'.$setting_manu->mw_link;
                            }else if($setting_manu->dt_link){
                                $menu_link = admin_url().$setting_manu->dt_link;
                            }else if($setting_manu->dt_temp_link){
                                $menu_link = site_url().$setting_manu->dt_temp_link;
                            }else{
                                $menu_link = "#";
                            }
                        ?>

                        <div class="col-12 col-sm-6 col-lg-4 " data-shortcut="<?php print $setting_manu->shortcut ?>" data-index="<?php print $setting_manu->id ?>">
                            <a href="<?php print $menu_link; ?>" class="d-flex my-3">
                                <div class="icon-holder">
                                    <?php if($setting_manu->icon): ?>
                                        <i class="<?php print $setting_manu->icon;  ?>"></i>
                                    <?php elseif($setting_manu->img): ?>
                                        <img src="<?php print modules_url().$setting_manu->img; ?>"  alt="">
                                    <?php else: ?>
                                        <i class="mdi mdi-cog mdi-20px"></i>
                                    <?php endif; ?>

                                </div>
                                <div class="info-holder">
                                    <span class="text-primary font-weight-bold"><?php _e($setting_manu->name); ?></span><br/>
                                    <small class="text-muted"><?php _e($setting_manu->sub_name);  ?></small>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>


                    <?php if(isset($shop_setting_manus) && empty($shop_setting_manus)): ?>
                        <div class="empty-shop-setting-menu"> <?php _e('Empty Shop Settings Menu'); ?> </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function refresh_web_shop_settings(){
        $.get("<?=api_url('admin_shop_menu_update');?>", function(res) {
            // console.log(res);
        }).then((res, err) => {
            mw.notification.success("Settings have been refreshed");
            location.reload();
            console.log(res , err);
        });

    }
</script>