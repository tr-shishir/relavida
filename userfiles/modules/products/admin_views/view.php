<?php

    if (!user_can_access('module.content.index')) {
        return;
    }
    Illuminate\Pagination\Paginator::useBootstrap();
    $action = url_param('action');
    $rand = uniqid(); 
    $pages_container_params_str = " is_shop='y' ";
    $tree_url_endpoint = api_url('content/get_admin_js_tree_json?is_shop=1');
    $my_tree_id = crc32(mw()->url_manager->string());
    $value_type = false;
    $value = false;
    $query = DB::table('product');
    if(isset($_GET['keyword'])){
        $value_type = 'keyword';
        $value = $_GET['keyword'];
    }

    if(isset($_GET['ean'])){
        $value_type = 'ean';
        $value = $_GET['ean'];
    }

    if(isset($_GET['brand'])){
        $value_type = 'brand';
        $value = $_GET['brand'];
    }

    if(isset($_GET['sku'])){
        $value_type = 'sku';
        $value = $_GET['sku'];
    }

    if(isset($_GET['category'])){
        $value_type = 'category';
        $value = $_GET['category'];
        $product_ids = DB::table('categories_items')->where('parent_id', $value)->where('rel_type', 'product')->select('rel_id')->get()->pluck('rel_id')->toArray();
        $query->whereIn('id', $product_ids);
    }

    if(isset($_GET['tag'])){
        $value_type = 'tag';
        $value = $_GET['tag'];
        $product_ids = DB::table('tagging_tagged')->where('tag_name', $value)->where('taggable_type', 'product')->select('taggable_id')->get()->pluck('taggable_id')->toArray();
        $query->whereIn('id', $product_ids);
    }

    if($value_type === 'keyword' and $value != false){
        $query->where('title', "LIKE", "%{$value}%")->orWhere('description', "LIKE", "%{$value}%")->orWhere('content_body', "LIKE", "%{$value}%");
    } else if($value_type != false and $value_type != 'category' and $value != false){
        $query->where($value_type, "LIKE", "%{$value}%");
    }
    $param = '';
    if($value_type){
        $param = ",`{$value_type}`,`{$value}`";
    }
    $products = $query->orderBy('position', 'desc')->paginate(10);
    $data = json_encode($products->items());
    $data = json_decode($data, true); 
?>
<link rel="stylesheet" href="<?=modules_url().'products/style.css'; ?>">

<script>
    function product_search(type, data){
        var current_url = "<?=admin_url();?>" + "view:products/action:view";
        var url = current_url+"?"+type+"="+data;

        $('#product-list').html('<div class="loader"></div>');
        $('.manage-posts-holder-inner').addClass('loader-dependency-class');
        $.ajax({
                type: "POST",
                url: "<?=api_url('filter_product_for_admin')?>",
                data: {
                    value_type: type,
                    value: data
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                    $('#product-list').html(response['html']);
                    $('.product-pagination').html(response['pagination']);
                    if(type != 'category'){
                        window.history.pushState(null, null, url);
                        window.history.replaceState(null, null, url);
                    }
                },
                error: function(response) {
                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                    mw.notification.error("Something went Wrong!");
                    $.post("<?=api_url('no_product_for_admin')?>", { data: false } ,function(res){
                            $('#product-list').html(res);
                    });
                    if(type != 'category'){
                        window.history.pushState(null, null, url);
                        window.history.replaceState(null, null, url);
                    }
                }
            });
    }

    mw.on.hashParam("action", function() {
        var action = mw.url.getHashParams(window.location.hash)['action'];
        var arr = action.split(":");
        if(arr[0] == 'showpostscat'){
            product_search('category', arr[1]);
        }
        
    });
    
    function paginate_data(page, para = false, para1 = false){
        var current_url = "<?=admin_url();?>" + "view:products/action:view";
        var url = current_url+"?"+"page"+"="+page;

        $('#product-list').html('<div class="loader"></div>');
        $('.manage-posts-holder-inner').addClass('loader-dependency-class');
        var data;
        if(para){
            data = {
                value_type: para,
                value: para1,
                page : page
            };
            var url = url+"&"+para+"="+para1;
        }else{
            data = {
                page : page
            };
        }
        console.log(data);
        $.ajax({
                type: "POST",
                url: "<?=api_url('filter_product_for_admin')?>",
                data: data,
                success: function(response) {
                    response = JSON.parse(response);
                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                    $('#product-list').html(response['html']);
                    $('.product-pagination').html(response['pagination']);
                    window.history.pushState(null, null, url);
                    window.history.replaceState(null, null, url);
                },
                error: function(response) {
                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                    mw.notification.error("Something went Wrong!");
                    $.post("<?=api_url('no_product_for_admin')?>", { data: false } ,function(res){
                            $('#product-list').html(res);
                    });
                    window.history.pushState(null, null, url);
                    window.history.replaceState(null, null, url);
                }
            });
    }


</script>

