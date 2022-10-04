<style>
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

        .cat-toggle.toggleSwitch{
            width: 60px;
            padding-top: 5px;
            margin-left: 5px;
        }

        .cat-toggle.toggleSwitch > span span:first-of-type{
            left: 36%;
            color: #3dc47e !important;
        }

        .cat-toggle.toggleSwitch input:checked ~ a {
            left: 82%;
            border-color: #ff4f52;
            background-color: #ff4f52;
            margin-left: -7px;
        }

        .cat-toggle.toggleSwitch > span:before{
            border: 1px solid #3dc47e !important;
        }

        .cat-toggle.toggleSwitch > span span{
            color: #ff4f52 !important;
        }

        .cat-toggle.toggleSwitch a{
            background-color: #3dc47e;
            border: 1px solid #3dc47e;
            left: 1px;
        }

        .cat-toggle.toggleSwitch input:checked ~ span:before {
            box-shadow: unset;
            border-color: #ff4f52 !important;
        }
    }
    .mw-module-category-manager .card-header-left{
        display:flex;
        align-items: center;
    }

    .mw-module-category-manager .card-header-left h5{
        margin-right:10px !important;
    }

    @media only screen and (max-width: 1250px){
        .mw-module-category-manager .card-header-left{
            margin-bottom:10px;
        }

        .mw-module-category-manager .card-header{
            flex-direction: column;
            align-items: flex-start !important;
        }

        .mw-module-category-manager .js-hide-when-no-items{
            align-self: flex-end;
        }
    }
    .toggleSwitch.german-toggle {
        width: 97px;
    }

    .toggleSwitch.german-toggle > span span:first-of-type {
        left: 26%;
    }

    .toggleSwitch.german-toggle input:checked ~ span span:last-of-type {
        left: 5%;
    }

    .toggleSwitch.german-toggle input:checked ~ a {
        left: 88%;
    }
</style>

