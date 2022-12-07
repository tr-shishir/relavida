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
<!-- http://localhost/performance/5a3edecd-b93b-42e9-9707-5a079d3891ce/api/module?
id=module-layouts-148058--1-shop-productsv2
&data-mw-title=Products
&hide_paging=true
&limit=6
&col_count=3
&data-type=shop%2Fproductsv2%2Fadmin
&parent-module-id=module-layouts-148058--1
&parent-module=layouts
&type=shop%2Fproductsv2%2Fadmin
&live_edit=true
&module_settings=true
&view=admin
&from_url=http%3A%2F%2Flocalhost%2Fperformance%2F5a3edecd-b93b-42e9-9707-5a079d3891ce%2Fshopv2 -->
<?php 

$settings = getProductModuleSettings($params['id']);
$limitOfProduct = $settings['content_limit_for_live_edit_module']->value ?? 50;
$data = $data = App\Models\Product::with(['media', 'tagged', 'categories'])->limit($limitOfProduct)->get()
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
        </script>
        <?php

    }
    ?>
    <div class="manage-posts-holder" id="mw_admin_posts_sortable">
        <div class="manage-posts-holder-inner muted-cards">

            <?php
            $edit_text = _e('Edit', true);
            $delete_text = _e('Delete', true);
            $live_edit_text = _e('Live Edit', true);
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
                    <?php if (isset($item['id'])):
                        $hasSubscription = false;
                        if(isset($item['content_type']) && $item['content_type'] == 'product'){
                            $hasSub = DB::table('subscription_status')->where('product_id', $item['id'])->first();
                            if(isset($hasSub) && !empty($hasSub)) $hasSubscription = true;
                        }
                        $pub_class = '';
                        $append = '';
                        if (isset($item['is_active']) and $item['is_active'] == '0') {
                            $pub_class = ' content-unpublished';
                            $append = '<div class="post-unpublished d-inline-flex align-items-center justify-content-center"><a href="javascript:;" class="btn btn-sm btn-link" onclick="mw.post.set(' . $item['id'] . ', \'publish\');">' . _e("Publish", true) . '</a> <span class="badge badge-warning">' . _e("Unpublished", true) . '</span></div>';
                        }
                        $content_link = (isset($item['product']))?$item['url']:content_link($item['id']);
                        ?>
                        <?php $pic = (isset($item['product']))?$item['media']??$item['image']:$item['image']??get_picture($item['id']); ?>
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
                                        $type = $item['content_type'];
                                        $type_icon = 'mdi-text';
                                        if ($type == 'product') {
                                            $type_icon = 'mdi-shopping';
                                        } elseif ($type == 'post') {
                                            $post_image_url = db_get('table=media&rel_id=0&title='.'live_screenshot-'.$item['id'].'&single=true');
                                            if($post_image_url){
                                                $pic = $post_image_url['filename'];
                                            }
                                            $type_icon = 'mdi-text';
                                        } elseif ($type == 'page') {
                                            $page_image_url = db_get('table=media&rel_id=0&title='.'live_screenshot-'.$item['id'].'&single=true');
                                            if($page_image_url){
                                                $pic = $page_image_url['filename'];
                                            }
                                            $type_icon = 'mdi-file-document';
                                        }
                                        ?>

                                        <!-- <?php //if ($pic == true) :
                                                ?>
                                            <div class="position-absolute text-muted" style="z-index: 1; right: -5px; top: -10px;">
                                                <i class="mdi <?php //echo $type_icon;
                                                                ?> mdi-18px" data-toggle="tooltip" title="<?php //ucfirst($type);
                                                                                                            ?>"></i>
                                            </div>
                                        <?php //endif;

                                        ?>
                                        ?> -->

                                        <div class="img-circle-holder border-radius-0 border-0">

                                            <?php if ($pic == true): ?>
                                                <a href="javascript:;" onClick="mw.url.windowHashParam('action', 'editpage:<?php print ($item['id']) ?>');return false;">
                                                    <img src="<?php print thumbnail($pic, 120, 120, true) ; ?>"/>
                                                </a>
                                            <?php else : ?>
                                                <a href="javascript:;" onclick="mw.url.windowHashParam('action', 'editpage:<?php print ($item['id']) ?>');return false;">
                                                    <i class="mdi <?php echo $type_icon; ?> mdi-48px text-muted text-opacity-5"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="screnshot-icon">
                                            <?php if($item['content_type'] == 'page' or $item['content_type'] == 'post'): ?>
                                                <i class="fa fa-camera page-screenshot-tooltip" onclick=page_screenshot<?php print $item['id']; ?>(); data-toggle="tooltip" data-placement="top" title="<?php _e('If you click here,then this page screenshot will generating') ?>" > </i>

                                                <script>
                                                    $(function () {
                                                        $('.page-screenshot-tooltip').tooltip();
                                                    });
                                                    function page_screenshot<?php print $item['id']; ?>(){
                                                        $("#page_screenshot").show();
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?=api_url('generate_page_screenshot')?>",
                                                            data:{ Page_id : '<?php print $item['id']; ?>'},
                                                            success: function(response) {
                                                                $("#page_screenshot").hide();
                                                                location.reload();
                                                                // mw.notification.success('Successfully Generate Screenshot ');
                                                            },
                                                            error: function(response){
                                                                $("#page_screenshot").hide();
                                                                mw.notification.error('Screenshot did  not Generating');
                                                            }
                                                        });
                                                    }
                                                </script>
                                            <?php endif; ?>
                                        </div>
                                        <?php $edit_link = admin_url('view:content#action=editpage:' . $item['id']); ?>
                                        <?php $edit_link_front = $content_link . '?editmode:y'; ?>
                                    </div>

                                    <div class="col item-title manage-post-item-col-3 manage-post-main">
                                        <div class="manage-item-main-top">
                                            <a target="_top" href="<?php print $edit_link_front; ?>" class="btn btn-link p-0">
                                                <h5 class="text-dark text-break-line-1 mb-0 manage-post-item-title"><?php print strip_tags($item['title']) ?></h5>
                                            </a>
                                            <?php mw()->event_manager->trigger('module.content.manager.item.title', $item) ?>

                                            <?php $cats = (isset($item['product']))?$item['categories']:content_categories($item['id']); ?>
                                            <?php $tags = (isset($item['product']))?$item['tagged']:content_tags($item['id'], false); ?>
                                            <?php if ($cats): ?>
                                                <span class="manage-post-item-cats-inline-list">
                                                    <?php foreach ($cats as $ck => $cat): ?>


                                                        <a href="#action=showpostscat:<?=$cat['id']??0;?>" class="btn btn-link p-0 text-muted"><?php if(isset($cat['title'])){ print $cat['title']; } ?></a><?php if (isset($cats[$ck + 1])): ?>,<?php endif; ?>
                                                    <?php endforeach; ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($tags): ?>
                                                <br/>
                                                <?php foreach ($tags as $tag): ?>
                                                    <small class="bg-secondary rounded-lg px-2">#<?php echo (isset($item['product']))?$tag['tag_name']:$tag; ?></small>
                                                <?php endforeach; ?>
                                            <?php endif; ?>


                                            <a class="manage-post-item-link-small mw-medium d-none d-lg-block" target="_top" href="<?php print $content_link; ?>?editmode:y">
                                                <small class="text-muted"><?php print $content_link; ?></small>
                                            </a>
                                        </div>

                                        <div class="manage-post-item-links">
                                            <?php
                                            if (user_can_access('module.content.edit')):
                                                ?>
                                                <a target="_top" class="btn btn-outline-success btn-sm" href="<?php print $edit_link ?>" onclick="javascript:mw.url.windowHashParam('action', 'editpage:<?php print ($item['id']) ?>');
                                                    return false;">
                                                    <?php echo $edit_text; ?>
                                                </a>
                                            <?php
                                            endif;
                                            ?>

                                            <?php
                                            $hide_delete = hide_delete() ?? [];
                                            $tk_url = explode('/',$item['url']);
                                            if (user_can_access('module.content.destroy')):
                                                if(!in_array(end($tk_url) , $hide_delete)){
                                                if($item['content_type'] == 'product' && $hasSubscription){ ?>
                                                    <a class="btn btn-outline-danger btn-sm" href="javascript:delete_subscription_single_post('<?php print ($item['id']) ?>');">
                                                        <?php echo $delete_text; ?>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a class="btn btn-outline-danger btn-sm" href="javascript:mw.delete_single_post('<?php print ($item['id']) ?>');">
                                                        <?php echo $delete_text; ?>
                                                    </a>
                                                <?php }}
                                            endif; ?>
                                            <?php if($item['content_type'] == 'page'): ?>
                                                <?php if($item['layout_file'] == 'layouts__thank_you.php'): ?>
                                                    <a target="_top" class="btn btn-outline-success btn-sm"  onclick="thank_you_clone('<?php print ($item['id']) ?>')"><?php _e('Clone'); ?></a>
                                                <?php else: ?>
                                                    <a target="_top" class="btn btn-outline-success btn-sm"  onclick="clonePage('<?php print ($item['id']) ?>')"><?php _e('Clone'); ?></a>
                                                <?php endif; ?>
                                                <?php
                                                $tempv = DB::table('header_show_hides')->where('page_id',$item['id'])->get();
                                                if($tempv->count() > 0){
                                                    $showvalue = $tempv[0]->page_id;
                                                }
                                                else{
                                                    $showvalue = 0;
                                                }
                                                ?>
                                                <?php if( $item['url'] == url('/').'/home' ): ?>

                                                <?php elseif( $showvalue == $item['id']):  ?>
                                                    <input type="checkbox" checked id="<?php print $item['id']; ?>" class="header-checkbox">
                                                    <div class="headercheck-tt">
                                                        <p>If you turn on this button then the header will be hidden from that page.</p>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="checkbox" id="<?php print $item['id']; ?>" class="header-checkbox">
                                                    <div class="headercheck-tt">
                                                        <p>If you turn on this button then the header will be hidden from that page.</p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <script>

                                        $('#<?php print $item['id']; ?>').click(function() {
                                            if($('#<?php print $item['id']; ?>').is(':checked')){
                                                console.log('<?php print $item['id']; ?>');
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?=api_url('headerShow')?>",
                                                    data:{ id : '<?php print $item['id']; ?>'},
                                                    success: function(response) {
                                                        console.log(response.message);
                                                    },
                                                    error: function(response){
                                                        console.log(response.responseJSON.message);
                                                    }
                                                });

                                            }
                                            else{
                                                console.log('<?php print $item['id']; ?>');
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?=api_url('headerHide')?>",
                                                    data:{ id : '<?php print $item['id']; ?>'},
                                                    success: function(response) {
                                                        console.log(response.message);
                                                    },
                                                    error: function(response){
                                                        console.log(response.responseJSON.message);
                                                    }
                                                });

                                            }
                                        });

                                        function clonePage(temp){
                                            mw.tools.confirm("<?php _ejs("Do you want to clone this page"); ?>?", function () {
                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?=api_url('clonePage')?>",
                                                    data:{ clonePageId : temp},
                                                    success: function(response) {
                                                        // console.log(response.message['newPageId']);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?=api_url('clonePageContentSave')?>",
                                                            data:{ newPageId : response.message['newPageId'],oldPageId : response.message['oldPageId']},
                                                            success: function(response) {
                                                                // console.log(response.message);
                                                                $.post( mw.settings.api_url + 'mw_post_update' );
                                                                window.location.href = "<?=url('/')?>/admin/view:content/action:pages#action=editpage:"+response.message;
                                                            },
                                                            error: function(response){
                                                                console.log(response.responseJSON.message);
                                                            }
                                                        });
                                                        // window.location.href = "<?=url('/')?>/admin/view:content/action:pages#action=editpage:"+response.message['newPageId'];
                                                    },
                                                    error: function(response){
                                                        console.log(response.responseJSON.message);
                                                    }
                                                });
                                            });
                                        }

                                    </script>
                                       <div class="item-author manage-post-item-col-4">
                                            <!-- <?php // if(in_array($item['id'],$p_ids_hide)) { ?>
                                                <span class="cat-hide-product-icon">

                                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>

                                                    <p class="cat-hide-product-icon-text">
                                                        The category of this product is hidden from the shop.
                                                    </p>
                                                </span>
                                            <?php // } ?> -->
                                        <span class="text-muted" title="<?php print user_name($item['created_by']); ?>"><?php print user_name($item['created_by'], 'username') ?></span>
                                    </div>

                                    <?php if(isset($item['content_type']) and $item['content_type'] == "post") : ?>
                                        <div class="col manage-post-item-col-5" style="max-width: 130px;">
                                            <?php if (isset($item['is_active']) AND $item['is_active'] == 1): ?>

                                                <?php
                                                $post_time = strtotime(($item['created_at']));
                                                $current_time = strtotime((date("Y-m-d H:i:s")));
                                                if($post_time >= $current_time) :?>
                                                    <span class="badge badge-dark font-weight-normal"><?php _e('Future Published'); ?></span>
                                                <?php else: ?>
                                                    <a href="javascript:void"><span class="badge badge-success font-weight-normal"  onclick="unPublished(<?php echo $item['id']; ?>)"><?php _e('Published'); ?></span></a>
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <a href="javascript:void"><span class="badge badge-warning font-weight-normal" onclick="published(<?php echo $item['id']; ?>)"><?php _e('Unpublished'); ?></span></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif(isset($item['content_type']) and $item['content_type'] == "page") : ?>
                                        <div class="col manage-post-item-col-5" style="max-width: 130px;">
                                            <?php
                                            $hide_delete = hide_delete() ?? [];
                                            $url_un = explode('/',$item['url']);
                                            $status = 0;
                                            if(!in_array(end($url_un) , $hide_delete)){
                                                $status = 1;
                                            } ?>
                                            <?php if (isset($item['is_active']) AND $item['is_active'] == 1): ?>
                                                <a href="javascript:void"><span class="badge badge-success font-weight-normal" onclick="unPublishedPage(<?php echo $item['id']; ?>, <?php echo $status; ?>)"><?php _e('Published'); ?></span></a>
                                            <?php else: ?>
                                                <a href="javascript:void"><span class="badge badge-warning font-weight-normal" onclick="publishedPage(<?php echo $item['id']; ?>)"><?php _e('Unpublished'); ?></span></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>


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
        <script>
            var thank_you_page_id = null;
            function thank_you_clone(page_id){
                thank_you_page_id = page_id;
                $.ajax({
                    type: "POST",
                    url: "<?=api_url('thank_you_page_check') ?>",
                    data:{page_id},
                    success:function(response){
                        if(response.message){
                            $('#thank_you_page_clone_modal-id').show();
                        }else{
                            mw.notification.error("Primary Thank you page is already cloned. You can't clone another one.");
                        }
                    }
                });
            }
            function save_thank_you_clone_page(){
                all_tags = $('#tags').val();
                console.log(thank_you_page_id);
                if(all_tags){
                    $.ajax({
                        type: "POST",
                        url: "<?=api_url('thank_you_save_tag_check')?>",
                        data: {all_tags},
                        success: function(response){
                            common_tags = response.message;
                            if(common_tags.length){
                                mw.notification.error(common_tags + " tag(s) is already in use in existing cloned Thank you page. You can't clone anymore Thank you page containing these tag(s).");
                            }else{
                                thank_you_page_clone();
                            }
                        },
                    });
                }else{
                    mw.notification.error("You must add minimum one tag to clone Thank you page.");
                }
            }
            function thank_you_page_clone(){
                $('#thank_you_page_clone_modal-id').hide();
                $.ajax({
                    type: "POST",
                    url: "<?=api_url('clonePage')?>",
                    data:{ clonePageId : thank_you_page_id},
                    success: function(response) {
                        $.ajax({
                            type: "POST",
                            url: "<?=api_url('clonePageContentSave')?>",
                            data:{ newPageId : response.message['newPageId'],oldPageId : response.message['oldPageId']},
                            success: function(response) {
                                $.ajax({
                                    type: "POST",
                                    url: "<?=api_url('thank_you_page_tags_save') ?>",
                                    data:{new_page_id : response.message, all_tags:  all_tags}
                                });
                                $.post( mw.settings.api_url + 'mw_post_update' );

                                window.location.href = "<?=url('/')?>/admin/view:content/action:pages#action=editpage:"+response.message;
                            },
                            error: function(response){
                                console.log(response.responseJSON.message);
                            }
                        });
                    },
                    error: function(response){
                        console.log(response.responseJSON.message);
                    }
                });
            }

            function hide_thank_you_page_clone_modal(){
                $('#thank_you_page_clone_modal-id').hide();
            }
        </script>
        <?php if(isset($params['content_type']) && $params['content_type'] == 'product'): ?>
        <?php else: ?>
            <!-- thank you page clone modal -->
            <div class="modal" id="thank_you_page_clone_modal-id" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php _e('You create a copy of your thank you page that customers will see after successful order'); ?></h5>
                    </div>
                    <div class="modal-body">
                        <h4><?php _e('Please add a tag(s)'); ?></h4>
                        <module type="content/views/content_tags" content-type="page" content-id="0"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="hide_thank_you_page_clone_modal()" data-dismiss="modal"><?php _e('Close'); ?></button>
                        <button type="button" class="btn btn-primary" onclick="save_thank_you_clone_page()"><?php _e('Save'); ?></button>
                    </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <script>

            function unPublished(id){
                mw.tools.confirm("<?php _ejs("Do you want to unpublish this content"); ?>?", function () {
                    $.post("<?=api_url('unpublished')?>",{
                    id: id
                    }).then((res, err) => {
                        console.log(res, err);
                    });
                    mw.notification.success("<?php _e('Content is unpublished sucessfully'); ?>");
                    mw.clear_cache();
                    location.reload();
                });
            }

            function published(id){
                mw.tools.confirm("<?php _ejs("Do you want to publish this content"); ?>?", function () {
                    $.post("<?=api_url('published')?>",{
                    id: id
                    }).then((res, err) => {
                        console.log(res, err);
                    });
                    mw.notification.success("<?php _e('Content is published sucessfully'); ?>");
                    mw.clear_cache();
                    location.reload();
            });
            }


            function unPublishedPage(id, status){
                if(status == 1){
                    mw.tools.confirm("<?php _ejs("Do you want to unpublish this page"); ?>?", function () {
                        $.post("<?=api_url('unpublishedPage')?>",{
                        id: id
                        }).then((res, err) => {
                            console.log(res, err);
                        });
                        mw.notification.success("<?php _e('Page is unpublished sucessfully'); ?>");
                        mw.clear_cache();
                        location.reload();
                    });
                } else{
                    mw.tools.confirm("<?php _ejs("This is a default page so you can't unpublish this page."); ?>", function () {
                    });

                }
            }


            function publishedPage(id)
            {
                mw.tools.confirm("<?php _ejs("Do you want to publish this page"); ?>?", function () {
                $.post("<?=api_url('publishedPage')?>",{
                    id: id
                }).then((res, err) => {
                    console.log(res, err);
                });
                mw.notification.success("<?php _e('Page is published sucessfully'); ?>");
                mw.clear_cache();
                location.reload();
                });
            }
        </script>

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
    <?php
    $page_is_shop = false;
    if (isset($post_params["page-id"])) {
        $page_is_shop_check = get_content_by_id($post_params["page-id"]);
        if (isset($page_is_shop_check['is_shop']) and $page_is_shop_check['is_shop'] == 1) {
            $page_is_shop = true;
        }
    }

    if ((isset($post_params['content_type']) and $post_params['content_type'] == 'product') or (isset($params['content_type']) and $params['content_type'] == 'product') or $page_is_shop) :
        ?>
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
    <?php else: ?>
        <div class="no-items-found posts">
            <?php $url = "#action=new:post"; ?>

            <?php if (isset($post_params['content_type']) AND $post_params['content_type'] == 'page'): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="no-items-box" style="background-image: url('<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/no_pages.svg');">
                            <h4><?php _e('You don’t have pages'); ?></h4>
                            <p><?php _e('Create your first page right now.
                                You are able to do that in very easy way!'); ?></p>
                            <br/>
                            <a href="<?php print admin_url() . 'view:content#action=new:page'; ?>" class="btn btn-primary btn-rounded"><?php _e('Create a Page'); ?></a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="no-items-box" style="background-image: url('<?php print modules_url(); ?>microweber/api/libs/mw-ui/assets/img/no_content.svg'); ">
                            <h4><?php _e('You don’t have any posts yet'); ?></h4>
                            <p><?php _e('Create your first post right now.You are able to do that in very easy way!'); ?></p>
                            <br/>
                            <a href="<?php print$url; ?>" class="btn btn-primary btn-rounded"><?php _e('Create a Post'); ?></a>
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
                        </div>
                    </div>
                </div>
            <?php endif; ?>

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

<!-- start template install pageloader modal -->
<div class="modal" id="page_screenshot" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="pre_loader" id="pageloader" >
                    <div class="logo">
                        <img src="<?php print modules_url(); ?>/content/views/page_preloader.gif" alt="prelaoder">
                    </div>
                    <p><?php _e('Generating Page Screenshot'); ?></p>
                    <div class="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end template install pageloader modal -->

<script>
    function delete_subscription_single_post(id) {
        mw.tools.confirm("<?php _ejs("Attention: This is a subscription product. By deleting it, you will lose all recurring revenue. Do you want to proceed with the deletion? If yes, customers will be notified by email accordingly."); ?>", function () {
            var arr = id;
			$.post("<?=api_url('delete_product_info')?>", {
                id:id
            }).then((res, err) => {
            // console.log(res, err);
            });
            // return;
            mw.post.del(arr, function () {
                mw.$(".manage-post-item-" + id).fadeOut(function () {
                    $(this).remove()
                });
            });
            $.post("<?=api_url('delete_subscription_product_if_has')?>", {
                id:id
            }).then((res, err) => {
                //console.log(res, err);
            });
        });
    }
</script>
