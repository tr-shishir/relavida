<style>
    .manage-post-item-links{
        display:flex;
        align-items:center;
    }
    .manage-post-item-links a{
        margin-right:15px;
    }
    .header-checkbox{
        width: 50px;
        height: 25px;
        border-radius: 30px;
        background-color: #eee;
        outline: none;
        -webkit-appearance: none;
        position: relative;
    }

    .header-checkbox:checked{
        background-color: #1AA3D0;
    }

    .header-checkbox::before{
        position: absolute;
        content: '';
        height: 20px;
        width: 20px;
        border-radius: 20px;
        background-color: #fff;
        transform: scale(.9);
        top: 3px;
        left: 0;
        transition: .5s;
    }

    .header-checkbox:checked::before{
        left: 24px;
    }
    div.screnshot-icon{
        padding-top: 8px;
    }
    div.screnshot-icon i.fa.fa-camera{
        margin-top: 10px;
        font-size: 20px;
        margin-left: 29px;
        color: #074A74;

    }

	.badge-dark {
        color: #fff;
        background-color: #ff4500;
        padding: 8px;
    }
    .badge-success:hover {
        color: #2b2b2b;
    }
    .badge-warning:hover {
        color: #ffffff;
    }
    .headercheck-tt {
        position: absolute;
        bottom: 35px;
        background-color: #000;
        width: 300px;
        padding: 10px;
        border-radius: 5px;
        display: none;
    }

    .headercheck-tt p {
        color: #fff;
        font-size: 11px;
        white-space: break-spaces;
        margin: 0px auto;
    }

    .header-checkbox:hover + .headercheck-tt {
        display: block;
    }

    .manage-post-item-col-4 span {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 2px 5px;
        margin:0 5px;
        display:inline-block;
    }

    .cat-hide-product-icon {
        position: relative;
    }

    .cat-hide-product-icon-text {
        position: absolute;
        top: -25px;
        right: -72px;
        width: 400px;
        text-align: center;
        background: #ccc;
        border-radius: 5px;
        visibility:hidden;
        opacity:0;
        margin-bottom: 0;
        transition: all .3s ease;
    }

    .cat-hide-product-icon:hover .cat-hide-product-icon-text{
        visibility:visible;
        opacity:1;
    }

    .card-product-holder .item-title {
        min-width: 400px !important;
        flex: 1 0 !important;
    }

    @media only screen and (max-width: 1366px){
        .card-product-holder .item-title{
            min-width: auto !important;
        }
    }
    @media screen and (max-width: 767px){
        .card-product-holder .item-author {
            display: block !important;
        }
    }

    .modal-page-pagination-title {
    border: 1px solid #e5e5e5;
    padding: 20px;
    padding-top: 0px;
    padding-bottom: 12px;
    border-radius: 10px;

    }

    .modal-page-pagination-title:not(:last-child) {
        margin-bottom: 30px;
    }

    .modal-page-pagination-title>span {
        text-align: center;
        display: inline-block;
        margin-bottom: 7px;
        width: 100%;
    }
</style>
<?php
    use Illuminate\Support\Facades\DB;
?>
<?php 
$settings = getProductModuleSettings($params['id']);
$limitOfProduct = $settings['content_limit_for_live_edit_module']->value ?? 50;
$order_by = 'position';
$ordering = 'desc';

if(isset($settings['position'])){
    $order_data = $settings['position']->value;
    $order_data = explode(" ", $order_data);
    $order_by = $order_data[0];
    $ordering = $order_data[1];
}

if(isset($settings['tags']) and !empty($settings['tags']->value)){
    $tags = $settings['tags']->value;
    $tags = explode(',', $tags);
    $taggable_id = DB::table('tagging_tagged')->whereIn('tag_name', $tags)->select('taggable_id')->get()->pluck('taggable_id')->toArray();
}

if(isset($settings['categories']) and !empty($settings['categories']->value)){
    $categories = $settings['categories']->value;
    $categories = DB::table('categories_items')->where('parent_id', $categories)->where('rel_type', 'product')->select('rel_id')->get()->pluck('rel_id')->toArray();
}

