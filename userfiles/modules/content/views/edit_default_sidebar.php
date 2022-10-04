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
$condition = '';
if(url_param('action', 'false') == 'products' || url_param('view', 'false') == 'shop' || @$params['content_type'] == "product"){
    $condition .= '?is_shop=1';
}
if(url_param('action', 'false') == 'posts' || @$params['subtype'] == "post"){
    $condition .= '?is_blog=1';
}
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
                    <?php if ($data['content_type'] != 'page' and $data['subtype'] != 'category'): ?>
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

            <?php if ($data['content_type'] != 'page' and $data['subtype'] != 'category'): ?>


                <div class="row">
                    <div class="col-12">
                        <small class="text-muted"><?php _e('Want to add the '.$data['content_type'].' in more categories?'); ?></small>
                        <br/>
                        <button type="button" class="btn btn-outline-primary btn-sm text-dark my-3" data-toggle="collapse" data-target="#show-categories-tree"><?php _e('Category Add to'); ?></button>
                        <br/>

                        <div id="show-categories-tree" class="collapse">
                            <div class="mw-admin-edit-page-primary-settings content-category-selector">
                                <div class="mw-ui-field-holder">
                                    <div class="mw-ui-category-selector mw-ui-category-selector-abs mw-tree mw-tree-selector" id="mw-category-selector-<?php print $rand; ?>">
                                        <?php if ($data['content_type'] != 'page' and $data['subtype'] != 'category'): ?>
                                            <script>
                                                $(document).ready(function () {
                                                    loadCategoriesTree();
                                                });

                                               mw.on('pagesTreeRefresh', function () {
                                                     loadCategoriesTree();
                                                });
                                            </script>

                                            <div id="quick-parent-selector-tree"></div>

                                            <?php include(__DIR__ . '/edit_default_scripts_two.php'); ?>
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
        <?php if($data['layout_file'] == 'layouts__thank_you.php' && $data['url'] != 'thank-you'): ?>
            <script>
                $("#tags").on("change",function(){
                    page_tags = $(this).val();
                    if(!page_tags){
                        // console.log("test");
                        $('.js-bottom-save').hide();
                    }else{
                        $('.js-bottom-save').show();
                    }
                    // console.log($(this).val());
                });

            </script>
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

                                        data.forEach(sup => {
                                        suplier_list += `<option value="${sup.id}" id="sup_${sup.id}">${sup.name}</option>
                                            `;


                                        })
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