<div class="mw-module-category-manager admin-side-content">
    <div class="card style-1 mb-3">

        <div class="card-header">
            <div class="card-header-left">
                <h5>
                    <i class="mdi mdi-folder text-primary mr-3"></i>
                    <strong><?php use Illuminate\Support\Arr; _e("Categories"); ?></strong>
                </h5>
                <?php
                $active = $GLOBALS['custom_active_category'];
                $blog_cat = get_content('layout_file=layouts__blog.php')[0]['id'];
                $shop_cat = $GLOBALS['shop_data'][0]['id'];

                if(url_param('action','false')!='shop_categories') {
                    ?>
                    <div style="display:flex;align-items:center">
                        <p style="margin-bottom:0px;margin-right:10px;"><?php _e('Category show in header '); ?>:</p>
                        <label class="toggleSwitch" onclick="">
                            <input type="checkbox" name="all" id="all_cat" value="<?php (@$blog_cat != @$active ) ? print $blog_cat : print 0;?>" <?php if (@$blog_cat == @$active ){
                                print "checked";
                            } ?>>
                            <span>
                                <span><?php _e('OFF'); ?></span>
                                <span><?php _e('ON'); ?></span>
                            </span>
                            <a></a>
                        </label>
                    </div>
                    <?php

                }else{
                    ?>
                    <div style="display:flex;align-items:center">
                        <p style="margin-bottom:0px;margin-right:10px;"><?php _e('Category show in header :'); ?></p>
                        <label class="toggleSwitch" onclick="">
                            <input type="checkbox" name="shop" id="shop_cat" value="<?php (@$shop_cat != @$active ) ? print $shop_cat : print 0;?>" <?php if (@$shop_cat == @$active ){
                                print "checked";
                            } ?>>
                            <span>
                                <span><?php _e('OFF'); ?></span>
                                <span><?php _e('ON'); ?></span>
                            </span>
                            <a></a>
                        </label>
                    </div>
                    <?php
                }
                ?>
                <script>
                    $('#shop_cat').change(function (){
                        $.post("<?= url('/') ?>/api/v1/set_single_header_cat", { confirm: $('#shop_cat').val() }, (res) => {
                            if($(this).prop( "checked")){
                                mw.notification.success("Shop category set in header");
                                $("#shop_cat").val('null');
                            }else{
                                $("#shop_cat").val("<?php print $shop_cat;?>");
                            }

                        });
                    });
                    $('#all_cat').change(function (){
                        $.post("<?= url('/') ?>/api/v1/set_single_header_cat", { confirm: $('#all_cat').val() }, (res) => {

                            if($(this).prop( "checked")){
                                mw.notification.success("Blog category set in header");
                                $("#all_cat").val('null');
                            }else{
                                $("#all_cat").val("<?php print $blog_cat;?>");
                            }

                        });
                    });
                </script>
            </div>


            <div class="js-hide-when-no-items">
                <div class="d-flex">
                    <?php
                    if (user_can_access('module.categories.edit')):
                        ?>
                        <button type="button" onclick="mw.quick_cat_edit_create(0);" class="btn btn-primary btn-sm mr-2"><i class="mdi mdi-plus"></i> <?php _e("New category"); ?></button>
                    <?php endif; ?>

                    <div class="form-group mb-0">
                        <div class="input-group mb-0 prepend-transparent">
                            <div class="input-group-prepend">
                                <span class="input-group-text px-1"><i class="mdi mdi-magnify"></i></span>
                            </div>

                            <input type="text" class="form-control form-control-sm" aria-label="Search" placeholder="<?php _e('Search') ?>" oninput="categorySearch(this)">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body pt-3">
            <div class="mw-ui-category-selector mw-ui-manage-list m-0" id="mw-ui-category-selector-manage">

                <?php

                $field_name = "categories";
                $selected = 0;
                $mainFilterTree = array();
                $mainFilterTree['ul_class'] = 'mw-ui-category-tree';
                $mainFilterTree['li_class'] = 'sub-nav';
                $mainFilterTree['rel_type'] = 'content';

                if (isset($params['page-id']) and $params['page-id'] != false) {
                    $mainFilterTree['rel_id'] = intval($params['page-id']);
                }

                if (user_can_access('module.categories.edit')) {
                    $mainFilterTree['link'] = "<span class='category_element mw-ui-category-tree-row'  value='{id}' ><span value='{id}' class='mdi mdi-folder text-muted mdi-18px mr-2' style='cursor: move'></span>&nbsp;{title}<span class=\"btn btn-outline-primary btn-sm\"  onclick='mw.quick_cat_edit({id})'><span>Bearbeiten</span> </span>  <span class=\" mr-1 btn btn-outline-danger btn-sm\" onclick='event.stopPropagation();event.preventDefault();mw.quick_cat_delete({id})'>Löschen</span><label class='toggleSwitch german-toggle cat-toggle'><input type='checkbox' onclick='mw.categoryHideOnOff({id});' class='category_hide_on_off category_hide_on_off{id}' name='category_hide_on_off' id='category_hide_on_off' data-id='{id}'><span class='slider round'></span><span><span>Anzeigen</span><span>Ausblenden</span></span><a></a></label></span> ";
                } else {
                    $mainFilterTree['link'] = "<span class='mw-ui-category-tree-row'><span class='mdi mdi-folder text-muted mdi-18px mr-2'></span>&nbsp;{title}</span>";
                }
                ?>

                <?php
                $shop_id = $GLOBALS['shop_data'][0] ?? ['id' => 1];
                $founded_cats = false;
                if(url_param('action','false')=='categories'){
                    $pages_with_cats = DB::table('content')->where('content_type','=','page')->select('id','title')->get()->toArray();
                }else{
                    $pages_with_cats = DB::table('content')->where('content_type','=','page')->where('id',$shop_id['id'])->select('id','title')->get()->toArray();
                }
                if ($pages_with_cats): ?>
                    <?php foreach ($pages_with_cats as $page):
                        $page = (array)$page;
                        $pageTreeFilter = $mainFilterTree;
                        $pageTreeFilter['rel_id'] = $page['id'];
                        if(url_param('action','false')!='shop_categories') {
                            if ($page['id'] == $shop_id['id']) {
                                continue;
                            }
                        }
                        ?>

                        <?php
                        $pageTreeFilter['return_data'] = true;
                        $categoryTree = category_tree($pageTreeFilter);
                        if (empty($categoryTree)) {
                            continue;
                        }
                        $founded_cats = true;
                        ?>
                        <div class="card border-0">
                            <div class="card-header pl-0">
                                <h6><i class="mdi mdi-post-outline text-primary mr-3"></i> <?php echo $page['title']; ?></h6>
                                <?php if (!empty($categoryTree) and isset($pageTreeFilter['rel_id']) and $pageTreeFilter['rel_id'] == 2) { ?>
                                <button class="btn btn-primary" onclick="category_refresh()"><i class="mdi mdi-cog-refresh" aria-hidden="true"></i>Refresh Cache</button>
                                <?php } ?>
                            </div>

                            <div class="card-body py-2 custimized-category-<?=$pageTreeFilter['rel_id']?>">
                                <?php echo $categoryTree; ?>
                            </div>
                        </div>
                        <input type="hidden" name="category_count" id="category_count" value="100">
                        <?php if(url_param('action','false')=='shop_categories') { ?>
                        <script>

                            var currentscrollHeight = 0;
                            var count = 0;

                            $(window).on("scroll", function () {
                                const scrollHeight = $(document).height();
                                const scrollPos = Math.floor($(window).height() + $(window).scrollTop());
                                const isBottom = scrollHeight - 100 < scrollPos;

                                if (isBottom && currentscrollHeight < scrollHeight) {

                                        //callData(count);

                                    currentscrollHeight = scrollHeight;
                                }
                            });

                            function callData(counter) {

                                let cat_c = $("#category_count").val();

                                $.get("<?php print url('api/v1/category_load_on_scroll?limit=') ?>"+cat_c,{ data: <?=json_encode($pageTreeFilter)?>},function(res){
                                    $("#category_count").val(+cat_c + +'50');
                                    $(".custimized-category-<?=$pageTreeFilter['rel_id']?>").html(res.data);
                                }).then(function(){
                                    $(".category_hide_on_off").on("click", function(){
                                        let val = $(this).val();
                                        let parent = $(this).closest('li').attr('data-category-parent-id');
                                        let cat_id = $(this).data('id');
                                        if(val != 1){
                                            mw.tools.confirm("<?php _ejs("Attention: If you turn on this button then this category will be hidden from the shop including the products & sub-categories of this category."); ?>",
                                            function () {

                                                $(".category_hide_on_off"+cat_id).val(1);

                                                $.ajax({
                                                    url: "<?php echo api_url('categories_hide'); ?>",
                                                    type: 'POST',
                                                    data: {
                                                        "id": cat_id
                                                    },
                                                    success: function () {
                                                        $.get("<?= url('api/v1/hidden_cat'); ?>",function(data){
                                                            data = data.data;
                                                            if(data.length > 0){
                                                                $('.category_hide_on_off').each(function() {
                                                                    if (data.includes($(this).data('id'))) {
                                                                        $(this).prop('checked', true);
                                                                        $(this).val(1);
                                                                        let parent = $(this).closest('li').attr('data-category-parent-id');
                                                                        let cat_id = $(this).data('id');
                                                                        if ($(this).val() == '1') {
                                                                            $(this).prop('checked', true);
                                                                            if (parent != "undifined" && $('.category_hide_on_off' + parent).val() == 1) {
                                                                                $(this).prop('disabled', true);
                                                                            }
                                                                        }else{
                                                                            $(this).prop('checked', false);
                                                                        }
                                                                    }
                                                                });
                                                            }else{
                                                                $('.category_hide_on_off').each(function() {
                                                                    $(this).prop('checked', false);
                                                                });
                                                            }
                                                        })
                                                    }
                                                });
                                            },
                                            function(){
                                                console.log('here');
                                                $(".category_hide_on_off"+cat_id).prop('checked', false);
                                            });
                                        }else{
                                            mw.tools.confirm("<?php _ejs("Attention: If you show this category, all products in this category and subcategories in the shop will be visible to your customers."); ?>",
                                            function () {
                                            $(this).val(0);


                                            // if($(this).val() == '1'){
                                                $(this).prop('checked', true);
                                                if(parent != "undifined"){
                                                    $(this).prop('disabled', true);
                                                }
                                            // }
                                            $.ajax({
                                                    url: "<?php echo api_url('categories_hide'); ?>",
                                                    type: 'POST',
                                                    data: {
                                                        "id": cat_id
                                                    },
                                                    success: function () {
                                                        $.get("<?= url('api/v1/hidden_cat'); ?>",function(data){
                                                            data = data.data;
                                                            if(data.length > 0){
                                                                $('.category_hide_on_off').each(function() {
                                                                    if (!data.includes($(this).data('id'))) {
                                                                        $(this).val(0);
                                                                        let parent = $(this).closest('li').attr('data-category-parent-id');
                                                                        let cat_id = $(this).data('id');
                                                                        if ($(this).val() == '1') {
                                                                            $(this).prop('checked', true);
                                                                            if (parent != "undifined" && $('.category_hide_on_off' + parent).val() == 1) {
                                                                                $(this).prop('disabled', true);
                                                                            }
                                                                        }else{
                                                                            $(this).prop('checked', false);
                                                                        }
                                                                    }
                                                                });
                                                            }else{
                                                                $('.category_hide_on_off').each(function() {
                                                                    $(this).prop('checked', false);
                                                                });
                                                            }
                                                        })
                                                    }
                                                });
                                            },
                                            function(){
                                                $(".category_hide_on_off"+cat_id).prop('checked', true);
                                            });

                                        }
                                    });
                                }).then(function(){
                                    $.post( mw.settings.api_url + 'mw_post_update' );
                                });

                            }
                        </script>


                    <?php } endforeach; ?>
                <?php endif; ?>

                <?php if (!$founded_cats): ?>
                    <div class="no-items-found categories py-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="no-items-box" style="background-image: url('<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/no_categories.svg'); ">
                                    <h4><?php _e('You don’t have any categories yet'); ?></h4>
                                    <p><?php _e('Create your first category right now.'); ?></p>
                                    <br/>
                                    <a href="javascript:;" onclick="mw.quick_cat_edit_create(0);" class="btn btn-primary btn-rounded"><?php _e('Create a Category'); ?></a>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $('.js-hide-when-no-items').hide()
                                // $('body > #mw-admin-container > .main').removeClass('show-sidebar-tree');
                            });
                        </script>
                    </div>
                <?php endif; ?>

                <?php
                $mainFilterTree['return_data'] = true;
                $mainFilterTree['content_id'] = false;
                $otherCategories = category_tree($mainFilterTree);
                ?>

                <?php if (!empty($otherCategories)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-header">
                                <h5>Other</h5>
                            </div>
                            <?php echo $otherCategories; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <script>
                function child_category(id){
                    jQuery('#expand-cat-'+id).css('pointer-events','none');
                    $.ajax({
                        url: "<?php echo api_url('child_category_for_parent'); ?>",
                        type: 'POST',
                        data: {
                            "id": id
                        },
                        success: function (res) {
                            jQuery('#expand-cat-'+id).removeClass("fa-plus-square").addClass("fa-minus-square");
                            jQuery('#expand-cat-'+id).attr('onclick','remove_child(' + id + ')')
                            jQuery('#expand-cat-'+id).css('pointer-events','auto');
                            jQuery('.'+id).append(res);
                        }
                    });
                }

                function remove_child(id){
                    jQuery('#expand-cat-'+id).removeClass("fa-minus-square").addClass("fa-plus-square");
                    jQuery('#expand-cat-'+id).attr('onclick','child_category(' + id + ')')
                    jQuery('.category-item-'+id).remove();
                }

                mw.require('block-edit.js');

                $( document ).ready(function() {
                    $(".category_hide_on_off").on("click", function(){
                        let val = $(this).val();
                        let parent = $(this).closest('li').attr('data-category-parent-id');
                        let cat_id = $(this).data('id');
                        if(val != 1){
                            mw.tools.confirm("<?php _ejs("Attention: If you turn on this button then this category will be hidden from the shop including the products & sub-categories of this category."); ?>",
                            function () {

                                $(".category_hide_on_off"+cat_id).val(1);

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
                                $(".category_hide_on_off"+cat_id).prop('checked', false);
                            });
                        }else{
                            mw.tools.confirm("<?php _ejs("Attention: If you show this category, all products in this category and subcategories in the shop will be visible to your customers."); ?>",
                            function () {
                            $(this).val(0);


                            // if($(this).val() == '1'){
                                $(this).prop('checked', true);
                                if(parent != "undifined"){
                                    $(this).prop('disabled', true);
                                }
                            // }
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
                                    console.log('here');
                                    $(".category_hide_on_off"+cat_id).prop('checked', true);
                            });

                        }
                    }).then(function(){
                        $.post( mw.settings.api_url + 'mw_post_update' );
                    });

                });

                mw.categoryHideOnOff = function (id)
                {

                }

                categorySearch = function (el) {
                    var val = el.value.trim().toLowerCase();
                    if (!val) {
                        $(".mw-ui-category-selector a").show()
                    }
                    else {
                        $(".mw-ui-category-selector li").each(function () {
                            var currel = $(this);
                            var curr = currel.attr('title').trim().toLowerCase();
                            if (curr.indexOf(val) !== -1) {
                                currel.show()
                            }
                            else {
                                currel.hide()
                            }
                        })
                    }
                }


                mw.live_edit_load_cats_list = function () {
                    mw.load_module('categories/manage', '#mw_add_cat_live_edit', function () {

                    });
                }

                mw.quick_cat_edit_create = mw.quick_cat_edit_create || function (id) {

                    mw.url.windowHashParam('action', 'editcategory:' + id)

                }


                mw.quick_cat_edit = function (id) {
                    if (!!id) {
                        var modalTitle = '<?php _e('Edit category'); ?>';
                    } else {
                        var modalTitle = '<?php _e('Add category'); ?>';
                    }

                    /*mw_admin_edit_category_item_module_opened = mw.modal({
                     content: '<div id="mw_admin_edit_category_item_module"></div>',
                     title: modalTitle,
                     id: 'mw_admin_edit_category_item_popup_modal'
                     });*/


                    var params = {}
                    params['data-category-id'] = id;
                    params['no-toolbar'] = true;
                    /*mw.load_module('categories/edit_category', '#mw_admin_edit_category_item_module', null, params);*/

                    // mw.categoryEditor.moduleEdit('categories/edit_category', params)


                    // if(typeof mw_select_category_for_editing  == 'undefined'){
                    //
                    //
                    //
                    //     mw.$(".pages_tree_item.active-bg").removeClass('active-bg');
                    //     mw.$(".category_element.active-bg").removeClass('active-bg');
                    //
                    //
                    //     mw.$('#pages_edit_container').removeAttr('parent_id');
                    //     mw.$('#pages_edit_container').removeAttr('data-parent-category-id');
                    //     cat_edit_load_from_modal('categories/edit_category');
                    //
                    //
                    //
                    //
                    // } else {
                    //
                    //
                    //
                    // }


                    mw.url.windowHashParam('action', 'editcategory:' + id)

                }

                mw.quick_cat_delete = function (id,shop=false) {
                    if(shop){
                        mw.tools.confirm("Möchten Sie diese Kategorie wirklich löschen? Wenn du diese Kategorie entfernst dann wird das Produkt den Status unvollständig erhalten.", function () {
                            $.ajax({
                                url: "<?php echo api_url('category/'); ?>" + id,
                                type: 'DELETE',
                                data: {
                                    "id": id
                                },
                                success: function () {
                                    mw.reload_module_everywhere('categories');
                                    mw.reload_module_everywhere('content/manager');
                                }
                            });
                        });
                    }else{
                        mw.tools.confirm("Möchten Sie diese Kategorie wirklich löschen?", function () {
                            $.ajax({
                                url: "<?php echo api_url('category/'); ?>" + id,
                                type: 'DELETE',
                                data: {
                                    "id": id
                                },
                                success: function () {
                                    mw.reload_module_everywhere('categories');
                                    mw.reload_module_everywhere('content/manager');
                                }
                            });
                        });
                    }

                }



                $(document).ready(function () {
                    mw.categoryEditor = new mw.blockEdit({
                        element: '#edit-content-row'
                    })


                    if(typeof mw_select_category_for_editing  == 'undefined'){


                        /* mw.quick_cat_edit = mw_select_category_for_editing_from_modal;
                         mw.quick_cat_delete =   function (id, callback) {
                             mw.tools.confirm('Are you sure you want to delete this?', function () {
                                 $.post(mw.settings.api_url + "category/delete", {id: id}, function (data) {
                                     mw.notification.success('Category deleted');
                                     if (callback) {
                                         callback.call(data, data);
                                     }



                                     mw.reload_module_everywhere('content/manager');
                                     mw.reload_module_everywhere('categories/manage');
                                     mw.reload_module_everywhere('categories/admin_backend');
                                     mw.url.windowDeleteHashParam('action');

                                 });
                             });
                         };
                         mw.on.hashParam("action", function () {


                             if (this == false) {

                                 cat_edit_load_from_modal('categories/admin_backend');
                                 return false;
                             } else {


                             var arr = this.split(":");

                             if (arr[0] === 'editcategory') {
                                 mw_select_category_for_editing_from_modal(arr[1])
                             }if (arr[0] === 'addsubcategory') {
                                 mw_select_add_sub_category(arr[1]);
                             }
                             }


                         });*/
                    }
                })
            </script>


            <script type="text/javascript">
                mw.on.moduleReload("<?php print $params['id'] ?>", function () {
                    mw.manage_cat_sort();
                    $(".mw-ui-category-selector a").append('<span class="category-edit-label">' + mw.msg.edit + ' ' + mw.msg.category + '</span>')
                });

                mw.manage_cat_sort = function () {



                    mw.$("#<?php print $params['id'] ?> .mw-ui-category-tree").sortable({
                        items: '.sub-nav',
                        axis: 'y',
                        handle: '.mw-ui-category-tree-row',
                        update: function () {


                            var obj = {ids: []}
                            $(this).find('.category_element').each(function () {
                                var id = this.attributes['value'].nodeValue;
                                obj.ids.push(id);
                            });
                            $.post("<?php print api_link('category/reorder'); ?>", obj, function () {
                                if (self !== parent && !!parent.mw) {
                                    parent.mw.reload_module('categories');
                                }
                                mw.parent().trigger('pagesTreeRefresh')

                            });
                        },
                        start: function (a, ui) {
                            $(this).height($(this).outerHeight());
                            $(ui.placeholder).height($(ui.item).outerHeight())
                            $(ui.placeholder).width($(ui.item).outerWidth())
                        },
                        scroll: false
                    });
                }
                mw.manage_cat_sort();


                /*function mw_select_category_for_editing_from_modal($p_id) {


                    mw.$(".pages_tree_item.active-bg").removeClass('active-bg');
                    mw.$(".category_element.active-bg").removeClass('active-bg');


                    mw.$('#categories-admin').removeAttr('parent_id');
                    mw.$('#categories-admin').removeAttr('data-parent-category-id');

                     mw.$('#categories-admin').attr('data-category-id', $p_id);



                    mw.$(".mw_edit_page_right").css("overflow", "hidden");
                    cat_edit_load_from_modal('categories/edit_category');
                }


                function mw_select_add_sub_category($p_id) {



                    mw.$('#categories-admin').removeAttr('parent_id');
                    mw.$('#categories-admin').attr('data-category-id', 0);
                    mw.$('#categories-admin').attr('data-parent-category-id', $p_id);
                    mw.$(".mw_edit_page_right").css("overflow", "hidden");
                    cat_edit_load_from_modal('categories/edit_category');
                }



                cat_edit_load_from_modal = function (module, callback) {


                    var action = mw.url.windowHashParam('action');
                    var holder = $('#categories-admin');

                    var time = !action ? 300 : 0;
                    if (!action) {
                        mw.$('.fade-window').removeClass('active');
                    }
                    setTimeout(function () {
                        mw.load_module(module, holder, function () {

                            mw.$('.fade-window').addClass('active')
                            if (callback) callback.call();

                        });
                    }, time)


                }



                    */

                function category_refresh(){
                    mw.notification.success('Categories are refreshing now ...');
                    $.post("<?= url('api/v1/category_reset'); ?>")
                        .then(function(res){
                            mw.notification.success('Categories are refreshed successfully');
                            location.reload();
                        });
                }

            </script>
        </div>
    </div>
    <div id="mw_edit_category_admin_holder"></div>
</div>
