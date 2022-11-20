<script>
    $(document).ready(function () {
        if (window.thismodal && thismodal.resize) {
            thismodal.resize(991);
        }
    });
</script>
<?php

if(isset($_GET['id'])){
    $data = (array)DB::table('product')
    ->where('id',$_GET['id'])
    ->first();
    $categories = DB::table('categories_items')
    ->where('rel_id',$data['id'])
    ->where('rel_type','product')
    ->pluck('parent_id')
    ->toArray();
    $data['category'] = implode(',',$categories);
}

$edit_page_info = isset($data) ? $data : $data = [
    "id" => 0,
    "content_type" => "product",
    "title" => false,
    "content" => false,
    "content_body" => false,
    "url" => "",
    "thumbnail" => "",
    "is_active" => 1,
    "is_home" => 0,
    "is_shop" => 1,
    "require_login" => 0,
    "subtype" => "product",
    "description" => "",
    "active_site_template" => "",
    "subtype_value" => "",
    "parent" => 2,
    "layout_name" => "",
    "layout_file" => "inherit",
    "original_link" => ""
  ];

$module_id = $is_quick = $just_saved = $is_live_edit = 1;
$rand = 2;
$categories_active_ids = $edit_page_info['category'] ?? false;
if (!isset($edit_page_info['title'])) {
    $edit_page_info['title'] = _e('Content title', true);
}

$quick_edit = false;

if (isset($params['quick_edit']) and $params['quick_edit']) {
    $quick_edit = true;
}
?>

<?php if (isset($edit_page_info['title'])): ?>
    <?php $title_for_input = str_replace('"', '&quot;', $edit_page_info['title']); ?>
<?php endif; ?>
<style>
    #admin-user-nav {
        display: none;
    }
</style>
<?php
if (isset($data['content_type']) and $data['content_type'] == 'page') {
    $parent_page_active = 0;
    if ($data['parent'] != 0 and $data['id'] == 0) {
        $data['parent'] = $recommended_parent = 0;
    } elseif (isset($data['parent'])) {
        $parent_page_active = $data['parent'];
    }
}


if (isset($data['id']) and intval($data['id']) == 0 and isset($data['parent']) and intval($data['parent']) != 0) {
    $parent_data = get_content_by_id($data['parent']);
    if (is_array($parent_data) and isset($parent_data['is_active']) and ($parent_data['is_active']) == 0) {
        $data['is_active'] = 0;
    }
}

if ($edit_page_info['content_type'] == 'product') {
    $type = 'Product';
}

$action_text = _e($type, true);
if (isset($edit_page_info['id']) and intval($edit_page_info['id']) != 0) {
    $action_text = _e("Editing " . strtolower($type), true);
} else {
    $action_text = _e("Add " . strtolower($type), true);
}

if (isset($edit_page_info['content_type']) and $edit_page_info['content_type'] == 'post' and isset($edit_page_info['subtype'])) {
    //     $action_text2 = $edit_page_info['subtype'];
}
?>

<?php if (!$quick_edit) { ?>
    <script>
        $(document).ready(function () {
            $('.fade-window .btn-fullscreen').on('click', function () {
                $(this).toggleClass('hidden');
                $('.fade-window .btn-close').toggleClass('hidden');
                $('.fade-window').toggleClass('closed');

            });
            $('.fade-window .btn-close').on('click', function () {
                $(this).toggleClass('hidden');
                $('.fade-window .btn-fullscreen').toggleClass('hidden');
                $('.fade-window').toggleClass('closed');
            });


            $('.fade-window').on('scroll', function () {
                var otop = $('.mw-iframe-editor').offset().top;
                $('#mw-admin-content-iframe-editor iframe').contents().find('#mw-admin-text-editor')[otop <= 0 ? 'addClass' : 'removeClass']('scrolled').css({
                    top: otop <= 0 ? Math.abs(otop) : 0
                });
            })

        });
    </script>
<?php } ?>

<script>
    $(document).ready(function () {
        $('body > #mw-admin-container > .main').removeClass('show-sidebar-tree');
    });
</script>

<script>
    $(document).ready(function () {
        var all = $(window);
        var header = document.querySelector('#mw-admin-container header');
        var postHeader = mw.element(document.querySelector('#content-title-field-row .card-header'));
        all.push(document)
        all.on('scroll load resize', function () {
            var stop = $(this).scrollTop(),
                otop = $('.mw-iframe-editor').offset().top,
                tbheight = $('.admin-toolbar').outerHeight(),
                is = (stop + tbheight) >= otop;


            $('#mw-admin-content-iframe-editor iframe').contents().find('#mw-admin-text-editor')[is ? 'addClass' : 'removeClass']('scrolled').css({
                top: is ? Math.abs((stop + tbheight) - otop) : 0
            });
            var fixinheaderTime = null;
            if (stop > $(".admin-toolbar").height()) {

                $(".top-bar").addClass("fix-in-header").css('left', $('.window-holder').offset().left);
                fixinheaderTime = setTimeout(function () {
                    $(".top-bar").addClass("after-fix-in-header")
                    // $("#create-content-btn").hide()
                }, 10)
            }
            else {
                $(".top-bar").removeClass("fix-in-header after-fix-in-header");
                //$("#create-content-btn").show()
                clearTimeout(fixinheaderTime)

            }
            var isFixed = (stop > (postHeader.get(0).offsetHeight + (header ? header.offsetHeight : 0) + $(postHeader).offset().top));
            postHeader[ isFixed ? 'addClass' : 'removeClass' ]('fixed')
            postHeader.width( isFixed ? postHeader.parent().width() : 'auto' )


        });

        $('[name]').on('change input', function (){
            document.querySelector('.btn-save').disabled = false;
            mw.askusertostay = true;
        })
    });
</script>

<?php
$wrapper_class = 'in-window';
if (isset($params['live_edit'])) {
    $wrapper_class = 'in-popup';
}
if (isset($params['quick_edit'])) {
    $wrapper_class = 'in-popup';
}
?>

