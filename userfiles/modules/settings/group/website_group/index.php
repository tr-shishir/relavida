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

if (isset($_GET['group']) and $_GET['group']) {
    $group = $_GET['group'];

    if ($group == 'general') {
        $show_inner = 'settings/group/website';
    } elseif ($group == 'updates') {
        $show_inner = 'updates';
    } elseif ($group == 'email') {
        $show_inner = 'settings/group/email';
    } elseif ($group == 'template') {
        $show_inner = 'settings/group/template';
    } elseif ($group == 'advanced') {
        $show_inner = 'settings/group/advanced';
    } elseif ($group == 'files') {
        $show_inner = 'files/admin';
    } elseif ($group == 'login') {
        $show_inner = 'settings/group/users';
    } elseif ($group == 'language') {
        $show_inner = 'settings/group/language';
    }
    //elseif ($group == 'privacy') {
      //  $show_inner = 'settings/group/privacy';
    //}
    elseif ($group == 'searchhits') {
        $show_inner = 'settings/group/searchhits';
    }elseif ($group == 'postlimit') {
        $show_inner = 'settings/group/postlimit';
    }elseif ($group == 'blog_menu') {
        $show_inner = 'settings/group/blog_menu';
    }elseif ($group == 'seo') {
        $show_inner = 'settings/group/seo_settings';
    } elseif ($group == 'performance') {
        $show_inner = 'settings/group/performance';
    }elseif ($group == 'thank_you_tag_page') {
        $show_inner = 'settings/group/thank_you_tag_page';
    } elseif ($group == 'display_blog') {
        $show_inner = 'settings/group/display_blog';
    }else{
        $show_inner = false;
    }
}
?>

<?php if ($show_inner): ?>
    <module type="<?php print $show_inner ?>"/>
    <?php return; ?>
<?php endif ?>

<div class="card bg-none style-1 mb-0">
    <div class="card-header px-0">
        <h5><i class="mdi mdi-earth text-primary mr-3"></i> <strong><?php _e('Website settings'); ?></strong></h5>
        <?php
            $total_setting_from_config = count(Config::get('admin_website_menu'));
            $total_setting_from_db = 0;
            if(Schema::hasTable('admin_website_menu')) {
                $total_setting_from_db  = DB::table('admin_website_menu')->count();   
            }
        ?>
        <?php if(isset($total_setting_from_config) and isset($total_setting_from_db) and $total_setting_from_config != $total_setting_from_db): ?>
            <button class="btn btn-primary refresh-btn" onclick="refresh_web_site_settings()">
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
        if(Schema::hasTable('admin_website_menu')) {
            $website_setting_menus = DB::table('admin_website_menu')->where('shortcut', 0)->orderBy('position', 'asc')->get()->toArray();    
        }else{
            $website_setting_menus = [];
        }
    ?>
    <div class="card-body pt-3 px-0">
        <div class="card style-1 mb-3">
            <div class="card-body pt-3 px-5">
                <div class="row select-settings" id="website-setting-sortable" data-type="0">
                    <?php foreach($website_setting_menus as  $setting_manu): ?>    
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
                                if($setting_manu->onclick){
                                    $onclicklink = $setting_manu->onclick;
                                }else{
                                    $onclicklink = "";
                                }
                            }
                        ?>
                        
                        <div class="col-12 col-sm-6 col-lg-4 " data-shortcut="<?php print $setting_manu->shortcut ?>" data-index="<?php print $setting_manu->id ?>">
                            <a href="<?php print $menu_link; ?>" class="d-flex my-3" <?php if($setting_manu->onclick){ print  $onclicklink; } ?>>
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
                    <?php if(isset($website_setting_menus) && empty($website_setting_menus)): ?>
                        <div class="empty-website-setting-menu"> <?php _e("Empty Website Setting Menu"); ?> </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function refresh_web_site_settings(){
        $.get("<?=api_url('admin_website_menu_update');?>", function(res) {
            // console.log(res);
        }).then((res, err) => {
            mw.notification.success("Settings habe been refreshed");
            location.reload();
            console.log(res , err);
        });
    }
</script>