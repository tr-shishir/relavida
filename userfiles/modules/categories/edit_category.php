<?php
must_have_access();
$form_rand_id = uniqid() . rand();
$data = false;
if (isset($params["data-category-id"])) {
    $data = get_category_by_id($params["data-category-id"]);
}

if ($data == false or empty($data)) {
    include('_empty_category_data.php');
}
if (!$data['id'] and isset($params["parent-category-id"])) {
    $data['parent_id'] = intval($params["parent-category-id"]);
}
$just_saved = false;
$quick_edit = false;
if (isset($params['just-saved'])) {
    $just_saved = $params['just-saved'];
}
if (isset($params['quick_edit'])) {
    $quick_edit = $params['quick_edit'];
}

$wrapper_class = 'mw-edit-category-item-admin';

if (isset($params['live_edit'])) {
    $wrapper_class = 'module-live-edit-settings';
}
?>
<style>
    .category-inner-toggle {
        margin-bottom: 10px;
    }
    .category-inner-toggle h6{
        font-weight: 700;
        display: inline-block;
    }
    .category-inner-toggle .toggleSwitch{
        padding-top: 5px;
        margin-left: 5px;
    }
    .mw-filepicker-component-section {
        width: 125px;
    }

    .mw-dialog-container>.mw-filepicker-component-section {
        width: 100%;
    }

    #post-media-card-header {
        padding: 15px;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 0;
        position: relative;
        width: 100%;
    }

    .select_actions_holder {
        position: absolute;
        top: -55px;
        right: 0;
    }

    .card-header.fixed {
        position: fixed !important;
        top: 69px;
        z-index: 10;
    }


    .toggleSwitch span span {
        display: none;
    }

    @media only screen {
        .toggleSwitch {
            display: inline-block;
            height: 18px;
            position: relative;
            overflow: visible;
            padding: 0;
            cursor: pointer;
            width: 40px;
            margin-bottom: 0;
        }
        .toggleSwitch * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .toggleSwitch label,
        .toggleSwitch > span {
            line-height: 20px;
            height: 20px;
            vertical-align: middle;
        }
        .toggleSwitch input:focus ~ a,
        .toggleSwitch input:focus + label {
            outline: none;
        }
        .toggleSwitch label {
            position: relative;
            z-index: 3;
            display: block;
            width: 100%;
        }
        .toggleSwitch input {
            position: absolute;
            opacity: 0;
            z-index: 5;
        }
        .toggleSwitch > span {
            position: absolute;
            left: -50px;
            width: 100%;
            margin: 0;
            padding-right: 50px;
            text-align: left;
            white-space: nowrap;
        }
        .toggleSwitch > span span {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 5;
            display: block;
            width: 50%;
            margin-left: 50px;
            text-align: left;
            font-size: 0.9em;
            width: 100%;
            left: 15%;
            top: -1px;
            opacity: 0;
        }
        .toggleSwitch a {
            position: absolute;
            right: 50%;
            z-index: 4;
            display: block;
            height: 100%;
            padding: 0;
            left: 2px;
            width: 18px;
            background-color: #fff;
            border: 1px solid #CCC;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            transition: all 0.2s ease-out;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .toggleSwitch > span span:first-of-type {
            color: #ccc;
            opacity: 1;
            left: 45%;
        }
        .toggleSwitch > span:before {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            left: 50px;
            top: -1px;
            background-color: #fafafa;
            border: 1px solid #ccc;
            border-radius: 30px;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            transition: all 0.2s ease-out;
        }
        .toggleSwitch input:checked ~ a {
            border-color: #fff;
            left: 100%;
            margin-left: -8px;
        }
        .toggleSwitch input:checked ~ span:before {
            border-color: #0097D1;
            box-shadow: inset 0 0 0 30px #0097D1;
        }
        .toggleSwitch input:checked ~ span span:first-of-type {
            opacity: 0;
        }
        .toggleSwitch input:checked ~ span span:last-of-type {
            opacity: 1;
            color: #fff;
        }

        .category-inner-toggle .toggleSwitch{
            width: 60px;
            padding-top: 5px;
            margin-left: 5px;
        }

        .category-inner-toggle .toggleSwitch > span span:first-of-type{
            left: 36%;
            color: #3dc47e !important;
        }

        .category-inner-toggle .toggleSwitch input:checked ~ a {
            left: 82%;
            border-color: #ff4f52;
            background-color: #ff4f52;
            margin-left: -7px;
        }

        .category-inner-toggle .toggleSwitch > span:before{
            border: 1px solid #3dc47e !important;
        }

        .category-inner-toggle .toggleSwitch > span span{
            color: #ff4f52 !important;
        }

        .category-inner-toggle .toggleSwitch a{
            background-color: #3dc47e;
            border: 1px solid #3dc47e;
            left: 1px;
        }

        .category-inner-toggle .toggleSwitch input:checked ~ span:before {
            box-shadow: unset;
            border-color: #ff4f52 !important;
        }

        .category-inner-toggle .toggleSwitch.german-toggle {
            width: 100px;
        }

        .category-inner-toggle .toggleSwitch.german-toggle > span span:first-of-type {
            left: 26%;
        }

        .toggleSwitch.german-toggle input:checked ~ span span:last-of-type {
            left: 5%;
        }

        .category-inner-toggle .toggleSwitch.german-toggle input:checked ~ a {
            left: 88%;
        }
    }
