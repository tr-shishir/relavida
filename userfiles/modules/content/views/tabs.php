<?php if (!isset($data)) {
    $data = $params;
}

$custom_tabs = mw()->module_manager->ui('content.edit.tabs');
?>

<script>
    mw.lib.require('colorpicker');
</script>


<div id="settings-tabs">
    <?php
    $is_rss = $data['is_rss'] ?? false;

    if ($is_rss != 1) : ?>
        <div class="card style-1 mb-3 images">
            <div class="card-header no-border" id="post-media-card-header">
                <h6><strong><?php _e('Pictures'); ?></strong></h6>
                <div class="post-media-type-holder">
                    <select class="selectpicker" data-title="<?php _e('Add media from'); ?>" data-style="btn-sm" data-width="auto" id="mw-admin-post-media-type">
                        <option value="url"><?php _e('Add image from URL'); ?></option>
                        <option value="server"><?php _e('Browse uploaded'); ?></option>
                        <option value="instagram"><?php _e('Instagram images'); ?></option>
                        <option value="library"><?php _e('Select from Unsplash'); ?></option>
                        <option value="file"><?php _e('Upload file'); ?></option>
                    </select>
                </div>
            </div>
            <div class="card-body pt-3">
                <module id="edit-post-gallery-main" type="pictures/admin" class="pictures-admin-content-type-<?php print trim($data['content_type']) ?>" for="content" content_type="<?php print trim($data['content_type']) ?>" for-id="<?php print $data['id']; ?>" />
            </div>
        </div>
    <?php endif; ?>
    <?php event_trigger('mw_admin_edit_page_tab_2', $data); ?>


    <?php
    $showCustomFields = true;
    if ($data['content_type'] == 'product') {
        $showCustomFields = true;
        include_once __DIR__ . DS . 'product' . DS . 'tabs.php';
    }
    ?>

    <?php if ($showCustomFields): ?>
        <style>
            .fields > .card-body .module > .card {
                background: transparent;
                border: 0;
                box-shadow: unset;
            }

            .fields > .card-body .module > .card > .card-body {
                padding: 0 !important;
            }
            .fields > .card-body .module > .card > .card-header {
                display: none;
            }
        </style>
        <div class="card style-1 mb-3 card-collapse fields">
            <div class="card-header no-border">
                <h6><strong><?php _e("Custom fields"); ?></strong></h6>
                <a href="javascript:;" class="btn btn-link btn-sm" data-toggle="collapse" data-target="#custom-fields-settings"><span class="collapse-action-label"><?php _e('Show') ?></span>&nbsp; <?php _e("Custom fields"); ?></a>
            </div>

            <div class="card-body py-0">
                <div class="collapse" id="custom-fields-settings">
                    <module type="custom_fields/admin" <?php if (trim($data['content_type']) == 'product'): ?> default-fields="price" <?php endif; ?> content-id="<?php print $data['id'] ?>" suggest-from-related="true" list-preview="true" id="fields_for_post_<?php print $data['id']; ?>"/>
                    <?php event_trigger('mw_admin_edit_page_tab_3', $data); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php /*if (trim($data['content_type']) == 'product'):  */?><!--
        <div class="card style-1 mb-3">
            <div class="card-body pt-3">
                <?php /*event_trigger('mw_edit_product_admin', $data); */?>
            </div>
        </div>
    --><?php /*endif;  */?>

    <?php event_trigger('mw_admin_edit_page_tab_4', $data); ?>

    <?php if (!empty($custom_tabs)): ?>
        <?php foreach ($custom_tabs as $item): ?>
            <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
            <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
            <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
            <div class="card style-1 mb-3 custom-tabs">
                <div class="card-body pt-3"><?php print $html; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <module type="content/views/advanced_settings" content-id="<?php print $data['id']; ?>" content-type="<?php print $data['content_type']; ?>" subtype="<?php print $data['subtype']; ?>"/>
    <?php event_trigger('content/views/advanced_settings', $data); ?>
</div>


<script>
    $(document).ready(function () {

        pick1 = mw.colorPicker({
            element: '.mw-ui-color-picker',
            position: 'bottom-left',
            onchange: function (color) {

            }
        });

        setTimeout(function (){
            mw.askusertostay = false;
            document.querySelector('.js-bottom-save').disabled = true;
        }, 999)

    });

    $("#mw-admin-post-media-type").on('change', function(){
            if($(this).val()=='instagram'){
                $('#instragram-gallery-modal').modal('show');

            }

            $('li.selected.active').on('click', function(){
                if($('li.selected.active span.text').html()=='Instagram images'){
                    $('#instragram-gallery-modal').modal('show');
                }
            });


        });
</script>
