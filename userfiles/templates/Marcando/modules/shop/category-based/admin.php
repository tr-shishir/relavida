<?php
$rand = uniqid();
$settings = getProductModuleSettings($params['id']);
$is_shop = true;
if (isset($params['is_shop'])) {
    $is_shop = $params['is_shop'];
}

$dir_name = normalize_path(modules_path());

$posts_mod = $dir_name . 'content' . DS . 'admin_live_edit_tab1.php';
?>
<?php
$add_post_q = '';

if (isset($params['id'])) {
    $add_post_q .= ' module-id="' . $params['id'] . '" ';

}

if (isset($params['content-id'])) {
    $add_post_q .= ' data-content-id=' . $params['content-id'];
}
if (isset($params['related'])) {
    $add_post_q .= ' related=' . $params['related'];
}
$parent_page = false;
$is_global = false;
if (isset($params['global'])) {
    $add_post_q .= ' global=' . $params['global'];
    $is_global = true;
} else {
    $set_content_type = get_option('data-content-type', $params['id']);

    if ($set_content_type == 'page') {
        $add_post_q .= ' global="true" ';
        $is_global = true;

    }
}
if ($is_global == false) {
    $add_post_q .= ' content_type="product"   ';
}

$posts_parent_page = get_option('data-content-id', $params['id']);
$posts_parent_category = get_option('data-category-id', $params['id']);
if ($posts_parent_page == false) {
    $posts_parent_page_id = intval(get_option('data-page-id', $params['id']));
    if ($posts_parent_page_id != 0) {
        $add_post_q .= ' parent-page-id=' . intval($posts_parent_page_id);
    }

}

if ($posts_parent_page != false and intval($posts_parent_page) > 0) {
    $add_post_q .= ' data-content-id=' . intval($posts_parent_page);
    $parent_page = $posts_parent_page;
} else if (isset($params['content-id'])) {
    $add_post_q .= ' data-content-id=' . $params['content-id'];
    $parent_page = $params['content-id'];

}

if ($posts_parent_category == false) {
    if (isset($params['category'])) {
        $posts_parent_category = $params['category'];


    }

}

if ($posts_parent_category != false) {
    $add_post_q .= ' parent-category-id="' . intval($posts_parent_category) . '" ';
}

if (!isset($params['global']) and $posts_parent_page != false and $posts_parent_category != false and intval($posts_parent_category) > 0) {

    $str0 = 'table=categories&limit=1000&data_type=category&what=categories&' . 'parent_id=0&rel_id=' . $posts_parent_page;
    //$page_categories = db_get($str0);
    $sub_cats = array();
    // $page_categories = db_get($str0);
    $page_categories = false;
    if (is_array($page_categories)) {
        foreach ($page_categories as $item_cat) {
            $sub_cats[] = $item_cat['id'];
            $more = get_category_children($item_cat['id']);
            if ($more != false and is_array($more)) {
                foreach ($more as $item_more_subcat) {
                    $sub_cats[] = $item_more_subcat;
                }
            }

        }
    }

    if (is_array($sub_cats) and in_array($posts_parent_category, $sub_cats)) {
        $add_post_q .= ' selected-category-id=' . intval($posts_parent_category);
    }

}

