<?php
must_have_access();
$is_shop = false;

if (isset($params['is_shop'])) {
    $is_shop = $params['is_shop'];
}

$dir_name = normalize_path(modules_path());

$posts_mod = $dir_name . 'content' . DS . 'admin_live_edit_tab1.php';
?>
<?php
$set_content_type_mod = 'page';
if (isset($params['global']) and $params['global'] != false) {
    $set_content_type_mod_1 = get_option('data-content-type', $params['id']);
    if ($set_content_type_mod_1 != false and $set_content_type_mod_1 != '') {
        $set_content_type_mod = $set_content_type_mod_1;
    }
}

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
    if (isset($params['is_shop']) and ($params['is_shop'] == 'y' or $params['is_shop'] == 1)) {
        $add_post_q .= ' content_type="product"   ';
    } else if (isset($params['content_type']) and $params['content_type'] != '') {
        $add_post_q .= ' content_type="' . $params['content_type'] . '"   ';
    } else {
        $add_post_q .= ' content_type="post" ';
    }
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
    $page_categories = db_get($str0);
    $sub_cats = array();
    $page_categories = db_get($str0);
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


    mw.on.hashParam("action", function () {
        var id = (this.split(':')[1]);

        if (this == 'new:post' || this == 'new:page' || this == 'new:product') {
            mw.add_new_content_live_edit(id);
        } else if (this == 'editpage') {
            // $('#mw_posts_create_live_edit').html("Content is added");
        } else {
            mw.edit_content_live_edit(id);
        }
    });

    mw.add_new_content_live_edit = function ($cont_type) {
        $('a[href="#last-1"]').trigger('click');

        $('#mw_posts_create_live_edit').removeAttr('data-content-id');
        $('#mw_posts_create_live_edit').attr('from_live_edit', 1);
        if ($cont_type == undefined) {
            $('#mw_posts_create_live_edit').removeAttr('content_type');

        } else {
            if ($cont_type == 'page') {
                $('#mw_posts_create_live_edit').removeAttr('subtype');
            } else {
                $('#mw_posts_create_live_edit').attr('subtype', $cont_type);

            }
            $('#mw_posts_create_live_edit').attr('content_type', $cont_type);
        }
        <?php if($parent_page): ?>
        mw.$('#mw_posts_create_live_edit').attr('parent-content-id', "<?php print $parent_page; ?>");
        <?php endif; ?>
        mw.$('#mw_posts_create_live_edit').attr('content-id', 0);
        mw.$('#mw_posts_create_live_edit').attr('quick_edit', 1);
        mw.$('#mw_posts_create_live_edit').removeAttr('live_edit');
        $('#mw_posts_edit_live_edit').html('');
        mw.load_module('content/edit', '#mw_posts_create_live_edit', function () {

            resizeModal();
        });
    }

    mw.manage_live_edit_content = function ($id) {
        sessionStorage.setItem("managetabsesstion", 1);

        $('a[href="#last-1"]').trigger('click');

        if ($id != undefined) {
            $('#mw_posts_manage_live_edit').attr('module-id', $id);
        }
        $('#mw_posts_manage_live_edit').removeAttr('just-saved');
        mw.load_module('content/manage_live_edit', '#mw_posts_manage_live_edit', function () {
            resizeModal();
        })

    }

    mw.edit_content_live_edit = function ($cont_id) {
        $('a[href="#last-2"]').trigger('click');
        mw.$('#mw_posts_edit_live_edit').empty();
        if (window.thismodal && thismodal.dialogContainer) {
            thismodal.dialogContainer.querySelector('iframe').style.height = 'auto';
            thismodal.dialogContainer.scrollTop = 0;
        }

        $('#mw_posts_edit_live_edit').attr('content-id', $cont_id);
        $('#mw_posts_edit_live_edit').removeAttr('live_edit');
        $('#mw_posts_edit_live_edit').attr('quick_edit', 1);

        $('#mw_posts_create_live_edit').html('');
        mw.load_module('content/edit', '#mw_posts_edit_live_edit', function () {
            resizeModal();
        });
    }

    mw.delete_content_live_edit = function (a, callback) {
        mw.tools.confirm("<?php _ejs("Do you want to delete this post"); ?>?", function () {
            var arr = $.isArray(a) ? a : [a];
            var obj = {ids: arr}
            $.post(mw.settings.site_url + "api/content/delete", obj, function (data) {
                typeof callback === 'function' ? callback.call(data) : '';
                $('.manage-post-item-' + a).fadeOut();
                mw.notification.warning("<?php _ejs('Content was sent to Trash'); ?>.");
                mw.reload_module_parent('posts')
                mw.reload_module_parent('shop/products')
                mw.reload_module_parent('content')
            });
        });
    }

    $(mwd).ready(function () {
        thismodal.width('800px');
        resizeModal()
    });
</script>


