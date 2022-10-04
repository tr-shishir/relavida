
<script>
    $(document).ready(function() {
        mw.lib.require('mwui_init');
    });
</script>
<style>
    @media only screen and (max-width: 1790px){
        .card-header.heading-style-two {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .card-header.heading-style-two .product-details-admin{
            align-self: flex-end;
        }
    }

    .card-header.heading-style-two h5{
        display:flex;
    }

    .rss-input {
        display: flex;
        align-items: center;
    }

    .rss-input label {
        margin-right: 10px;
    }

    #rss_xml_link_btn {
        padding: 13px 10px !important;
    }

    #newImageopt,
    #newDescopt,
    #newTitleopt,
    #newLinkopt {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    #newImageopt select,
    #newDescopt select,
    #newTitleopt select,
    #newLinkopt select {
        margin: 5px !important;
    }

    .rss-maping .input-group {
        display: flex;
        align-items: center;
    }

    .rss-maping .input-group label {
        margin-right: 0px;
        width: 130px;
    }

    .rss-mapping select {
        margin: 0 !important;
        width: 200px;
    }
    select.js-search-by-selector {
        color: #2b2b2b;
        font-weight: 500;
        border: 1px solid #cfcfcf;
        border-radius: 5px;
        margin: 10px auto;
        padding: 6px  10px;
        font-size: 12px;
    }

    .js-search-by-keywords {
        margin: 10px 0px;
    }

    #posts-select-tags {
        margin: 10px auto;
        margin-left: 10px;
    }
</style>
<?php
$custom_tabs = false;

$type = 'page';
$act = url_param('action', 1);
$view = url_param('view', 1);
?>

<?php
if (isset($params['page-id'])) {
    $last_page_front = $params['page-id'];
} else {

    $last_page_front = session_get('last_content_id');
    if ($last_page_front == false) {
        if (isset($_COOKIE['last_page'])) {
            $last_page_front = $_COOKIE['last_page'];
        }
    }
}

$past_page = false;
if ($last_page_front != false) {
    $cont_by_url = mw()->content_manager->get_by_id($last_page_front, true);
    if (isset($cont_by_url) and $cont_by_url == false) {
        $past_page = mw()->content_manager->get("order_by=updated_at desc&limit=1");
        $past_page = mw()->content_manager->link($past_page[0]['id']);
    } else {
        $past_page = mw()->content_manager->link($last_page_front);
    }
} else {
    $past_page = mw()->content_manager->get("order_by=updated_at desc&limit=1");
    if (isset($past_page[0])) {
        $past_page = mw()->content_manager->link($past_page[0]['id']);
    } else {
        $past_page = false;
    }
}
?>
<?php if (isset($past_page) and $past_page != false) : ?>
    <script>
        $(function() {
            mw.tabs({
                nav: "#manage-content-toolbar-tabs-nav a",
                tabs: '#manage-content-toolbar-tabs .mw-ui-box-content'
            });
            $('.go-live-edit-href-set').attr('href', '<?php print $past_page; ?>');
        });
    </script>
<?php endif; ?>

<?php if (isset($params['keyword']) and $params['keyword'] != false) : ?>
    <?php $params['keyword'] = urldecode($params['keyword']); ?>

    <script>
        $(function() {
            $('[autofocus]').focus(function() {
                this.selectionStart = this.selectionEnd = this.value.length;
            });

            $('[autofocus]:not(:focus)').eq(0).focus();
        });
    </script>
<?php endif; ?>

