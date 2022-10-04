<?php must_have_access(); ?>
<script>
    $(document).ready(function () {
        mw.options.form('.<?php print $config['module_class'] ?>,.mw_adm_cont_head_change_holder', function () {
            mw.notification.success("<?php _ejs("Advanced settings updated"); ?>.");
        });
        mw.options.form('.<?php print $config['module_class'] ?>,.mw_adm_robots_txt_change_holder', function () {
            mw.notification.success("<?php _ejs("Advanced settings updated"); ?>.");
        });
    });

    function settings_load_module(title, module) {
        $("#mw_admin_edit_settings_load_module_popup").remove();
        mw_admin_edit_settings_load_module = mw.dialog({
            content: '<div id="mw_admin_edit_settings_load_module"></div>',
            title: title,
            id: 'mw_admin_edit_settings_load_module_popup',
        });
        var params = {}
        mw.load_module(module, '#mw_admin_edit_settings_load_module', null, params);
    }

    function reloadMwDB() {
        $.post( mw.settings.api_url + 'mw_post_update' );
        mw.notification.success("<?php _ejs("The DB was reloaded"); ?>.");
    }

    function reload_all_module(){
        $.post( mw.settings.api_url + 'mw_reload_modules' );
        mw.notification.success("<?php _ejs("The Modules was reloaded"); ?>.");
    }
</script>

<div class="<?php print $config['module_class'] ?>">
    <div class="card bg-none style-1 mb-0 card-settings">
        <div class="card-header px-0">
            <div>

            </div>
        </div>

        <div class="card-body pt-3 pb-0 px-0">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="font-weight-bold"><?php _e("SEO Settings"); ?></h5>
                    <small class="text-muted"><?php _e('Fill in the fields for maximum results when finding your website in search engines.'); ?></small>
                </div>
                
                <div class="col-md-9">
                    <div class="card bg-light style-1 mb-3">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label class="control-label"><?php _e("Website Name"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("This is very important for search engines.") . ' '; ?><?php _e("Your website will be categorized by many criteria and its name is one of them."); ?></small>
                                        <input  autocomplete="off" name="website_title" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option('website_title', 'website'); ?>"/>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="control-label"><?php _e("Website Description"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Describe what your website is about"); ?>.</small>
                                        <textarea autocomplete="off" name="website_description" class="mw_option_field form-control" rows="7" type="text" option-group="website"><?php print get_option('website_description', 'website'); ?></textarea>
                                    </div>

                                    <?php
                                    /*        <div class="form-group">
                                                <label class="control-label">
                                                    <?php _e("Shop Enable/Disable"); ?>
                                                </label>

                                                <div class="mw-ui-check-selector">
                                                    <label class="mw-ui-check" style="margin-right: 15px;">
                                                        <input name="shop_disabled" class="mw_option_field" onchange="" data-option-group="website" value="n" type="radio" <?php if (get_option('shop_disabled', 'website') != "y"): ?> checked="checked" <?php endif; ?> >
                                                        <span></span><span><?php _e("Enable"); ?></span>
                                                    </label>
                                                    <label class="mw-ui-check">
                                                        <input name="shop_disabled" class="mw_option_field" onchange="" data-option-group="website" value="y" type="radio" <?php if (get_option('shop_disabled', 'website') == "y"): ?> checked="checked" <?php endif; ?> >
                                                        <span></span> <span><?php _e("Disable"); ?></span>
                                                    </label>
                                                </div>
                                            </div>*/
                                    ?>

                                    <div class="form-group">
                                        <label class="control-label"><?php _e("Website Keywords"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Ex.: Cat, Videos of Cats, Funny Cats, Cat Pictures, Cat for Sale, Cat Products and Food"); ?></small>
                                        <input autocomplete="off" name="website_keywords" class="mw_option_field form-control" type="text" option-group="website" value="<?php print get_option('website_keywords', 'website'); ?>"/>
                                    </div>

                                    <div class="form-group js-permalink-edit-option-hook">
                                        <label class="control-label"><?php _e("Permalink Settings"); ?></label>
                                        <small class="text-muted d-block mb-2"><?php _e("Choose the URL posts & page format."); ?></small>
                                        <?php $permalinkStructures = mw()->permalink_manager->getStructures(); ?>
                                        <?php $currentPremalinkStructure = get_option('permalink_structure', 'website'); ?>


                                        <div class="d-block d-xl-flex align-items-center">
                                            <small class="mr-2 my-2 font-weight-bold"><?php echo mw()->url_manager->site_url(); ?> </small>
                                            <select name="permalink_structure" class="selectpicker mw_option_field" data-width="100%" data-style="btn-sm" option-group="website">
                                                <?php if (is_array($permalinkStructures)): ?>
                                                    <?php foreach ($permalinkStructures as $structureKey => $structureVal): ?>
                                                        <option value="<?php print $structureKey ?>" <?php if ($currentPremalinkStructure == $structureKey): ?> selected="selected" <?php endif; ?>><?php print $structureVal ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="thin mx-4"/>
        <div class="card-body pt-3 pb-0 px-0">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="font-weight-bold"><?php _e("Advanced SEO Settings"); ?></h5>
                    <small class="text-muted"><?php _e('Make these settings to get the best results when finding your website.'); ?></small>
                </div>
                <div class="col-md-9">
                    <div class="card bg-light style-1 mb-3">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <module type="settings/group/seo"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="thin"/>

                    <div class="card bg-light style-1 mb-1">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <module type="settings/group/custom_head_tags"/>
                                    <module type="settings/group/custom_footer_tags"/>
                                    <module type="settings/group/robots_txt"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