if (isset($params['is_shop']) and $params['is_shop'] == 'y') {
    $add_post_q .= ' content_type="product"   ';
} else {
    $add_post_q .= '  ';
}
?>
<style>
     .preloader {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            cursor: default;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            height: 100%;
            width: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            position: absolute;
            background-color: white;
            left: 0;
            top: 0;
            overflow: hidden !important;
            z-index: 999999999;
        }
        .loader {
            border: 8px solid #f3f3f3; / Light grey /
            border-top: 8px solid #3498db; / Blue /
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
</style>
<script type="text/javascript">
    resizeModal = function (w, h) {
        if (window.thismodal && thismodal.resize) {
            thismodal.resize(w, h);
            thismodal.center();
        }
    };


    mw.manage_live_edit_content = function ($id) {
        sessionStorage.setItem("managetabsesstion", 1);

        $('a[href="#last-1"]').trigger('click');

        if ($id != undefined) {
            $('#mw_posts_manage_live_edit').attr('module-id', $id);
        }
        $('#mw_posts_manage_live_edit').removeAttr('just-saved');
        // mw.load_module('content/manage_live_edit', '#mw_posts_manage_live_edit', function () {
        //     resizeModal();
        // })

    }


    $(mwd).ready(function () {
        thismodal.width('800px');
        resizeModal()
    });
</script>


<div class="post-settings-holder">
    <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
    <?php
        if(strpos($params['id'], 'shop-category-based') !== false){
?>
        <a class="btn btn-outline-secondary justify-content-center active product__management" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
        <a class="btn btn-outline-secondary justify-content-center product__management manage__tab" onclick="mw.manage_live_edit_content('<?php print $params['id'] ?>');" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> <?php _e("Manage"); ?></a>

        <script>

            $('document').ready(function(){
                var managetabsesstion = sessionStorage.getItem("managetabsesstion");
                if(managetabsesstion == 1){
                    $(".product__management").removeClass("active show");
                    $(".manage__tab").addClass("active show");

                    $("#list").addClass("active show");
                    $("#list1").addClass("active show");
                    $("#settings").removeClass("active show");
                }
                var params = {
                    "class":"module module-content-manager module module-content-manage-live-edit ",
                    "module-id":"<?=$params['id']?>" ,
                    "module_id":"<?=$params['id']?>" ,
                    "content_type":"product" ,
                    "no_page_edit":"true" ,
                    "id":"mw_posts_manage_live_edit",
                    "no_toolbar":"true" ,
                    "data-type":"content/manage_live_edit",
                    "parent-module-id":"<?=$params['id']?>",
                    "parent-module":"shop/products/admin",
                };
                // params.content_type = 'product';
                // params.no_page_edit = 'true';
                // params.id = 'mw_posts_manage_live_edit';
                // params.module_id = '<?=$params['id']?>';
                // params.no_toolbar = 'true';
                // console.log(params);
                mw.load_module('content/manager_content_v2', '#products_module', function () {
                    resizeModal();
                }, params).then(function(){
                    $('.module-content-manager').each(function() {
                        $(this).addClass('active show');
                        mw.reload_module_everywhere('shop/products');
                        // mw.reload_module('#pages_edit_container_content_list');

                    });
                });
            });
        </script>
<?php
        }
    ?>
        <a class="btn btn-outline-secondary justify-content-center" style="display: none;" data-toggle="tab" href="#last-1"></a>
        <a class="btn btn-outline-secondary justify-content-center" style="display: none;" data-toggle="tab" href="#last-2"></a>
    </nav>
    <?php
        if(strpos($params['id'], 'shop-category-based') !== false){
?>
<div class="tab-content py-3">
        <div class="tab-pane fade" id="list">
            
            <div class="setting-row d-flex align-items-center justify-content-between">
                <div></div>
                <div>
                    <label class="d-inline-block">
                        <?php $ord_by = $settings['position']->value ?? 'position desc'; ?>
                        <?php _e("Order by"); ?>
                    </label>

                    <select id="data-order-by" name="data-order-by" class="mw_option_field_dt selectpicker" data-width="auto" data-also-reload="<?php print  $config['the_module'] ?>">
                        <option value="position desc" <?php if ('position desc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Position"); ?>(Oldest)</option>
                        <option value="position asc" <?php if ('position asc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Position"); ?>(Newest)</option>
                        <option value="created_at desc" <?php if ('created_at desc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Date"); ?>(Oldest)</option>
                        <option value="created_at asc" <?php if ('created_at asc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Date"); ?>(Newest)</option>
                        <option value="title asc" <?php if ('title asc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Title"); ?>(A to Z)</option>
                        <option value="title desc" <?php if ('title desc' == $ord_by): ?>   selected="selected"  <?php endif; ?>><?php _e("Title"); ?>(Z to A)</option>
                    </select>
                </div>
            </div>
            <div id="products_module">
                <div class="preloader">
                    <div class="loader"></div>
                </div>
            </div>
            <!-- <module type="content/manager" <?php print $add_post_q ?> no_page_edit="true" id="mw_posts_manage_live_edit" no_toolbar="true" limit='1'/> -->

        </div>

        <div class="tab-pane fade  show active" id="settings">
        <?php
            must_have_access();

            $set_content_type = 'product';
            if (isset($params['global']) and $params['global'] != false) {
                $set_content_type = get_option('data-content-type', $params['id']);
            }

            ?>

                <script type="text/javascript">
                    $(document).ready(function () {
                        mw.lib.require('bootstrap3ns');
                        mw.lib.require('bootstrap_tags');
                    });

                    function mw_reload_content_mod_window(curr_mod) {
                        setTimeout(function () {
                            mw.reload_module_parent('#<?php print $params['id'] ?>');
                            window.location.href = mw.url.removeHash(window.location.href);
                        }, 1000)

                        $(mwd.body).ajaxStop(function () {
                            setTimeout(function () {
                                window.location.href = mw.url.removeHash(window.location.href);
                            }, 1000)
                        });
                    }
                </script>

            <?php $posts_parent_page = get_option('data-page-id', $params['id']); ?>

            <?php if (isset($params['global']) and $params['global'] != false) : ?>
                    <?php $is_shop = 1; ?>
                <label class="mw-ui-label"><?php _e("Content type"); ?></label>
                <select name="data-content-type" id="the_post_data-content-type<?php print  $rand ?>" class="mw-ui-field w100 mw_option_field" onchange="mw_reload_content_mod_window(1)">
                    <option value="" <?php if (('' == trim($set_content_type))): ?>  selected="selected"  <?php endif; ?>><?php _e("Choose content type"); ?></option>
                    <option value="product" <?php if (('product' == trim($set_content_type))): ?>   selected="selected"  <?php endif; ?>><?php _e("Product"); ?></option>
                </select>
            <?php endif; ?>

            <?php if (!isset($set_content_type) or $set_content_type != 'none') :
                    $posts_parent_page = $GLOBALS['shop_data'][0]['id'];
                    if ($posts_parent_page != false and intval($posts_parent_page) > 0):
                    $posts_parent_category = $settings['categories']->value ?? null;
                    $categories = DB::table('categories')->where('is_hidden',0)->where('status',1)->where('rel_id',$posts_parent_page)->get();
                    ?>

                    <div class="form-group">
                        <label class="control-label d-block"><?php _e("Show only from category"); ?></label>
                        <select name="data-category-id" id="the_post_data-page-id<?php print  $rand ?>" class="mw_option_field_dt selectpicker" data-width="100%" data-size="5" data-live-search="true" data-also-reload="<?php print  $config['the_module'] ?>">
                            <option value='' <?php if ((0 == intval($posts_parent_category))): ?>   selected="selected"  <?php endif; ?>><?php _e("Select a category"); ?></option>
                            <?php
                                $pt_opts = array();
                                $pt_opts['link'] = " {title}";
                                $pt_opts['list_tag'] = " ";
                                $pt_opts['list_item_tag'] = "option";
                                $pt_opts['active_ids'] = $posts_parent_category;
                                $pt_opts['active_code_tag'] = '   selected="selected"  ';
                                $pt_opts['rel_type'] = 'content';
                                $pt_opts['rel_id'] = $posts_parent_page;
                            ?>
                            <option value='0' <?php if ((0 == intval($posts_parent_category))): ?>   selected="selected"  <?php endif; ?>>-- <?php _e("All"); ?></option>
                            <?php
                                foreach($categories as $category){
                                    ?>
                                    <option value='<?=$category->id?>' <?php if (($category->id == trim($posts_parent_category))): ?>   selected="selected"  <?php endif; ?>> <?= $category->title ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="bootstrap3ns">
                    <?php
                        session()->put("content", $is_shop);
                        $all_existing_tags = json_encode(content_tags());
                        if ($all_existing_tags == null) {
                            $all_existing_tags = '[]';
                        }
                    ?>


                    <div>
                        <?php
                            $listOfoptions = [
                                "data-title-limit",
                                "data-character-limit",
                                "data-add-to-cart-text",
                                "filter-only-in-stock",
                                "content_limit_for_live_edit_module",
                                "data-read-more-text",
                                "data-hide-paging",
                                "data-limit",
                            ];
                            if(isset($_GET['col_count']) && $_GET['col_count'] >= 3){
                                $showProduct = ($_GET['col_count']*2);
                            }
                            $getDefaultOptions = DB::table('options')->select('option_value','option_key','option_group')->where('option_group', $params['id'])->whereIn('option_key',$listOfoptions)->get()->keyBy('option_key')->toArray();
                            foreach($listOfoptions as $option) {
                                if(!in_array($option, array_keys($getDefaultOptions))){
                                    if($option == 'data-limit'){
                                        $getDefaultOptions[$option] = (object)['option_value' => $showProduct??3];
                                    }else{
                                        $getDefaultOptions[$option] = (object)['option_value' => ""];
                                    }
                                }
                                if($option == 'data-limit'){
                                    if($getDefaultOptions[$option]->option_value == ""){
                                        $getDefaultOptions[$option] = (object)['option_value' => $showProduct??3];
                                    }
                                }
                            }

                        ?>

                    </div>
                </div>

                <?php

                
                    $show_fields = get_option('data-show', $params['id']);
                    if (is_string($show_fields)) {
                        $show_fields = explode(',', $show_fields);
                        $show_fields = array_trim($show_fields);
                    }
                    if ($show_fields == false or !is_array($show_fields)) {
                        $show_fields = array("thumbnail","title","description","price","add_to_cart","content_limit_for_live_edit_module","read_more","created_at");
                    }
                ?>

                <style type="text/css">
                    .setting-row {
                        padding: 10px;
                    }

                    .setting-row .custom-control,
                    .setting-row label {
                        margin: 0;
                    }

                    .setting-row:hover {
                        background-color: #f5f5f5;
                    }
                </style>

                <label class="control-label"><?php _e("Display on") . ' '; ?> <?php print ($set_content_type) ?>:</label>

                <div class="">
                    <div id="post_fields_sort_<?php print  $rand ?>" class="fields-controlls">

                        <div class="setting-row d-flex align-items-center justify-content-between">
                            <div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input mw_option_field_dt" name="data-show" value="title" id="title" checked disabled>
                                    <label class="custom-control-label" for="title"><?php _e("Title"); ?></label>
                                </div>
                            </div>

                            <div>
                                <label class="d-inline-block"><?php _e("Length"); ?></label>
                                <input type="text" class="form-control d-inline-block w-auto mw_option_field_dt" id="data-title-limit" name="data-title-limit" value="<?php print $settings['data-title-limit']->value ?? 255 ?>" placeholder="255"/>
                            </div>
                        </div>

                        <div class="setting-row d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input mw_option_field_dt" name="data-show" value="content_limit_for_live_edit_module" checked disabled>
                                        <label class="custom-control-label" for="content_limit_for_live_edit_module"><?php _e("Content's limit for manage settings"); ?></label>
                                    </div>
                                </div>

                                <div>
                                    <label class="d-inline-block"><?php _e("Limit"); ?></label>
                                    <input type="text" class="form-control d-inline-block w-auto mw_option_field_dt" id="content_limit_for_live_edit_module" name="content_limit_for_live_edit_module" value="<?php print $settings['content_limit_for_live_edit_module']->value ?? 50 ?>" placeholder="50"/>
                                </div>
                            </div>

                        <div class="setting-row d-flex align-items-center justify-content-between">
                            <div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input mw_option_field_dt" name="data-hide-paging" id="data-hide-paging" <?php if (isset($settings['data-hide-paging']->value) && $settings['data-hide-paging']->value == 'y'): ?> value="n" checked<?php else: ?>value="y"<?php endif; ?>>
                                    <label class="custom-control-label" for="data-hide-paging"><?php _e("Hide paging"); ?></label>
                                </div>
                            </div>

                            <div>
                                <label class="d-inline-block"><?php _e("Products per page"); ?></label>
                                <input name="data-limit" id="pagination_post" class="<?php if(!isset($_GET['col_count'])){ print "mw_option_field_dt";} ?> form-control d-inline-block w-auto" type="number" style="width:55px;" placeholder="<?=$showProduct??6?>" value="<?php print $settings['data-limit']->value ?? 6 ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <script>
                var type_timer;
                var finished_writing_interval = 1000;
                var my_input = $("#pagination_post");

                //Start timeout when user start typing
                my_input.on('keyup', function () {
                clearTimeout(type_timer);
                    type_timer = setTimeout(finished_typing, finished_writing_interval);
                });

                //Clear timeout on key down event
                my_input.on('keydown', function () {
                    clearTimeout(type_timer);
                });

                //This function runs when user has finished writing in input
                function finished_typing () {
                    if(my_input.val()%(<?=$_GET['col_count']??3?>) == 0){
                        var o_data = {
                            key: "data-limit",
                            module_id: "<?=$params['id']?>",
                            value: my_input.val()
                        }
                        $.ajax({
                            type: "POST",
                            url: mw.settings.site_url + "api/v1/module_setting_save",
                            data: o_data,
                        }).then(function(){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        });
                    }else{
                        mw.notification.error('Value must be Divisors of <?=$_GET['col_count']??3?>');
                        my_input.val("<?=($_GET['col_count']??3)*2?>")
                    }
                    
                }

                setTimeout($("#content_limit_for_live_edit_module").on("keyup",function (){
                    var n_data = {
                            key: "content_limit_for_live_edit_module",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);

                setTimeout($("#data-title-limit").on("keyup",function (){
                    var n_data = {
                            key: "data-title-limit",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);

                setTimeout($("#the_post_data-page-id<?php print  $rand ?>").on("change",function (){
                    var n_data = {
                            key: "categories",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);

                setTimeout($("#tags").on("change",function (){
                    var n_data = {
                            key: "tags",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);

                setTimeout($("#data-hide-paging").on("change",function (){
                    var n_data = {
                            key: "data-hide-paging",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>")
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);

                setTimeout($("#data-order-by").on("change",function (){
                    console.log($(this).val());
                    var n_data = {
                            key: "position",
                            module_id: "<?=$params['id']?>",
                            value: $(this).val()
                        }
                    $.post('<?=url("/")?>/api/v1/module_setting_save', n_data , (res) => {

                        if(res.success){
                            mw.notification.success('Settings are saved.');
                            mw.reload_module_parent("#<?=$params['id']?>");
                            mw.reload_module_everywhere('content/manager_content_v2');

                        }

                    });
                }),1000);
            </script>

        </div>

        <div class="tab-pane fade" id="templates">
            <?php if (isset($params['global'])) : ?>
                <module type="admin/modules/templates" id="posts_list_templ" for-module="posts"/>
            <?php else: ?>
                <module type="admin/modules/templates" id="posts_list_templ"/>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="last-1">
            <div <?php print $add_post_q ?> id="mw_posts_create_live_edit"></div>
        </div>
        <div class="tab-pane fade" id="last-2">
            <div id="mw_posts_edit_live_edit" class="mw_posts_edit_live_edit"></div>
        </div>
    </div>
<?php
        }
    ?>

</div>
