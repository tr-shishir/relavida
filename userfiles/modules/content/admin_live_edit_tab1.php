<?php
must_have_access();

$set_content_type = 'post';
if (isset($params['global']) and $params['global'] != false) {
    $set_content_type = get_option('data-content-type', $params['id']);
}

$rand = uniqid(); ?>

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

<?php if (!isset($is_shop) or $is_shop == false): ?>
    <?php $is_shop = false;
    $pages = get_content('content_type=page&subtype=dynamic&is_shop=1&limit=1000'); ?>
<?php else: ?>
    <?php $pages = get_content('content_type=page&is_shop=0&limit=1000'); ?>
<?php endif; ?>

<?php $posts_parent_page = get_option('data-page-id', $params['id']); ?>

<?php if (isset($params['global']) and $params['global'] != false) : ?>
    <?php if ($set_content_type == 'product'): ?>
        <?php $is_shop = 1;
        $pages = get_content('content_type=page&is_shop=0&limit=1000'); ?>
    <?php endif; ?>

    <label class="mw-ui-label"><?php _e("Content type"); ?></label>
    <select name="data-content-type" id="the_post_data-content-type<?php print  $rand ?>" class="mw-ui-field w100 mw_option_field" onchange="mw_reload_content_mod_window(1)">
        <option value="" <?php if (('' == trim($set_content_type))): ?>  selected="selected"  <?php endif; ?>><?php _e("Choose content type"); ?></option>
        <option value="page" <?php if (('page' == trim($set_content_type))): ?>   selected="selected"  <?php endif; ?>><?php _e("Pages"); ?></option>
        <option value="post" <?php if (('post' == trim($set_content_type))): ?>   selected="selected"  <?php endif; ?>><?php _e("Posts"); ?></option>
        <option value="product" <?php if (('product' == trim($set_content_type))): ?>   selected="selected"  <?php endif; ?>><?php _e("Product"); ?></option>
        <option value="none" <?php if (('none' == trim($set_content_type))): ?>   selected="selected"  <?php endif; ?>><?php _e("None"); ?></option>
    </select>
<?php endif; ?>