<div class="post-settings-holder">
    <nav class="nav nav-pills nav-justified btn-group btn-group-toggle btn-hover-style-3">
    <?php
        if(strpos($params['id'], 'shop-products') !== false){
?>
        <a class="btn btn-outline-secondary justify-content-center active product__management" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
        <a class="btn btn-outline-secondary justify-content-center product__management manage__tab" onclick="mw.manage_live_edit_content('<?php print $params['id'] ?>');" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> <?php _e("Manage"); ?></a>
        <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>

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
                mw.load_module('content/manager', '#products_module', function () {
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
        }else{
?>
        <a class="btn btn-outline-secondary justify-content-center active" onclick="mw.manage_live_edit_content('<?php print $params['id'] ?>');" data-toggle="tab" href="#list"><i class="mdi mdi-format-list-bulleted-square mr-1"></i> <?php _e("Manage"); ?></a>
        <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#settings"><i class="mdi mdi-cog-outline mr-1"></i> <?php print _e('Settings'); ?></a>
        <a class="btn btn-outline-secondary justify-content-center" data-toggle="tab" href="#templates"><i class="mdi mdi-pencil-ruler mr-1"></i> <?php print _e('Templates'); ?></a>
<?php
        }
    ?>
        <a class="btn btn-outline-secondary justify-content-center" style="display: none;" data-toggle="tab" href="#last-1"></a>
        <a class="btn btn-outline-secondary justify-content-center" style="display: none;" data-toggle="tab" href="#last-2"></a>
    </nav>
    <?php
        if(strpos($params['id'], 'shop-products') !== false){
?>
<div class="tab-content py-3">
        <div class="tab-pane fade" id="list">
            <div class="setting-row d-flex align-items-center justify-content-between">
                <div></div>
                <div>
                    <label class="d-inline-block">
                        <?php $ord_by = get_option('data-order-by', $params['id']); ?>
                        <?php _e("Order by"); ?>
                    </label>

                    <select name="data-order-by" class="mw_option_field selectpicker" data-width="auto" data-also-reload="<?php print  $config['the_module'] ?>">
                        <option value="" <?php if ((0 == intval($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Position"); ?>(Oldest)</option>
                        <option value="position asc" <?php if (('position asc' == trim($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Position"); ?>(Newest)</option>
                        <option value="created_at desc" <?php if (('created_at desc' == trim($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Date"); ?>(Oldest)</option>
                        <option value="created_at asc" <?php if (('created_at asc' == trim($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Date"); ?>(Newest)</option>
                        <option value="title asc" <?php if (('title asc' == trim($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Title"); ?>(A to Z)</option>
                        <option value="title desc" <?php if (('title desc' == trim($ord_by))): ?>   selected="selected"  <?php endif; ?>><?php _e("Title"); ?>(Z to A)</option>
                    </select>
                </div>
            </div>
            <div class="text-right">
                <?php if (isset($params['global'])): ?>
                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('<?php print addslashes($set_content_type_mod); ?>');" style="position: absolute;top: 12px;right: 12px;z-index: 2;"><i class="mdi mdi-<?php print trim($set_content_type_mod); ?>"></i>
                        <?php _e("Add new"); ?> <?php _e(ucwords($set_content_type_mod)); ?></a>
                <?php elseif ($is_shop) : ?>
                    <!-- <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('product');"><i class="mdi mdi-shopping"></i> New Product </a> -->
                <?php else : ?>
                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('post');"><i class="mdi mdi-text"></i> <?php _e("New Post"); ?></a>
                <?php endif; ?>
            </div>

            <div id="products_module">
                <div class="preloader">
                    <div class="loader"></div>
                </div>
            </div>
            <!-- <module type="content/manager" <?php print $add_post_q ?> no_page_edit="true" id="mw_posts_manage_live_edit" no_toolbar="true" limit='1'/> -->

        </div>

        <div class="tab-pane fade  show active" id="settings">
            <?php include($posts_mod); ?>
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
        }else{

?>
<div class="tab-content py-3">
        <div class="tab-pane fade show active" id="list">
            <div class="text-right">
                <?php if (isset($params['global'])): ?>
                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('<?php print addslashes($set_content_type_mod); ?>');" style="position: absolute;top: 12px;right: 12px;z-index: 2;"><i class="mdi mdi-<?php print trim($set_content_type_mod); ?>"></i>
                        <?php _e("Add new"); ?> <?php _e(ucwords($set_content_type_mod)); ?></a>
                <?php elseif ($is_shop) : ?>
                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('product');"><i class="mdi mdi-shopping"></i> <?php _e("New Product"); ?></a>
                <?php else : ?>
                    <a href="javascript:;" class="btn btn-success btn-sm" onclick="mw.add_new_content_live_edit('post');"><i class="mdi mdi-text"></i> <?php _e("New Post"); ?></a>
                <?php endif; ?>
            </div>
            <module type="content/manager" <?php print $add_post_q ?> no_page_edit="true" id="mw_posts_manage_live_edit" no_toolbar="true"/>
        </div>

        <div class="tab-pane fade" id="settings">
            <?php include($posts_mod); ?>
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
