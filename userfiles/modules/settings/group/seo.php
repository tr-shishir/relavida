<?php must_have_access(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        mw.options.form('.<?php print $config['module_class'] ?>', function () {
            mw.notification.success("<?php _ejs("All changes are saved"); ?>.");
        });
    });
</script>

<div class="form-group">
    <label class="control-label"><?php _e("Site verification code for"); ?> Google</label>
    <small class="text-muted d-block mb-2"><?php _e("If you have a Google Tag Manager account, you can verify ownership of a site using your Google Tag Manager container snippet code. To verify ownership using Google Tag Manager: Choose Google Tag Manager in the verification details page for your site, and follow the instructions shown."); ?></small>
    <?php $key_name = 'google-site-verification-code'; ?>
    <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>"/>
</div>

<div class="form-group">
    <label class="control-label"><?php _e('Google Analytics ID'); ?></label>
    <small class="text-muted d-block mb-2"><?php _e("Google Analytics' property ID is the identifier associated with your account and used by Google Analytics to collect the data."); ?></small>
    <?php $key_name = 'google-analytics-id'; ?>
    <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>" placeholder="Ex. UA-54516993-1"/>
</div>

<div class="form-group">
    <label class="control-label"><?php _e('Google Tag Manager integration'); ?></label>
    <small class="text-muted d-block mb-2"><?php _e(" Google Tag Manager integration' property ID is the identifier associated with your account and used by Google Analytics to collect the data."); ?></small>
    <?php $key_name = 'google-tag-manager-id'; ?>
    <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>" placeholder="Ex. GMT-23435632-1"/>
</div>

<div class="form-group">
    <label class="control-label"><?php _e('Google Ads Conversion ID'); ?> </label>
    <small class="text-muted d-block mb-2"><?php _e("Google Ads Conversion ID' property ID is the identifier associated with your account and used by Google Analytics to collect the data."); ?> </small>
    <?php $key_name = 'google-ads-id'; ?>
    <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>" placeholder="Ex. 828262687"/>
</div>

<div class="form-group">
    <label class="control-label"><?php _e('Google Ads Conversion Label'); ?> </label>
    <small class="text-muted d-block mb-2"><?php _e("Google Ads Conversion Label' property ID is the identifier associated with your account and used by Google Analytics to collect the data."); ?> </small>
    <?php $key_name = 'google-ads-label'; ?>
    <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>" placeholder="Ex. cXy7CVBCi-EYTRKS-PkD"/>
</div>

<a href="javascript:$('.other-site-verification-codes-hidden-toggle').toggle();void(0)" class="btn btn-outline-primary btn-sm mb-3"><?php _e('Other search engines'); ?></a>
<script>
    $(document).ready(function () {
        $('#js-static_files_delivery_method_select').on('change', function () {
            if (this.value == 'cdn_domain' || this.value == 'content_proxy') {
                $(".js-toggle-content-proxy-settings").show();
            }
            else {
                $(".js-toggle-content-proxy-settings").hide();
            }
        });
    });
</script>

<div class="other-site-verification-codes-hidden-toggle" style="display: none">
    <div class="form-group">
        <label class="control-label"><?php _e("Verification code for"); ?> Bing</label>
        <small class="text-muted d-block mb-2"><?php _e("You can find a tutorials in internet where and how to find the code"); ?></small>
        <?php $key_name = 'bing-site-verification-code'; ?>
        <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>"/>
    </div>

    <div class="form-group">
        <label class="control-label"><?php _e("Verification code for"); ?> Alexa</label>
        <small class="text-muted d-block mb-2"><?php _e("You can find a tutorials in internet where and how to find the code"); ?></small>
        <?php $key_name = 'alexa-site-verification-code'; ?>
        <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>"/>
    </div>

    <div class="form-group">
        <label class="control-label"><?php _e("Verification code for"); ?> Pinterest</label>
        <small class="text-muted d-block mb-2"><?php _e("You can find a tutorials in internet where and how to find the code"); ?></small>
        <?php $key_name = 'pinterest-site-verification-code'; ?>
        <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>"/>
    </div>

    <div class="form-group">
        <label class="control-label">
            <?php _e("Verification code for"); ?> Yandex </label>
        <small class="text-muted d-block mb-2"><?php _e("You can find a tutorials in internet where and how to find the code"); ?></small>
        <?php $key_name = 'yandex-site-verification-code'; ?>
        <input name="<?php print $key_name ?>" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option($key_name, 'website'); ?>"/>
    </div>
</div>