<?php if (!isset($set_content_type) or $set_content_type != 'none') :
            if ($is_shop == false) {
                ?>
    <div class="form-group">
        <label class="control-label d-block"><?php echo _e("Display", true) . ' ' . $set_content_type . ' ' . _e("from page", true); ?></label>

        <select name="data-page-id" id="the_post_data-page-id<?php print  $rand ?>" class="mw_option_field selectpicker" data-width="100%" data-size="5" data-live-search="true" onchange="mw_reload_content_mod_window()">
            <?php if (intval($posts_parent_page) > 0 and !get_content_by_id($posts_parent_page)) { ?>
                <option value="" selected="selected"><?php _e("Unknown page"); ?></option>
            <?php } ?>
            <option value="current_page" <?php if (('current_page' == ($posts_parent_page))): ?>   selected="selected"  <?php endif; ?>>-- <?php _e("Current page"); ?></option>
            <option value="0" <?php if ($posts_parent_page != 'current_page' and (0 == intval($posts_parent_page))): ?>   selected="selected"  <?php endif; ?>><?php _e("All pages"); ?></option>
            <?php
            $pt_opts = array();
            $pt_opts['link'] = "{title}";
            //     $pt_opts['list_tag'] = "optgroup";
            //   $pt_opts['list_tag'] = " ";
            //   $pt_opts['list_item_tag'] = "option";

            $pt_opts['list_tag'] = " ";
            $pt_opts['list_item_tag'] = "option";

            //$pt_opts['include_categories'] = "option";
            $pt_opts['active_ids'] = $posts_parent_page;
            $pt_opts['remove_ids'] = $params['id'];
            $pt_opts['active_code_tag'] = '   selected="selected"  ';
            if ($is_shop != false) {
                $pt_opts['is_shop'] = 'y';
            }
            if ($set_content_type == 'product') {
                $pt_opts['is_shop'] = 'y';
            }

            pages_tree($pt_opts);
            ?>
        </select>
    </div>
    <?php }else{
        $posts_parent_page = $GLOBALS['shop_data'][0]['id'];
    }
    if ($posts_parent_page != false and intval($posts_parent_page) > 0): ?>
        <?php $posts_parent_category = get_option('data-category-id', $params['id']);
        $categories = DB::table('categories')->where('is_hidden',0)->where('status',1)->where('rel_id',$posts_parent_page)->get();
         ?>

        <div class="form-group">
            <label class="control-label d-block"><?php _e("Show only from category"); ?></label>
            <select name="data-category-id" id="the_post_data-page-id<?php print  $rand ?>" class="mw_option_field selectpicker" data-width="100%" data-size="5" data-live-search="true" data-also-reload="<?php print  $config['the_module'] ?>">
                <option value='' <?php if ((0 == intval($posts_parent_category))): ?>   selected="selected"  <?php endif; ?>><?php _e("Select a category"); ?></option>
                <?php
                $pt_opts = array();
                $pt_opts['link'] = " {title}";

                $pt_opts['list_tag'] = " ";
                $pt_opts['list_item_tag'] = "option";

                //  $pt_opts['list_tag'] = " ";
                //   $pt_opts['list_tag'] = "optgroup";

                //  $pt_opts['list_item_tag'] = "option";
                $pt_opts['active_ids'] = $posts_parent_category;
                $pt_opts['active_code_tag'] = '   selected="selected"  ';
                $pt_opts['rel_type'] = 'content';
                $pt_opts['rel_id'] = $posts_parent_page;
                category_tree($pt_opts);
                ?>
                <option value='0' <?php if ((0 == intval($posts_parent_category))): ?>   selected="selected"  <?php endif; ?>>-- <?php _e("All"); ?></option>
                <!-- <option value='related' <?php //if (('related' == trim($posts_parent_category))): ?>   selected="selected"  <?php //endif; ?>>-- <?php //_e("Related"); ?></option>
                <option value='sub_pages' <?php //if (('sub_pages' == trim($posts_parent_category))): ?>   selected="selected"  <?php //endif; ?>>-- <?php //_e("Sub Pages"); ?></option>
                <option value='current_category' <?php //if (('current_category' == trim($posts_parent_category))): ?>   selected="selected"  <?php //endif; ?>>-- <?php //_e("Current category"); ?></option> -->
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
		// dd($is_shop);
        session()->put("content", $is_shop);
        $all_existing_tags = json_encode(content_tags());
        if ($all_existing_tags == null) {
            $all_existing_tags = '[]';
        }




         ?>


        <div>
            <?php
            $tags_val_arr = [];
            $tags_val = get_option('data-tags', $params['id']);
            if ($tags_val and is_string($tags_val)) {
                $tags_val = explode(',', $tags_val);
                $tags_val = array_trim($tags_val);
                $tags_val = array_filter($tags_val);
                $tags_val = array_filter($tags_val,'addslashes');
                $tags_val = array_unique($tags_val);
                $tags_val_arr = $tags_val;

                $tags_val = implode(',', $tags_val);
            }
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

            <style>
                #content-tags-search-block-live-edit .mw-select{
                    width: 100% !important;
                }
            </style>

            <div class="form-group">
                <label class="control-label d-block"><?php _e("Show only with tags"); ?></label>


                <div class="">
                    <div id="content-tags-block-live-edit"></div>
                    <div id="content-tags-search-block-live-edit"></div>
                    <input type="hidden" class="form-control mw-full-width mw_option_field"  name="data-tags"  value="<?php print $tags_val; ?>"  id="tags"/>
                </div>
            </div>

            <script type="text/javascript">


                $(document).ready(function () {
                    var data = <?php print json_encode($tags_val_arr) ?>;

                    var node = document.querySelector('#content-tags-block-live-edit');
                    var nodesearch = document.querySelector('#content-tags-search-block-live-edit');

                    var tagsData = <?php print  json_encode($tags_val_arr) ?>.map(function (tag){
                        return {title: tag, id: tag}
                    });
                    var tags = new mw.tags({
                        element: node,
                        data: tagsData,
                        color: 'primary',
                        size:  'sm',
                        inputField: false,
                    })
                    $(tags)
                        .on('change', function(e, item, data){
                            mw.element('[name="data-tags"]').val(data.map(function (c) {  return c.title }).join(',')).trigger('change')
                        });


                    var tagsSelect = mw.select({
                        element: nodesearch,
                        multiple: false,
                        autocomplete: true,
                        tags: false,
                        placeholder: '<?php _ejs('Add tag') ?>',
                        ajaxMode: {
                            paginationParam: 'page',
                            searchParam: 'keyword',
                            endpoint: mw.settings.api_url + 'tagging_tag/autocomplete',
                            method: 'get'
                        }
                    });


                    $(tagsSelect).on("change", function (event, tag) {
                        tags.addTag(tag)
                        setTimeout(function () {tagsSelect.element.querySelector('input').value = '';})
                    });

                    $(tagsSelect).on('enterOrComma', function (e, node){
                        tags.addTag({title: node.value, id: node.value});
                        setTimeout(function () {node.value = '';})
                    })

                });
            </script>

        </div>
    </div>

    <?php $show_fields = get_option('data-show', $params['id']);
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
                        <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="thumbnail" id="thumbnail" <?php if (in_array('thumbnail', $show_fields)): ?>checked<?php endif; ?>>
                        <label class="custom-control-label" for="thumbnail"><?php _e("Thumbnail"); ?></label>
                    </div>
                </div>
            </div>

            <div class="setting-row d-flex align-items-center justify-content-between">
                <div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="title" id="title" <?php if (in_array('title', $show_fields)): ?>checked<?php endif; ?>>
                        <label class="custom-control-label" for="title"><?php _e("Title"); ?></label>
                    </div>
                </div>

                <div>
                    <label class="d-inline-block"><?php _e("Length"); ?></label>
                    <input type="text" class="form-control d-inline-block w-auto mw_option_field" name="data-title-limit" value="<?php print $getDefaultOptions['data-title-limit']->option_value ?>" placeholder="255"/>
                </div>
            </div>

            <?php if ($is_shop != 1): ?>
                <div class="setting-row d-flex align-items-center justify-content-between">
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="description" id="description" <?php if (in_array('description', $show_fields)): ?>checked<?php endif; ?>>
                            <label class="custom-control-label" for="description"><?php _e("Description"); ?></label>
                        </div>
                    </div>

                    <div>
                        <label class="d-inline-block"><?php _e("Length"); ?></label>
                        <input type="text" class="form-control d-inline-block w-auto mw_option_field" name="data-character-limit" value="<?php print $getDefaultOptions['data-character-limit']->option_value ?>" placeholder="80"/>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($is_shop): ?>
                <div class="setting-row d-flex align-items-center justify-content-between">
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="price" id="price" <?php if (in_array('price', $show_fields)): ?>checked<?php endif; ?>>
                            <label class="custom-control-label" for="price"><?php _e("Show price"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="setting-row d-flex align-items-center justify-content-between">
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="add_to_cart" id="add_to_cart" <?php if (in_array('add_to_cart', $show_fields)): ?>checked<?php endif; ?>>
                            <label class="custom-control-label" for="add_to_cart"><?php _e("Add to cart button"); ?></label>
                        </div>
                    </div>

                    <div>
                        <label class="d-inline-block"><?php _e("Title"); ?></label>
                        <input name="data-add-to-cart-text" class="mw_option_field form-control d-inline-block w-auto" style="width:95px;" placeholder="<?php _e("Add to cart"); ?>" type="text" value="<?php print $getDefaultOptions['data-add-to-cart-text']->option_value ?>"/>
                    </div>
                </div>

                <div class="setting-row d-flex align-items-center justify-content-between">
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mw_option_field" name="filter-only-in-stock" value="1" id="filter-only-in-stock" <?php if ($getDefaultOptions['filter-only-in-stock']->option_value): ?>checked<?php endif; ?>>
                            <label class="custom-control-label" for="filter-only-in-stock"><?php _e("Show only products in stock"); ?></label>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <div class="setting-row d-flex align-items-center justify-content-between">
                    <div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="content_limit_for_live_edit_module" checked disabled>
                            <label class="custom-control-label" for="content_limit_for_live_edit_module"><?php _e("Content's limit for manage settings"); ?></label>
                        </div>
                    </div>

                    <div>
                        <label class="d-inline-block"><?php _e("Limit"); ?></label>
                        <input type="text" class="form-control d-inline-block w-auto mw_option_field" id="content_limit_for_live_edit_module" name="content_limit_for_live_edit_module" value="<?php print get_option('content_limit_for_live_edit_module', 'content_limit_for_live_edit_module') ?>" placeholder="50"/>
                    </div>
                </div>
            <?php if ($is_shop != 1): ?>

            <div class="setting-row d-flex align-items-center justify-content-between">
                <div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="read_more" id="read_more" <?php if (in_array('read_more', $show_fields)): ?>checked<?php endif; ?>>
                        <label class="custom-control-label" for="read_more"><?php _e("Read More Link"); ?></label>
                    </div>
                </div>

                <div>
                    <label class="d-inline-block"><?php _e("Title"); ?></label>
                    <input name="data-read-more-text" class="mw_option_field form-control d-inline-block w-auto" type="text" placeholder="<?php _e("Read more"); ?>" style="width:95px;" value="<?php print $getDefaultOptions['data-read-more-text']->option_value ?>"/>
                </div>
            </div>
            <div class="setting-row d-flex align-items-center justify-content-between">
                <div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input mw_option_field" name="data-show" value="created_at" id="created_at" <?php if (in_array('created_at', $show_fields)): ?>checked<?php endif; ?>>
                        <label class="custom-control-label" for="created_at"><?php _e("Date"); ?></label>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="setting-row d-flex align-items-center justify-content-between">
                <div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input mw_option_field" name="data-hide-paging" value="y" id="data-hide-paging" <?php if (get_option('data-hide-paging', $params['id']) == 'y'): ?>checked<?php endif; ?>>
                        <label class="custom-control-label" for="data-hide-paging"><?php _e("Hide paging"); ?></label>
                    </div>
                </div>

                <div>
                    <label class="d-inline-block"><?php _e("Posts per page"); ?></label>
                    <input name="data-limit" id="pagination_post" class="<?php if(!isset($_GET['col_count'])){ print "mw_option_field";} ?> form-control d-inline-block w-auto" type="number" style="width:55px;" placeholder="<?=$showProduct??6?>" value="<?php print $getDefaultOptions['data-limit']->option_value ?? 6 ?>"/>
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
                option_key: "data-limit",
                option_group: "<?=$params['id']?>",
                option_value: my_input.val()
            }
            $.ajax({
                type: "POST",
                url: mw.settings.site_url + "api/save_option",
                data: o_data,
            }).then(function(){
                mw.notification.success('Settings are saved.');
                mw.reload_module_parent("#<?=$params['id']?>")

            });
        }else{
            mw.notification.error('Value must be Divisors of <?=$_GET['col_count']??3?>');
            my_input.val("<?=($_GET['col_count']??3)*2?>")
        }
        $.post('<?=url("/")?>/api/v1/rss_paging', { page: my_input.val() }, (res) => {

        });
    }
    $("#content_limit_for_live_edit_module").on("change",function (){
        $.post('<?=url("/")?>/api/v1/module_content_limit', { limit: $(this).val() }, (res) => {

            if(res.success){
                mw.notification.success('Settings are saved.');
            }

        });
    });
</script>