if(isset($categories) and isset($taggable_id)){
    $taggable_id = array_unique($taggable_id);
    $categories = array_unique($categories);
    $data_id = array_merge($taggable_id, $categories);
    $data_id = array_unique($data_id);
}else if(isset($categories)){
    $data_id = array_unique($categories);
} else if(isset($taggable_id)){
    $data_id = array_unique($taggable_id);
}

if(isset($data_id) and !empty($data_id)){
    $query = App\Models\Product::whereIn('id', $data_id)->orderBy($order_by, $ordering);
}else{
    $query = App\Models\Product::orderBy($order_by, $ordering);
}

$data = $query->with(['media', 'tagged', 'categories'])->limit($limitOfProduct)->get()
->map(function($item){
    $item = $item->toArray();
    $item['image'] = false;
    if(isset($item['media'][0]['filename']))
    $item['image'] = $item['media'][0]['filename'];

    $item['price'] = $item['vk_price'] ?? 0;

    return (array)$item;
})->toArray();
if (is_array($data) and !empty($data)):
    $colCount = $settings['data-limit']->value ?? 6;
    
    if(isset($colCount)){
        if(isset($settings['content_limit_for_live_edit_module']->value)){
            if($settings['content_limit_for_live_edit_module']->value < count($data)){
                $contentLimit = $settings['content_limit_for_live_edit_module']->value;
            }else{
                $contentLimit = $limitOfProduct;
            }
        }else{
            $contentLimit = $limitOfProduct;
        }
        $checkCount = $contentLimit/$colCount;
        if(!is_integer($checkCount)){
            $checkCount = intval($checkCount)+1;
        }
        ?>
        <div>
            <select class="selectpicker js-modules-sort-types" id="form_select_page" data-width="100%">
                <option selected>Go to the page</option>
                <?php

                for($i = 1; $i <= $checkCount; $i++){ ?>
                    <option value="#Page-<?=$i?>"><?=$i?></option>
                <?php } ?>
            </select>
        </div>
        <br>
        <script>
            $("#form_select_page").on( 'change', function(e){
                var href = $(this).val();
                $(href).focus();
            });
            $(document).ready(function () {
                $('body > #mw-admin-container > .main').addClass('show-sidebar-tree');
            });

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
        
        </script>
        <?php

    }
    ?>
    <div class="manage-posts-holder" id="mw_admin_posts_sortable">
        <div class="manage-posts-holder-inner muted-cards">

            <?php
            $edit_text = _e('Edit', true);
            $delete_text = _e('Delete', true);
            ?>

            <?php if (is_array($data)):
                $count = 0;
                $pageToShow = 0;
                ?>
                <?php foreach ($data as $key => $item):
                    if(isset($colCount)){
                        if(($key)%$colCount == 0){
                            $start = true;
                            $count++;
                            if($key > 0){
                                ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="modal-page-pagination-title" id="Page-<?=$count?>-n" data-bs-spy="scroll" data-bs-target="#" data-bs-offset="0" tabindex="0">
                                <span class="badge rounded-pill bg-light text-dark mt-2 ml-2" ><?php _e('Page'); ?>-<?=$count?></span>
                            <?php

                        }
                        if($start){
                            $pageToShow++;
                        }

                        // dump($colCount >= 3 , $pageToShow == 3);
                            if(($colCount >= 3 && $pageToShow == 3) || $contentLimit == $key+1){
                                // dump('abc');
                                ?>
                                <div id="Page-<?=$count?>" data-bs-spy="scroll" data-bs-target="#" data-bs-offset="0" tabindex="0"></div>
                                <?php
                                $pageToShow = 0;
                                $start = false;
                            }
                    }
                    ?>
                    <?php 
                        if (isset($item['id'])):
                            $hasSubscription = false;
                            if(isset($item['content_type']) && $item['content_type'] == 'product'){
                                $hasSub = DB::table('subscription_status')->where('product_id', $item['id'])->first();
                                if(isset($hasSub) && !empty($hasSub)) $hasSubscription = true;
                            }
                            $pub_class = '';
                            $content_link = site_url() . $item['url'];
                            $edit_link = admin_url('view:products/action:create?id=' . $item['id']);
                            // $p_ids_hide = cat_product_hide();
                            $p_ids_hide = [];
                    ?>
                        <?php $pic = get_picture($item['id']); ?>
                        <div class="card card-product-holder mb-2 post-has-image-<?php print($pic == true ? 'true' : 'false'); ?> manage-post-item-type-<?php print $item['content_type']; ?> manage-post-item manage-post-item-<?php print($item['id']) ?> <?php print $pub_class ?>">
                            <div class="card-body">
                                <div class="row align-items-center flex-lg-nowrap">
                                    <div class="col text-center manage-post-item-col-1" style="max-width: 40px;">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox mx-1">
                                                <input type="checkbox" class="custom-control-input select_posts_for_action" name="select_posts_for_action" id="select-content-<?php print($item['id']) ?>" value="<?php print($item['id']) ?>">
                                                <label class="custom-control-label" for="select-content-<?php print($item['id']) ?>"></label>
                                            </div>
                                        </div>

                                        <span class="btn btn-link text-muted px-0 js-move mw_admin_posts_sortable_handle" onmousedown="mw.manage_content_sort()"><i class="mdi mdi-cursor-move"></i></span>
                                    </div>

                                    <div class="col manage-post-item-col-2" style="max-width: 120px;">
                                        <?php
                                            $type = 'product';
                                            $type_icon = 'mdi-shopping';
                                        ?>
                                        <div class="img-circle-holder border-radius-0 border-0">

                                            <?php if ($pic == true): ?>
                                                <a href="<?=$edit_link; ?>">
                                                    <img src="<?php print thumbnail($pic, 120, 120, true) ; ?>"/>
                                                </a>
                                            <?php else : ?>
                                                <a href="<?=$edit_link; ?>">
                                                    <i class="mdi <?php echo $type_icon; ?> mdi-48px text-muted text-opacity-5"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col item-title manage-post-item-col-3 manage-post-main">
                                        <div class="manage-item-main-top">
                                            <a target="_top" href="<?php print $edit_link; ?>" class="btn btn-link p-0">
                                                <h5 class="text-dark text-break-line-1 mb-0 manage-post-item-title"><?php print strip_tags($item['title']) ?></h5>
                                            </a>
                                            <?php mw()->event_manager->trigger('module.content.manager.item.title', $item) ?>

                                            <?php $cats = content_categories_V2($item['id']);
                                            $tags = content_tags_V2($item['id']);
                                            $cat_link = admin_url('view:products/action:view');
                                            if ($cats): ?>
                                                    <span class="manage-post-item-cats-inline-list">
                                                        <?php foreach ($cats as $ck => $cat): ?>


                                                        <a href="<?=$cat_link; ?>#action=showpostscat:<?=$cat['id']??0;?>"
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


                                            <a class="manage-post-item-link-small mw-medium d-none d-lg-block" target="_top" href="<?php print $content_link; ?>">
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
                                            $tk_url = explode('/',$item['url']);
                                            if (user_can_access('module.content.destroy')):
                                                if($item['content_type'] == 'product' && $hasSubscription){ ?>
                                                    <a class="btn btn-outline-danger btn-sm" href="javascript:delete_subscription_single_post('<?php print ($item['id']) ?>');">
                                                        <?php echo $delete_text; ?>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a class="btn btn-outline-danger btn-sm" href="javascript:mw.delete_single_post('<?php print ($item['id']) ?>');">
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
                                    <div class="col item-comments manage-post-item-col-5 d-none" style="max-width: 100px;">
                                        <?php mw()->event_manager->trigger('module.content.manager.item', $item) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php
             endforeach; ?>
            <?php endif; ?>
        </div>
        <?php
        $numactive = 1;

        if (isset($params['data-page-number'])) {
            $numactive = intval($params['data-page-number']);
        } else if (isset($params['current_page'])) {
            $numactive = intval($params['current_page']);
        }
        ?>

        <?php if (isset($paging_links) and is_array($paging_links)): ?>
            <div class="mw-paging" style="display: none">
                <?php $i = 1; ?>
                <?php foreach ($paging_links as $item): ?>
                    <a class="page-<?php print $i; ?> <?php if ($numactive == $i): ?> active <?php endif; ?>" href="#<?php print $paging_param ?>=<?php print $i ?>" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '<?php print $i ?>');return false;"><?php print $i; ?></a>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($paging_links) and is_array($paging_links)): ?>
            <div class="mw-paging pull-right">
                <?php $count = count($paging_links); ?>
                <?php if ($count < 6): ?>
                    <?php $i = 1; ?>
                    <?php foreach ($paging_links as $item): ?>
                        <a class="page-<?php print $i; ?> <?php if ($numactive == $i): ?> active <?php endif; ?>" href="#<?php print $paging_param ?>=<?php print $i ?>" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '<?php print $i ?>');return false;"><?php print $i; ?></a>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php if ($numactive > 2): ?>
                        <a class="page-1" href="#<?php print $paging_param ?>=1" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '1');return false;">First</a>

                        <?php for ($i = $numactive - 2; $i <= $numactive + 2; $i++): ?>
                            <?php if ($i < $count): ?>
                                <a class="page-<?php print $i; ?> <?php if ($numactive == $i): ?> active <?php endif; ?>" href="#<?php print $paging_param ?>=<?php print $i ?>" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '<?php print $i ?>');return false;"><?php print $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <a class="page-<?php print $i; ?> <?php if ($numactive == $i): ?> active <?php endif; ?>" href="#<?php print $paging_param ?>=<?php print $i ?>" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '<?php print $i ?>');return false;"><?php print $i; ?></a>
                        <?php endfor; ?>
                    <?php endif; ?>

                    <a class="page-<?php print $count; ?>" href="#<?php print $paging_param . '=' . ($count - 1); ?>" onclick="mw.url.windowHashParam('<?php print $paging_param ?>', '<?php print $count - 1; ?>');return false;"><?php _e("Last"); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