<div class="<?php echo $wrapper_class; ?>">

    <?php
    $data['id'] = intval($data['id']);
    $formActionUrl = site_url() . 'api/save_content_admin';
    if ($type == 'Page') {
        $formActionUrl = route('api.page.index');
        if ($data['id'] > 0) {
            $formActionUrl = route('api.page.update', $data['id']);
        }
    }
    if ($type == 'Product') {
        $formActionUrl = route('product.store');
        if ($data['id'] > 0) {
            $formActionUrl = route('product.update', $data['id']);
        }
    }
    if ($type == 'Post') {
        $formActionUrl = route('api.post.index');
        if ($data['id'] > 0) {
            $formActionUrl = route('api.post.update', $data['id']);
        }
    }

    ?>

    <form method="post"  class="mw_admin_edit_content_form" action="<?php echo $formActionUrl; ?>" id="quickform-edit-content" autocomplete="off">

        <?php if ($data['id'] > 0): ?>
            <input name="_method" type="hidden" value="PATCH">
        <?php endif; ?>

        <input type="hidden" name="id" id="mw-content-id-value" value="<?php print $data['id']; ?>"/>
        <input type="hidden" name="content_type" id="mw-content-type-value-<?php print $rand; ?>" value="<?php print $data['content_type']; ?>"/>
        <input type="hidden" name="parent" id="mw-parent-page-value-<?php print $rand; ?>" value="<?php print $data['parent']; ?>" class=""/>

        <div class="row">
            <div class="col-md-8 manage-content-body">
                <div class="card style-1 mb-3" id="content-title-field-row">
                    <div class="card-header-fix">
                        <div class="card-header">
                            <?php
                            $type_icon = 'mdi-text';
                            if ($type == 'Product') {
                                $type_icon = 'mdi-shopping';
                            } elseif ($type == 'Post') {
                                $type_icon = 'mdi-text';
                            } elseif ($type == 'Page') {
                                $type_icon = 'mdi-file-document';
                            }
                            ?>
                            <h5><i class="mdi <?php echo $type_icon; ?> text-primary mr-3"></i> <strong><?php  _e($action_text); ?></strong></h5>
                            <?php

                            $product_limit = json_decode(get_drm_product_limit(),true);
                            if(@$product_limit['limit_amount']<@$product_limit['products'] and @$params['content-id'] == 0 and @$params['content_type'] == 'product'):
                                ?>
                                <div>
                                    <input type="button" onclick="reload_module();" class="btn btn-sm btn-success" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" value="save">
                                </div>
                                <!--product limit popup-->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><b> Your product limit is 500.You have to extend the limit form DRM</b></p>
                                                <a href="https://drm.software/admin/import-payment" class="btn btn-primary">Purchase</a>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            <?php else: ?>

                                <div id="content-title-field-buttons">
                                    <button type="submit" onclick="reload_module();" disabled class="btn btn-sm btn-success btn-save js-bottom-save" form="quickform-edit-content"><span><?php print _e('Save'); ?></span></button>
                                    <?php if(isset($data['id']) && $data['id'] >0 && $data['content_type'] == "page"):
                                        $hide_delete = hide_delete() ?? [];
                                        $tk_url = explode('/',$data['url']);
                                        ?>
 -->
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <script>
                        function reload_module(){
                            $.ajax({
                                url: "<?=api_url('mw_reload_modules')?>"
                            });
                        }
                        mw.delete_single_post = function (id) {
                            mw.tools.confirm("<?php _ejs("Do you want to delete this page"); ?>?", function () {
                                var arr = id;
                                mw.post.del(arr, function () {
                                    mw.$(".manage-post-item-" + id).fadeOut(function () {
                                        $(this).remove()
                                    });
                                });
                                history.go(-1);
                            });
                        }
                    </script>

                    <?php if (isset($edit_page_info['title'])): ?>
                        <div class="card-body pt-3">
                            <div class="form-group" id="slug-field-holder">
                                <label class="control-label">
                                    <?php _e($type.' title'); ?>
                                    <span class="badge serp_status_title"></span>
                                </label>
                                <input type="text" autocomplete="off" class="form-control product-title-bind-meta" name="title" onkeyup="slugFromTitle()" id="content-title-field" value="<?php print ($title_for_input) ?>">

                                <?php if($data['content_type'] == 'product'):?>
                                    <div data-target="content-title-field" class="line_bar">
                                        <div class="line"></div>
                                    </div>
                                <?php endif;?>

                                <div class="mw-admin-post-slug">
                                    <?php
                                    $is_rss = $data['is_rss'] ?? false;

                                    if ($is_rss != 1) : ?>
                                        <i class="mdi mdi-link mdi-20px lh-1_3 mr-1 text-silver float-left" title="Copy link" onclick="copy_url_of_page();" style="cursor: copy"></i>
                                        <span class="mw-admin-post-slug-text">
                                            <?php
                                            if (isset($data['slug_prefix_url'])) {
                                                $site_prefix_url = $data['slug_prefix_url'];
                                            } else {
                                                $site_prefix_url = site_url();
                                            }
                                            ?>

                                            <span class="text-silver" id="slug-base-url"><?php print $site_prefix_url; ?></span>
                                            <?php
                                                $hide_edite = hide_edite();
                                                $url =site_url('admin');
                                                if(in_array($data['url'], $hide_edite)):?>
                                                    <script>
                                                        var adminUrl = "<?php print $url; ?>";
                                                        console.log(adminUrl);
                                                        $(document).ready(function(){
                                                            console.log(adminUrl);
                                                            location.replace(adminUrl)
                                                        });
                                                    </script>
                                            <?php endif; ?>
                                            <span class="contenteditable js-slug-base-url" data-toggle="tooltip" data-title="edit" data-placement="right" contenteditable="true"><?php print $data['url']; ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-none">
                                    <input autocomplete="off" name="url" id="edit-content-url" class="js-slug-base-url-changed edit-post-slug" type="text" value="<?php print $data['url']; ?>"/>

                                    <script>
                                        slugFromTitle = function () {
                                            var slug = mw.slug.create($('#content-title-field').val());
                                            $('.js-slug-base-url-changed').val(slug);
                                            $('.js-slug-base-url').text(slug);
                                        }

                                        $('.js-slug-base-url').on('paste', function (e) {
                                            e.preventDefault();
                                            var text = (e.originalEvent || e).clipboardData.getData('text/plain');
                                            document.execCommand("insertHTML", false, text);
                                            if(this.innerHTML.length > mw.slug.max) {
                                                this.innerHTML = this.innerHTML.substring(0, mw.slug.max)
                                            }
                                            document.querySelector('.btn-save').disabled = false;
                                            mw.askusertostay = true;
                                            slugEdited = true;
                                        })
                                            .on('keydown', function (e) {
                                                var sel = getSelection();
                                                var fn = mw.wysiwyg.validateCommonAncestorContainer(sel.focusNode);
                                                var collapsedIn = fn === this && sel.isCollapsed;
                                                slugEdited = true;
                                                document.querySelector('.btn-save').disabled = false;
                                                mw.askusertostay = true;
                                                if (!mw.event.is.delete(e) && !mw.event.is.backSpace(e) && !e.ctrlKey) {
                                                    if ($('.js-slug-base-url').html().length >= mw.slug.max && collapsedIn) {
                                                        e.preventDefault();
                                                    }
                                                }
                                            })
                                        $('body').on('blur', '.js-slug-base-url', function () {
                                            var slug = mw.slug.create($(this).text());
                                            $('.js-slug-base-url-changed').val(slug);
                                            $('.js-slug-base-url').text(slug);
                                        });


                                        copy_url_of_page =function(){
                                            var site_url =  $('#slug-base-url').html();
                                            var slug_base_url =  $('.js-slug-base-url').html();
                                            var url = site_url + slug_base_url ;
                                            mw.tools.copy(url);
                                        }

                                    </script>
                                </div>
                            </div>





                            <?php $content_edit_modules = mw('ui')->module('admin.content.edit.text'); ?>
                            <?php $modules = array(); ?>
                            <?php
                            if (!empty($content_edit_modules) and !empty($data)) {
                                foreach ($content_edit_modules as $k1 => $content_edit_module) {
                                    foreach ($data as $k => $v) {
                                        if (isset($content_edit_module[$k])) {
                                            $v1 = $content_edit_module[$k];
                                            $v2 = $v;
                                            if (trim($v1) == trim($v2)) {
                                                $modules[] = $content_edit_module['module'];
                                            }
                                        }

                                    }
                                }
                                $modules = array_unique($modules);
                            }
                            ?>

                            <div id="mw-edit-page-editor-holder">
                                <?php event_trigger('content.edit.richtext', $data); ?>
                                <?php $content_edit_modules = mw()->ui->module('content.edit.richtext'); ?>
                                <?php $modules = array(); ?>
                                <?php

                                if (!empty($content_edit_modules) and !empty($data)) {
                                    foreach ($content_edit_modules as $k1 => $content_edit_module) {
                                        if (isset($content_edit_module['module'])) {
                                            $modules[] = $content_edit_module['module'];
                                        }
                                    }
                                    $modules = array_unique($modules);
                                }
                                ?>
                                <?php if (!empty($modules)): ?>
                                    <?php foreach ($modules as $module) : ?>
                                        <?php print load_module($module, $data); ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php if (isset($data['content_type']) and ($data['content_type'] != 'page')): ?>
                                        <div class="form-group">
                                            <?php if (isset($data['content_type']) and ($data['content_type'] == 'product')): ?>


                                                <label class="control-label" title="Content Body"><?php _e('Description') ?></label>

                                                <div id="mw-admin-content-iframe-editor">

                                                    <textarea id="content_template" name="content_body"><?php print $data['content_body']; ?></textarea>

                                                </div>
                                            <?php else: ?>
                                                <label class="control-label"><?php _e("Content"); ?></label>

                                                <div id="mw-admin-content-iframe-editor">

                                                    <textarea id="content_template" name="content"><?php print $data['content']; ?></textarea>

                                                </div>
                                            <?php endif; ?>


                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <div>
                                <script>
                                    $(document).ready(function () {
                                        setTimeout(function () {
                                            $('#content-title-field').focus();
                                            if (typeof(mw.adminPagesTree) != 'undefined') {
                                                mw.adminPagesTree.select({
                                                    id:<?php print $edit_page_info['id']  ?>,
                                                    type: 'page'
                                                })
                                            }
                                            mw.askusertostay = false
                                        }, 100);
                                    });
                                </script>

                                <?php event_trigger('content.edit.title.after'); ?>
                                <?php $custom_title_ui = mw()->module_manager->ui('content.edit.title.after'); ?>

                                <?php if (!empty($custom_title_ui)): ?>
                                    <?php foreach ($custom_title_ui as $item): ?>
                                        <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                                        <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                                        <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                                        <?php $width = (isset($item['width'])) ? ($item['width']) : false; ?>
                                        <div class="mw-ui-col <?php print $class; ?>"<?php if ($width): ?> style="width: <?php print $width ?>;"  <?php endif; ?> title="<?php print $title; ?>"><?php print $html; ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php $custom_title_ui = mw()->module_manager->ui('content.edit.title.end'); ?>
                                <?php if (!empty($custom_title_ui)): ?>
                                    <?php foreach ($custom_title_ui as $item): ?>
                                        <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                                        <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                                        <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                                        <?php $width = (isset($item['width'])) ? ($item['width']) : false; ?>
                                        <div class="mw-ui-col <?php print $class; ?>"<?php if ($width): ?> style="width: <?php print $width ?>;"  <?php endif; ?> title="<?php print $title; ?>"><?php print $html; ?></div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="admin-manage-content-wrap">
                    <?php if (isset($data['content_type']) and ($data['content_type'] == 'page')): ?>
                        <?php if (isset($data['id']) and ($data['id'] == 0)): ?>
                            <module type="content/views/layout_selector" id="mw-quick-add-choose-layout-middle-pos" autoload="yes" template-selector-position="top" live-edit-btn-overlay="true" content-id="<?php print $data['id']; ?>" edit_page_id="<?php print $data['id']; ?>" inherit_from="<?php print $data['parent']; ?>"/>
                        <?php else: ?>
                            <module type="content/views/layout_selector" id="mw-quick-add-choose-layout-middle-pos" autoload="yes" template-selector-position="top" live-edit-btn-overlay="true" content-id="<?php print $data['id']; ?>" edit_page_id="<?php print $data['id']; ?>" inherit_from="<?php print $data['parent']; ?>" small="true" layout_file"="<?php print $data['layout_file']; ?>"   />
                        <?php endif; ?>

                        <?php
                        $data['recommended_parent'] = $recommended_parent;
                        $data['active_categories'] = $categories_active_ids;
                        ?>
                    <?php else: ?>
                        <div id="mw-admin-edit-content-main-area"></div>
                    <?php endif; ?>

                    <?php if (isset($data['subtype']) and $data['subtype'] == 'dynamic' and (isset($data['content_type']) and $data['content_type'] == 'page')): ?>
                        <script>
                            mw.$("#quick-add-post-options-item-template-btn").hide();
                        </script>
                    <?php endif; ?>

                    <div class="mw-admin-edit-content-holder">
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
                                $product = [];
                                $product['id'] = 0;
                                $productPrice = 0;
                                $productEkPrice = 0;
                                $contentData = \MicroweberPackages\Product\Models\Product::$contentDataDefault;
                                $customFields = \MicroweberPackages\Product\Models\Product::$customFields;

                                if ($data['id'] > 0) {

                                    $contentData = [
                                        "sku" => $data['sku'],
                                        "barcode" => "",
                                        "qty" => $data['quantity'],
                                        "track_quantity" => "1",
                                        "max_quantity_per_order" => null,
                                        "sell_oos" => "",
                                        "physical_product" => "",
                                        "free_shipping" => "",
                                        "fixed_cost" => "",
                                        "weight_type" => "kg",
                                        "params_in_checkout" => 0,
                                        "weight" => "",
                                        "width" => "",
                                        "height" => "",
                                        "depth" => "",
                                        "special_price" => "0.00"
                                    ];
                                    $productPrice = $data['vk_price'];
                                    $productEkPrice = $data['ek_price'] ?? 0;
                                }
                                ?>

                                <style>
                                    .info-details {
                                        position: relative;
                                        z-index: 1;
                                        display: inline-block;
                                        line-break: auto;
                                        opacity: 1;
                                    }

                                    .info-details:hover {
                                        z-index: 999;
                                    }


                                    .info-details.vk .tooltiptext, .info-details.ek .tooltiptext{
                                        visibility: hidden;
                                        width: 380px;
                                        background-color: #555;
                                        color: #fff;
                                        text-align: center;
                                        border-radius: 6px;
                                        padding: 10px;
                                        position: absolute;
                                        z-index: 1;
                                        bottom: 22px;
                                        opacity: 0;
                                        transition: opacity 0.3s;

                                    }

                                    .info-details.vk .tooltiptext {
                                        right: -26px;
                                        left: unset;
                                    }

                                    .info-details.ek .tooltiptext {
                                        left: -26px;
                                        right: unset;
                                    }

                                    .info-details.vk .tooltiptext::after,  .info-details.ek .tooltiptext::after{
                                        content: "";
                                        position: absolute;
                                        top: 100%;
                                        margin-left: -5px;
                                        border-width: 5px;
                                        border-style: solid;
                                        border-color: #555 transparent transparent transparent;
                                        transform: rotate(-2deg);
                                    }

                                    .info-details.vk .tooltiptext::after {
                                        left: unset;
                                        right: 28px;
                                    }

                                    .info-details.ek .tooltiptext::after {
                                        right: unset;
                                        left: 30px;
                                    }

                                    .info-details:hover .tooltiptext {
                                        visibility: visible;
                                        opacity: 1;
                                    }

                                    .info-details i {
                                        color: #074a74;
                                        font-size: 12px;
                                    }
                                </style>
                                <div class="card style-1 mb-3">
                                    <div class="card-header no-border">
                                        <h6><strong><?php _e('Pricing'); ?></strong></h6>
                                    </div>

                                    <div class="card-body pt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>
                                                    <?php _e('EK Price netto'); ?>
                                                    <div class="info-details ek">
                                                        <i class="fa fa-eye"></i>
                                                        <span class="tooltiptext ek">
                                                            <?php _e('The sales price is net. The sales price is calculated automatically in the frontend of your store according to your tax settings. For Germany we would add 19% by default'); ?>.
                                                        </span>
                                                    </div>
                                                </label>
                                                <div class="input-group mb-3 prepend-transparent">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-muted"><?php echo get_currency_code(); ?></span>
                                                    </div>
                                                    <input type="text" class="form-control js-product-price" required <?php if(isset($productEkPrice) && $productEkPrice != 0){?> disabled="disabled" <?php } ?> name="ek_price" value="<?php if(isset($productEkPrice) && $productEkPrice != 0) { echo number_format($productEkPrice, 2); } ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>
                                                    <?php _e('VK Price netto'); ?>
                                                    <div class="info-details vk">
                                                        <i class="fa fa-eye"></i>
                                                        <span class="tooltiptext vk">
                                                            <?php _e('The sales price is net. The sales price is calculated automatically in the frontend of your store according to your tax settings. For Germany we would add 19% by default'); ?>.
                                                        </span>
                                                    </div>
                                                </label>
                                                <div class="input-group mb-3 prepend-transparent">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-muted"><?php echo get_currency_code(); ?></span>
                                                    </div>
                                                    <input type="text" class="form-control js-product-price" required name="price" value="<?php echo number_format($productPrice, 2); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <?php
                                                if (is_module('shop/offers')):
                                                ?>
                                                    <module type="shop/offers/special_price_field" product_id="<?php echo $product['id'];?>" />
                                                <?php endif; ?>
                                            </div>

                                            <?php $tax_types = array(
                                                            '1' => 'ORIGINAL',
                                                            '2' => 'REDUCED',
                                                        ) ?>
                                            <div class="col-md-6">
                                                <label><?php _e('Tax Type'); ?>:</label>
                                                <div class="input-group mb-3 prepend-transparent">
                                                    <select class="form-control" id="tax_type" name="tax_type" disabled>
                                                                <?php  foreach ($tax_types as $key => $x) { ?>
                                                                    <option value="<?php print($key); ?>"
                                                                        <?php
                                                                            if($data['id'] != 0){
                                                                                if(@$data['tax_type']){
                                                                                    if(@$data['tax_type'] == $key){
                                                                                        print('selected="selected"');
                                                                                    }
                                                                                }
                                                                            }
                                                                        ?>>
                                                                    <?php echo "$x"; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                                <?php if($product['id']): ?>
                                    <?php
                                        $productUpsellingData = DB::table('product_upselling')->get()->all();
                                        $selectproductUpsellingData = DB::table('product_upselling_item')->where('product_id',$product['id'])->get(['item_id']);
                                        $itemcount = 0;
                                        $passloop = false;
                                    ?>

                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e('Product Upselling'); ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <?php if(isset($productUpsellingData)):  ?>
                                                    <?php foreach($productUpsellingData as $pitem):  ?>
                                                        <?php if(!$selectproductUpsellingData->count()): ?>
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <?php foreach($selectproductUpsellingData as $sitem):  ?>
                                                                <?php if($pitem->id == $sitem->item_id): ?>
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox">
                                                                            <label><input type="checkbox" checked id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <?php
                                                                        $itemcount++;
                                                                        if($selectproductUpsellingData->count() == $itemcount){
                                                                            $passloop = true;
                                                                        }
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach;  ?>
                                                        <?php endif; ?>

                                                        <?php if($passloop):
                                                        $passloop = false;
                                                        $itemcount = 0;
                                                        ?>
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" id="<?php print $pitem->id;  ?>" value="<?php print $pitem->id;  ?>"> <?php print $pitem->serviceName;  ?></label>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                                <?php
                                                                    $passloop = false;
                                                                    $itemcount = 0;
                                                                ?>
                                                        <?php endif; ?>
                                                        <script>
                                                            $('#<?php print $pitem->id;  ?>').click(function() {
                                                                if($('#<?php print $pitem->id;  ?>').is(':checked')){
                                                                    var product_id = '<?php echo $product['id'];?>';
                                                                    var item_id = $('#<?php print $pitem->id;  ?>').val();
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "<?=api_url('productUpsellingItemInsert')?>",
                                                                        data:{ product_id : product_id, item_id : item_id },
                                                                        success: function(response) {
                                                                            // console.log(response.message);
                                                                        },
                                                                        error: function(response){
                                                                            // console.log(response.responseJSON.message);
                                                                        }
                                                                    });

                                                                }
                                                                else{
                                                                    var product_id = '<?php echo $product['id'];?>';
                                                                    var item_id = '<?php print $pitem->id;  ?>';
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: "<?=api_url('productUpsellingItemDelete')?>",
                                                                        data:{ product_id : product_id, item_id : item_id },
                                                                        success: function(response) {
                                                                            console.log(response.message);
                                                                        },
                                                                        error: function(response){
                                                                            console.log(response.responseJSON.message);
                                                                        }
                                                                    });

                                                                }

                                                                });


                                                        </script>
                                                    <?php endforeach;  ?>
                                                <?php endif;  ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php
                                        $productUpsellingData = DB::table('product_upselling')->get()->all();
                                    ?>

                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e('Product Upselling'); ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <?php if(isset($productUpsellingData)):  ?>
                                                    <?php foreach($productUpsellingData as $pitem):  ?>
                                                            <div class="col-md-6">
                                                                <div class="checkbox">
                                                                    <label><input type="checkbox" name="upselling<?php print $pitem->id; ?>" > <?php print $pitem->serviceName; ?></label>
                                                                </div>
                                                            </div>
                                                    <?php endforeach;  ?>
                                                <?php endif;  ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>



                                <?php if($product['id']): ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e('Thank You Product Templates') ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <?php
                                                    for ($x = 1; $x <= 6; $x++) {
                                                ?>
                                                    <?php if(DB::table("thank_you_pages")->where('template_name',$x)->where('product_id',$product['id'])->get()->count()):  ?>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <label><input onclick="check('<?php print $x; ?>')" checked type="checkbox" id="theme<?php print $x; ?>" value="<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                                                        </div>
                                                    </div>
                                                    <?php else:  ?>
                                                        <div class="col-md-4">
                                                            <div class="checkbox">
                                                            <label><input onclick="check('<?php print $x; ?>')"  type="checkbox" id="theme<?php print $x; ?>" value="<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    function check(id){
                                        if($('#theme'+id).is(':checked')){

                                            templateName = $('#theme'+id).val();
                                            // console.log(templateName);
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('productModulesInsert')?>",
                                                data:{ template_name : templateName, product_id : '<?php echo $product['id'];?>' },
                                                success: function(response) {
                                                    // console.log(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                        else{
                                            templateName = $('#theme'+id).val();
                                            // console.log(templateName);
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('productModulesDelete')?>",
                                                data:{ template_name : templateName, product_id : '<?php echo $product['id'];?>' },
                                                success: function(response) {
                                                    // console.log(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                    }

                                    </script>
                                <?php else: ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e('Thank You Product Templates') ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <?php for($x = 1; $x <= 6; $x++): ?>
                                                    <div class="col-md-4">
                                                        <div class="checkbox">
                                                            <label><input  type="checkbox" name="theme<?php print $x; ?>"> <?php _e('Thank You') ?>-<?php print $x; ?> </label>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>






                                <?php if($product['id']): ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e("Checkout Bumbs") ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                    <?php if(DB::table("checkout_bumbs")->where('product_id',$product['id'])->get()->count()):  ?>
                                                    <div class="col-md-12">
                                                        <div class="checkbox">
                                                            <label><input onclick="bumbs()" checked type="checkbox" id="checkBumbs" > <?php _e("Select This Product") ?> </label>
                                                        </div>
                                                    </div>
                                                    <?php else:  ?>
                                                        <div class="col-md-12">
                                                            <div class="checkbox">
                                                            <label><input onclick="bumbs()"  type="checkbox" id="checkBumbs"> <?php _e("Select This Product") ?> </label>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="card-body pt-3" style="margin-left: 10px; ">
                                            <div class="row">
                                                <?php if(DB::table("checkout_bumbs")->where('show_cart',1)->get()->count()):  ?>
                                                    <div class="form-check" style="margin-right: 10px; ">
                                                        <input class="form-check-input" type="radio" onclick="checkbumbs('scart',1,0)" name="flexRadioDefault" id="scart" checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            <?php _e(" Shopping Cart Bumbs") ?>
                                                        </label>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="form-check" style="margin-right: 10px; ">
                                                        <input class="form-check-input" onclick="checkbumbs('scart',1,0)" type="radio" name="flexRadioDefault" id="scart">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            <?php _e(" Shopping Cart Bumbs") ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(DB::table("checkout_bumbs")->where('show_checkout',1)->get()->count()):  ?>
                                                    <div class="form-check" style="margin-right: 10px; ">
                                                        <input class="form-check-input" type="radio" onclick="checkbumbs('scheckout',0,1)" name="flexRadioDefault" id="scheckout" checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            <?php _e("Checkout Page-2 Bumbs") ?>
                                                        </label>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="form-check" style="margin-right: 10px; ">
                                                        <input class="form-check-input" onclick="checkbumbs('scheckout',0,1)" type="radio" name="flexRadioDefault" id="scheckout">
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            <?php _e("Checkout Page-2 Bumbs") ?>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    function bumbs(id){
                                        if($('#checkBumbs').is(':checked')){
                                            if($('#scart').is(':checked')){
                                                show_cart = 1;
                                            }else{
                                                show_cart = 0;
                                            }
                                            if($('#scheckout').is(':checked')){
                                                show_checkout = 1;
                                            }else{
                                                show_checkout = 0;
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('checkoutBumbsInsert')?>",
                                                data:{ product_id : '<?php echo $product['id'];?>',show_cart : show_cart, show_checkout: show_checkout },
                                                success: function(response) {
                                                    // console.log(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                        else{
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('checkoutBumbsDelete')?>",
                                                data:{ product_id : '<?php echo $product['id'];?>' },
                                                success: function(response) {
                                                    $('#scart').prop('checked', false);
                                                    $('#scheckout').prop('checked', false);
                                                    // console.log(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                    }


                                    function checkbumbs(name,show_cart,show_checkout){
                                        if($('#'+name).is(':checked')){
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=api_url('activeBumbs')?>",
                                                data:{ show_cart : show_cart, show_checkout: show_checkout },
                                                success: function(response) {
                                                    $('#'+name).prop('checked', true);
                                                    // console.log(response.message);
                                                },
                                                error: function(response){
                                                    console.log(response.responseJSON.message);
                                                }
                                            });
                                        }
                                    }


                                    </script>
                                <?php else: ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e("Checkout Bumbs") ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                    <label><input  type="checkbox" name="checkBumbs"> <?php _e("Select This Product") ?> </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body pt-3" style="margin-left: 10px; ">
                                        <?php $check_bumbs = DB::table("checkout_bumbs")->get()->first();  ?>
                                            <div class="row">
                                                <div class="form-check" style="margin-right: 10px; ">
                                                    <input class="form-check-input"  type="radio" name="bumbs" value="cartbumbs" <?php if(isset($check_bumbs->show_cart) && !empty($check_bumbs->show_cart)): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php _e(" Shopping Cart Bumbs") ?>
                                                    </label>
                                                </div>
                                                <div class="form-check" style="margin-right: 10px; ">
                                                    <input class="form-check-input"  type="radio" name="bumbs" value="checkoutbumbs" <?php if(isset($check_bumbs->show_checkout) && !empty($check_bumbs->show_checkout)): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php _e("Checkout Page-2 Bumbs") ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($product['id']): ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e("Select for customer group") ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        <label><?php _e("Available customer group") ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-3" style="margin-left: 10px; ">
                                            <?php
                                                $customer_groups = DB::table("customer_groups")->get();
                                                $this_product_group = DB::table("group_product")->where('product_id',$product['id'])->select('group_id')->get()->toArray();
                                            ?>
                                            <div class="row">
                                                <?php foreach($customer_groups as $customer_group){ ?>
                                                <div class="form-check" style="margin-right: 10px; ">
                                                    <?php
                                                        $check =  '';
                                                        if(isset($this_product_group)){
                                                            foreach($this_product_group as $groupId){
                                                                if($groupId->group_id == $customer_group->id){
                                                                    $check =  'checked';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                        <input class="form-check-input"  type="checkbox" name="customer_group[]" value="<?php echo $customer_group->id; ?>" <?php echo $check; ?>>

                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php _e($customer_group->group_name) ?>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <div class="card style-1 mb-3">
                                        <div class="card-header no-border">
                                        <h6><strong><?php _e("Select for customer group") ?></strong></h6>
                                        </div>
                                        <div class="card-body pt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="checkbox">
                                                        <label><?php _e("Available customer group") ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-3" style="margin-left: 10px; ">
                                            <?php $customer_groups = DB::table("customer_groups")->get();  ?>
                                            <div class="row">
                                                <?php foreach($customer_groups as $customer_group){ ?>
                                                <div class="form-check" style="margin-right: 10px; ">
                                                <input class="form-check-input"  type="checkbox" name="customer_group[]" value="<?php echo $customer_group->id; ?>" <?php if($customer_group->id == 1 || $customer_group->id == 10){ echo 'checked';} ?>>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php _e($customer_group->group_name) ?>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Subscription product start from here -->
                                <?php
                                    if($product['id']):
                                    //$type="product";
                                    //$optionValue= DB::table('subscription_items')->get()->all();
                                    // dd($optionValue);
                                    $isChecked=null;
                                    $status=DB::table('subscription_status')->where('product_id',$product['id'])->get();
                                        if(count($status)>0){
                                            $isChecked="checked";
                                        }

                                ?>


                                <div class="card style-1 mb-3">
                                    <div class="card-header no-border">
                                        <h6><strong><?php _e('Available for Subscription'); ?></strong></h6>
                                    </div>

                                    <div class="card-body pt-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <input type="checkbox" name="sub_product" id="sub_product" onclick="isSubShow()" <?php print $isChecked; ?>>
                                            <label for="sub_product"><?php _e('Is this product available for subscription'); ?></label>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body pt-3" id="status" style="display:none;">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="live"><?php _e('Available Subscription Interval'); ?></label><br><br>
                                                <input type="hidden" name="id" id="id" value="<?php print $product['id']; ?>">
                                                <div class="row">
                                                <?php
                                                    $sub=DB::table('subscription_items')->groupBy('sub_interval')->get();

                                                ?>
                                                <?php if(isset($sub)):  ?>
                                                    <?php foreach($sub as $item):  ?>
                                                        <?php
                                                            $z="";
                                                            $a=DB::table('subscription_status')->where('product_id',$product['id'])->where('sub_id',$item->id)->get();
                                                            if(count($a)>0){
                                                                $z="checked";
                                                            }
                                                        ?>
                                                        <div class="col col-3">
                                                            <input type="checkbox" id="live<?php print $item->id; ?>" name="live" onclick="insertData(<?php print $item->id; ?>)" <?php print $z; ?> >
                                                            <label for="item" class="mr-3"><?php $sub_info = explode(" ", $item->sub_interval);
                                                                                                    print $sub_info[0] . ' ';
                                                                                                    _e($sub_info[1]); ?></label>
                                                        </div>

                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </div>
                                            </div>
                                        </div><br>

                                    </div>
                                    <div class="card-body pt-3">
                                        <h6><a href="<?php echo site_url('admin/view:shop/action:options/?group=subProduct'); ?>" target="_blank"><?php _e('Here you can create and manage your intervals'); ?></a> </h6>
                                    </div>
                                </div>




                                <script>
                                $( document ).ready(function() {
                                    isSubShow();
                                    // window.alert("hum");
                                });
                                function isSubShow(){
                                    var pId=document.getElementById("id").value;
                                    if(document.getElementById("sub_product").checked==true){
                                        // window.alert("show");
                                        document.getElementById("status").style.display="";
                                    }
                                    else{
                                        $.post("<?=api_url('delete_subscription_statuses')?>", {
                                            product_id: pId
                                        }).then((res, err) => {
                                            // console.log(res, err);
                                        });
                                        document.getElementById("status").style.display="none";
                                    }
                                }

                                function insertData(data){
                                    var pId=document.getElementById("id").value;
                                    var sub_id=data;
                                    if(document.getElementById("live"+data).checked==true){

                                        $.post("<?=api_url('add_subscription_status')?>", {
                                            product_id: pId,
                                            sub_id: sub_id
                                        }).then((res, err) => {
                                            console.log(res, err);
                                        });
                                        console.log("add");
                                    } else{
                                        $.post("<?=api_url('delete_subscription_status')?>", {
                                            sub_id: sub_id
                                        }).then((res, err) => {
                                            console.log(res, err);
                                        });
                                    }

                                }
                                </script>

                                <!-- End Add Subcription product -->

                                <?php endif; ?>

                                <style>
                                    /* .js-track-quantity {
                                        display: none;
                                    } */

                                    .preloader-floating-circles {
                                        position: relative;
                                        width: 80px;
                                        height: 80px;
                                        margin: auto;
                                        transform: scale(0.6);
                                        -o-transform: scale(0.6);
                                        -ms-transform: scale(0.6);
                                        -webkit-transform: scale(0.6);
                                        -moz-transform: scale(0.6);
                                    }

                                    .preloader-floating-circles .f_circleG {
                                        position: absolute;
                                        background-color: white;
                                        height: 14px;
                                        width: 14px;
                                        border-radius: 7px;
                                        -o-border-radius: 7px;
                                        -ms-border-radius: 7px;
                                        -webkit-border-radius: 7px;
                                        -moz-border-radius: 7px;
                                        animation-name: f_fadeG;
                                        -o-animation-name: f_fadeG;
                                        -ms-animation-name: f_fadeG;
                                        -webkit-animation-name: f_fadeG;
                                        -moz-animation-name: f_fadeG;
                                        animation-duration: 0.672s;
                                        -o-animation-duration: 0.672s;
                                        -ms-animation-duration: 0.672s;
                                        -webkit-animation-duration: 0.672s;
                                        -moz-animation-duration: 0.672s;
                                        animation-iteration-count: infinite;
                                        -o-animation-iteration-count: infinite;
                                        -ms-animation-iteration-count: infinite;
                                        -webkit-animation-iteration-count: infinite;
                                        -moz-animation-iteration-count: infinite;
                                        animation-direction: normal;
                                        -o-animation-direction: normal;
                                        -ms-animation-direction: normal;
                                        -webkit-animation-direction: normal;
                                        -moz-animation-direction: normal;
                                    }

                                    .preloader-floating-circles #frotateG_01 {
                                        left: 0;
                                        top: 32px;
                                        animation-delay: 0.2495s;
                                        -o-animation-delay: 0.2495s;
                                        -ms-animation-delay: 0.2495s;
                                        -webkit-animation-delay: 0.2495s;
                                        -moz-animation-delay: 0.2495s;
                                    }

                                    .preloader-floating-circles #frotateG_02 {
                                        left: 9px;
                                        top: 9px;
                                        animation-delay: 0.336s;
                                        -o-animation-delay: 0.336s;
                                        -ms-animation-delay: 0.336s;
                                        -webkit-animation-delay: 0.336s;
                                        -moz-animation-delay: 0.336s;
                                    }

                                    .preloader-floating-circles #frotateG_03 {
                                        left: 32px;
                                        top: 0;
                                        animation-delay: 0.4225s;
                                        -o-animation-delay: 0.4225s;
                                        -ms-animation-delay: 0.4225s;
                                        -webkit-animation-delay: 0.4225s;
                                        -moz-animation-delay: 0.4225s;
                                    }

                                    .preloader-floating-circles #frotateG_04 {
                                        right: 9px;
                                        top: 9px;
                                        animation-delay: 0.509s;
                                        -o-animation-delay: 0.509s;
                                        -ms-animation-delay: 0.509s;
                                        -webkit-animation-delay: 0.509s;
                                        -moz-animation-delay: 0.509s;
                                    }

                                    .preloader-floating-circles #frotateG_05 {
                                        right: 0;
                                        top: 32px;
                                        animation-delay: 0.5955s;
                                        -o-animation-delay: 0.5955s;
                                        -ms-animation-delay: 0.5955s;
                                        -webkit-animation-delay: 0.5955s;
                                        -moz-animation-delay: 0.5955s;
                                    }

                                    .preloader-floating-circles #frotateG_06 {
                                        right: 9px;
                                        bottom: 9px;
                                        animation-delay: 0.672s;
                                        -o-animation-delay: 0.672s;
                                        -ms-animation-delay: 0.672s;
                                        -webkit-animation-delay: 0.672s;
                                        -moz-animation-delay: 0.672s;
                                    }

                                    .preloader-floating-circles #frotateG_07 {
                                        left: 32px;
                                        bottom: 0;
                                        animation-delay: 0.7585s;
                                        -o-animation-delay: 0.7585s;
                                        -ms-animation-delay: 0.7585s;
                                        -webkit-animation-delay: 0.7585s;
                                        -moz-animation-delay: 0.7585s;
                                    }

                                    .preloader-floating-circles #frotateG_08 {
                                        left: 9px;
                                        bottom: 9px;
                                        animation-delay: 0.845s;
                                        -o-animation-delay: 0.845s;
                                        -ms-animation-delay: 0.845s;
                                        -webkit-animation-delay: 0.845s;
                                        -moz-animation-delay: 0.845s;
                                    }

                                    @keyframes f_fadeG {
                                        0% {
                                            background-color: black;
                                        }

                                        100% {
                                            background-color: white;
                                        }
                                    }

                                    @-webkit-keyframes f_fadeG {
                                        0% {
                                            background-color: black;
                                        }

                                        100% {
                                            background-color: white;
                                        }
                                    }

                                    .digital-product-file-upload-success-text p {
                                        font-weight: 700;
                                        color: green;
                                        font-size: 20px;
                                        text-align: center;
                                    }

                                    .digital-product-file-upload-success-text {
                                        display: none;
                                    }

                                    .digital-product-file-upload-preloader {
                                        display: none;
                                    }
                                    .digital-product-file p {
                                        display: inline-block;
                                        margin-bottom: 0;
                                    }

                                    .digital-product-file p:first-child {
                                        font-size: 16px;
                                        margin-right: 10px;
                                    }

                                    .digital-product-file {
                                        border-radius: 5px;
                                        padding: 5px;
                                        background: #ebebeb;
                                        display: flex;
                                    }

                                    .digital-product-file p a {
                                        word-break: break-all;
                                    }

                                    .digital-product-file p:last-child {
                                        max-width: 700px;
                                    }
                                </style>
                                <?php
                                    $d_P_download_link = $data['d_P_download_link'] ?? null;
                                    if($data['id']==0){
                                        $d_P_download_link = null;
                                    }
                                ?>
                                <script>
                                    $(document).ready(function() {
                                        var dig_val = $("select#digital-opt option:checked").val();
                                        if (dig_val == '1') {
                                            $(".digital-upload").css("display", "block");
                                        }
                                    });

                                    function digitalProductOption(opt) {
                                        var option = opt.value;
                                        $.post("<?= api_url('set_product_opt') ?>", {
                                            option: option,
                                            product_id: <?= $data['id'] ?>
                                        }).then((res, err) => {
                                            mw.notification.success(res);
                                        });
                                        if (option == '1') {
                                            $(".digital-upload").css("display", "block");
                                            <?php if($d_P_download_link == null): ?>
                                                $("#digital-content").prop('required',true);
                                            <?php endif; ?>
                                        } else {
                                            $(".digital-upload").css("display", "none");
                                            $("#digital-content").prop('required',false);
                                        }
                                    }

                                    $("#digital-content").on('change', function() {
                                        $(".digital-product-file-upload-preloader").css('display', 'block');
                                        var file = this.files[0];

                                        var formData = new FormData();
                                        formData.append('file', file);
                                        formData.append('product_id', <?= $data['id'] ?>);

                                        $.ajax({
                                            type: "POST",
                                            url: "<?= url('/') ?>/api/v1/upload_digital_product",
                                            data: formData,
                                            async: true,
                                            cache: false,
                                            contentType: false,
                                            enctype: 'multipart/form-data',
                                            processData: false,
                                            success: function(response) {
                                                $(".digital-product-file-upload-preloader").css('display', 'none');
                                                $(".digital-product-file-upload-success-text").css('display', 'block');
                                                $('.digital-product-file-upload-success-text').delay(2000).fadeOut('slow');
                                                mw.notification.success(response);
                                            }
                                        });
                                    });

                                    $('.js-bottom-save').on('click', function(){

                                    setTimeout(function(){

                                        if( $('.invalid-feedback').length > 0 ){
                                            $('html, body').animate({
                                                scrollTop: $(".invalid-feedback").offset().top -= 200
                                            }, 2000);
                                        }
                                        }, 1000);

                                    });
                                    $(document).ready(function () {
                                        $('.js-track-quantity-check').click(function () {
                                            mw.toggle_inventory_forms_fields();
                                        });
                                        enableTrackQuantityFields();
                                        <?php if ($contentData['track_quantity'] != 0):?>
                                        mw.toggle_inventory_forms_fields();
                                        enableTrackQuantityFields();
                                        <?php else: ?>
                                        //disableTrackQuantityFields();
                                        <?php endif; ?>

                                    });


                                    mw.toggle_inventory_forms_fields = function(){

                                        $('.js-track-quantity').toggle();

                                        if ($('.js-track-quantity-check').prop('checked')) {
                                            enableTrackQuantityFields();
                                        } else {
                                            //disableTrackQuantityFields();
                                        }
                                    }

                                    function disableTrackQuantityFields() {
                                        $("input,select",'.js-track-quantity').prop("disabled", true);
                                        $("input,select",'.js-track-quantity').attr("readonly",'readonly');

                                    }

                                    function enableTrackQuantityFields() {
                                        $("input,select",'.js-track-quantity').prop("disabled", false);
                                        $("input,select",'.js-track-quantity').removeAttr("readonly");


                                    }

                                    function contentDataQtyChange(instance) {
                                        if ($(instance).val()== '') {
                                            $(instance).val('nolimit');
                                        }
                                    }

                                    function checkSku(val){
                                        if(val == ''){
                                            jQuery('.sku-field').css('border', '1px solid red');
                                            jQuery('.sku-error').text('Please fill up this field');
                                            jQuery('.sku-error').removeClass('d-none');
                                        }
                                        else if(val == 0){
                                            jQuery('.sku-field').css('border', '1px solid red');
                                            jQuery('.sku-error').text('You can`t insert 0 here');
                                            jQuery('.sku-error').removeClass('d-none');
                                        }else{
                                            jQuery('.sku-field').css('border', '');
                                            jQuery('.sku-error').addClass('d-none');
                                        }
                                    }
                                </script>

                                <div class="card style-1 mb-3">
                                    <div class="card-header no-border">
                                        <h6><strong><?php _e("Inventory") ?></strong></h6>
                                    </div>

                                    <div class="card-body pt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label><?php _e('SKU (Stock Keeping Unit)'); ?></label>
                                                    <input type="text" name="content_data[sku]" class="form-control" value="<?php echo $contentData['sku']; ?>" required onkeyup="checkSku(this.value)">
                                                    <span class="sku-error d-none" style="color: red;"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Barcode (ISBN, UPC, GTIN, etc.)</label>
                                                    <!-- new code ean_input_field-->
                                                    <?php if($type=='Product'){ ?>
                                                        <input type="text" name="ean" id="ean_number" class="form-control" <?php if(isset($data['ean'])){ ?>value="<?php print $data['ean']; ?>"  disabled<?php }else{ ?> value="" placeholder="<?php _e('Please enter a 8 to 13 digit EAN number') ?>" required <?php } ?>>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <!-- <input type="checkbox" name="content_data[track_quantity]" class="custom-control-input js-track-quantity-check" value="1" <?php if ($contentData['track_quantity']==1):?>checked="checked"<?php endif; ?> id="customCheck2"> -->
                                                            <input type="checkbox" name="content_data[track_quantity]" class="custom-control-input js-track-quantity-check" value="1" id="customCheck2" checked="checked">
                                                        <label class="custom-control-label" for="customCheck2"><?php _e("Track quantity") ?></label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="content_data[sell_oos]" value="1" <?php if ($contentData['sell_oos']==1):?>checked="checked"<?php endif; ?>>
                                                        <label class="custom-control-label" for="customCheck3"><?php _e('Continue selling when out of stock') ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php $digital_opt = $data['digital_opt'] ?? 0; ?>
                                                    <label><?php _e("Digital product") ?></label>
                                                    <select class="selectpicker js-search-by-selector form-control" id="digital-opt" name="digital-opt" data-width="100%" data-style="btn-sm" onchange="digitalProductOption(this)">
                                                        <option value="0" <?php (!$digital_opt) ? print 'selected' : print '' ?>><?php _e("NO"); ?></option>
                                                        <option value="1" <?php ($digital_opt) ? print 'selected' : print '' ?>><?php _e("YES"); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row digital-upload" style="display:none;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><?php _e("Digital product download limit") ?></label>
                                                    <select class="selectpicker js-search-by-selector form-control" id="download_limit" name="download_limit" data-width="100%" data-style="btn-sm">
                                                        <?php for($i=1; $i < 10;$i++): ?>
                                                            <option value="<?php print $i; ?>" <?php if(isset($data['download_limit']) && $i == $data['download_limit']): ?> selected <?php endif; ?>><?php print $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label><?php _e("Upload Digital product content") ?></label>
                                                    <input type="file" id="digital-content" name="digital-content" class="form-control" <?php if($d_P_download_link == null && $digital_opt): ?> required <?php endif; ?>>
                                                </div>
                                                <div class="preloader-floating-circles digital-product-file-upload-preloader">
                                                    <div class="f_circleG" id="frotateG_01"></div>
                                                    <div class="f_circleG" id="frotateG_02"></div>
                                                    <div class="f_circleG" id="frotateG_03"></div>
                                                    <div class="f_circleG" id="frotateG_04"></div>
                                                    <div class="f_circleG" id="frotateG_05"></div>
                                                    <div class="f_circleG" id="frotateG_06"></div>
                                                    <div class="f_circleG" id="frotateG_07"></div>
                                                    <div class="f_circleG" id="frotateG_08"></div>
                                                </div>
                                                <div class="digital-product-file-upload-success-text">
                                                    <p>File uploaded successfully!</p>
                                                </div>
                                            </div>
                                            <?php if ($d_P_download_link) : ?>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-3 digital-product-file">
                                                        <p>File :</p>
                                                        <p>
                                                            <i class="fa fa-file" aria-hidden="true"></i>
                                                            <a href="<?= site_url() . 'admin_download_digital_product/' . $data['id']  ?>"><?= $d_P_download_link ?></a>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="js-track-quantity">

                                            <hr class="thin no-padding"/>

                                            <h6><strong><?php _e("Quantity") ?></strong></h6>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php _e("Available") ?></label>
                                                        <div class="input-group mb-1 append-transparent input-group-quantity">
                                                            <input type="text" class="form-control" name="content_data[qty]" onchange="contentDataQtyChange(this)" value="<?php echo $contentData['qty']; ?>" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text plus-minus-holder">
                                                                    <button type="button" class="plus"><i class="mdi mdi-menu-up"></i></button>
                                                                    <button type="button" class="minus"><i class="mdi mdi-menu-down"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <small class="text-muted"><?php _e("How many products you have") ?></small>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label><?php _e("Max quantity per order") ?></label>
                                                        <div class="input-group mb-1 append-transparent input-group-quantity">
                                                            <input type="text" class="form-control" name="content_data[max_quantity_per_order]" value="<?php echo $contentData['max_quantity_per_order']; ?>" placeholder="<?php _e('No Limit') ?>" />
                                                            <div class="input-group-append">
                                                                <div class="input-group-text plus-minus-holder">
                                                                    <button type="button" class="plus"><i class="mdi mdi-menu-up"></i></button>
                                                                    <button type="button" class="minus"><i class="mdi mdi-menu-down"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small class="text-muted"><?php _e("How many products can be ordered at once") ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <small class="text-muted"><?php _e("If you change the quantity manually here, you activate the overright in Dropmatix, i.e. the automatic stock updates are suspended. To undo this, open the product in Dropmatix and remove the overright.") ?></small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            <?php }
                            ?>


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

                    </div>

                    <?php event_trigger('mw_admin_edit_page_footer', $data); ?>

                    <script>
                        mw.require("content.js");
                        mw.require("files.js");
                        mw.require("admin_custom_fields.js");
                    </script>
                    <script>
                        /* FUNCTIONS */

                        if (self !== parent && !!parent.mw) {

                            mw.top().win.iframe_editor_window = window.self;
                        }


                        mw.edit_content = {};

                        mw.edit_content.saving = false;


                        mw.edit_content.create_new = function () {
                            mw.$('#<?php print $module_id ?>').attr("content-id", "0");
                            mw.$('#<?php print $module_id ?>').removeAttr("just-saved");
                            mw.reload_module('#<?php print $module_id ?>');
                        };

                        mw.edit_content.close_alert = function () {
                            mw.$('#quickform-edit-content').show();
                            mw.$('#post-added-alert-<?php print $rand; ?>').hide();

                        };

                        mw.edit_content.load_page_preview = function (element_id) {
                            var element_id = element_id || 'mw-admin-content-iframe-editor';
                            var parent_page = mw.$('#mw-parent-page-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var content_id = mw.$('#mw-content-id-value', '#<?php print $params['id'] ?>').val();
                            var content_type = mw.$('#mw-content-type-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val()
                            var subtype = mw.$('#mw-content-subtype', '#<?php print $params['id'] ?>').val();
                            var subtype_value = mw.$('#mw-content-subtype-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var active_site_template = $('#mw-active-template-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var active_site_layout = $('#mw-layout-file-value-<?php print $rand; ?>').val();
                            // var name = 'content/views/edit_default_inner';
                            var name = 'content/views/layout_selector';
                            var selector = '#mw-admin-edit-content-main-area';


                            var callback = false;
                            var attributes = {}
                            attributes.parent_page = parent_page;
                            attributes.content_id = content_id;
                            attributes.content_id = content_id;
                            attributes.content_type = content_type;
                            attributes.subtype = subtype;
                            attributes.subtype_value = subtype_value;
                            attributes.active_site_template = active_site_template;
                            attributes.active_site_layout = active_site_layout;
                            attributes['template-selector-position'] = 'none';
                            attributes['live-edit-overlay'] = true;
                            attributes['edit_page_id'] = content_id;
                            mw.load_module(name, selector, callback, attributes);
                        }


                        mw.edit_content.load_editor = function (element_id) {

                            var parent_page = mw.$('#mw-parent-page-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var content_id = mw.$('#mw-content-id-value', '#<?php print $params['id'] ?>').val();
                            var content_type = mw.$('#mw-content-type-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val()
                            var subtype = mw.$('#mw-content-subtype', '#<?php print $params['id'] ?>').val();
                            var subtype_value = mw.$('#mw-content-subtype-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var active_site_template = $('#mw-active-template-value-<?php print $rand; ?>', '#<?php print $params['id'] ?>').val();
                            var active_site_layout = $('#mw-layout-file-value-<?php print $rand; ?>').val();
                            var name = 'content/views/edit_default_inner';
                            var selector = '#mw-admin-edit-content-main-area';


                            var callback = false;
                            var attributes = {}
                            attributes.parent_page = parent_page;
                            attributes.content_id = content_id;
                            attributes.content_type = content_type;
                            attributes.subtype = subtype;
                            attributes.subtype_value = subtype_value;
                            attributes.active_site_template = active_site_template;
                            attributes.active_site_layout = active_site_layout;
                            mw.load_module(name, selector, callback, attributes);
                        }
                        mw.edit_content.before_save = function () {
                            mw.askusertostay = false;
                            if (window.parent != undefined && window.parent.mw != undefined) {
                                window.parent.mw.askusertostay = false;
                            }
                        }
                        mw.edit_content.after_save = function (saved_id) {
                            mw.askusertostay = false;
                            var content_id = mw.$('#mw-content-id-value').val();
                            var quick_add_holder = mwd.getElementById('mw-quick-content');
                            if (quick_add_holder != null) {
                                mw.tools.removeClass(quick_add_holder, 'loading');
                            }
                            if (content_id == 0) {
                                if (saved_id !== undefined) {
                                    mw.$('#mw-content-id-value').val(saved_id);
                                }
                                <?php if($is_quick != false) : ?>
                                mw.$('#quickform-edit-content').hide();
                                mw.$('#post-added-alert-<?php print $rand; ?>').show();
                                <?php endif; ?>
                            }
                            if (mw.notification != undefined) {
                                mw.notification.success('<?php _ejs('Content saved!'); ?>');
                            }
                            if (parent !== self && !!parent.mw) {


                                mw.reload_module_parent('posts');
                                mw.reload_module_parent('shop/products');
                                mw.reload_module_parent('shop/cart_add');
                                mw.reload_module_parent('pages');
                                mw.reload_module_parent('content');
                                mw.reload_module_parent('custom_fields');
                                mw.tools.removeClass(mwd.getElementById('mw-quick-content'), 'loading');
                                mw.reload_module('pages');
                                parent.mw.askusertostay = false;
                            } else {
                                mw.reload_module('[data-type="pages"]', function () {
                                    if (mw.$("#pages_tree_toolbar .mw_del_tree_content").length === 0) {
                                        mw.$("#pages_tree_toolbar").removeClass("activated");
                                        var action = mw.url.windowHashParam('action');
                                        if (action) {
                                            var id = action.split(':')[1];
                                            if (id) {
                                                $('[data-page-id="' + id + '"]').addClass("active-bg")
                                            }
                                        }


                                    }
                                    mw.tools.removeClass(mwd.getElementById('mw-quick-content'), 'loading');
                                });
                            }


                        }

                        mw.edit_content.set_category = function (id) {
                            /* FILLING UP THE HIDDEN FIELDS as you change category or parent page */
                            var names = [];
                            var inputs = mwd.getElementById(id).querySelectorAll('input[type="checkbox"]'), i = 0, l = inputs.length;
                            for (; i < l; i++) {
                                if (inputs[i].checked === true) {
                                    names.push(inputs[i].value);
                                }
                            }
                            if (names.length > 0) {
                                mw.$('#mw_cat_selected_for_post').val(names.join(',')).trigger("change");
                            } else {
                                mw.$('#mw_cat_selected_for_post').val('__EMPTY_CATEGORIES__').trigger("change");
                            }
                            var names = [];
                            var inputs = mwd.getElementById(id).querySelectorAll('input[type="radio"]'), i = 0, l = inputs.length;
                            for (; i < l; i++) {
                                if (inputs[i].checked === true) {
                                    names.push(inputs[i].value);
                                }
                            }
                            if (names.length > 0) {
                                mw.$('#mw-parent-page-value-<?php print $rand; ?>').val(names[0]).trigger("change");
                            } else {
                                mw.$('#mw-parent-page-value-<?php print $rand; ?>').val(0).trigger("change");
                            }
                        }


                        mw.edit_content.handle_form_submit = function (go_live) {


                            if (mw.edit_content.saving) {
                                return false;
                            }
                            mw.edit_content.saving = true;
                            var go_live_edit = go_live || false;
                            var el = mwd.getElementById('quickform-edit-content');
                            if (el === null) {
                                return;
                            }

                            mw.edit_content.before_save();
                            var module = $(mw.tools.firstParentWithClass(el, 'module'));


                            var data = mw.serializeFields(el);
                            data.id = mw.$('#mw-content-id-value').val();

                            var categories = [];

                            if (window.categorySelector) {
                                $.each(categorySelector.tree.selectedData, function () {
                                    if (this.type == 'category') {
                                        categories.push(this.id);
                                    }
                                    if (this.type == 'page') {
                                        data.parent = this.id;
                                    }
                                });
                            }


                            if (categories.length) {
                                data.category_ids  = categories.join(',')
                            } else {
                                data.category_ids = '';

                            }


                            module.addClass('loading');
                            mw.content.save(data, {
                                url: el.getAttribute('action'),
                                onSuccess: function (a) {
                                    if (window.pagesTreeRefresh) {
                                        pagesTreeRefresh()
                                    }

                                    mw.$('.mw-admin-go-live-now-btn').attr('content-id', this);
                                    mw.askusertostay = false;

                                    if (parent !== self && !!window.parent.mw) {
                                        window.parent.mw.askusertostay = false;
                                        if (typeof(data.is_active) !== 'undefined' && typeof(data.id) !== 'undefined') {
                                            if ((data.id) != 0) {
                                                if ((data.is_active) == 0) {
                                                    window.parent.mw.$('.mw-set-content-unpublish').hide();
                                                    window.parent.mw.$('.mw-set-content-publish').show();
                                                }
                                                else if ((data.is_active) == 1) {
                                                    window.parent.mw.$('.mw-set-content-publish').hide();
                                                    window.parent.mw.$('.mw-set-content-unpublish').show();
                                                }
                                            }

                                        }
                                    }

                                    if (typeof(this) != "undefined") {
                                        var inner_edits = mw.collect_inner_edit_fields();

                                        if (inner_edits !== false) {
                                            var save_inner_edit_data = inner_edits;
                                            save_inner_edit_data.id = this;

                                            var xhr = mw.save_inner_editable_fields(save_inner_edit_data);
                                            xhr.success(function () {
                                                mw.trigger('adminSaveEnd');
                                            });
                                            xhr.fail(function () {
                                                $(window).trigger('adminSaveFailed');
                                            });

                                        }
                                    }
                                    if (go_live_edit != false) {
                                        if (parent !== self && !!window.parent.mw) {
                                            if (window.parent.mw.drag != undefined && window.parent.mw.drag.save != undefined) {
                                                window.parent.mw.drag.save();
                                            }
                                            window.parent.mw.askusertostay = false;
                                        }
                                        $.get('<?php print site_url('api_html/content_link/?id=') ?>' + this, function (data) {
                                            mw.top().win.location.href = data + '?editmode=y';
                                        });
                                    }
                                    else {
                                        var nid = typeof this === "number" ? this : this.id;
                                        $.get('<?php print site_url('api/content/get_link_admin/?id=') ?>' + nid, function (data) {

                                            if (data == null) {
                                                return false;
                                            }

                                            var slug = data.slug;
                                            mw.$("#edit-content-url").val(slug);
                                            mw.$(".view-post-slug").html(slug);
                                            mw.$("#slug-base-url").html(data.slug_prefix_url);
                                            mw.$("a.quick-post-done-link").attr("href",  data.url + '?editmode=y');
                                            mw.$("a.quick-post-done-link").html(data.url);
                                        });
                                        mw.$("#<?php print $module_id ?>").attr("content-id", nid);
                                        <?php if($is_quick != false) : ?>
                                        //  mw.$("#<?php print $module_id ?>").attr("just-saved",this);
                                        <?php else: ?>
                                        //if (self === parent) {
                                        if (self === parent) {
                                            //var type =  el['subtype'];
                                            mw.url.windowHashParam("action", "editpage:" + nid);
                                        }
                                        <?php endif; ?>
                                        mw.edit_content.after_save(this);
                                    }
                                    mw.edit_content.saving = false;


                                    $(window).trigger('adminSaveContentCompleted');

                                    if (self !== parent) {
                                        if ((data.id) == 0) {
                                            mw.$("#<?php print $module_id ?>").attr("content-id", this);

                                            mw.reload_module("#<?php print $module_id ?>");
                                        }
                                    }


                                },
                                onError: function () {
                                    $(window).trigger('adminSaveFailed');
                                    module.removeClass('loading');

                                    mw.edit_content.saving = false;
                                }
                            });
                        }

                        mw.collect_inner_edit_fields = function (data) {
                            var frame = mwd.querySelector('#mw-admin-content-iframe-editor iframe');
                            if (frame === null) return false;
                            var frameWindow = frame.contentWindow;
                            if (typeof(frameWindow.mwd) === 'undefined') return false;
                            var root = frameWindow.mwd.getElementById('mw-iframe-editor-area');
                            var data = frameWindow.mw.drag.getData(root);
                            return data;
                        }

                        mw.save_inner_editable_fields = function (data) {
                            var xhr = $.ajax({
                                type: 'POST',
                                url: mw.settings.site_url + 'api/save_edit',
                                data: data,
                                datatype: "json"
                            });
                            return xhr;
                        }


                        /* END OF FUNCTIONS */
                    </script>

                    <script>
                        $(mwd).ready(function () {
                            $("#quickform-edit-content").on('keydown', "input[type='text']", function (e) {
                                if (e.keyCode == 13) {
                                    e.preventDefault()
                                }
                            })
                            $(window).on('hashchange beforeunload', function (e) {
                                mw.$(".mw-admin-go-live-now-btn").off('click');
                            });


                            mw.$(".mw-admin-go-live-now-btn").off('click');

                            mw.$(".mw-admin-go-live-now-btn").on('click', function (e) {
                                mw.edit_content.handle_form_submit(true);
                                return false;
                            });

                            mw.reload_module('#edit-post-gallery-main');

                            mw.edit_content.load_editor();
                            <?php if($just_saved != false) : ?>
                            mw.$("#<?php print $module_id ?>").removeAttr("just-saved");
                            <?php endif; ?>
                            // mw.edit_content.render_category_tree("<?php print $rand; ?>");
                            mw.$("#quickform-edit-content").submit(function () {
                                mw.edit_content.handle_form_submit();
                                return false;
                            });
                            <?php if($data['id'] != 0) : ?>
                            mw.$(".mw-admin-go-live-now-btn").attr('content-id', <?php print $data['id']; ?>);
                            <?php endif; ?>
                            mw.$('#mw-parent-page-value-<?php print $rand; ?>').on('change', function (e) {
                                var iframe_ed = $('.mw-iframe-editor');


                                var changed = iframe_ed.contents().find('.changed').size();
                                if (changed == 0) {

                                    mw.edit_content.load_editor();
                                }
                                //mw.edit_content.load_editor();
                            });
                            $(window).on('templateChanged', function (e) {

                                var iframe_ed = $('.mw-iframe-editor')
                                var changed = iframe_ed.contents().find('.changed').size();
                                if (changed == 0) {
                                    // mw.edit_content.load_editor();
                                }
                                mw.edit_content.load_editor();
                            });
                            if (mwd.querySelector('.mw-iframe-editor') !== null) {
                                mwd.querySelector('.mw-iframe-editor').onload = function () {
                                    $(window).on('scroll', function () {
                                        var scrolltop = $(window).scrollTop();
                                        if (mwd.getElementById('mw-edit-page-editor-holder') !== null) {
                                            var otop = mwd.getElementById('mw-edit-page-editor-holder').offsetTop;
                                            if ((scrolltop + 100) > otop) {
                                                var ewr = mwd.querySelector('.mw-iframe-editor').contentWindow.document.querySelector('.editor_wrapper');
                                                if (ewr === null) {
                                                    return false;
                                                }
                                                ewr.style.position = 'absolute';
                                                ewr.style.top = scrolltop + otop + 'px';
                                                ewr.style.top = scrolltop - otop /*+ mwd.querySelector('.admin-manage-toolbar').offsetTop*/ + mwd.querySelector('.admin-manage-toolbar').offsetHeight - 98 + 'px';
                                                mw.$('.admin-manage-toolbar-scrolled').addClass('admin-manage-toolbar-scrolled-wysiwyg');
                                                mw.tools.addClass(ewr, 'editor_wrapper_fixed');
                                            }
                                            else {
                                                var ewr = mwd.querySelector('.mw-iframe-editor').contentWindow.document.querySelector('.editor_wrapper');
                                                if (ewr === null) {
                                                    return false;
                                                }
                                                ewr.style.position = 'static';
                                                mw.$('.admin-manage-toolbar-scrolled').removeClass('admin-manage-toolbar-scrolled-wysiwyg');
                                                mw.tools.removeClass(ewr, 'editor_wrapper_fixed');
                                            }
                                        }
                                    });
                                }
                            }

                            var title_field_shanger = $('#content-title-field');

                            if (title_field_shanger.length > 0) {
                                $(title_field_shanger).unbind("change");
                                $(title_field_shanger).on("change", function () {
                                    var newtitle = $(this).val();
                                    $('#content-title-field-master').val(newtitle);
                                });
                            }

                            $(".postbtnmore").on('mousedown', function () {
                                $(this).remove()
                            })

                            mww.QTABS = mw.tabs({
                                nav: mw.$("#quick-add-post-options .mw-ui-abtn"),
                                tabs: mw.$("#quick-add-post-options-items-holder .quick-add-post-options-item"),
                                toggle: true,
                                onclick: function (qtab) {

                                    var tabs = $(mwd.getElementById('quick-add-post-options-items-holder'));
                                    if (mw.$("#quick-add-post-options .mw-ui-abtn.active").length > 0) {
                                        var tabsnav = $(mwd.getElementById('quick-add-post-options'));
                                        var off = tabsnav.offset();
                                        $(tabs).show();
                                        QTABSArrow(this);
                                        QTABMaxHeight();
                                    }
                                    else {
                                        $(tabs).hide();
                                    }
                                    if (qtab.id === 'post-gallery-manager') {
                                        $(qtab).width(mw.$("#mw-edit-page-editor-holder").width())
                                    } else if (qtab.id === 'quick-add-post-options-item-template') {
                                        mw.reload_module('#mw-quick-add-choose-layout');
                                    }


                                    try {
                                        mwd.querySelector('.mw-iframe-editor').contentWindow.GalleriesRemote()
                                    } catch (err) {
                                    }

                                }
                            });

                            QTABMaxHeight = function () {
                                var qt = mw.$('#quick-add-post-options-items-holder-container'),
                                    wh = $(window).height(),
                                    st = $(window).scrollTop();
                                if (qt.length == 0) {
                                    return false;
                                }
                                qt.css('maxHeight', (wh - (qt.offset().top - st + 20)));
                                qt.css('width', ($(".admin-manage-content-wrap").width()));
                            }

                            $(mww).on('mousedown', function (e) {
                                var el = mwd.getElementById('content-edit-settings-tabs-holder');
                                var cac = mw.wysiwyg.validateCommonAncestorContainer(e.target);
                                if (el != null && !el.contains(e.target)
                                    && !!cac
                                    && !mw.tools.hasParentsWithTag(e.target, 'grammarly-btn')
                                    && cac.className.indexOf('grammarly') !== -1
                                    && cac.querySelector('[class*="grammarly"]') === null
                                    && !mw.tools.hasParentsWithTag(e.target, 'grammarly-ghost')
                                    && !mw.tools.hasParentsWithTag(e.target, 'grammarly-card')) {
                                    mww.QTABS.unset()
                                    mw.$(".quick-add-post-options-item, #quick-add-post-options-items-holder").hide();
                                    mw.$("#quick-add-post-options .active").removeClass('active');
                                }
                            });

                            mw.$(".mw-iframe-editor").on("editorKeyup", function () {
                                mw.tools.addClass(mwd.body, 'editorediting');
                            });
                            $(mwd.body).on("mousedown", function () {
                                mw.tools.removeClass(mwd.body, 'editorediting');
                            });
                            mw.$(".admin-manage-toolbar").on("mousemove", function () {
                                mw.tools.removeClass(mwd.body, 'editorediting');
                            });



                        });
                    </script>

                </div>
            </div>

            <?php if (isset($data['url']) and $data['id'] > 0): ?>
                <script>
                    $(document).ready(function () {
                        $('.go-live-edit-href-set').attr('href', '<?php print content_link($data['id']); ?>');
                    });
                </script>

            <?php endif;
            ?>

            <script>
                mw.require("<?php print mw_includes_url(); ?>css/select2.min.css");
                mw.require("<?php print mw_includes_url(); ?>js/select2.min.js");
            </script>

            <style>

                .select2-container--default .select2-selection--single {
                    border: 1px solid #cfcfcf;
                    border-radius: 5px;
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                    height: 2.5rem;
                    padding-top: 5px;
                box-shadow: inset 0 0 3px rgb(0 0 0 / 20%);
                }



                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    top: 7px;
                }


                #quick-parent-selector-tree .mw-tree-nav{
                    padding: 12px 30px;
                    border: 1px solid #cfcfcf;
                    margin: 20px 0;
                    border-radius: 3px;

                }




                .postEditCategory {}

                .postEditCategory .card-body {
                    padding: 25px 15px!important;
                }

                .postEditCategory ul {
                    padding: 12px 20px !important;
                }

                .postEditCategory ul ul {
                    padding: 5px 0px !important;
                }

                .postEditCategory ul  span {
                    padding-right: 5px !important;
                }

                .postEditCategory ul li {
                }

                .postEditCategory ul li input[type="checkbox"] + span {
                    height: 15px;
                    width: 15px;
                    padding-right: 5px !important;
                }

                .postEditCategory ul li span.mw-tree-item-title {
                    margin-left: 0px !important;
                    padding-left: 0px !important;
                    top: 1px !important;
                    position: relative;
                    font-size: 11px;
                }

                .postEditCategory ul ul li {
                    padding-left: 12px !important;
                }

                .postEditCategory ul ul li .mw-tree-toggler {
                }

                .postEditCategory ul ul li .mw-tree-toggler:after {
                    right: -15px;
                }
                .basic-price-input p.base-price {
                    flex: 2;
                }
                .basic-price-input {
                    display: flex;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-shadow: inset 0 0 3px rgb(0 0 0 / 20%);
                }

                .basic-price-input p {
                    margin-bottom: 0;
                    padding: 10px 5px;
                }

                .basic-price-input p.base-price-currency {
                    border-right: 1px solid #ccc;
                    flex: 1;
                }

                .basic-price-input p.base-price-unit{
                    text-align: center;
                    border-left: 1px solid #ccc;
                }
                .input-group-append {
                    margin-left: -4px;
                }
            </style>
            <?php
            $condition = '?is_shop=1';
            ?>
            <script>

                var loadCategoriesTree = function () {
                    var request = new XMLHttpRequest();
                    request.open('GET', '<?php print api_url('content/get_admin_js_tree_json'.$condition); ?>', true);
                    request.send();
                    request.onload = function() {
                        if (request.status >= 200 && request.status < 400) {
                            var tdata = JSON.parse(request.responseText);

                                var selectedPages = [ <?php print $data['parent']; ?>];
                                var selectedCategories = [ <?php print $categories_active_ids; ?>];



                                var tags = mw.element();
                                var tree = mw.element();

                                mw.element('.post-category-tags').empty().append(tags)
                                mw.element('#quick-parent-selector-tree').empty().append(tree)



                                window.categorySelector = new mw.treeTags({
                                    data: tdata,
                                    selectable: true,
                                    multiPageSelect: false,
                                    tagsHolder: tags.get(0),
                                    treeHolder: tree.get(0),
                                    color: 'primary',
                                    size: 'sm',
                                    outline: true,
                                    saveState: false,
                                    on: {
                                        selectionChange: function () {
                                            document.querySelector('.btn-save').disabled = false;
                                            mw.askusertostay = true;
                                        }
                                    }
                                });

                                $(categorySelector.tree).on('ready', function () {
                                    if (window.pagesTree && pagesTree.selectedData.length) {
                                        $.each(pagesTree.selectedData, function () {
                                            categorySelector.tree.select(this)
                                        })
                                    } else {
                                        $.each(selectedPages, function () {
                                            categorySelector.tree.select(this, 'page')
                                        });
                                        $.each(selectedCategories, function () {
                                            categorySelector.tree.select(this, 'category')
                                        });
                                    }

                                    var atcmplt = mw.element('<div class="input-group mb-0 prepend-transparent"> <div class="input-group-prepend"> <span class="input-group-text px-1"><i class="mdi mdi-magnify"></i></span> </div> <input type="text" class="form-control form-control-sm" placeholder="Search"> </div>');

                                    tree.before(atcmplt);

                                    atcmplt.find('input').on('input', function () {
                                        var val = this.value.toLowerCase().trim();
                                        console.log(val);
                                        if (!val) {
                                            categorySelector.tree.showAll();
                                        }
                                        else {
                                            categorySelector.tree.options.data.forEach(function (item) {

                                                if (item.title.toLowerCase().indexOf(val) === -1) {
                                                    categorySelector.tree.hide(item);
                                                }
                                                else {
                                                    categorySelector.tree.show(item);
                                                }
                                            });
                                        }
                                    })
                                });

                                $(categorySelector.tags).on("tagClick", function (e, data) {
                                    $(".mw-tree-selector").show();
                                    mw.tools.highlight(categorySelector.tree.get(data))
                                });

                        }
                    }

                }
                var catManager;
                var addCategory = function () {
                    if(!catManager) {
                        catManager = new mw.CategoryManager();
                    }
                    catManager.addNew().then(function (data){
                        loadCategoriesTree()
                    })
                }


            </script>

            <div class="col-md-4 manage-content-sidebar">
                <div class="card style-1 mb-3">
                    <div class="card-body pt-3 pb-0">
                        <div class="row">
                            <div class="col-12">
                                <strong><?php _e("Visibility"); ?></strong>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-12"><input type="hidden" name="is_active" id="is_post_active" value="<?php print $data['is_active']; ?>"/>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="is_active_1" name="is_active" class="custom-control-input" value="1" onclick="isShow()" <?php if ($data['is_active']): ?>checked<?php endif; ?>>
                                        <label class="custom-control-label" for="is_active_1">Sofort veröffentlichen</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="is_active_0" name="is_active" class="custom-control-input" value="0" onclick="isShow()" <?php if (!$data['is_active']): ?>checked<?php endif; ?>>
                                        <label class="custom-control-label" for="is_active_0">Entwurf</label>
                                    </div>
                                    <?php if (empty($data['id']) and $data['id'] == null): ?>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="future_post" name="is_active" class="custom-control-input" value="1" onclick="isShow()" <?php if (!$data['is_active']): ?>checked<?php endif; ?>>
                                            <label class="custom-control-label" for="future_post">Veröffentlichung planen</label>
                                            <div id="status" style="display:none; ">
                                                <label for="meeting-time">Choose a time for post your blog:</label>
                                                <?php $time=date('Y-m-d').'T'.date('H:i') ?>
                                                <input type="datetime-local" id="created_at"
                                                    name="created_at" value="<?php echo $time; ?>"
                                                    min="<?php echo $time; ?>">
                                            </div>
                                            <script>
                                                function isShow(){
                                                    if(document.getElementById("future_post").checked){
                                                        document.getElementById("status").style.display="";
                                                    } else {
                                                        document.getElementById("status").style.display="none";
                                                    }
                                                }
                                            </script>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (isset($data['id']) and $data['id'] != 0): ?>
                                <div class="col-12">
                                    <?php
                                    $time_info = DB::table('content')->where('id', $data['id'])->first();
                                    $post_time = strtotime($time_info->created_at);
                                    $current_time = strtotime((date("Y-m-d H:i:s")));
                                    // echo $post_time."==".$current_time."\n";
                                    if($post_time <= $current_time):  ?>
                                        <button type="button" class="btn btn-link px-0" data-toggle="collapse" data-target="#set-a-specific-publish-date"><?php _e('Set a specific publish date'); ?></button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-link px-0" data-toggle="collapse" data-target="#set-a-specific-publish-date"><?php _e('Change post publish date'); ?></button>
                                    <?php endif; ?>

                                    <div class="collapse" id="set-a-specific-publish-date">
                                        <div class="row pb-3">
                                            <script>mw.lib.require('bootstrap_datetimepicker');</script>
                                            <script>
                                                $(function () {
                                                    $('.mw-admin-edit-post-change-created-at-value').datetimepicker();
                                                    $('.mw-admin-edit-post-change-updated-at-value').datetimepicker();
                                                });
                                            </script>
                                            <?php if (isset($data['created_at'])): ?>
                                                <div class="col-md-12">
                                                    <div class="mw-admin-edit-post-created-at" onclick="mw.adm_cont_enable_edit_of_created_at()">
                                                        <small>
                                                            <?php _e("Created on"); ?>: <span class="mw-admin-edit-post-display-created-at-value"><?php print date('Y-m-d H:i:s', strtotime($data['created_at'])) ?></span>
                                                            <input class="form-control form-control-sm mw-admin-edit-post-change-created-at-value" style="display:none" type="text" name="created_at" value="<?php print date('Y-m-d H:i:s', strtotime($data['created_at'])) ?>"  >
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (isset($data['updated_at'])): ?>
                                                <div class="col-md-12 mt-2">
                                                    <div class="mw-admin-edit-post-updated-at" onclick="mw.adm_cont_enable_edit_of_updated_at()">
                                                        <small>
                                                            <?php _e("updated on"); ?>: <span class="mw-admin-edit-post-display-updated-at-value"><?php print date('Y-m-d H:i:s', strtotime($data['updated_at'])) ?></span>
                                                            <input class="form-control form-control-sm mw-admin-edit-post-change-updated-at-value" style="display:none" type="text" name="updated_at" value="<?php print date('Y-m-d H:i:s', strtotime($data['updated_at'])) ?>" >
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card style-1 mb-3 categories postEditCategory">
                    <div class="card-body pt-3 pb-1">
                        <div class="row">
                            <?php if ($data['content_type'] == 'page') : ?>
                                <div class="col-12">
                                    <strong><?php _e("Select parent page"); ?></strong>

                                    <div class="quick-parent-selector mt-2">
                                        <module type="content/views/selector" no-parent-title="<?php _e('No parent page'); ?>" field-name="parent_id_selector" change-field="parent" selected-id="<?php print $data['parent']; ?>" remove_ids="<?php print $data['id']; ?>" recommended-id="<?php print $recommended_parent; ?>"/>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-12">
                                    <strong><?php _e('Categories'); ?></strong>
                                <a onclick="mw.top().tools.open_global_module_settings_modal('categories/admin_backend_modal', 'categories-admin');void(0);return false;" href="<?php /*echo admin_url(); */?>view:content/action:categories" class="btn btn-link float-right py-1 px-0"> <?php _e('Manage'); ?></a>

                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="row mb-3">
                            <div class="col-12">
                                <?php if ($data['content_type'] != 'page'): ?>
                                    <script>
                                        $(document).ready(function () {
                                            $('#mw-post-added-<?php print $rand; ?>').on('mousedown touchstart', function (e) {
                                                if (e.target.nodeName === 'DIV') {
                                                    setTimeout(function () {
                                                        $('.mw-ui-invisible-field', e.target).focus()
                                                    }, 78)
                                                }
                                            });

                                            var all = [{type: 'page', id: <?php print !empty($data['parent']) ? $data['parent'] : 'null' ?>}];
                                            var cats = [<?php print $categories_active_ids; ?>];

                                            $.each(cats, function () {
                                                all.push({
                                                    type: 'category',
                                                    id: this
                                                })
                                            });

                                            if (typeof(mw.adminPagesTree) != 'undefined') {
                                                mw.adminPagesTree.select(all);
                                            }
                                        });
                                    </script>

                                    <div class="mw-tag-selector mt-3" id="mw-post-added-<?php print $rand; ?>">
                                        <div class="post-category-tags" data-parent="<?php if(url_param('action', 'false') == 'products' || url_param('view', 'false') == 'shop'  || @$params['content_type'] == "product") print "shop"; ?>"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>



                        <?php if ($data['content_type'] != 'page'): ?>


                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted"><?php _e('Want to add the '.$data['content_type'].' in more categories?'); ?></small>
                                    <br/>
                                    <button type="button" class="btn btn-outline-primary btn-sm text-dark my-3" data-toggle="collapse" data-target="#show-categories-tree"><?php _e('Category Add to'); ?></button>
                                    <br/>

                                    <div id="show-categories-tree" class="collapse show">
                                        <div class="mw-admin-edit-page-primary-settings content-category-selector">
                                            <div class="mw-ui-field-holder">
                                                <div class="mw-ui-category-selector mw-ui-category-selector-abs mw-tree mw-tree-selector" id="mw-category-selector-<?php print $rand; ?>">
                                                    <?php if ($data['content_type'] != 'page'): ?>
                                                        <script>
                                                            $(document).ready(function () {
                                                                loadCategoriesTree();
                                                            });

                                                        mw.on('pagesTreeRefresh', function () {
                                                                loadCategoriesTree();
                                                            });
                                                        </script>

                                                        <div id="quick-parent-selector-tree"></div>

                                                        <script>

                                                            var thetree = mwd.querySelector(".mw-ui-category-selector-abs .module")


                                                            CreateCategoryForPost = function (step) {

                                                                mw.$("#category-not-found-name").html(mw.$('#quick-tag-field').val());
                                                                if (step === 0) {
                                                                    mw.$("#category-tree-not-found-message").hide();
                                                                    mw.$("#parent-category-selector-block").hide();
                                                                }
                                                                if (step === 1) {
                                                                    mw.$(".mw-ui-category-selector-abs").scrollTop(0);
                                                                    mw.$("#category-tree-not-found-message").show();
                                                                    mw.$("#parent-category-selector-block").hide();
                                                                }
                                                                else if (step === 2) {
                                                                    if (mw.$(".mw-tag-selector .mw-ui-btn-small").length === 0) {
                                                                        mw.$("#category-tree-not-found-message").hide();
                                                                        mw.$("#parent-category-selector-block").show();
                                                                    }
                                                                    else {
                                                                        CreateCategoryForPost(3);
                                                                    }
                                                                }
                                                                else if (step == 3) {
                                                                    var checked = mwd.querySelector('#categoryparent input:checked');
                                                                    if (checked == null) {
                                                                        var checked = mwd.querySelector('#pages_edit_container input[type=radio]:checked');
                                                                    }
                                                                    if (checked == null) {
                                                                        return;
                                                                    }
                                                                    var parent = "content_id"
                                                                    //  var parent = mw.tools.firstParentWithTag(checked, 'li');
                                                                    //  var parent = mw.tools.hasClass(parent, 'is_page') ? 'content_id' : 'parent_id';
                                                                    var data = {
                                                                        title: mw.$('#quick-tag-field').val()
                                                                    };
                                                                    data[parent] = checked.value;
                                                                    //data[parent] = checked.value;
                                                                    $.post(mw.settings.api_url + "category/save", data, function () {
                                                                        mw.reload_module("categories/selector", function (el) {
                                                                            mw.$("#category-tree-not-found-message").hide();
                                                                            mw.$("#parent-category-selector-block").show();
                                                                        })
                                                                    });
                                                                }
                                                            }

                                                        </script>

                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($data['content_type'] == 'page'): ?>
                    <div class="card style-1 mb-3 menus">
                        <div class="card-body pt-3">
                            <?php event_trigger('mw_edit_page_admin_menus', $data); ?>

                            <?php if (isset($data['add_to_menu'])): ?>
                                <module type="menu" view="edit_page_menus" content_id="<?php print $data['id']; ?>" add_to_menu="<?php print $data['add_to_menu']; ?>"/>
                            <?php else: ?>
                                <module type="menu" view="edit_page_menus" content_id="<?php print $data['id']; ?>"/>
                            <?php endif; ?>

                            <?php event_trigger('mw_admin_edit_page_after_menus', $data); ?>
                        </div>
                    </div>
                <?php endif;

                if(!isset($data['position'])){
                    $new_position = DB::table('content')->max('position')+1;

                    DB::table('content')->where('id',$data['id'])->update(
                        [
                            'position' => $new_position,
                        ]
                    );
                    $data['position'] = $new_position;
                }
                if (isset($data['content_type']) and ($data['content_type'] != 'page') and ($data['content_type'] != 'post')): ?>
                    <?php $varint = DB::table('variants')->where('rel_id',$data['id'])->get(); //dd($varint);

                        $positions = DB::table('content')->select('position','id')->where('content_type','product')->orderBy('position','desc')->get();

                endif;
                ?>

                <?php if (isset($data['content_type'])): ?>
                    <?php if($data['url'] != 'thank-you'): ?>
                        <div class="card style-1 mb-3">
                            <div class="card-body pt-3">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <strong><?php _e("Tags"); ?></strong>
                                        <small class="tag-tooltip" data-toggle="tooltip" title="Um einen Tag zu generieren, gebe bitte den Tag ein und drücke anschließend Komma (,)">(?)</small>
                                    </div>
                                </div>

                                <?php if (isset($data['content_type'])): ?>
                                    <module type="content/views/content_tags" content-type="<?php print $data['content_type'] ?>" content-id="<?php print $data['id'] ?>"/>
                                <?php else: ?>
                                    <small class="text-muted">The tags are available only for saved content</small>
                                <?php endif;
                                ?>
                                <?php if (isset($data['content_type']) and ($data['content_type'] != 'page') and ($data['content_type'] != 'post')): ?>
                                        <div class="form-group">
                                            <label for="usr" style="margin-top: 20px;">
                                                <strong><?php _e("Set Content's Position"); ?></strong>
                                            </label>
                                            <small class="tag-tooltip" data-toggle="tooltip" title="<?php _e("From this dropdown you can assign a content's position for content's layouts."); ?>">(?)</small>
                                            <div style="display: flex;align-items: center;">
                                                <select class="form-control" id="position" name="position" >
                                                    <?php  foreach($positions as $key => $position){ ?>
                                                        <option value="<?=$position->id.','.$position->position.','.$key?>" <?php if($position->position == $data['position']){
                                                            print "selected";
                                                        } ?>><?=$key+1?></option>
                                                        <?php
                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                    <?php    endif; ?>
                            </div>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="card style-1 mb-3 d-none">
                    <div class="card-body">
                        <div id="content-title-field-buttons">
                            <?php if ($is_live_edit == false) : ?>
                                <button type="submit" class="btn btn-primary mw-live-edit-top-bar-button" onclick="mw.edit_content.handle_form_submit(true);" form="quickform-edit-content"><i class="mai-eye2"></i> <span><?php _e("Live Edit"); ?></span></button>
                            <?php else: ?>
                                <?php if ($data['id'] == 0): ?>
                                    <button type="submit" class="btn btn-primary mw-live-edit-top-bar-button" onclick="mw.edit_content.handle_form_submit(true);" data-text="<?php _e("Live Edit"); ?>" form="quickform-edit-content"><i class="mai-eye2"></i> <span><?php _e("Live Edit"); ?></span></button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary mw-live-edit-top-bar-button" onclick="mw.edit_content.handle_form_submit(true);" data-text="<?php _e("Live Edit"); ?>"><i class="mai-eye2"></i> <span><?php _e("Live Edit"); ?></span></button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php

                if (isset($data['content_type']) and ($data['content_type'] != 'page') and ($data['content_type'] != 'post')): ?>

                    <div class="card style-1 mb-3">
                        <div class="card-body pt-3">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <strong><?php _e("Product Data"); ?></strong>
                                    <small class="tag-tooltip" data-toggle="tooltip" title="<?php _e('Product Brand, Weight, Size, Delivery time, Handling time Data (,)'); ?>">(?)</small>
                                </div>
                            </div>

                            <?php if (isset($data['content_type']) AND $data['content_type'] != 'page'): ?>
                                <div class="product_barnd">
                                    <div class="form-group">
                                    <label for="usr"><?php _e('Brand'); ?>:</label>
                                    <input type="text" class="form-control" id="brand" name="brand" value="<?php if($data['id'] != 0){if(@$data['brand']){ print($data['brand']);}} ?>">
                                    </div>
                                    <div class="form-group">
                                    <label for="pwd"><?php _e('Weight'); ?>:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="item_weight" name="item_weight" value="<?php if($data['id'] != 0){if(@$data['item_weight']){ print((float)$data['item_weight']);}} ?>">
                                        <div class="input-group-append">
                                        <input type="hidden" class="form-control" id="item_unit" name="item_unit" value="<?php if(isset($data['item_unit'])){ print($data['item_unit']);} ?>">
                                        <select class="form-control" id="item_unit" name="item_unit" disabled>
                                            <option value="">..</option>
                                            <option value="Gram" <?php if(isset($data['item_unit']) && $data['item_unit']=='Gram'){ print 'selected'; } ?> >Gram</option>
                                            <option value="Kilogram" <?php if(isset($data['item_unit']) && $data['item_unit']=='Kilogram'){ print 'selected'; } ?> >Kilogram</option>
                                            <option value="Milliliter" <?php if(isset($data['item_unit']) && $data['item_unit']=='Milliliter'){ print 'selected'; } ?>>Milliliter</option>
                                            <option value="Liter" <?php if(isset($data['item_unit']) && $data['item_unit']=='Liter'){ print 'selected'; } ?>>Liter</option>
                                            <option value="Centimeter" <?php if(isset($data['item_unit']) && $data['item_unit']=='Centimeter'){ print 'selected'; } ?>>Centimeter</option>
                                            <option value="Meter" <?php if(isset($data['item_unit']) && $data['item_unit']=='Meter'){ print 'selected'; } ?>>Meter</option>
                                        </select>
                                        </div>
                                    </div>
                                    </div>
                                    <?php if(!empty($data['item_unit']) && !empty($data['item_weight'])): ?>
                                        <?php
                                            //base price calculation for single product
                                            if($data['item_unit'] == 'Gram' || $data['item_unit'] == 'Milliliter'){
                                                $product_base_price = (1000/(float)$data['item_weight'])*$productPrice;
                                            }elseif($data['item_unit'] == 'Centimeter'){
                                                $product_base_price = (100/(float)$data['item_weight'])*$productPrice;
                                            }else{
                                                $product_base_price = (1/(float)$data['item_weight'])*$productPrice;
                                            }
                                            if(isset($data['basic_price']) && !empty($data['basic_price'])){
                                                $product_base_price = $data['basic_price'];
                                            }
                                            //base unit set for product
                                            if($data['item_unit'] == 'Gram' || $data['item_unit'] == 'Kilogram'){
                                                $item_unit = 'Kilogram';
                                            }elseif($data['item_unit'] == 'Milliliter' || $data['item_unit'] == 'Liter'){
                                                $item_unit = 'Liter';
                                            }elseif($data['item_unit'] == 'Centimeter' || $data['item_unit'] == 'Meter'){
                                                $item_unit = 'Meter';
                                            }

                                        ?>
                                        <div class="form-group">
                                            <label for="pwd"><?php _e('Base Price'); ?>:</label>
                                            <div class="basic-price-input">
                                                <p class="base-price"><?php print  currency_format($product_base_price);; ?></p>
                                                <p class="base-price-unit">Per <?php print $item_unit; ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Size'); ?>:</label>
                                        <?php if($data['id'] != 0){
                                                if(isset($data['item_size'])){ ?>
                                                    <input type="text" class="form-control" id="item_size" name="item_size" value="<?php if($data['id'] != 0){if(@$data['item_size']){ print($data['item_size']);}} ?>">
                                        <?php }elseif(isset($varint->size)){?>
                                            <select class="form-control" id="size" name="size">
                                                <?php foreach ($varint as $size) { ?>
                                                    <option value="<?php print($size->size); ?>"><?php print($size->size); ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php }else{?>
                                            <input type="text" class="form-control" id="item_size" name="item_size">
                                        <?php }} ?>
                                        <?php if($data['id'] == 0){ ?>
                                            <input type="text" class="form-control" id="item_size" name="item_size">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                    <label for="sel1"><?php _e('Delivery time / Handling time'); ?>:</label>
                                    <select class="form-control" id="delivery_days" name="delivery_days">
                                        <?php  for ($x = 1; $x <= 120; $x++) { ?>
                                            <option value="<?php print($x); ?>"
                                                <?php
                                                    if($data['id'] != 0){
                                                        if(@$data['delivery_days']){
                                                            if(@$data['delivery_days'] == $x){
                                                                print('selected="selected"');
                                                            }
                                                        }
                                                    }
                                                ?>
                                            ><?php echo "$x"; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Color'); ?>:</label>
                                        <input type="text" class="form-control" id="item_color" name="item_color" value="<?php if($data['id'] != 0){if( @$data['item_color']){ print($data['item_color']);}} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Materials'); ?>:</label>
                                        <input type="text" class="form-control" id="materials" name="materials" value="<?php if($data['id'] != 0){if(@$data['materials']){ print($data['materials']);}} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Year of Production'); ?>:</label>
                                        <input type="text" class="form-control" id="production_year" name="production_year" value="<?php if($data['id'] != 0){if(@$data['production_year']){ print($data['production_year']);}} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Gender'); ?>:</label>
                                        <input type="text" class="form-control" id="gender" name="gender" value="<?php if($data['id'] != 0){if( @$data['gender']){ print($data['gender']);}} ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Note'); ?>:</label>
                                        <input type="text" class="form-control" id="note" name="note" value="<?php if($data['id'] != 0){if(@$data['note']){ print($data['note']);}} ?>">
                                    </div>

                                    <?php $status = array(
                                        '1000' => 'Neu',
                                        '1500' => 'Neu: Sonstige (siehe Artikelbeschreibung)',
                                        '1750' => 'Neu mit Fehlern',
                                        '2000' => 'Vom Hersteller generalüberholt',
                                        '2500' => 'Vom Verkäufer generalüberholt',
                                        '2750' => 'Neuwertig',
                                        '3000' => 'Gebraucht',
                                        '4000' => 'Sehr gut',
                                        '5000' => 'Gut',
                                        '6000' => 'Akzeptabel',
                                        '7000' => 'Als Ersatzteil / defekt',
                                    ) ?>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Status'); ?>:</label>
                                        <select class="form-control" id="status" name="status">
                                        <?php  foreach ($status as $key => $x) { ?>
                                            <option value="<?php print($key); ?>"
                                                <?php
                                                    if($data['id'] != 0){
                                                        if(@$data['status']){
                                                            if(@$data['status'] == $key){
                                                                print('selected="selected"');
                                                            }
                                                        }
                                                    }
                                                ?>
                                            ><?php echo "$x"; ?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                    <?php
                                        $data['suplier'] = (int) @$data['suplier'];

                                    ?>
                                    <script>

                                        function sup_do(){
                                            return $.post("<?= url('/') ?>/api/v1/supliers_details", {  }, (res) => {

                                                    let data = res.data;
                                                    let suplier_list = ``;

                                                    suplier_list = `<option value="" id="no_supli"><?php _e('Select Suplier'); ?></option>`;
                                                    if(data.length > 0){
                                                        data.forEach(sup => {
                                                        suplier_list += `<option value="${sup.id}" id="sup_${sup.id}">${sup.name}</option>
                                                            `;
                                                        })
                                                    }


                                                    $('#suplier').html(suplier_list);

                                                })
                                                .catch(err => {
                                                    console.log(err)
                                                })
                                        }

                                        $(document).ready(async function () {
                                            await sup_do();
                                            $("#sup_<?=@$data['suplier']?>").attr('selected', 'selected');
                                        });
                                        $('#suplier').on('change',function(){
                                            $("#sup_"+$(this).val()).attr('selected', 'selected');
                                        });
                                        $(document).ready(function(){
                                            setTimeout(executeSup, 2000);
                                            function executeSup(){
                                                var hasSup = $('#suplier').val();
                                                if(hasSup != null){
                                                    $('#suplier').attr('disabled', true);
                                                }
                                            }

                                        });
                                    </script>
                                    <div class="form-group">
                                        <label for="usr"><?php _e('Suplier'); ?>:</label>
                                        <div style="display: flex;align-items: center;">
                                            <select class="form-control" id="suplier" name="suplier" required>

                                            </select>
                                            <a class="btn btn-success" href="https://drm.software/admin/delivery_companies/add" style="margin-left: 5px;" target="_blank"><?php _e('Add'); ?></a>
                                        </div>
                                    </div>




                                </div>
                            <?php else: ?>
                                <small class="text-muted"><?php _e('The tags are available only for saved content'); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <style type="text/css">
                    .product_barnd input,select{
                        box-shadow: inset 0 0 3px rgb(0 0 0 / 20%);
                    }
                </style>
            </div>
            <script>
            $(function () {
            $('.tag-tooltip').tooltip();
            });
            $(document).ready(function() {
                $('#position').select2();
                $("#position").on("change",function(){

                    $.post('<?=url("/api/v1/reorder_position")?>', { product_id: <?=$data["id"]?>, replace_with: $(this).val() }, (res) => {

                        if(res.success){
                            mw.notification.success("Order Changed Successfully");
                        }

                    });

                });
            });
            </script>

        </div>
    </form>
</div>
<script>
    $(".preloader-whirlpool").hide();
    $('#instragram-gallery-modal').on('show.bs.modal', function (){
        $(".preloader-whirlpool").show();
        $.post("<?= url('/') ?>/api/v1/instagram_feed", { data:1 }, (res) => {
            if(res.success = 'true'){
                $(".preloader-whirlpool").hide();
                insta_images(res);
            }

            $(".paging").on("click",function(){


                $.post("<?= url('/') ?>/api/v1/insta_next", { data:$(this).data('url') }, (res) => {
                    if(res.success = 'true'){
                        insta_images(res);
                    }
                });
            });

        });


    });

    function insta_images(res){

        let html = ``;
        let paging = ``;
        let media_urls;
        let data = JSON.parse(res.data);
        if(data.error){
            html+= `<div class="">
                     <p>please connect your account</p>
                            </div>`
        }else {

            data.data.forEach(image => {
                if (image.media_type != "VIDEO") {
                    // if(image.children){
                    //     const urls = image.children.data.map(item => {
                    //         return  item.media_url
                    //     });
                    //         media_urls = JSON.stringify(urls);
                    // }else{
                    media_urls = image.media_url;
                    // }
                    html += `
                            <div class="col-md-3">
                                <div class="instragram-gallery-item">
                                <img src="${image.media_url}" alt="" data-imgurl="${media_urls}" class="img-show">
                                    <div class="instragram-gallery-item-hover img-show" data-imgurl="${media_urls}">
                                        <div class="instragram-gallery-item-hover-content">
                                            <p>
                                                ${image.caption}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                }
            });

            if (typeof data.paging.previous != 'undefined') {
                $("#previous_url").data('url', data.paging.previous);
                $("#previous_url").removeClass('hide');
            } else {
                $("#previous_url").addClass('hide');
            }

            if (typeof data.paging.next != 'undefined') {
                $("#next_url").data('url', data.paging.next);
                $("#next_url").removeClass('hide');
            } else {
                $("#next_url").addClass('hide');
            }
        }
        $("#insta_details").html(html);

        $(".img-show").on('click',function (){
            // console.log($(this).data('imgurl'));
            // return false;
            var obj = {
                "for": "content",
                "for_id": <?=$data['id']?>,
                "media_type": "picture",
                "src": $(this).data('imgurl'),
            }
            var des = $(this).find('p').html();
            $.post("<?= url('/') ?>/api/save_media", obj, (res) => {
                if(res){
                    var instainfo = {
                        "media_id": res,
                        "insta_img_description": des,
                    }
                    $.post("<?= url('/') ?>/api/v1/insta_details", instainfo, (res) => {
                        if(res.success){

                            mw.top().reload_module('pictures');
                            mw.reload_module('pictures/admin');
                            mw.reload_module_parent("pictures/admin");
                            mw.reload_module('pictures/admin_backend_sortable_pics_list');
                            mw.notification.success('File uploaded');
                        }
                    });
                }
            });
        });
    }
</script>