<?php if ($page_info) : ?>
    <?php
    $content_types = array();
    $available_content_types = get_content('order_by=created_at asc&is_deleted=0&fields=content_type&group_by=content_type&parent=' . $page_info['id']);
    $have_custom_content_types_count = 0;
    if (!empty($available_content_types)) {
        foreach ($available_content_types as $available_content_type) {
            if (isset($available_content_type['content_type'])) {
                $available_content_subtypes = get_content('order_by=created_at asc&is_deleted=0&fields=subtype&group_by=subtype&parent=' . $page_info['id'] . '&content_type=' . $available_content_type['content_type']);
                if (!empty($available_content_subtypes)) {
                    $content_types[$available_content_type['content_type']] = $available_content_subtypes;
                }
            }
        }
    }

    $have_custom_content_types_count = count($content_types);

    if ($have_custom_content_types_count < 3) {
        $content_types = false;
    }
    ?>
    <?php if (isset($content_types) and !empty($content_types)) : ?>
        <?php $content_type_filter = (isset($params['content_type_filter'])) ? ($params['content_type_filter']) : false; ?>
        <?php $subtype_filter = (isset($params['subtype_filter'])) ? ($params['subtype_filter']) : false; ?>
        <?php
        $selected = $content_type_filter;
        if ($subtype_filter != false) {
            $selected = $selected . '.' . $subtype_filter;
        }
        ?>

        <script>
            $(function() {
                $("#content_type_filter_by_select").change(function() {
                    var val = $(this).val();
                    if (val != null) {
                        vals = val.split('.');
                        if (vals[0] != null) {
                            mw.$('#<?php print $params['id']; ?>').attr('content_type_filter', vals[0]);
                        } else {
                            mw.$('#<?php print $params['id']; ?>').removeAttr('content_type_filter');
                        }
                        if (vals[1] != null) {
                            mw.$('#<?php print $params['id']; ?>').attr('subtype_filter', vals[1]);
                        } else {
                            mw.$('#<?php print $params['id']; ?>').removeAttr('subtype_filter');
                        }

                        mw.reload_module('#<?php print $params['id']; ?>');
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php
if ($act) {
    if ($act == 'products') {
        session(['content' => 1]);
    } elseif ($act == 'pages') {
        session(['content' => 2]);
    } elseif ($act == 'posts') {
        session(['content' => 3]);
    }
} else {
    if ($view == 'content') {
        session(['content' => 4]);
    } elseif ($view == 'shop') {
        session(['content' => 1]);
    }
}
?>


<?php if (!isset($edit_page_info)) : ?>
    <?php mw()->event_manager->trigger('module.content.manager.toolbar.start', $page_info) ?>

    <?php
    $type = 'mdi-post-outline';

    if (is_array($page_info)) {
        if ($page_info['is_shop'] == 1) {
            $type = 'mdi-shopping';
        } elseif ($page_info['subtype'] == 'dynamic') {
            $type = 'mdi-post-outline';
        } else if (isset($page_info['layout_file']) and stristr($page_info['layout_file'], 'blog')) {
            $type = 'mdi-text';
        } else {
            $type = 'mdi-post-outline';
        }
    }
    if (($act == 'products')) {
        $admin_header = "heading-style-one";
    }else if(($act == 'posts')){
        $admin_header = "heading-style-two";
    }else {
        $admin_header = "";
    }
    ?>

    <div class="card-header <?php print $admin_header; ?> d-flex justify-content-between">
        <?php if (!isset($params['category-id']) and isset($page_info) and is_array($page_info)) : ?>
            <h5>
                <i class="mdi text-primary mr-2 <?php if ($type == 'shop') : ?>mdi-shopping<?php else : ?><?php print $type; ?><?php endif; ?>"></i>
                <?php print($page_info['title']) ?>

                <?php if (isset($params['page-id']) and intval($params['page-id']) != 0) : ?>
                    <?php $edit_link = admin_url('view:content#action=editpost:' . $params['page-id']); ?>
                    <a href="<?php print $edit_link; ?>" class="btn btn-outline-primary btn-sm" id="edit-content-btn"><?php _e("Edit page"); ?></a>
                <?php endif; ?>
            </h5>
        <?php elseif (isset($params['category-id'])) : ?>
            <div>
                <h5>
                    <?php $cat = get_category_by_id($params['category-id']); ?>
                    <?php if (isset($cat['title'])) : ?>
                        <i class="mdi mdi-folder text-primary mr-3"></i>
                        <strong><?php print $cat['title'] ?></strong>
                    <?php endif; ?>
                </h5>
            </div>
        <?php elseif ($act == 'pages') : ?>
            <h5>
                <i class="mdi mdi-post-outline text-primary mr-3"></i>
                <strong><?php _e("Pages"); ?></strong>
                <a href="<?php echo admin_url(); ?>view:content#action=new:page" class="btn btn-outline-success btn-sm ml-2"><?php _e("Add Page"); ?></a>
            </h5>
        <?php elseif ($act == 'posts') : ?>
            <h5>
                <div class="admin-page-header-content">
                    <i class="mdi mdi-text text-primary mr-3"></i>
                    <strong><?php _e("Posts"); ?></strong>
                </div>
                <div class="admin-page-header-button">
                    <a href="<?php echo admin_url(); ?>view:content#action=new:post" class="btn btn-outline-success btn-sm ml-2 js-hide-when-no-items"><?php _e("Add Post"); ?></a>

                    <!-- generate rss -->
                    <button type="button" class="btn btn-outline-success btn-sm ml-2 js-hide-when-no-items" data-toggle="modal" data-target=".rss-modal-lg" onclick="generate_rss_url()"><?php _e("Generate RSS"); ?></button>

                    <div class="modal fade rss-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php _e('RSS Page Link') ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control" type="text" id="rssUrl" name="rssUrl">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- add rss -->
                    <button type="button" id="add_rss" class="btn btn-outline-success btn-sm ml-2 js-hide-when-no-items" data-toggle="modal" data-target=".bd-example-modal-lg"><?php _e("Add RSS"); ?></button>
                    <?php $rssLink  = get_option('rss_link', 'rss_data') ?? null; ?>
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php _e('Add RSS Link') ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <div id="advice">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="rss-maping">

                                                        <div class="input-group mb-3 rss-input">
                                                            <label>RSS Link</label>
                                                            <input type="text" name="rss_link" class="form-control  " placeholder="RSS link" autocomplete="off">
                                                            <div class="input-group-append">
                                                                <button onclick="rss_xml_link()" id="rss_xml_link_btn" type="button" class="btn btn-sm btn-success"><?php _e('ADD') ?></button>
                                                            </div>
                                                        </div>
                                                        <div class="rss-mapping">
                                                            <div class="input-group mb-3">
                                                                <label for="rssImageOption">Image :</label>
                                                                <div id="newImageopt">

                                                                </div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <label for="rssTitleOption">Title :</label>
                                                                <div id="newTitleopt">

                                                                </div>

                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <label for="rssDescOption">Description :</label>
                                                                <div id="newDescopt">

                                                                </div>

                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <label for="rssLinkOption">Link :</label>
                                                                <div id="newLinkopt">

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                        <button onclick="rss_xml_save()" type="button" class="btn btn-sm btn-success btn-save js-bottom-save rss-xml-save">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </h5>

            <script>
                $('document').ready(function() {
                    $(".rss-xml-save").prop('disabled', true);
                    $('.rss-mapping').css('display', 'none');
                });

                var rss_xml_Array = '';
                var rss_image_data = '';
                var rss_desc_data = '';
                var rss_title_data = '';
                var rss_link_data = '';

                function rss_xml_option(res) {
                    var html = '';
                    res.forEach(function(result) {
                        html += '<option value="'
                        html += result;
                        html += '">';
                        html += result;
                        html += '</option>';
                    });
                    return html;
                }

                function rss_xml_link() {
                    var link = $("input[name='rss_link']").val() ?? null;
                    if (link) {

                        $.post("<?= api_url('insert_rss_xml_blog') ?>", {
                            rss_link: link
                        }).then((res, err) => {

                            rss_xml_Array = res[2];
                            if (res[0] == 1) {
                                $.post(mw.settings.api_url + 'mw_reload_modules');
                                mw.notification.success(res[1]);
                                location.reload();
                            } else if (res[0] == 2) {
                                mw.notification.warning(res[1]);
                                $(".rss-xml-save").prop('disabled', false);
                                $('.rss-mapping').css('display', 'block');

                                $.post("<?= api_url('rss_xml_key') ?>", {
                                    rss_xml_Array: rss_xml_Array
                                }).then((res, err) => {
                                    if (res.length > 0) {
                                        $("input[name='rss_link']").prop('disabled', true);
                                        $("#rss_xml_link_btn").prop('disabled', true);

                                        // for image
                                        var html = '';
                                        html += '<select onchange="rss_image_option(this)" id="rssImageOption" name="rssImageOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                        html += '<option value="" selected>select</option>';
                                        html += rss_xml_option(res);
                                        html += '</select>';
                                        $('#newImageopt').append(html);

                                        // for title
                                        var html = '';
                                        html += '<select onchange="rss_title_option(this)" id="rssTitleOption" name="rssTitleOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                        html += '<option value="" selected>select</option>';
                                        html += rss_xml_option(res);
                                        html += '</select>';
                                        $('#newTitleopt').append(html);

                                        // for desc
                                        var html = '';
                                        html += '<select onchange="rss_desc_option(this)" id="rssDescOption" name="rssDescOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                        html += '<option value="" selected>select</option>';
                                        html += rss_xml_option(res);
                                        html += '</select>';
                                        $('#newDescopt').append(html);

                                        // for link
                                        var html = '';
                                        html += '<select onchange="rss_link_option(this)" id="rssLinkOption" name="rssLinkOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                        html += '<option value="" selected>select</option>';
                                        html += rss_xml_option(res);
                                        html += '</select>';
                                        $('#newLinkopt').append(html);
                                    }
                                });
                            } else if (res[0] == 3) {
                                mw.notification.warning(res[1]);
                                location.reload();
                            }
                        });
                    }
                }

                function rss_image_option(opt) {
                    opt.setAttribute("disabled", "disabled");
                    var option = opt.value;
                    if (option) {
                        $.post("<?= api_url('rss_xml_nested_key') ?>", {
                            type: "image",
                            option: option,
                            rss_xml_Array: rss_xml_Array,
                            rss_image_data: rss_image_data
                        }).then((res, err) => {
                            rss_image_data = res[1];
                            if (res[0] != false) {
                                var html = '';
                                html += '<select onchange="rss_image_option(this)" id="rssImageOption" name="rssImageOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                html += '<option value="" selected>select</option>';
                                html += rss_xml_option(res[0]);
                                html += '</select>';
                                $('#newImageopt').append(html);
                            }
                        });
                    }
                }

                function rss_desc_option(opt) {
                    opt.setAttribute("disabled", "disabled");
                    var option = opt.value;
                    if (option) {
                        $.post("<?= api_url('rss_xml_nested_key') ?>", {
                            type: "desc",
                            option: option,
                            rss_xml_Array: rss_xml_Array,
                            rss_desc_data: rss_desc_data
                        }).then((res, err) => {
                            rss_desc_data = res[1];
                            if (res[0] != false) {
                                var html = '';
                                html += '<select onchange="rss_desc_option(this)" id="rssDescOption" name="rssDescOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                html += '<option value="" selected>select</option>';
                                html += rss_xml_option(res[0]);
                                html += '</select>';
                                $('#newDescopt').append(html);
                            }

                        });
                    }
                }

                function rss_title_option(opt) {
                    opt.setAttribute("disabled", "disabled");
                    var option = opt.value;
                    if (option) {
                        $.post("<?= api_url('rss_xml_nested_key') ?>", {
                            type: "title",
                            option: option,
                            rss_xml_Array: rss_xml_Array,
                            rss_title_data: rss_title_data
                        }).then((res, err) => {
                            rss_title_data = res[1];
                            if (res[0] != false) {
                                var html = '';
                                html += '<select onchange="rss_title_option(this)" id="rssTitleOption" name="rssTitleOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                html += '<option value="" selected>select</option>';
                                html += rss_xml_option(res[0]);
                                html += '</select>';
                                $('#newTitleopt').append(html);
                            }

                        });
                    }
                }

                function rss_link_option(opt) {
                    opt.setAttribute("disabled", "disabled");
                    var option = opt.value;
                    if (option) {
                        $.post("<?= api_url('rss_xml_nested_key') ?>", {
                            type: "link",
                            option: option,
                            rss_xml_Array: rss_xml_Array,
                            rss_link_data: rss_link_data
                        }).then((res, err) => {
                            rss_link_data = res[1];
                            if (res[0] != false) {
                                var html = '';
                                html += '<select onchange="rss_link_option(this)" id="rssLinkOption" name="rssLinkOption[]" class="js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">';
                                html += '<option value="" selected>select</option>';
                                html += rss_xml_option(res[0]);
                                html += '</select>';
                                $('#newLinkopt').append(html);
                            }

                        });
                    }
                }

                function rss_xml_save() {
                    var image = rss_image_data;
                    var title = rss_title_data;
                    var desc = rss_desc_data;
                    var link = rss_link_data;

                    if (title != "" && image != "" && desc != "") {
                        $.post("<?= api_url('rss_xml_save') ?>", {
                            image: image,
                            title: title,
                            desc: desc,
                            link: link
                        }).then((res, err) => {
                            if (res) {
                                $.post(mw.settings.api_url + 'mw_reload_modules');
                                mw.notification.success("Your rss blog save successfully");
                                location.reload();
                            }
                        });

                    } else {
                        mw.notification.success("please select image, title and description  ");

                    }
                }


                function getComboA(rssopt) {
                    var option = rssopt.value;
                    $.post("<?= api_url('rss_xml_filter') ?>", {
                        option: option
                    }).then((res, err) => {
                        location.reload();
                    });
                    location.reload();
                }



                function generate_rss_url() {
                    document.getElementById("rssUrl").value = "<?php echo site_url('rss-blog'); ?>";
                }
            </script>
        <?php elseif ($act == 'products') :
        $product_limit = json_decode(get_drm_product_limit(), true);
        ?>
            <h5>
                <i class="mdi mdi-shopping text-primary mr-3"></i>
                <strong><?php _e("Products"); ?></strong>
                <a href="<?php echo admin_url(); ?>view:content#action=new:product" class="btn btn-outline-success btn-sm mt-1 js-hide-when-no-items"><?php _e("Add Product"); ?></a>
            </h5>
            <?php
        if (@$product_limit['limit_amount'] and @$product_limit['products']) {
            ?>
            <h5 class="av-product" style="max-width: 200px;">
                <?php _e('Available Products'); ?> <br> ( <?= $product_limit['products'] ?>/<?= $product_limit['limit_amount'] ?> )
            </h5>
        <?php
        }
        ?>
        <?php elseif (isset($params['is_shop'])) : ?>
            <h5>
                <span class="mdi mdi-shopping text-primary mr-3"></span>
                <strong><?php _e("My Shop"); ?></strong>
                <a href="<?php echo admin_url(); ?>view:content#action=new:product" class="btn btn-outline-success btn-sm ml-2 js-hide-when-no-items"><?php _e("Add Product"); ?></a>
            </h5>
        <?php else : ?>
            <h5 class="d-inline-block">
                <i class="mdi mdi-earth text-primary mr-3"></i>
                <strong><?php _e("Website"); ?></strong>
                <a href="<?php echo admin_url(); ?>view:content#action=new:page" class="btn btn-outline-success btn-sm ml-2 js-hide-when-no-items"><?php _e("Add Page"); ?></a>
            </h5>
        <?php endif; ?>

        <?php
        $cat_page = false;
        if (isset($params['category-id']) and $params['category-id']) {
            $cat_page = get_page_for_category($params['category-id']);
        }

        $url_param_action = url_param('action', true);
        $url_param_view = url_param('view', true);

        $url_param_type = 'page';

        if ($type == 'shop' or $url_param_view == 'shop' or $url_param_action == 'products') {
            $url_param_type = 'product';
        } else if ($cat_page and isset($cat_page['is_shop']) and intval($cat_page['is_shop']) != 0) {
            $url_param_type = 'product';
        } else if ($url_param_action == 'categories' or $url_param_view == 'category') {
            $url_param_type = 'category';
        } else if ($url_param_action == 'showposts' or $url_param_action == 'posts' or $type == 'dynamicpage') {
            $url_param_type = 'post';
        } else if ($cat_page and isset($cat_page['subtype']) and ($cat_page['subtype']) == 'dynamic') {
            $url_param_type = 'product';
        }

        $add_new_btn_url = admin_url('view:content#action=new:') . $url_param_type;
        ?>



        <div class="js-hide-when-no-items product-details-admin">



            <?php if (isset($params['add-to-page-id']) and intval($params['add-to-page-id']) != 0) : ?>
                <div class="mw-ui-dropdown">
                    <span class="mw-ui-btn mw-icon-plus"><span class=""></span></span>
                    <div class="mw-ui-dropdown-content">
                        <div class="mw-ui-btn-vertical-nav">
                            <?php event_trigger('content.create.menu'); ?>

                            <?php $create_content_menu = mw()->module_manager->ui('content.create.menu'); ?>
                            <?php if (!empty($create_content_menu)) : ?>
                                <?php foreach ($create_content_menu as $type => $item) : ?>
                                    <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                                    <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                                    <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                                    <?php $type = (isset($item['content_type'])) ? ($item['content_type']) : false; ?>
                                    <?php $subtype = (isset($item['subtype'])) ? ($item['subtype']) : false; ?>
                                    <span class="mw-ui-btn <?php print $class; ?>"><a href="<?php print admin_url('view:content'); ?>#action=new:<?php print $type; ?><?php if ($subtype != false) : ?>.<?php print $subtype; ?><?php endif; ?>&amp;parent_page=<?php print $params['page-id'] ?>"> <?php print $title; ?> </a></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($params['category-id'])) : ?>
                <?php $edit_link = admin_url('view:content#action=editcategory:' . $params['category-id']); ?>
                <a href="<?php print $edit_link; ?>" class="btn btn-outline-primary btn-sm" id="edit-category-btn"><?php _e("Edit category"); ?></a>
            <?php endif; ?>

            <?php if (isset($content_types) and !empty($content_types)) : ?>
                <div>
                    <select id="content_type_filter_by_select" class="selectpicker" data-style="btn-sm" <?php if (!$selected) : ?> style="display:none" <?php endif; ?>>
                        <option value=""><?php _e('All'); ?></option>
                        <?php foreach ($content_types as $k => $items) : ?>
                            <optgroup label="<?php print ucfirst($k); ?>">
                                <option value="<?php print $k; ?>" <?php if ($k == $selected) : ?> selected="selected" <?php endif; ?>><?php print ucfirst($k); ?></option>
                                <?php foreach ($items as $item) : ?>
                                    <?php if (isset($item['subtype']) and $item['subtype'] != $k) : ?>
                                        <option value="<?php print $k; ?>.<?php print $item['subtype']; ?>" <?php if ($k . '.' . $item['subtype'] == $selected) : ?> selected="selected" <?php endif; ?>><?php print ucfirst($item['subtype']); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>

                    <?php if (!$selected) : ?>
                        <span class="mw-ui-btn mw-icon-menu" onclick="$('#content_type_filter_by_select').toggle(); $(this).hide();"></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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
                                // let searchVal = $("#"+value+"_i").val();
                                console.log(value);
                                if(value == "keywords"){
                                    let hasData = "mw.url.windowHashParam('search',$('#"+value+"_i').val())";
                                    $('.search-field-btn').attr('onclick', hasData);

                                }else{
                                    let hasData = "mw.url.windowHashParam('"+value+"',$('#"+value+"_i').val())";
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
                    <option value="keywords" <?php if(!@$params['brand'] && !@$params['ean'] && !@$params['sku']){ ?>selected<?php } ?>><?php _e("search by keyword"); ?></option>
                    <option value="tags"><?php _e("search by tags"); ?></option>
                    <?php if($act == 'products') :?>
                    <option value="ean" <?php if(@$params['ean']){ ?>selected<?php } ?>><?php _e("search by EAN"); ?></option>
                    <option value="brand" <?php if(@$params['brand']){ ?>selected<?php } ?>><?php _e("search by Brand"); ?></option>
                    <option value="sku" <?php if(@$params['sku']){ ?>selected<?php } ?>><?php _e("search by Item Number/SKU"); ?></option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="js-search-by d-inline-block">
                <div class="js-hide-when-no-items">
                    <div class="js-search-by-keywords">
                        <div class="form-inline">
                            <div class="input-group mb-0 prepend-transparent mx-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text px-1"><i class="mdi mdi-magnify"></i></span>
                                </div>

                                <input type="text" id="keywords_i" class="search-field form-control form-control-sm" style="width: 100px;" value="<?php if (isset($params['keyword']) and $params['keyword'] != false) : ?><?php print $params['keyword'] ?><?php endif; ?>" <?php if (isset($params['keyword']) and $params['keyword'] != false) : ?>autofocus="autofocus" <?php endif; ?> placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('search',this.value):false" />
                                <input type="text" id="ean_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if (isset($params['ean']) and $params['ean'] != false) : ?><?php print $params['ean'] ?><?php endif; ?>" <?php if (isset($params['ean']) and $params['ean'] != false) : ?>autofocus="autofocus" <?php endif; ?> placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('ean',this.value):false" />
                                <input type="text" id="brand_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if (isset($params['brand']) and $params['brand'] != false) : ?><?php print $params['brand'] ?><?php endif; ?>" <?php if (isset($params['brand']) and $params['brand'] != false) : ?>autofocus="autofocus" <?php endif; ?> placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('brand',this.value):false" />
                                <input type="text" id="sku_i" class="search-field form-control form-control-sm hide" style="width: 100px;" value="<?php if (isset($params['sku']) and $params['sku'] != false) : ?><?php print $params['sku'] ?><?php endif; ?>" <?php if (isset($params['sku']) and $params['sku'] != false) : ?>autofocus="autofocus" <?php endif; ?> placeholder="<?php _e("Search"); ?>" onkeyup="event.keyCode==13?mw.url.windowHashParam('sku',this.value):false" />
                            </div>

                            <button type="button" class="search-field-btn btn btn-sm btn-icon" style="background-color:#074A74;color:#fff;border-color:#074A74" onclick="mw.url.windowHashParam('search',$(this).prev().find('input').val())"><i class="mdi mdi-magnify"></i></button>

                        </div>
                    </div>

                    <div class="js-search-by-tags" style="display: none;">
                        <div id="posts-select-tags" class="js-toggle-search-mode-tags d-flex align-items-center" style="width:120px; height: 30px;"></div>
                    </div>
                </div>
            </div>

            <?php mw()->event_manager->trigger('module.content.manager.toolbar.end', $page_info); ?>
        </div>


    </div>
    <div class="shopinnerClassic-trigger">
        <style>
            .shopinnerClassic-trigger {
                position: relative;
                padding: 0px 0px 25px;
                border-bottom: 1px solid #cfcfcf;
                margin: 25px;
                border-left: none;
                border-right: none;
                display: none;
            }
            .view-shop .shopinnerClassic-trigger {
                display: block;
            }

            .shopinnerClassic-trigger .sct-input input {
                margin-right: 5px;
                position: relative;
                top: 1px;
            }

            .shopinnerClassic-trigger .sct-input {
                width: 50%;
                display: inline-block;
                position: relative;
                float: left;
                text-align: center;
            }

            .shopinnerClassic-trigger .sct-input {
                border: 1px solid #cfcfcf;
                min-height: 99px;
                vertical-align: middle;
                padding:15px;
                text-align: left;
            }

            .shopinnerClassic-trigger .sct-input.scti-1 {

                border-right: 0px;

            }

            .shopinnerClassic-trigger .sct-input.scti-2 {

            }

            .sc-limit input {
                width: 50px;
                text-align: center;
                border: 1px solid #000;
                border-radius: 5px;
            }

            .onoffswitch {
                position: relative; width: 50px;
                -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
                display: inline-block;
                text-align: left;
                margin-top: -15px;
            }
            .onoffswitch-checkbox {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }
            .onoffswitch-label {
                display: block; overflow: hidden; cursor: pointer;
                border: 2px solid #999999; border-radius: 20px;
                position: relative;
            }
            .onoffswitch-inner {
                display: block; width: 200%; margin-left: -100%;
                transition: margin 0.3s ease-in 0s;
            }
            .onoffswitch-inner:before, .onoffswitch-inner:after {
                display: block;
                float: left;
                width: 50%;
                height: 20px;
                padding: 0;
                line-height: 22px;
                font-size: 10px;
                color: white;
                font-family: Trebuchet, Arial, sans-serif;
                font-weight: bold;
                box-sizing: border-box;
            }
            .onoffswitch-inner:before {
                content: "ON";
                padding-left: 7px;
                background-color: #074a74; color: #FFFFFF;
            }
            .onoffswitch-inner:after {
                content: "OFF";
                padding-right: 7px;
                background-color: #EEEEEE; color: #999999;
                text-align: right;
            }
            .onoffswitch-switch {
                display: block; width: 15px; margin: 3px;
                background: #FFFFFF;
                position: absolute; top: 0; bottom: 0;
                right: 25px;
                border: 2px solid #999999; border-radius: 20px;
                transition: all 0.3s ease-in 0s;
            }
            .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
                margin-left: 0;
            }
            .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
                right: 0px;
            }









            .onoffswitch2 {
                position: relative; width: 50px;
                -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
                display: inline-block;
                text-align: left;
                margin-top: -15px;
            }
            .onoffswitch-checkbox2 {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }
            .onoffswitch-label2 {
                display: block; overflow: hidden; cursor: pointer;
                border: 2px solid #999999; border-radius: 20px;
                position: relative;
            }
            .onoffswitch-inner2 {
                display: block; width: 200%; margin-left: -100%;
                transition: margin 0.3s ease-in 0s;
            }
            .onoffswitch-inner2:before, .onoffswitch-inner2:after {
                display: block;
                float: left;
                width: 50%;
                height: 20px;
                padding: 0;
                line-height: 22px;
                font-size: 10px;
                color: white;
                font-family: Trebuchet, Arial, sans-serif;
                font-weight: bold;
                box-sizing: border-box;
            }
            .onoffswitch-inner2:before {
                content: "ON";
                padding-left: 7px;
                background-color: #074a74; color: #FFFFFF;
            }
            .onoffswitch-inner2:after {
                content: "OFF";
                padding-right: 7px;
                background-color: #EEEEEE; color: #999999;
                text-align: right;
            }
            .onoffswitch-switch2 {
                display: block; width: 15px; margin: 3px;
                background: #FFFFFF;
                position: absolute; top: 0; bottom: 0;
                right: 25px;
                border: 2px solid #999999; border-radius: 20px;
                transition: all 0.3s ease-in 0s;
            }
            .onoffswitch-checkbox2:checked + .onoffswitch-label2 .onoffswitch-inner2 {
                margin-left: 0;
            }
            .onoffswitch-checkbox2:checked + .onoffswitch-label2 .onoffswitch-switch2 {
                right: 0px;
            }


            .shopinnerClassic-trigger .sct-input p {
                margin-bottom: 0px;
                font-size: 12px;
                font-weight: 600;
                line-height: 14px;
                display: inline-block;
            }

            .sc-limit {
                position: absolute;
                bottom: 28px;
                text-align: center;
                left: 75px;
            }

            .sc-limit label {
                font-weight: 600;
                /* display: block; */
                font-size: 13px;
            }
            .sct-tooltip {
                position: relative;
                display: inline-block;
            }


            .tooltip {
                position: relative;
                z-index: 1;
                display: inline-block;
                line-break: auto;
                opacity: 1;
            }
            .tooltip:hover {
                z-index: 999;
            }
            .tooltip .tooltiptext {
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
                right: -25px;
                opacity: 0;
                transition: opacity 0.3s;
                left: unset;
            }
            .tooltip .tooltiptext::after {
                content: "";
                position: absolute;
                top: 100%;
                margin-left: -5px;
                border-width: 5px;
                border-style: solid;
                border-color: #555 transparent transparent transparent;
                transform: rotate(
                    -2deg);
                left: unset;
                right: 28px;
            }

            .tooltip:hover .tooltiptext {
                visibility: visible;
                opacity: 1;
            }
            .tooltip i {
                color: #074a74;
                font-size: 12px;
            }



            @media only screen and (max-width: 1367px) {
                .shopinnerClassic-trigger .sct-input p {
                    font-size: 11px;
                }
            }

        </style>


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
            //
            // $("#prductClassLayout").on("click",function(){
            //     var layoutStatusEnable = "0";
            //     $.post("<?= url('/') ?>/api/v1/enableClassicProductLayout", { layoutStatus:layoutStatusEnable}, (res) => {
            //         if(res.success){
            //             console.log(res.data);
            //         }
            //     });

            // });






            $("#prductClassLayout").on("click",function(){

                var layoutStatusEnable = "";
                if ($('input#prductClassLayout').is(':checked')) {
                    var layoutStatusEnable = "1";
                }else{
                    var layoutStatusEnable = "0";
                };

                $.post("<?=api_url('enableClassicProductLayout')?>", {
                    layoutStatus:layoutStatusEnable
                }).then((res, err) => {
                    console.log(res, err);
                });

            });


            $("#prductReadmore").on("click",function(){
                var productReadmore = "";
                if ($('input#prductReadmore').is(':checked')) {
                    var productReadmore = "1";

                    $(".sc-limit").removeClass("hide");
                }else{
                    var productReadmore = "0";
                    $(".sc-limit").addClass("hide");
                };

                $.post("<?=api_url('enableProductReadmore')?>", {
                    productReadmoreStatus:productReadmore
                }).then((res, err) => {
                    console.log(res, err);
                });

                var productDescriptionLimit = $("#readMoreLimit").val();

                $.post("<?=api_url('pdescriptionWordLimit')?>", {
                    pdLimitStatus:productDescriptionLimit
                }).then((res, err) => {
                    console.log(res, err);
                });
            });

            $( "#readMoreLimit" ).on("keyup", function() {
                var productDescriptionLimit = $("#readMoreLimit").val();
                // if ($('input#readMoreLimit').is(':checked')) {
                //     var productDescriptionLimit = "1";
                // }else{
                //     var productDescriptionLimit = "0";
                // };

                $.post("<?=api_url('pdescriptionWordLimit')?>", {
                    pdLimitStatus:productDescriptionLimit
                }).then((res, err) => {
                    console.log(res, err);
                });
            });





        </script>
    </div>
<?php endif; ?>

<?php if ($page_info) : ?>
    <?php mw()->event_manager->trigger('module.content.manager.toolbar', $page_info) ?>
<?php endif; ?>
<?php $custom_tabs = mw()->module_manager->ui('content.manager.toolbar'); ?>
<?php if (!empty($custom_tabs)) : ?>
    <div id="manage-content-toolbar-tabs">
        <div class="mw-ui-btn-nav mw-ui-btn-nav-tabs" id="manage-content-toolbar-tabs-nav">
            <?php foreach ($custom_tabs as $item) : ?>
                <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                <a class="mw-ui-btn tip" data-tip="<?php print $title; ?>"> <span class="<?php print $class; ?>"></span> <span> <?php print $title; ?> </span>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="mw-ui-box">
            <?php foreach ($custom_tabs as $item) : ?>
                <?php $title = (isset($item['title'])) ? ($item['title']) : false; ?>
                <?php $class = (isset($item['class'])) ? ($item['class']) : false; ?>
                <?php $html = (isset($item['html'])) ? ($item['html']) : false; ?>
                <div class="mw-ui-box-content" style="display: none;"><?php print $html; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if (!isset($edit_page_info)) : ?>
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
                                <?php if($view != 'shop'): ?>
                                <option value="publish_selected_posts"><?php _e("Published"); ?></option>
                                <option value="unpublish_selected_posts"><?php _e("Unpublish"); ?></option>
                            <?php endif; endif; ?>

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
                $('.select_posts_for_action').on('change', function() {
                    var all = mwd.querySelector('.select_posts_for_action:checked');
                    if (all === null) {
                        $('.js-bulk-actions').hide();
                    } else {
                        $('.js-bulk-actions').show();
                    }
                });

                $('.js-bulk-action').on('change', function() {
                    var selectedBulkAction = $('.js-bulk-action option:selected').val();
                    if (selectedBulkAction == 'assign_selected_posts_to_category') {
                        assign_selected_posts_to_category();
                    } else if (selectedBulkAction == 'publish_selected_posts') {
                        publish_selected_posts();
                    } else if (selectedBulkAction == 'unpublish_selected_posts') {
                        unpublish_selected_posts();
                    } else if (selectedBulkAction == 'delete_selected_posts') {
                        delete_selected_posts();
                    }
                });
            </script>
            <?php
            $order_by_field = '';
            $order_by_type = '';
            if (isset($params['data-order'])) {
                $explode_date_order = explode(' ', $params['data-order']);
                if (isset($explode_date_order[1])) {
                    $order_by_field = $explode_date_order[0];
                    $order_by_type = $explode_date_order[1];
                }
            }
            ?>

            <div class="js-table-sorting col-sm-8 text-right my-1 d-flex justify-content-center justify-content-sm-end align-items-center">
                <!-- blog post option -->
                <?php if ($act == 'posts') : ?>
                    <!-- filter post -->
                    <?php $rssOption = get_option('blog_filter', 'blog_filter_option'); ?>
                    <select onchange="getComboA(this)" id="rssOption" name="rssOption[]" class="selectpicker js-search-by-selector form-control" data-width="120" data-style="btn-sm" tabindex="-98" aria-label="RSS option selected">
                        <option <?php if (intval($rssOption) == 1 || $rssOption == false) {
                            echo "selected";
                        } ?> value="1" selected><?php _e('Merge Posts'); ?></option>
                        <option <?php if (intval($rssOption) == 2) {
                            echo "selected";
                        } ?> value="2"><?php _e('Own Posts'); ?></option>
                        <option <?php if (intval($rssOption) == 3) {
                            echo "selected";
                        } ?> value="3"><?php _e('RSS Posts'); ?></option>
                    </select>
                    <!-- end filter post -->
                <?php endif; ?>
                <span><?php _e("Sort By"); ?>:</span>

                <div class="d-inline-block mx-1">
                    <button type="button" class="js-sort-btn btn btn-outline-secondary btn-sm icon-right" data-state="<?php if ($order_by_field == 'created_at') : ?><?php echo $order_by_type;
                    else : echo 'DESC'; ?><?php endif; ?>" data-sort-type="created_at" onclick="postsSort({id:'pages_edit_container_content_list', el:this});">
                        <?php _e("Date"); ?> <i class="mdi mdi-chevron-down text-muted"></i>
                    </button>
                </div>

                <div class="d-inline-block">
                    <button type="button" class="js-sort-btn btn btn-outline-secondary btn-sm icon-right" data-state="<?php if ($order_by_field == 'title') : ?><?php echo $order_by_type; ?><?php endif; ?>" data-sort-type="title" onclick="postsSort({id:'pages_edit_container_content_list', el:this});">
                        <?php _e("Title"); ?> <i class="mdi mdi-chevron-down text-muted"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $("#rss-submit").click(function() {
        alert("Handler for .click() called.");
    });
</script>


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

    });
</script>

<script>
    mw.require('forms.js', true);


    $(document).ready(function() {
        var postsSelectTags = mw.select({
            element: '#posts-select-tags',
            placeholder: '<?php _e('Filter by tag'); ?>',
            multiple: true,
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
            var parent_mod = mwd.getElementById('pages_edit_container_content_list');
            parent_mod.setAttribute('tags', '');
            $('.mw-paging').show();
            if (val.length > 0) {

                var tagSeperated = '';
                for (i = 0; i < val.length; i++) {
                    tagSeperated += val[i].title + ',';
                }

                parent_mod.setAttribute('tags', tagSeperated);
                $('.mw-paging').hide();
            }
            mw.reload_module(parent_mod);
        });
    });

    postsSort = function(obj) {

        var group = mw.tools.firstParentWithClass(obj.el, 'js-table-sorting');
        var parent_mod = mwd.getElementById('pages_edit_container_content_list');


        var others = group.querySelectorAll('.js-sort-btn'),
            i = 0,
            len = others.length;
        for (; i < len; i++) {
            var curr = others[i];
            if (curr !== obj.el) {
                $(curr).removeClass('ASC DESC active');
            }
        }
        obj.el.attributes['data-state'] === undefined ? obj.el.setAttribute('data-state', 0) : '';
        var state = obj.el.attributes['data-state'].nodeValue;

        var jQueryEl = $(obj.el);

        var tosend = {}
        tosend.type = obj.el.attributes['data-sort-type'].nodeValue;
        if (state === '0') {
            tosend.state = 'ASC';
            //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
            obj.el.setAttribute('data-state', 'ASC');

            jQueryEl.find('i').removeClass('mdi-chevron-down');
            jQueryEl.find('i').addClass('mdi-chevron-up');
        } else if (state === 'ASC') {
            tosend.state = 'DESC';
            //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right DESC';
            obj.el.setAttribute('data-state', 'DESC');

            jQueryEl.find('i').removeClass('mdi-chevron-up');
            jQueryEl.find('i').addClass('mdi-chevron-down');
        } else if (state === 'DESC') {
            tosend.state = 'ASC';
            //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
            obj.el.setAttribute('data-state', 'ASC');

            jQueryEl.find('i').removeClass('mdi-chevron-down');
            jQueryEl.find('i').addClass('mdi-chevron-up');
        } else {
            tosend.state = 'ASC';
            //            obj.el.className = 'js-sort-btn btn btn-outline-primary btn-sm icon-right ASC';
            obj.el.setAttribute('data-state', 'ASC');

            jQueryEl.find('i').removeClass('mdi-chevron-down');
            jQueryEl.find('i').addClass('mdi-chevron-up');
        }

        if (parent_mod !== undefined) {
            parent_mod.setAttribute('data-order', tosend.type + ' ' + tosend.state);
            mw.reload_module(parent_mod);
        }
    }
</script>