<?php else: ?>
    <div class="no-items-found products">
        <?php
        /*  if (isset($post_params['category-id'])) {
            $url = "#action=new:product&amp;category_id=" . $post_params['category-id'];
            } elseif (isset($post_params['category'])) {
            $url = "#action=new:product&amp;category_id=" . $post_params['category'];
            } else if (isset($post_params['parent'])) {
            $url = "#action=new:product&amp;parent_page=" . $post_params['parent'];
            } else {
            $url = "#action=new:product";
            } */
        $url = "#action=new:product";
        ?>

        <div class="row">
            <div class="col-12">
                <div class="no-items-box" style="background-image: url('<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/no_products.svg'); ">
                    <h4><?php _e('You don’t have any products'); ?></h4>
                    <p><?php _e('Create your first product right now.You are able to do that in very easy way!'); ?></p>
                    <br/>
                    <a href="<?php print$url; ?>" class="btn btn-primary btn-rounded"><?php _e('Create a Product'); ?></a>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                $('.js-hide-when-no-items').hide();
                //                    $('body > #mw-admin-container > .main').removeClass('show-sidebar-tree');
            });
        </script>
        <script>
            $(document).ready(function () {
                $('.manage-toobar').hide();
                $('.top-search').hide();
            });
        </script>
    </div>
        <script>
            $(document).ready(function () {
                $('.js-hide-when-no-items').hide()
                //                    $('body > #mw-admin-container > .main').removeClass('show-sidebar-tree');
            });
        </script>

        <script>
            $(document).ready(function () {
                $('.manage-toobar').hide();
                $('.top-search').hide();
            });
        </script>
    </div>
<?php endif; ?>



<style>
     div#pageloader {
          width: 100%;
          margin: 0 auto;
          text-align: center;
      }
      .pre_loader .logo
      {
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .pre_loader .logo img {
          max-height: 110px;
          margin-bottom: 10px;
      }
      .pre_loader .logo h2
      {
          font-weight: 900;
          margin: 0;
          font-size: 3rem;
          color: #0078d4;
      }
      .pre_loader .logo img
      {
          height: 5rem;
      }
      .pre_loader .progressbar
      {
          margin-top: 5px;
          height: 0.2rem;
          width: 10rem;
          background: #b3b3b3;
          margin: 0 auto !important;
      }
      .pre_loader .progressbar::after
      {
          content: "";
          width: 3rem;
          height: 0.2rem;
          background: #0078d4;
          display: block;
          border-radius: 0.5rem;
          animation: animation 1.5s cubic-bezier(0.65, 0.05, 0.36, 1) infinite;
      }
      .pre_loader p {
          margin-bottom: 10px;
      }
      .pre_loader h1
      {
          font-size: 1.5rem;
          color: #585858;
          position: absolute;
          bottom: 1rem;
          font-weight: 400;
      }
</style>


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