</style>

<div class="card style-1 mb-3 <?php print $wrapper_class; ?>">
    <script type="text/javascript">
        mw.require('forms.js');
        mw.lib.require('mwui_init');
    </script>
    <script type="text/javascript">
        function save_cat(el) {
            if (mwd.querySelector('.mw-ui-category-selector input:checked') !== null) {
                $(document.forms['admin_edit_category_form']).submit();
            } else {
                Alert('<?php _e("Please choose Page or Category"); ?>.');
            }
        }

        make_new_cat_after_save = function(el) {
            $('#<?php print $params['id'] ?>').removeClass('loading');
            $('#<?php print $params['id'] ?>').removeAttr('just-saved');
            $('#<?php print $params['id'] ?>').removeAttr('selected-category-id');
            $('#<?php print $params['id'] ?>').removeAttr('data-category-id');
            $('#<?php print $params['id'] ?>').removeAttr('category-id');
            <?php if (isset($params['live_edit']) != false) : ?>
                window.location.reload();
            <?php else : ?>
                mw.reload_module('#<?php print $params['id'] ?>');

            <?php endif; ?>
        }

        continue_editing_cat = function() {
            mw.$('.add-edit-category-form').show();
            mw.$('.mw-quick-cat-done').hide();
        }

        <?php if ($just_saved != false) : ?>
            $('#<?php print $params['id'] ?>').removeClass('loading');
            $('#<?php print $params['id'] ?>').removeAttr('just-saved');

        <?php endif; ?>
        $(document).ready(function() {



            var all = $(window);
            var header = document.querySelector('#mw-admin-container header');
            var postHeader = mw.element(document.querySelector('.card-header'));
            all.push(document)
            all.on('scroll load resize', function() {
                var stop = $(this).scrollTop(),
                    otop = $('.mw-iframe-editor').offset().top,
                    tbheight = $('.admin-toolbar').outerHeight(),
                    is = (stop + tbheight) >= otop;



                var isFixed = (stop > (postHeader.get(0).offsetHeight + (header ? header.offsetHeight : 0) + $(postHeader).offset().top));
                postHeader[isFixed ? 'addClass' : 'removeClass']('fixed')
                postHeader.width(isFixed ? postHeader.parent().width() : 'auto')


            });

            mw.category_is_saving = false;
            <?php if (intval($data['id']) == 0) : ?>
            <?php endif; ?>
            var h = mwd.getElementById('edit_category_set_par');
            mw.$('label', h).click(function() {
                set_category_parent();
            });

            mw.$('#admin_edit_category_form').submit(function() {
                var form = this;
                if (mw.category_is_saving) {
                    return false;
                }
                mw.notification.success("Saving...", 3000);
                mw.category_is_saving = true;
                $('.mw-cat-save-submit').addClass('disabled');
                mw.tools.addClass(mw.tools.firstParentWithClass(this, 'module'), 'loading');
                mw.form.post(mw.$('#admin_edit_category_form'), '<?php print api_link('category/save') ?>', function(val) {



                    //todo: move method to separate service
                    var dialog = mw.dialog.get(mw.$('#admin_edit_category_form'));
                    if (dialog) {
                        dialog.result(this.toString())
                    }
                    if (typeof(this.error) != "undefined") {
                        mw.notification.msg(this);
                        mw.category_is_saving = false;
                        return false;
                    }

                    mw.$('#mw-notifications-holder').empty();
                    mw.notification.success("Category changes are saved");
                    var v = this.toString();
                    mw.$('#mw_admin_edit_cat_id').val(v);
                    mw.$('#mw-cat-pics-admin').attr("for-id", v);
                    mw.reload_module('[data-type="categories"]');
                    if (self !== parent && !!parent.mw) {
                        parent.mw.reload_module('categories');
                    }
                    mw.reload_module('categories/manage');
                    mw.reload_module('content/manager');


                    mw.parent().trigger('pagesTreeRefresh')

                    if (window.pagesTreeRefresh) {
                        pagesTreeRefresh()
                    }


                    document.querySelector('.btn-save').disabled = true;
                    mw.askusertostay = false;



                    <?php if (intval($data['id']) == 0) : ?>
                        // mw.url.windowHashParam("new_content", "true");


                    <?php endif; ?>
                    // mw.reload_module('#<?php print $params['id'] ?>');

                    var module = mw.tools.firstParentWithClass(form, 'module');
                    mw.tools.removeClass(module, 'loading');
                    mw.category_is_saving = false;
                    mw.$('.mw-cat-save-submit').removeClass('disabled');



                    mw.url.windowHashParam('action', 'editcategory:' + this)


                });

                return false;
            });

            var curr_id = '' + <?php print $data['id']; ?>;

            if (mw.url.mwParams().action == 'categories') {
                $("#category-page-title").hide()
            } else {
                if (mw.url.windowHashParam('action') == 'new:category') {
                    $("#category-page-title-edit").hide()
                } else {
                    $("#category-page-title-add").hide()
                }
            }
        });
    </script>

    <?php
    if (intval($data['id']) == 0) {
        if (isset($params['selected-category-id']) and intval($params['selected-category-id']) != 0) {
            $data['parent_id'] = intval($params['selected-category-id']);
        } else if (isset($params['recommended_parent'])) {
            $data['rel_id'] = intval($params['recommended_parent']);
        } else if (isset($params['page-id'])) {
            $data['rel_id'] = intval($params['page-id']);
        }
    }
    ?>

    <?php if (!isset($params['no-toolbar'])) : ?>
        <div class="card-header">
            <h5><span class="mdi mdi-folder text-primary mr-3"></span><strong><?php if ($data['id'] == 0) : ?><?php _e('Add category') ?><?php else : ?><?php _e('Edit category') ?><?php endif; ?><?php echo ' '; ?></strong></h5>
            <div>
                <button type="button" onclick="save_cat(this);" class="btn btn-success btn-sm btn-save" form="quickform-edit-content"><?php _e('Save') ?></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="<?php if (!isset($params['no-toolbar'])) : ?>card-body pt-3<?php endif; ?>">
        <div class="text-right">
            <div class="create-root mb-3">
                <div id="content-title-field-buttons">

                    <?php if (intval($data['id']) != 0) : ?>
                        <script>

                            $( document ).ready(function() {
                                $("#category_diff").on("click", function(){
                                    let val = $(this).val();
                                    let parent = $(this).closest('li').attr('data-category-parent-id');
                                    let cat_id = $(this).data('id');
                                    if(val != 1){
                                        mw.tools.confirm("<?php _ejs("Attention: If you turn on this button then this category will be hidden from the shop including the products & sub-categories of this category."); ?>",
                                        function () {

                                            $(this).val(1);

                                            $.ajax({
                                                url: "<?php echo api_url('categories_hide'); ?>",
                                                type: 'POST',
                                                data: {
                                                    "id": cat_id
                                                },
                                                success: function () {
                                                    mw.reload_module_everywhere('categories');
                                                    mw.reload_module_everywhere('content/manager');
                                                }
                                            });
                                        },
                                        function(){
                                            $("#category_diff").prop('checked', false);
                                        });
                                    }else{

                                        $(this).val(0);


                                        // if($(this).val() == '1'){
                                        //     $(this).prop('checked', true);
                                        //     if(parent != "undifined"){
                                        //         $(this).prop('disabled', true);
                                        //     }
                                        // }
                                        if($("#category_diff").val() == '1' && "<?=$data['parent_id']?>" != "0"){
                                            $("#category_diff").prop('disabled', true);
                                        }
                                        $.ajax({
                                                url: "<?php echo api_url('categories_hide'); ?>",
                                                type: 'POST',
                                                data: {
                                                    "id": cat_id
                                                },
                                                success: function () {
                                                    mw.reload_module_everywhere('categories');
                                                    mw.reload_module_everywhere('content/manager');
                                                }
                                            });

                                    }
                                });
                                // if($("#category_diff").val() == '1' && "<?=$data['parent_id']?>" != "0"){
                                //     $("#category_diff").prop('disabled', true);
                                // }
                            }).then(function(){
                                $.post( mw.settings.api_url + 'mw_post_update' );
                            });


                            mw.categoryHideOnOff = function (id)
                            {


                            }
                            mw.quick_cat_edit_create = function(id) {
                                mw.url.windowHashParam('action', 'new:category');
                                return false;

                                if (!!id) {
                                    var modalTitle = '<?php _e('Edit category'); ?>';
                                } else {
                                    var modalTitle = '<?php _e('Add category'); ?>';
                                }

                                mw.dialog({
                                    content: '<div id="mw_admin_edit_category_item_module"></div>',
                                    title: modalTitle,
                                    id: 'mw_admin_edit_category_item_popup_modal'
                                });

                                var params = {}
                                params['data-category-id'] = id;
                                params['no-toolbar'] = true;
                                mw.load_module('categories/edit_category', '#mw_admin_edit_category_item_module', null, params);
                            }
                        </script>

                        <?php if (isset($params['parent-module']) and $params['parent-module']  == 'categories/admin_backend_modal') : ?>

                            <a href="#action=managecats:<?php print $data['id'] ?>" class="btn btn-sm btn-outline-primary"><?php _e("Manage"); ?></a> &nbsp;



                        <?php endif; ?>

                        <a href="#action=addsubcategory:<?php print $data['id'] ?>" class="btn btn-sm btn-outline-primary"><?php _e("Add subcategory"); ?></a> &nbsp;



                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="category-inner-toggle">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                <h6><?php _e('Control this category for shop'); ?>:</h6>
                    <label class="toggleSwitch <?php if(app()->getLocale()=='de') echo 'german-toggle'; ?>" onclick="">
                        <?php $status = DB::table('categories')->where('status' , 0)->pluck('id')->toArray();
                        $category_options = [];
                        if(isset($status) && !empty($status)){
                            $category_options = $status;
                        }?>
                        <input type="checkbox" data-id="<?=$data['id']?>" name="category_diff" <?php if(!empty($category_options)){ if(in_array($data['id'],$category_options)){ print 'checked'; } } ?> id="category_diff" onclick="mw.categoryHideOnOff(<?=$data['id']?>)" value="<?php if(!empty($category_options)){ if(in_array($data['id'],$category_options)){ print 1; } else{ print 0;} }else{ print 0;} ?>" >
                        <span>
                            <span><?php _e('Show'); ?></span>
                            <span><?php _e('Hide'); ?></span>
                        </span>
                        <a></a>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <p><?php _e('Please fill the fields to create or edit a new category'); ?></p>

                <form id="admin_edit_category_form" name="admin_edit_category_form" autocomplete="off" style="<?php if ($just_saved != false) { ?> display: none; <?php } ?>">
                    <input name="id" type="hidden" id="mw_admin_edit_cat_id" value="<?php print($data['id']) ?>" />
                    <input name="rel" type="hidden" value="<?php print($data['rel_type']) ?>" />
                    <input name="rel_id" type="hidden" value="<?php print($data['rel_id']) ?>" id="rel_id" />
                    <input name="data_type" type="hidden" value="<?php print($data['data_type']) ?>" />
                    <input name="parent_id" type="hidden" value="<?php print($data['parent_id']) ?>" id="parent_id" />

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group" id="content-title-field-row">
                                <label class="control-label" for="content-title-field"><?php _e('Category name'); ?></label>
                                <div class="input-group mb-3 prepend-transparent">
                                    <?php if ($data['id'] == 0 and isset($data['parent_id']) and $data['parent_id'] > 0) : ?>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-folder-move text-silver"></i></span>
                                        </div>

                                        <input id="content-title-field" class="form-control" name="title" type="text" placeholder="<?php _e("Subcategory Name"); ?>" />
                                    <?php else : ?>
                                        <?php if (isset($data['parent_id']) and $data['parent_id'] > 0) : ?>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="mdi mdi-folder-move text-silver"></i></span>
                                            </div>
                                        <?php else : ?>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="mdi mdi-folder text-silver"></i></span>
                                            </div>
                                        <?php endif; ?>
                                        <input class="form-control" autofocus id="content-title-field" name="title" type="text" placeholder="<?php _e("Category Name"); ?>" <?php if ($data['id'] == 0) : ?><?php else : ?>value<?php endif ?>="<?php print($data['title']); ?>" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="bootstrap-select form-control">
                                    <label class="control-label"><?php print _e('Choose a parent'); ?></label>
                                    <small class="text-muted d-block mb-2"><?php _e('Choose a parent page or category'); ?></small>

                                    <span class="btn dropdown-toggle btn-light" onclick="$(this).next().stop().slideToggle()" id="category-dropdown-holder"><?php _e("Select Parent page or category"); ?></span>
                                    <?php $is_shop = ''; ?>
                                    <div class="mw-ui mw-ui-category-selector mw-tree mw-tree-selector" style="display: none" id="edit_category_set_par">
                                        <?php /*
                                        <module type="categories/selector" include_inactive="true"
                                        categories_active_ids="<?php print (intval($data['parent_id'])) ?>"
                                        active_ids="<?php print ($data['rel_id']) ?>" <?php print $is_shop ?>
                                        input-name="temp"
                                        input-name-categories='temp' input-type-categories="radio"
                                        categories_removed_ids="<?php print (intval($data['id'])) ?>"
                                        show_edit_categories_admin_link="true"/>
                                        */ ?>

                                        <div class="category-parent-selector"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label" for="show_category"><?php _e("Category Description & Picture"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Choose a section where you want to show description & picture"); ?></small>
                                <select id="show_category" name="show_category" class="form-control selectpicker js-search-by-selector">
                                    <option selected value="0"><?php _e('Select your option'); ?></option>
                                    <option <?php if (isset($data['show_category']) && $data['show_category'] == 1) {
                                                echo "selected";
                                            } ?> value="1"><?php _e("Top section") ?></option>
                                    <option <?php if (isset($data['show_category']) && $data['show_category'] == 2) {
                                                echo "selected";
                                            } ?> value="2"><?php _e("Bottom section") ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label" for="description"><?php _e("Description"); ?></label>
                                <small class="text-muted d-block mb-2"><?php _e("Type description of your category in the field"); ?></small>
                                <textarea class="form-control" id="description" name="description" rows="3" spellcheck="false"><?php print_r($data['description'] ? $data['description'] : ''); ?></textarea>
                            </div>
                        </div>
                        <script>
                            $('#show_category').on('change', function() {
                                document.querySelector('.btn-save').disabled = false;
                            });
                        </script>
                        <script type="text/javascript">
                            mw.require('tree.js')
                            var parent_page = <?php print intval($data['rel_id']);  ?>;
                            var parent_category = <?php print(intval($data['parent_id']));  ?>;
                            var current_category = <?php print isset($data['id']) ? $data['id'] : 'false'; ?>;
                            var skip = [];
                            if (current_category) {
                                skip.push({
                                    id: current_category,
                                    type: 'category'
                                })
                            }
                            var selectedData = [];
                            if (parent_page) {
                                selectedData.push({
                                    id: parent_page,
                                    type: 'page'
                                })
                            }
                            if (parent_category) {
                                selectedData.push({
                                    id: parent_category,
                                    type: 'category'
                                });

                            }
                            $(mwd).ready(function() {

                                mw.$('input,select,textarea').on('input', function() {
                                    document.querySelector('.btn-save').disabled = false;
                                    mw.askusertostay = true;
                                });
                                $.get("<?php print api_url('content/get_admin_js_tree_json'); ?>", function(data) {
                                    var categoryParentSelector = new mw.tree({
                                        id: 'category-parent-selector',
                                        element: '.category-parent-selector',
                                        selectable: true,
                                        data: data,
                                        singleSelect: true,
                                        selectedData: selectedData,
                                        skip: skip
                                    });
                                    if (selectedData.length) {
                                        mw.$('#category-dropdown-holder').html(categoryParentSelector.selectedData[0].title)
                                    }
                                    $(categoryParentSelector).on("selectionChange", function(e, selected) {
                                        document.querySelector('.btn-save').disabled = false;
                                        mw.askusertostay = true;
                                        var parent = selected[0];
                                        if (!parent) {
                                            mw.$('#rel_id').val(0);
                                            mw.$('#parent_id').val(0);
                                            $("#category-dropdown-holder").html(' ');
                                        } else {
                                            $("#category-dropdown-holder").html(parent.title);
                                            if (parent.type === 'category') {
                                                mw.$('#rel_id').val(0);
                                                mw.$('#parent_id').val(parent.id);
                                            }
                                            if (parent.type === 'page') {
                                                mw.$('#rel_id').val(parent.id);
                                                mw.$('#parent_id').val(0);
                                            }
                                        }
                                    })
                                });

                                var _parent = mwd.querySelector('#edit_category_set_par input:checked');

                                if (_parent !== null) {
                                    $("#category-dropdown-holder").html($(_parent).parent().find('span:last').html())
                                }

                                $('#edit_category_set_par input').on('change', function() {
                                    var html = $(this).parent().find('span:last').html();
                                    $("#category-dropdown-holder").html(html)
                                });

                                var advancedBtn = $(".js-category-advanced-seetings-button")
                                advancedBtn.on('click', function() {
                                    $("#category-edit-advanced").stop().slideDown(function() {
                                        advancedBtn.remove()
                                    })
                                })
                                setTimeout(function() {
                                    mw.askusertostay = false;
                                    document.querySelector('button[form="quickform-edit-content"]').disabled = true;
                                }, 999)
                            });




                            var dropdownUploader;

                            mw.$('#mw-admin-post-media-type')
                                .selectpicker()
                                .on('changed.bs.select', function() {
                                    mw._postsImageUploader.displayControllerByType($(this).selectpicker('val'))
                                    setTimeout(function() {
                                        mw.$('#mw-admin-post-media-type').val('0').selectpicker('refresh');
                                    }, 10)

                                })
                                .on('show.bs.select', function() {
                                    if (!!dropdownUploader) return;
                                    var item = mw.$('#mw-admin-post-media-type').parent().find('li:last');
                                    dropdownUploader = mw.upload({
                                        element: item,
                                        accept: 'image/*',
                                        multiple: true
                                    });
                                    $(dropdownUploader).on('FileAdded', function(e, res) {
                                        mw._postsImageUploader._thumbpreload()
                                    })
                                    $(dropdownUploader).on('FileUploaded', function(e, res) {
                                        var url = res.src ? res.src : res;
                                        if (window.after_upld) {

                                            mw._postsImageUploader.hide()
                                        }
                                    });
                                })
                        </script>
                        <input name="position" type="hidden" value="<?php print($data['position']) ?>" />

                        <div class="card-header no-border" id="post-media-card-header">
                            <h6><strong><?php _e('Pictures'); ?></strong></h6>
                            <div class="post-media-type-holder">
                                <select class="selectpicker" data-title="<?php _e('Add media from'); ?>" data-style="btn-sm" data-width="auto" id="mw-admin-post-media-type">
                                    <option value="url"><?php _e('Add image from URL'); ?></option>
                                    <option value="server"><?php _e('Browse uploaded'); ?></option>
                                    <option value="library"><?php _e('Select from Unsplash'); ?></option>
                                    <option value="file"><?php _e('Upload file'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <module type="pictures/admin" title="<?php _e("Category images"); ?>" for="categories" for-id="<?php print $data['id'] ?>" hideHeader="true" uploaderType="small" id="mw-cat-pics-admin" />
                        </div>

                        <div class="col-12">
                            <label class="control-label"><?php _e('Other settings'); ?></label>
                            <small class="text-muted d-block mb-2"><?php _e('Discover more advanced options'); ?></small>

                            <button type="button" class="btn btn-link btn-sm px-0" data-toggle="collapse" data-target="#show-more"><?php _e('Show more'); ?></button>

                            <div class="collapse mt-3" id="show-more">
                                <div class="row">
                                    <?php if (isset($data['id']) and $data['id'] != 0) : ?>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php _e("Link"); ?></label>
                                                <div class="mb-3">
                                                    <small><a href="<?php print category_link($data['id']); ?>" target="_blank"><?php print category_link($data['id']); ?></a></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php _e("Slug"); ?></label>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="url" value="<?php (isset($data['url'])) ? print($data['url']) : '' ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php
                                            if (!isset($data['users_can_create_content'])) {
                                                $data['users_can_create_content'] = 0;
                                            }
                                            ?>
                                            <label class="control-label"><?php _e("Can users create content"); ?> <span class="help-tooltip" data-toggle="tooltip" title="<?php _e("If you set this to YES the website users will be able to add content under this category"); ?>"></span></label>

                                            <div>
                                                <div class="custom-control custom-radio d-inline-block mr-3">
                                                    <input type="radio" id="users_can_create_content_1" name="users_can_create_content" class="custom-control-input" value="1" <?php if ('1' == trim($data['users_can_create_content'])) : ?> checked<?php endif; ?>>
                                                    <label class="custom-control-label" for="users_can_create_content_1"><?php _e("Yes"); ?></label>
                                                </div>
                                                <div class="custom-control custom-radio d-inline-block">
                                                    <input type="radio" id="users_can_create_content_0" name="users_can_create_content" class="custom-control-input" value="0" <?php if ('' == trim($data['users_can_create_content']) or '0' == trim($data['users_can_create_content'])) : ?> checked<?php endif; ?>>
                                                    <label class="custom-control-label" for="users_can_create_content_0"><?php _e("No"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <?php if (isset($data['id'])) : ?>
                                            <?php if (!isset($data['category_subtype'])) {
                                                $data['category_subtype'] = 'default';
                                            } ?>
                                            <input type="hidden" name="category_subtype" value="<?php print $data['category_subtype'] ?>" />
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $('.edit-category-choose-subtype-dd').on('change', function() {
                                                        var val = $(this).val();
                                                        $('[name="category_subtype"]', '#admin_edit_category_form').val(val)
                                                        $('#admin_edit_category_subtype_settings').attr('category_subtype', val);
                                                        mw.reload_module('#admin_edit_category_subtype_settings');
                                                    });
                                                });
                                            </script>

                                            <div class="form-group">
                                                <label class="control-label"><?php _e("Category subtype"); ?> <span class="help-tooltip" data-toggle="tooltip" title="You can set the category behaviour by changing its subtype"></span></label>

                                                <div>
                                                    <select class="selectpicker edit-category-choose-subtype-dd" data-width="100%">
                                                        <option value="default" <?php if ($data['category_subtype'] === 'default') {
                                                                                    print 'selected';
                                                                                } ?>><?php _e("Default"); ?></option>
                                                        <option value="content_filter" <?php if ($data['category_subtype'] === 'default') {
                                                                                            print 'selected';
                                                                                        } ?>><?php _e("Content filter"); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <module type="categories/edit_category_subtype_settings" category_subtype="<?php print $data['category_subtype'] ?>" category-id="<?php print $data['id'] ?>" id="admin_edit_category_subtype_settings" />
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="form-group js-count-letters">
                                            <div class="d-flex justify-content-between">
                                                <label class="control-label"><?php _e("Meta Title"); ?></label>
                                                <span class="text-muted"><span class="js-typed-letters">0</span> of 70 characters used</span>
                                            </div>
                                            <input type="text" class="form-control" name="category_meta_title" value="<?php (isset($data['category_meta_title'])) ? print($data['category_meta_title']) : '' ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group js-count-letters">
                                            <div class="d-flex justify-content-between">
                                                <label class="control-label">Meta descriptions</label>
                                                <span class="text-muted"><span class="js-typed-letters">0</span> of 70 characters used</span>
                                            </div>
                                            <textarea class="form-control" name="category_meta_description"><?php (isset($data['category_meta_description'])) ? print($data['category_meta_description']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php _e("Meta Keywords"); ?></label>
                                            <small class="text-muted d-block mb-2">Separate keywords with a comma and space</small>
                                            <textarea class="form-control" name="category_meta_keywords" placeholder="e.g. Summer, Ice cream, Beach"><?php (isset($data['category_meta_keywords'])) ? print($data['category_meta_keywords']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <?php if (isset($data['id'])) : ?>
                                        <div class="col-md-12">
                                            <module type="content/views/settings_from_template" content-type="category" category-id="<?php print $data['id'] ?>" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-right">
            <?php if (intval($data['id']) != 0) : ?>
                <a href="javascript:mw.content.deleteCategory('<?php print($data['id']) ?>');" class="btn btn-sm btn-outline-danger"><i class="mw-icon-bin"></i>&nbsp; <?php _e('Delete') ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