<div id="edit-content-row">

    <script>
        $(document).ready(function() {
            $('body > #mw-admin-container > .main').addClass('show-sidebar-tree');
            $(".js-tree").prependTo("body > #mw-admin-container .main.container");
            $(".js-tree").before($("body .main.container aside"));
        });
    </script>

    <div class="js-tree tree">
        <div class="tree-column-holder">
            <div class="fixed-side-column">
                <script>
                    $(document).ready(function() {
                        $('.js-open-close-all-tree-elements').on('change', function() {
                            if ($(this).is(':checked') == '1') {
                                pagesTree.openAll();
                            } else {
                                pagesTree.closeAll();
                            }
                        });
                    });
                </script>
                <div class="fixed-side-column-container mw-tree" id="pages_tree_container_<?php print $my_tree_id; ?>">
                <script>
                    var pagesTree;

                    var pagesTreeRefresh = function () {

                        var request = new XMLHttpRequest();
                        request.open('GET', '<?php print $tree_url_endpoint; ?>', true);
                        request.send();
                        request.onload = function() {
                            if (request.status >= 200 && request.status < 400) {

                                var data = JSON.parse(request.responseText);

                                var treeTail = [
                                    {
                                        title: '<?php _lang("Trash") ?>',
                                        icon: 'mdi mdi-delete',
                                        action: function () {
                                            mw.url.windowHashParam('action', 'trash');
                                        }
                                    }
                                ];

                                pagesTree = new mw.tree({
                                    data: data,
                                    element: $("#pages_tree_container_<?php print $my_tree_id; ?>")[0],
                                    sortable: false,
                                    selectable: false,
                                    id: 'admin-main-tree',
                                    append: treeTail,
                                    contextMenu: [
                                        {
                                            title: 'Edit',
                                            icon: 'mdi mdi-pencil',
                                            action: function (element, data, menuitem) {
                                                mw.url.windowHashParam("action", "edit" + data.type + ":" + data.id);
                                            }
                                        },
                                        {
                                            title: 'Move to trash',
                                            icon: 'fas fa-trash',
                                            action: function (element, data, menuitem) {
                                                if (data.type === 'category') {
                                                    mw.content.deleteCategory(data.id, function () {

                                                        $('#' + pagesTree.options.id + '-' + data.type + '-' + data.id).fadeOut(function () {
                                                            if (window.pagesTreeRefresh) {
                                                                pagesTreeRefresh()
                                                            }
                                                            ;
                                                        })
                                                    });
                                                }
                                                else {
                                                    mw.content.deleteContent(data.id, function () {
                                                        $('#' + pagesTree.options.id + '-' + data.type + '-' + data.id, pagesTree.list).fadeOut(function () {
                                                            if (window.pagesTreeRefresh) {
                                                                pagesTreeRefresh()
                                                            }
                                                            ;
                                                        })
                                                    });
                                                }
                                            }
                                        }
                                    ]
                                });
                                mw.adminPagesTree = pagesTree;

                                $(pagesTree).on("orderChange", function (e, item, data, old, local) {
                                    var obj = {ids: local};
                                    var url;
                                    if (item.type === 'category') {
                                        url = "<?php print api_link('category/reorder'); ?>";
                                    }
                                    else {
                                        url = "<?php print api_link('content/reorder'); ?>";
                                    }
                                    $.post(url, obj, function () {
                                        mw.reload_module('#mw_page_layout_preview');
                                        mw.notification.success('<?php _ejs("Changes are saved"); ?>')
                                    });
                                });
                                $(pagesTree).on("ready", function () {
                                    $('#main-tree-search').on('input', function () {
                                        var val = this.value.toLowerCase().trim();
                                        if (!val) {
                                            pagesTree.showAll();
                                        }
                                        else {
                                            pagesTree.options.data.forEach(function (item) {
                                                if (item.title.toLowerCase().indexOf(val) === -1) {
                                                    pagesTree.hide(item);
                                                }
                                                else {
                                                    pagesTree.show(item);
                                                }
                                            });
                                        }
                                    })

                                    $('.mw-tree-item-title', pagesTree.list).on('click', function () {
                                        $('li.selected', pagesTree.list).each(function () {
                                            pagesTree.unselect(this)
                                        });
                                        var li = mw.tools.firstParentWithTag(this, 'li'),
                                            data = li._data,
                                            action;
                                        if (!$(li).hasClass('mw-tree-additional-item')) {
                                            if (data.type === 'page') {
                                                action = 'editpage';
                                            }
                                            if (data.subtype === 'dynamic' || data.subtype == 'shop') {
                                                action = 'showposts';
                                            }
                                            if (data.type === 'category') {
                                                action = 'showpostscat';
                                            }
                                            mw.url.windowHashParam("action", action + ":" + data.id);
                                        }


                                    });
                                    mainTreeSetActiveItems()

                                    $("#edit-content-row .tree-column").resizable({
                                        handles: "e",
                                        resize: function (e, ui) {
                                            var root = mw.$(ui.element);
                                            mw.$('.fixed-side-column', root).width(root.width())
                                        },
                                        minWidth: 200
                                    })
                                })
                            }
                        };




                    };

                    if (window.pagesTreeRefresh) {
                        pagesTreeRefresh()
                    }


                </script>
                <?php 
                    $custom_title_ui = mw()->module_manager->ui('content.manager.tree.after');
                    if (!empty($custom_title_ui)) :
                        foreach ($custom_title_ui as $item) :
                            $title = (isset($item['title'])) ? ($item['title']) : false;
                            $class = (isset($item['class'])) ? ($item['class']) : false;
                            $html = (isset($item['html'])) ? ($item['html']) : false;
                            $width = (isset($item['width'])) ? ($item['width']) : false; ?>
                            <div class="tree-column-holder-custom-item <?php print $class; ?>" <?php if ($width) : ?>
                                style="width: <?php print $width ?>;" <?php endif; ?> title="<?php print $title; ?>">
                                <?php print $html; ?>
                            </div>
                        <?php endforeach;
                    endif; 
                ?>
                </div>
            </div>
        </div>
    </div>


    <div id="edit-content-row">

        <script>
            $(document).ready(function() {
                $('body > #mw-admin-container > .main').addClass('show-sidebar-tree');
                $(".js-tree").prependTo("body > #mw-admin-container .main.container");
                $(".js-tree").before($("body .main.container aside"));
            });
        </script>

        <div class="module module module-content-manager " id="pages_edit_container" is_shop="y"
            contenteditable="false" paging_param="pg" pg="1" data-page-number="1">
            
            <style>
                .loader-dependency-class{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 350px;

                }
                .loader {
                    border: 8px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 8px solid #074A74;
                    border-bottom: 8px solid #074A74;
                    width: 50px;
                    height: 50px;
                    -webkit-animation: spin 2s linear infinite;
                    animation: spin 2s linear infinite;
                    margin: auto;
                }

                @-webkit-keyframes spin {
                    0% {
                        -webkit-transform: rotate(0deg);
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                    }
                }

                @keyframes spin {
                    0% {
                        transform: rotate(0deg);
                    }

                    100% {
                        transform: rotate(360deg);
                    }
                }
                .product-paging a{
                    text-decoration: none;
                }
                
                .product-paging a.active{
                    background-color: #074A74;
                    color: #fff;
                }

                .product-paging a.active:hover{
                    background-color: #074A74;
                    color: #fff;
                }
            </style>
            <script type="text/javascript">
                mw.require('forms.js', true);
                mw.require('content.js', true);

                delete_selected_posts = function() {
                    mw.tools.confirm("Are you sure you want to delete the selected products?", function() {
                        var master = mwd.getElementById('pages_edit_container');
                        var arr = mw.check.collectChecked(master);
                        $.post("<?=api_url('delete_products_info_V2'); ?>", {
                            id: arr
                        }).then((res, err) => {
                            console.log(res, err);
                        });
                        mw.post.delV2(arr, function() {
                            location.reload();
                        });
                    });
                }

                assign_selected_posts_to_category_exec = function() {
                    mw.tools.confirm("Are you sure you want to move the selected posts?", function() {
                        var dialog = mw.dialog.get('#pick-categories');
                        var tree = mw.tree.get('#pick-categories');
                        var selected = tree.getSelected();
                        var posts = mw.check.collectChecked(mwd.getElementById('pages_edit_container'));
                        var data = {
                            content_ids: posts,
                            categories: []
                        };
                        selected.forEach(function(item) {
                            if (item.type === 'category') {
                                data.categories.push(item.id);
                            } else if (item.type === 'page') {
                                data.parent_id = item.id;
                            }
                        });
                        // console.log(data);
                        $.post("<?= api_link('product/bulk_assign'); ?>", data, function(
                            msg) {
                            mw.notification.msg(msg);
                            // location.reload();
                        });
                    });
                };

                assign_selected_posts_to_category = function() {
                    $.get("<?= api_link('content/get_admin_js_tree_json?is_shop=1'); ?>", function(data) {
                        var btn = document.createElement('button');
                        btn.disabled = true;
                        btn.className = 'mw-ui-btn';
                        btn.innerHTML = mw.lang('Move posts');
                        btn.onclick = function(ev) {
                            assign_selected_posts_to_category_exec();
                        };
                        var dialog = mw.dialog({
                            height: 'auto',
                            autoHeight: true,
                            id: 'pick-categories',
                            footer: btn,
                            title: mw.lang('Select categories')
                        });
                        var tree = new mw.tree({
                            data: data,
                            element: dialog.dialogContainer,
                            sortable: false,
                            selectable: true,
                            multiPageSelect: false
                        });
                        $(tree).on("selectionChange", function() {
                            btn.disabled = tree.getSelected().length === 0;
                        });
                        $(tree).on("ready", function() {
                            dialog.center();
                        })
                    });
                };

                mw.delete_single_post = function(id) {
                    mw.tools.confirm("Do you want to delete this product?", function() {
                        var arr = id;
                        $.post("<?=api_url('delete_product_info_V2'); ?>", {
                            id: id
                        }).then((res, err) => {
                            console.log(res, err);
                        });
                        // return;
                        mw.post.delV2(arr, function() {
                            mw.$(".manage-post-item-" + id).fadeOut(function() {
                                $(this).remove()
                            });
                        });
                    });
                }

                mw.manage_content_sort = function() {
                    if (!mw.$("#mw_admin_posts_sortable").hasClass("ui-sortable")) {
                        mw.$("#mw_admin_posts_sortable").sortable({
                            items: '.manage-post-item',
                            axis: 'y',
                            handle: '.mw_admin_posts_sortable_handle',
                            update: function() {
                                var obj = {
                                    ids: []
                                }
                                $(this).find('.select_posts_for_action').each(function() {
                                    var id = this.attributes['value'].nodeValue;
                                    obj.ids.push(id);
                                });
                                $.post("<?= api_link('product/reorder'); ?>", obj,
                                    function() {
                                        mw.reload_module('#mw_page_layout_preview');
                                        mw.reload_module_parent('products/admin_views/view');
                                    });
                            },
                            start: function(a, ui) {
                                $(this).height($(this).outerHeight());
                                $(ui.placeholder).height($(ui.item).outerHeight())
                                $(ui.placeholder).width($(ui.item).outerWidth())
                            },
                            scroll: false
                        });
                    }
                }
            </script>
            <div class="card style-1 mb-3 ">

                <script>
                    $(document).ready(function() {
                        mw.lib.require('mwui_init');
                    });

                    $(function() {
                        mw.tabs({
                            nav: "#manage-content-toolbar-tabs-nav a",
                            tabs: '#manage-content-toolbar-tabs .mw-ui-box-content'
                        });
                    });
                </script>

                <div class="card-header heading-style-one d-flex justify-content-between">
                    <h5>
                        <i class="mdi mdi-shopping text-primary mr-3"></i>
                        <strong><?php _e("Products"); ?></strong>
                        <a href="<?=admin_url(); ?>view:products/action:create"
                            class="btn btn-outline-success btn-sm mt-1 js-hide-when-no-items"><?php _e("Add Product"); ?></a>
                    </h5>
                    <?php
                    $product_limit = json_decode(get_drm_product_limit(), true);
                    if (@$product_limit['limit_amount'] and @$product_limit['products']) { ?>
                    <h5 class="av-product" style="max-width: 200px;">
                     <?php _e('Available Products'); ?> <br> ( <?= $product_limit['products'] ?>/<?= $product_limit['limit_amount'] ?> )
                    </h5>
                    <?php } ?>
                    <div class="js-hide-when-no-items product-details-admin">
                        <script>
                            $(document).ready(function() {
                                $('.js-search-by-selector').on('change', function() {
                                    if ($(this).find('option:selected').val() == 'keywords') {
                                        $('.js-search-by-tags').hide();
                                        $('.js-search-by-keywords').show();
                                    }
                                    if ($(this).find('option:selected').val() == 'tags') {
                                        $('.js-search-by-tags').show();
                                        $('.js-search-by-keywords').hide();
                                    }
                                    let value = $(this).val();
                                    if(value != undefined){

                                        $(".search-field").addClass('hide');
                                        setTimeout(function(){
                                            $('.js-search-by-tags').hide();
                                            $('.js-search-by-keywords').show();
                                            $("#keywords_i").addClass('hide');
                                            $("#"+value+"_i").removeClass('hide');
                                            if(value == "tags"){
                                                $('.js-search-by-tags').show();
                                                $('.js-search-by-keywords').hide();

                                            }
                                            if(value == "keywords"){
                                                let hasData = "product_search('keyword',$('#"+value+"_i').val())";
                                                $('.search-field-btn').attr('onclick', hasData);

                                            }else{
                                                let hasData = "product_search('"+value+"',$('#"+value+"_i').val())";
                                                $('.search-field-btn').attr('onclick', hasData);

                                            }
                                        }, 10);

                                    }else{
                                        $("#keywords_i").removeClass('hide');
                                    }

                                });
                                let searchItem = $(this).find(":selected").val();
                                if(searchItem != undefined){
                                    $(".search-field").addClass('hide');
                                    setTimeout(function(){
                                        $("#"+searchItem+"_i").removeClass('hide');
                                        $("#"+searchItem+"_b").removeClass('hide');
                                    }, 10);
                                }
                            });
                        </script>

                        <div class="d-inline-block">
                            <select class="js-search-by-selector" data-width="150" data-style="btn-sm">
                                <option value="keywords" <?php if($value_type == 'keyword') echo "selected"; ?>><?php _e("search by keyword"); ?></option>
                                <option value="tags" ><?php _e("search by tags"); ?></option>
                                <option value="ean" <?php if($value_type == 'ean') echo "selected"; ?>><?php _e("search by EAN"); ?></option>
                                <option value="brand" <?php if($value_type == 'brand') echo "selected"; ?>><?php _e("search by Brand"); ?></option>
                                <option value="sku" <?php if($value_type == 'sku') echo "selected"; ?>><?php _e("search by Item Number/SKU"); ?></option>
                            </select>
                        </div>

                        <div class="js-search-by d-inline-block">
                            <div class="js-hide-when-no-items">
                                <div class="js-search-by-keywords">
                                    <div class="form-inline">
                                        <div class="input-group mb-0 prepend-transparent mx-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text px-1"><i
                                                        class="mdi mdi-magnify"></i></span>
                                            </div>
                                            <input type="text" id="keywords_i" class="search-field form-control form-control-sm" style="width: 100px;" value="<?php if($value_type == 'keyword') echo $value; ?>" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?product_search('keyword',this.value):false" />
                                            <input type="text" id="ean_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if($value_type == 'ean') echo $value; ?>" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?product_search('ean',this.value):false" />
                                            <input type="text" id="brand_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if($value_type == 'brand') echo $value; ?>" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?product_search('brand',this.value):false" />
                                            <input type="text" id="sku_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if($value_type == 'sku') echo $value; ?>" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?product_search('sku',this.value):false" />

                                            <!-- <input type="text" id="keywords_i" class="search-field form-control form-control-sm" style="width: 100px;" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?product_search('keyword',this.value):false" />
                                            <input type="text" id="ean_i" class="search-field form-control form-control-sm hide" style="width: 100px;" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('ean',this.value):false" />
                                            <input type="text" id="brand_i" class="search-field form-control form-control-sm hide" style="width: 100px;" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('brand',this.value):false" />
                                            <input type="text" id="sku_i" class="search-field form-control form-control-sm hide" style="width: 100px;" autofocus="autofocus" placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('sku',this.value):false" /> -->
                                        </div>

                                        <button type="button" class="search-field-btn btn btn-sm btn-icon" style="background-color:#074A74;color:#fff;border-color:#074A74" onclick="product_search('keyword',$(this).prev().find('input').val())"><i class="mdi mdi-magnify"></i></button>
                                        
                                        <!-- <button type="button" class="search-field-btn btn btn-sm btn-icon" style="background-color:#074A74;color:#fff;border-color:#074A74" onclick="mw.url.windowHashParam('keyword',$(this).prev().find('input').val())"><i class="mdi mdi-magnify"></i></button> -->

                                    </div>
                                </div>

                                <div class="js-search-by-tags" style="display: none;">
                                    <div class="js-search-by-tags" style="display: none;">
                                        <div id="posts-select-tags" class="js-toggle-search-mode-tags d-flex align-items-center" style="width:120px; height: 30px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="shopinnerClassic-trigger">
                    <div class="sct-input scti-1">
                        <?php $check_value = get_option('classic_layout', 'product_classic_layout') ?? 0; ?>
                        <!-- <label for="prductClassLayout">Active Classic Layout For Product Details</label> -->
                        <div class="label-area">
                            <p><?php _e('Activate classic layout for product description'); ?>

                            </p>
                            <div class="sct-tooltip">
                                <div class="tooltip"><i class="fa fa-eye"></i>
                                    <span class="tooltiptext"><?php _e('When you activate this option that time product description will be shown throughout the whole page. If the button is inactive then the description will be shown on only right section of the page'); ?>.</span>
                                </div>
                            </div>

                        </div>

                        <div class="onoffswitch">
                            <!-- <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" tabindex="0"> -->
                            <input type="checkbox" id="prductClassLayout" class="onoffswitch-checkbox" name="prductClassLayout" <?php  if($check_value == "1") { echo "checked"; } ?>>
                            <label class="onoffswitch-label" for="prductClassLayout">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>

                    </div>
                    <div class="sct-input scti-2">
                        <?php $check_readmore_value = get_option('readMoreOption', 'product_readmore_layout') ?? 0; ?>
                        <div class="label-area">
                            <p><?php _e('Activate read more button for product description'); ?>

                            </p>
                            <div class="sct-tooltip">
                                <div class="tooltip"><i class="fa fa-eye"></i>
                                    <span class="tooltiptext"><?php _e('When you activate this option that time the read more button will be active after the word limit'); ?>.</span>
                                </div>
                            </div>
                        </div>

                        <div class="onoffswitch2">
                            <input type="checkbox" id="prductReadmore" class="onoffswitch-checkbox2" name="prductReadmore" <?php  if($check_readmore_value == "1") { echo "checked"; } ?>>
                            <label class="onoffswitch-label2" for="prductReadmore">
                                <span class="onoffswitch-inner2"></span>
                                <span class="onoffswitch-switch2"></span>
                            </label>
                        </div>




                        <?php $checkWordLimit_value = get_option('readMoreLimit', 'product_readmore_limit') ?? 0; ?>
                        <div class="sc-limit <?php  if($check_readmore_value == "0") {  echo "hide"; } ?>">
                            <label for="readMoreLimit"><?php _e('Word Limit'); ?>: </label>
                            <input type="text" class="readMoreWord" id="readMoreLimit" placeholder="15" value="<?php
                            if(!empty($checkWordLimit_value)){
                                echo $checkWordLimit_value;
                            }else{
                                echo "15";
                            };
                            ?>">
                        </div>

                    </div>

                    <script>
                        $("#prductClassLayout").on("click", function() {

                            var layoutStatusEnable = "";
                            if ($('input#prductClassLayout').is(':checked')) {
                                var layoutStatusEnable = "1";
                            } else {
                                var layoutStatusEnable = "0";
                            };

                            $.post("<?=api_url('enableClassicProductLayout'); ?>", {
                                layoutStatus: layoutStatusEnable
                            }).then((res, err) => {
                                console.log(res, err);
                            });

                        });


                        $("#prductReadmore").on("click", function() {
                            var productReadmore = "";
                            if ($('input#prductReadmore').is(':checked')) {
                                var productReadmore = "1";

                                $(".sc-limit").removeClass("hide");
                            } else {
                                var productReadmore = "0";
                                $(".sc-limit").addClass("hide");
                            };

                            $.post("<?=api_url('enableProductReadmore'); ?>", {
                                productReadmoreStatus: productReadmore
                            }).then((res, err) => {
                                console.log(res, err);
                            });
                            var productDescriptionLimit = $("#readMoreLimit").val();
                            $.post("<?=api_url('pdescriptionWordLimit'); ?>", {
                                pdLimitStatus: productDescriptionLimit
                            }).then((res, err) => {
                                console.log(res, err);
                            });
                        });

                        $("#readMoreLimit").on("keyup", function() {
                            var productDescriptionLimit = $("#readMoreLimit").val();
                            $.post("<?=api_url('pdescriptionWordLimit'); ?>", {
                                pdLimitStatus: productDescriptionLimit
                            }).then((res, err) => {
                                console.log(res, err);
                            });
                        });
                    </script>
                </div>
                <div class="card-body pt-3 pb-0">
                    <div class="toolbar row js-hide-when-no-items">
                        <div class="col-sm-4 d-flex align-items-center justify-content-center justify-content-sm-start my-1">
                            <div class="custom-control custom-checkbox mb-0">
                                <input type="checkbox" class="custom-control-input" id="posts-check">
                                <label class="custom-control-label" for="posts-check"><?php _e("Check all"); ?></label>
                            </div>
                            <div class="d-inline-block ml-3">
                                <div class="js-bulk-actions" style="display: none;">
                                    <select class="selectpicker js-bulk-action" title="Bulk actions" data-style="btn-sm" data-width="auto">

                                        <?php
                                        if (user_can_access('module.content.edit')) :
                                            ?>
                                            <option value="assign_selected_posts_to_category"><?php _e("Move to category"); ?></option>
                                        <?php endif; ?>

                                        <?php
                                        if (user_can_access('module.content.destroy')) :
                                            ?>
                                            <option value="delete_selected_posts"><?php _e("Delete"); ?></option>
                                        <?php endif; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <script>
                            $('.js-bulk-action').on('change', function() {
                                var selectedBulkAction = $('.js-bulk-action option:selected').val();
                                if (selectedBulkAction == 'assign_selected_posts_to_category') {
                                    assign_selected_posts_to_category();
                                } else if (selectedBulkAction == 'delete_selected_posts') {
                                    delete_selected_posts();
                                }
                            });
                        </script>
                        <?php
                        $order_by_field = '';
                        $order_by_type = 'desc';
                        ?>

                        <div class="js-table-sorting col-sm-8 text-right my-1 d-flex justify-content-center justify-content-sm-end align-items-center">
                            <span><?php _e("Sort By"); ?>:</span>
                            <div class="d-inline-block mx-1">
                                <button type="button" class="js-sort-btn btn btn-outline-secondary btn-sm icon-right" data-order="<?php echo $order_by_type; ?>" onclick="postsSort('created_at', this);">
                                    <?php _e("Date"); ?> <i class="mdi mdi-chevron-down text-muted"></i>
                                </button>
                            </div>

                            <div class="d-inline-block">
                                <button type="button" class="js-sort-btn btn btn-outline-secondary btn-sm icon-right" data-order="<?php echo $order_by_type; ?>" onclick="postsSort('title', this);">
                                    <?php _e("Title"); ?> <i class="mdi mdi-chevron-down text-muted"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        var el = $("#posts-check")
                        el.on('change', function() {
                            mw.check.toggle('#mw_admin_posts_sortable');

                            var all = $('#mw_admin_posts_sortable input[type="checkbox"]');
                            var checked = all.filter(':checked');
                            if (checked.length && checked.length === all.length) {
                                el[0].checked = true;
                            } else {
                                el[0].checked = false;
                            }

                            var all = mwd.querySelector('.select_posts_for_action:checked');
                            if (all === null) {
                                $('.js-bulk-actions').hide();
                            } else {
                                $('.js-bulk-actions').show();
                            }
                        });

                        $('.select_posts_for_action').on('change', function() {
                            var all = mwd.querySelector('.select_posts_for_action:checked');
                            if (all === null) {
                                $('.js-bulk-actions').hide();
                            } else {
                                $('.js-bulk-actions').show();
                            }
                        });

                    });

                    $(document).ready(function() {
                        var postsSelectTags = mw.select({
                            element: '#posts-select-tags',
                            placeholder: 'Filter by tag',
                            multiple: false,
                            autocomplete: true,
                            size: 'small',
                            tags: true,
                            ajaxMode: {
                                paginationParam: 'page',
                                searchParam: 'keyword',
                                endpoint: mw.settings.api_url + 'tagging_tag/autocomplete',
                                method: 'get'
                            }
                        });

                        $(postsSelectTags).on("change", function(event, val) {
                            product_search('tag', val.title);
                        });
                    });

                    postsSort = function(type, selector) {
                        $('#product-list').html('<div class="loader"></div>');
                        $('.manage-posts-holder-inner').addClass('loader-dependency-class');
                        var jQueryEl = $(selector);
                        var ordering = jQueryEl.attr('data-order');
                        if(ordering == 'desc'){
                            ordering = 'asc';
                            jQueryEl.find('i').removeClass('mdi-chevron-down');
                            jQueryEl.find('i').addClass('mdi-chevron-up');
                        }else if(ordering == 'asc'){
                            ordering = 'desc';
                            jQueryEl.find('i').removeClass('mdi-chevron-up');
                            jQueryEl.find('i').addClass('mdi-chevron-down');
                        }
                        $.ajax({
                                type: "POST",
                                url: "<?=api_url('filter_product_for_admin')?>",
                                data: {
                                    type: type,
                                    ordering: ordering
                                },
                                success: function(response) {
                                    response = JSON.parse(response);
                                    // console.log(response['html']);
                                    // return;
                                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                                    $('#product-list').html(response['html']);
                                },
                                error: function(response) {
                                    $('.manage-posts-holder-inner').removeClass('loader-dependency-class');
                                    mw.notification.error("Something went Wrong!");
                                    $.post("<?=api_url('no_product_for_admin')?>", { data: false } ,function(res){
                                            $('#product-list').html(res);
                                    });
                                }
                            });
                        jQueryEl.attr('data-order', ordering);
                    }
                </script>

                <div class="card -body pt-3">
                    <div class="module module module-content-manager " >
                        <?php 
                        if (is_array($data) and !empty($data)): 
                            ?>
                        <div class="manage-posts-holder" id="mw_admin_posts_sortable">
                            <?php
                                // $p_ids_hide = cat_product_hide();
                                $p_ids_hide = [];
                                $edit_text = _e('Edit', true);
                                $delete_text = _e('Delete', true);
                                $live_edit_text = _e('Live Edit', true);
                            ?>
                            <div class="manage-posts-holder-inner muted-cards" id="product-list" style="margin: 0 20px;">
                                <?php if (is_array($data)):
                                        $count = 0;
                                        ?>
                                <?php foreach ($data as $key => $item):
                                            ?>
                                <?php if (isset($item['id'])):
                                $hasSubscription = false;
                                $hasSub = DB::table('subscription_status')->where('product_id', $item['id'])->first();
                                if(isset($hasSub) && !empty($hasSub)) $hasSubscription = true;
                                $content_link = site_url() . $item['url'];
                                $edit_link = admin_url('view:products/action:create?id=' . $item['id']);
                                ?>
                                <?php $pic = get_picture($item['id']); ?>
                                <div
                                    class="card card-product-holder mb-2 post-has-image-<?php print($pic == true ? 'true' : 'false'); ?> manage-post-item-type-<?php print $item['content_type']; ?> manage-post-item manage-post-item-<?php print($item['id']) ?>">
                                    <div class="card-body">
                                        <div class="row align-items-center flex-lg-nowrap">
                                            <div class="col text-center manage-post-item-col-1"
                                                style="max-width: 40px;">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mx-1">
                                                        <input type="checkbox"
                                                            class="custom-control-input select_posts_for_action"
                                                            name="select_posts_for_action"
                                                            id="select-content-<?php print($item['id']) ?>"
                                                            value="<?php print($item['id']) ?>">
                                                        <label class="custom-control-label"
                                                            for="select-content-<?php print($item['id']) ?>"></label>
                                                    </div>
                                                </div>

                                                <span
                                                    class="btn btn-link text-muted px-0 js-move mw_admin_posts_sortable_handle"
                                                    onmousedown="mw.manage_content_sort()"><i
                                                        class="mdi mdi-cursor-move"></i></span>
                                            </div>

                                            <div class="col manage-post-item-col-2" style="max-width: 120px;">
                                                <?php
                                                                $type = "product";
                                                                $type_icon = 'mdi-shopping';
                                                                ?>

                                                <div class="img-circle-holder border-radius-0 border-0">

                                                    <?php if ($pic == true): ?>
                                                    <a href="<?=$edit_link; ?>">
                                                        <img src="<?php print thumbnail($pic, 120, 120, true) ; ?>" />
                                                    </a>
                                                    <?php else : ?>
                                                    <a href="<?=$edit_link; ?>">
                                                        <i
                                                            class="mdi <?php echo $type_icon; ?> mdi-48px text-muted text-opacity-5"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col item-title manage-post-item-col-3 manage-post-main">
                                                <div class="manage-item-main-top">
                                                    <a target="_top" href="<?php print $content_link; ?>"
                                                        class="btn btn-link p-0">
                                                        <h5
                                                            class="text-dark text-break-line-1 mb-0 manage-post-item-title">
                                                            <?php print strip_tags($item['title']) ?></h5>
                                                    </a>
                                                    <?php 
                                                    mw()->event_manager->trigger('module.content.manager.item.title', $item);

                                                    $cats = content_categories_V2($item['id']);
                                                    $tags = content_tags_V2($item['id']);
                                                    if ($cats): ?>
                                                    <span class="manage-post-item-cats-inline-list">
                                                        <?php foreach ($cats as $ck => $cat): ?>


                                                        <a href="#action=showpostscat:<?=$cat['id']??0;?>"
                                                            class="btn btn-link p-0 text-muted"><?php  print $cat['title']; ?></a><?php if (isset($cats[$ck + 1])): ?>,<?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </span>
                                                    <?php endif; ?>

                                                    <?php if ($tags): ?>
                                                    <br />
                                                    <?php foreach ($tags as $tag): ?>
                                                    <small
                                                        class="bg-secondary rounded-lg px-2">#<?php echo $tag['name']; ?></small>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>


                                                    <a class="manage-post-item-link-small mw-medium d-none d-lg-block"
                                                        target="_top" href="<?php print $content_link; ?>">
                                                        <small class="text-muted"><?php print $content_link; ?></small>
                                                    </a>
                                                </div>

                                                <div class="manage-post-item-links">
                                                    <?php
                                                                    if (user_can_access('module.content.edit')):
                                                                        ?>
                                                    <a target="_top" class="btn btn-outline-success btn-sm"
                                                        href="<?php print $edit_link ?>">
                                                        <?php echo $edit_text; ?>
                                                    </a>
                                                    <?php
                                                                    endif;
                                                                    ?>

                                                    <?php
                                                                    if (user_can_access('module.content.destroy')):
                                                                        if($type == 'product' && $hasSubscription){ ?>
                                                    <a class="btn btn-outline-danger btn-sm"
                                                        href="javascript:delete_subscription_single_post('<?php print ($item['id']) ?>');">
                                                        <?php echo $delete_text; ?>
                                                    </a>
                                                    <?php }else{ ?>
                                                    <a class="btn btn-outline-danger btn-sm"
                                                        href="javascript:mw.delete_single_post('<?php print ($item['id']) ?>');">
                                                        <?php echo $delete_text; ?>
                                                    </a>
                                                    <?php }
                                                                    endif; ?>
                                                </div>
                                            </div>
                                            <div class="item-author manage-post-item-col-4">
                                                <?php if(in_array($item['id'],$p_ids_hide)) { ?>
                                                <span class="cat-hide-product-icon">

                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>

                                                    <p class="cat-hide-product-icon-text">
                                                        The category of this product is hidden from the shop.
                                                    </p>
                                                </span>
                                                <?php } ?>
                                                <span class="text-muted"
                                                    title="<?php print user_name($item['created_by']); ?>"><?php print user_name($item['created_by'], 'username') ?></span>
                                            </div>

                                            <div class="col item-comments manage-post-item-col-5 d-none"
                                                style="max-width: 100px;">
                                                <?php mw()->event_manager->trigger('module.content.manager.item', $item) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="product-pagination mx-4">
                                <div class="mw-paging product-paging pull-left my-2">
                                    <?php
                                        $page_count = 1;
                                        $current_page = 1;
                                        if(isset($_GET['page'])){
                                            $current_page = $_GET['page'];
                                        }
                                        $last_page = $products->onLastPage();
                                        $total_page = $products->lastPage();
                                        if($total_page != 1){
                                            if(!$last_page){ ?>
                                                <a href="javascript:paginate_data(<?=$total_page ?>,'<?=$value_type ?>','<?=$value ?>')" class="">Last</a>
                                            <?php }
                                            $i = 1;
                                            if($current_page == $total_page){
                                                $i = $total_page -4;
                                                if($i < 1){
                                                    $i =1;
                                                }
                                                
                                            }elseif(($current_page-4) >= 1 and ($current_page+1) <= $total_page){
                                                $i = $current_page-3;
                                            }
                                            for($i;$i<=$total_page; $i++){ 
                                                if($page_count <= 5){?>
                                                    <a href="javascript:paginate_data(<?=$i ?>,'<?=$value_type ?>','<?=$value ?>')" class="<?php if($current_page == $i): echo 'active'; endif?>"><?=$i;?></a>
                                                <?php }else{
                                                    break;
                                                } 
                                                $page_count++; 
                                            }
                                            if($total_page >= ($current_page+1)){ 
                                                ?>
                                                <a href="javascript:paginate_data(<?=$current_page+1 ?>,'<?=$value_type ?>','<?=$value ?>')" class="">Next</a>
                                            <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="no-items-found products">
                            <div class="row">
                                <div class="col-12">
                                    <div class="no-items-box"
                                        style="background-image: url('<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/no_products.svg'); ">
                                        <h4><?php _e('You don’t have any products'); ?></h4>
                                        <p><?php _e('Create your first product right now.You are able to do that in very easy way!'); ?>
                                        </p>
                                        <br />
                                        <a href="<?php print admin_url(); ?>view:products/action:create"
                                            class="btn btn-primary btn-rounded"><?php _e('Create a Product'); ?></a>
                                    </div>
                                </div>
                            </div>


                            <script>
                            $(document).ready(function() {
                                $('.js-hide-when-no-items').hide();
                                //                    $('body > #mw-admin-container > .main').removeClass('show-sidebar-tree');
                            });
                            </script>
                            <script>
                            $(document).ready(function() {
                                $('.manage-toobar').hide();
                                $('.top-search').hide();
                            });
                            </script>
                        </div>
                        <?php endif; ?>

                        <script>
                            function delete_subscription_single_post(id) {
                                mw.tools.confirm(
                                    "Attention: This is a subscription product. By deleting it, you will lose all recurring revenue. Do you want to proceed with the deletion? If yes, customers will be notified by email accordingly.",
                                    function() {
                                        var arr = id;
                                        $.post("<?=api_url('delete_product_info_V2');?>", {
                                            id: id
                                        }).then((res, err) => {
                                            // console.log(res, err);
                                        });
                                        // return;
                                        mw.post.del(arr, function() {
                                            mw.$(".manage-post-item-" + id).fadeOut(function() {
                                                $(this).remove()
                                            });
                                        });
                                        $.post("<?=api_url('delete_subscription_product_if_has'); ?>", {
                                            id: id
                                        }).then((res, err) => {
                                            //console.log(res, err);
                                        });
                                    });
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>