<?php if (isset($_COOKIE['mw_basic_mode']) and $_COOKIE['mw_basic_mode'] == '1') {
    return;
} ?>

<style>
    .optin-tab img {
        height: 40px;
        width: 40px;
    }

    .live-edit-export img {
        height: 35px;
        width: 30px;
    }

    .live-edit-export {
        margin-top: 10px;
    }

    .optin-form-element {
        display: block;
        margin-bottom: 30px;
    }

    .optin-form-element-heading {
        color: #fff;
        font-size: 15px;
        background-color: #000;
        padding: 2px 8px;
    }
</style>
<div id="modules-and-layouts-sidebar" class="modules-and-layouts-holder">
    <div id="mw-modules-layouts-tabsnav">
        <a href="javascript:mw.liveEditSettings.hide();" class="mw-close-sidebar-btn"><i class="mw-icon-close"></i></a>


        <div class="mw-live-edit-sidebar-tabs-wrapper">
            <a href="javascript:;" title="<?php _e("Open/Close menu"); ?>" data-id="mw-toolbar-show-sidebar-btn" class="sidebar-toggler">
                <div class="i-holder">
                    <span class="mw-m-menu-button">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>
            </a>
            <div class="mw-live-edit-sidebar-tabs mw-normalize-css">
                <a href="javascript:;" class="tabnav active tip  mw-lslayout-tab" data-tip="<?php _e("Layouts"); ?>" data-tipposition="left-center">
                    <i class="mw-liveedit-cbar-icon"> </i>
                </a>
                <a href="javascript:;" class="tabnav active tip optin-tab  mw-lslayout-tab" data-tip="<?php _e("Optin form"); ?>" data-tipposition="left-center">
                    <img src="<?php print template_url(); ?>assets/image/dropfunnel-ico.png" alt="">
                </a>
                <a href="javascript:;" class="tabnav tip tab mw-lsmodules-tab" data-tip="<?php _e("Modules"); ?>" data-tipposition="left-center"><i class="mw-liveedit-cbar-icon"> </i></a>

                <?php if (file_exists(TEMPLATE_DIR . 'template_settings.php')) { ?>

                    <a href="javascript:;" class="tabnav tip mw-lstemplatee-tab" onclick="mw.liveEditWidgets.loadTemplateSettings('<?php print api_url() ?>module?id=template_settings_admin&live_edit=true&module_settings=true&type=settings/template&autosize=false&content_id=<?php print CONTENT_ID ?>')" data-tip="<?php _e("Template Settings"); ?>" data-tipposition="left-center"><i class="mw-liveedit-cbar-icon"> </i></a>

                <?php } ?>


                <a href="javascript:;" class="tabnav tip mw-lscsse-tab" onclick="mw.liveEditWidgets.cssEditorInSidebarAccordion()" data-tip="<?php _e("Visual Editor"); ?>" data-tipposition="left-center">
                    <i class="mw-liveedit-cbar-icon"> </i>
                </a>
                <!-- <a href="https://drm.software/admin/channel-products?channel=10" target="_blank" class="live-edit-export">
                    <img src="<?php print modules_url(); ?>preisvergleich-export.png" alt="">
                </a>-->
            </div>
        </div>


        <div class="mw-ui-box mw-scroll-box" id="mw-sidebar-modules-and-layouts-holder">
            <div class="tabitem mw-normalize-css">
                <div class="mw-live-edit-tab-title layouts">
                    <h6><?php _e('Layouts'); ?></h6>
                    <div class="mw-liveedit-sidebar-search-wrapper">
                        <label for="search-input">
                            <i class="mw-icon-search" aria-hidden="true"></i>
                        </label>
                        <input onkeyup="mwSidebarSearchItems(this.value, 'layouts')" placeholder="<?php _e('Search for Layouts'); ?>" autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1" data-id="mw-sidebar-search-input-for-modules-and-layouts">
                        <a href="javascript:mwSidebarSearchClear('layouts');" class="mw-sidebar-search-clear-x-btn mw-icon-close" aria-hidden="true" style="display: none;"></a>
                    </div>
                    <p class="mw-search-no-results"><?php _e("No results were found"); ?></p>
                </div>
                <div class="mw-ui-box-content">
                    <?php if (is_post() or is_product()) { ?>
                        <div data-xmodule type="admin/modules/list_layouts" id="mw-sidebar-layouts-list" hide-dynamic="true"></div>
                    <?php } else { ?>
                        <div data-xmodule type="admin/modules/list_layouts" id="mw-sidebar-layouts-list"></div>
                    <?php } ?>
                </div>
            </div>

            <div class="tabitem mw-normalize-css">
                <div class="mw-live-edit-tab-title layouts">
                    <h6><?php _e('Optin form Layouts'); ?></h6>

                </div>
                <div class="mw-ui-box-content">
                    <hr>
                    <h4>Optin Final Form</h4>
                    <hr>
                    <div data-xmodule type="admin/modules/list_optin_form_layouts"></div>

                    <div class="optin-edited-form">
                        <hr>
                        <h4>Optin default Form</h4>
                        <hr>
                        <?php
                        $preview_form_layout = form_layout();
                        $i = 1;
                        ?>
                        <?php foreach ($preview_form_layout as $pre_layout) : ?>
                            <a href="https://drm.software/admin/login?redirect_url=<?php echo site_url('webhook_for_optin_form')  ?>&is_default=true&template_id=<?php echo $pre_layout['id'] ?>" class="optin-form-element" target="_blank">
                                <img src="<?php echo $pre_layout['image'] ?>" alt="">
                                <p class="optin-form-element-heading">Sample <?php echo $i++ ?></p>
                            </a>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>

            <div class="tabitem mw-normalize-css" style="display: none">
                <div class="mw-live-edit-tab-title modules">
                    <h6><?php _e("Modules"); ?></h6>
                    <div class="mw-liveedit-sidebar-search-wrapper">
                        <label for="search-input">
                            <i class="mw-icon-search" aria-hidden="true"></i>
                        </label>
                        <input onkeyup="mwSidebarSearchItems(this.value, 'modules')" placeholder="Search for Modules" autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1" data-id="mw-sidebar-search-input-for-modules-and-layouts">
                        <a href="javascript:mwSidebarSearchClear('modules');" class="mw-sidebar-search-clear-x-btn mw-icon-close" aria-hidden="true" style="display: none;"></a>
                    </div>
                    <p class="mw-search-no-results"><?php _e("No results were found"); ?></p>
                </div>
                <div class="mw-ui-box-content">
                    <div data-xmodule type="admin/modules/list" id="mw-sidebar-modules-list"></div>
                </div>
            </div>
            <?php if (file_exists(TEMPLATE_DIR . 'template_settings.php')) { ?>

                <div class="tabitem mw-normalize-css" style="display: none;">
                    <div class="mw-live-edit-tab-title">
                        <h6><?php _e("Template settings"); ?></h6>
                    </div>

                    <div id="mw-live-edit-sidebar-settings-iframe-holder-template-settings" class="mw-live-edit-sidebar-iframe-holder"></div>


                </div>
            <?php } ?>
            <div class="tabitem ">
                <div class="mw-live-edit-tab-title">
                    <h6><?php _e("Visual editor"); ?></h6>
                </div>
                <div id="mw-css-editor-sidebar-iframe-holder" class="  mw-live-edit-sidebar-iframe-holder"></div>
            </div>
        </div>
        <script>
            mw.require('prop_editor.js');
            mw.require('color.js');
            //mw.require('libs/html2canvas/html2canvas.min.js');

            function mwSidebarSearchClear(what) {
                $('[data-id="mw-sidebar-search-input-for-modules-and-layouts"]').val('');
                $('.mw-sidebar-search-clear-x-btn', '.' + what).hide();
                mwSidebarSearchItems('', what);
                $('.mw-search-no-results', '.' + what).hide();
            }

            function mwSidebarSearchItems(value, what) {
                if (what == 'modules') {
                    var obj = mw.$("#mw-sidebar-modules-list .modules-list > li");
                } else {
                    var obj = mw.$("#mw-sidebar-layouts-list .modules-list > li");
                }
                if (!value) {
                    $('.mw-sidebar-search-clear-x-btn', '.' + what).hide();
                    obj.show();
                    return;
                }

                $('.mw-sidebar-search-clear-x-btn', '.' + what).show();

                var value = value.toLowerCase();

                var numberOfResults = 0;

                var yourArray = [];
                $(obj).each(function() {

                    var show = false;

                    var description = $(this).attr('description') || false;
                    var description = description || $(this).attr('data-filter');
                    var title = $(this).attr('title') || false;
                    var template = $(this).attr('template') || false;

                    if (
                        !!title && title.toLowerCase().contains(value) ||
                        (!!description && description.toLowerCase().contains(value)) ||
                        (!!template && template.toLowerCase().contains(value))

                    ) {
                        var show = true;
                    }

                    if (!show) {
                        $(this).hide();

                    } else {
                        $(this).show();
                        numberOfResults++;
                    }
                });

                if (numberOfResults == 0) {
                    $('.mw-search-no-results', '.' + what).show();
                } else {
                    $('.mw-search-no-results', '.' + what).hide();
                }
            }

            $(document).ready(function() {
                mw.sidebarSettingsTabs = mw.tabs({
                    nav: '#mw-modules-layouts-tabsnav  .tabnav',
                    tabs: '#mw-modules-layouts-tabsnav .tabitem'
                });



                $('#mw-modules-layouts-tabsnav .tabnav').on('mouseup touchend', function() {

                    $('#modules-and-layouts-sidebar .mw-ui-box').scrollTop(0);
                    var active = $(this).hasClass('active');
                    if (!active) {
                        mw.liveEditSettings.show();
                    } else {
                        mw.liveEditSettings.toggle();
                    }

                });


                $("#mw-sidebar-modules-and-layouts-holder").on("mousedown", function(e) {
                    if (e.target.nodeName != 'INPUT' && e.target.nodeName != 'SELECT' && e.target.nodeName != 'OPTION' && e.target.nodeName != 'CHECKBOX') {
                        e.preventDefault();
                    }
                });
                mw.dropdown();
                mw.wysiwyg.init("#mw-sidebar-modules-and-layouts-holder .mw_editor_btn");
                mw.wysiwyg.dropdowns();

                $(".mw-live-edit-sidebar-tabs-wrapper").on('click', function(e) {
                    if (e.target === this) {
                        mw.liveEditSettings.toggle();
                    }
                })


            });

            var setScrollBoxes = function() {
                var root = document.querySelector('#modules-and-layouts-sidebar');
                if (root !== null) {
                    var el = root.querySelectorAll('.mw-scroll-box');
                    for (var i = 0; i < el.length; i++) {
                        var h = (innerHeight - 50 - ($(el[i]).offset().top - $("#live_edit_side_holder").offset().top));
                        el[i].style.height = h + 'px'
                    }
                }
            }

            mw.on('liveEditSettingsReady', function() {
                setScrollBoxes();
                setTimeout(function() {
                    mw.drag.toolbar_modules();
                    $("#mw-sidebar-layouts-list, #mw-sidebar-modules-list").removeClass("module");

                }, 333)

            });

            $(window).on('resize orientationchange', function() {
                setScrollBoxes()
            });
        </script>


        <script>
            mw.liveEditDynamicTemp = {};
        </script>

        <style type="text/css" id="mw-dynamic-css">

        </style>
    </div>