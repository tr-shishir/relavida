<?php

/*

type: layout

name: Portfolio Posts

description: Skin 2

*/
?>

<?php 
if (CATEGORY_ID != false) {
    $cate = DB::table('categories')->where('id', CATEGORY_ID)->first();
    $cat_img = array(
        'rel_type'  => "categories",
        'rel_id' => $cate->id
    );
    $media_cat = get_pictures($cat_img);
}
if (!empty($data)) :
    $description_character_limit = 120;
    if(is_array($show_fields) && in_array('description', $show_fields)){
        $character_limit_of_description = get_option('data-character-limit', $params['id']);
        if(!empty($character_limit_of_description)){
            $description_character_limit = $character_limit_of_description;
        }
    }
    $title_character_limit = 200;
    if(is_array($show_fields) && in_array('title', $show_fields)){
        $character_limit_of_title = get_option('data-title-limit', $params['id']);
        if(!empty($character_limit_of_title)){
            $title_character_limit = $character_limit_of_title;
        }
    }
    $blog_category_header_ignore = (array)json_decode($GLOBALS['custom_blog_category_header_ignore']) ?? [];

    $showHeader = category_hide_or_show();

    if (is_admin()) { ?>
        <div class="row mb-3 header-blog-toggle">
            <div class="col-md-12">
                <div id="hide_blog" style="display:flex;align-items:center" class="<?php print $showHeader['button'] ?? ''; ?>">
                    <p style="margin-bottom:0px;margin-right:10px;">Category show in header :</p>
                    <input type="checkbox" data-toggle="toggle" data-size="mini" name="blog_cat_head" id="blog_cat_head" data-on="Off" data-off="On" value="<?php (in_array(PAGE_ID, $blog_category_header_ignore)) ? print 0 : print PAGE_ID; ?>" <?php (in_array(PAGE_ID, $blog_category_header_ignore)) ? print "checked" : ""; ?>>

                    </label>
                </div>
            </div>
        </div>

    <?php } ?>
    <?php if (CATEGORY_ID != false) : ?>
        <?php if ($cate->show_category == null || $cate->show_category == 0 || $cate->show_category == 1 || $cate->show_category == false) : ?>
            <module type="category-details" />
        <?php endif; ?>
    <?php endif; ?>

    <script>
        $('#blog_cat_head').change(function() {

            var blog_cat = $('#blog_cat_head').val();
            var page_id = <?= PAGE_ID ?>;
            console.log(blog_cat, page_id);

            $.post('<?= url('/') ?>/api/v1/not_show', {
                blog_cat: blog_cat,
                page_id: page_id
            }, (res) => {
                if ($(this).prop('checked')) {
                    mw.notification.success('Category off in header');
                    $('#blog_cat_head').val("0");
                    $('.header-cat').hide();

                } else {
                    mw.notification.success('Category on in header');
                    $('#blog_cat_head').val('<?= PAGE_ID ?>');
                    $('.header-cat').attr('style', 'display: block !important;');

                }
            });


        });
    </script>

    <div class="nk-portfolio-list nk-isotope nk-isotope-3-cols">
        <?php foreach ($data as $item) :
        $item = (array)$item;
        $post_time = strtotime(($item['created_at']));
        $current_time = strtotime((date("Y-m-d H:i:s")));
        if ($post_time <= $current_time) :
            $cats = content_categories($params['content_id']); ?>
            <div class="nk-isotope-item" itemscope itemtype="<?php print $schema_org_item_type_tag ?>">
                <div class="nk-portfolio-item nk-portfolio-item-square nk-portfolio-item-info-style-1">
                    <a href="<?php ($item['is_rss'] == 1) ? print $item['rss_link'] : print $item['link'] ?>" class="nk-portfolio-item-link" itemprop="url"></a>
                    <div class="nk-portfolio-item-image">
                        <?php if ($show_fields == false or in_array('thumbnail', $show_fields)) : ?>
                            <div style="background-image: url(<?php ($item['is_rss'] == 1) ? print $item['rss_image'] : print thumbnail($item['image'], $tn[0], $tn[1]); ?>);"></div>
                        <?php endif; ?>
                    </div>
                    <div class="nk-portfolio-item-info nk-portfolio-item-info-center text-xs-center">
                        <div>
                            <?php if ($show_fields == false or in_array('title', $show_fields)) : ?>
                                <?php $blog_titile =  character_limiter($item['title'], $title_character_limit); ?>
                                <h2 class="portfolio-item-title h3" itemprop="name"><?php print $blog_titile; ?></h2>
                            <?php endif; ?>

                            <?php if ($show_fields == false or in_array('price', $show_fields)) : ?>
                                <div class="portfolio-item-category">
                                    <strong>
                                        <?php if (isset($item['prices']) and is_array($item['prices'])) : ?>
                                            <?php
                                            $vals2 = array_values($item['prices']);
                                            $val1 = array_shift($vals2); ?>
                                            <span><?php print currency_format($val1); ?></span>
                                        <?php endif; ?>
                                    </strong>
                                </div>
                                <br />
                            <?php endif; ?>

                            <?php if ($show_fields == false or ($show_fields != false and is_array($show_fields) and in_array('description', $show_fields))) : ?>
                                <?php $blog_description =  character_limiter(strip_tags($item['content']), $description_character_limit); ?>
                                <div class="portfolio-item-category" itemprop="description"> <?php print $blog_description; ?> </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<input type="hidden" name="blog_category_status" id="blog_<?= PAGE_ID ?>" data-<?= PAGE_ID ?>="blog" value="<?= PAGE_ID ?>">
<?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)) : ?>
    <module type="pagination" template="bootstrap4" pages_count="<?php echo $pages_count; ?>" paging_param="<?php echo $paging_param; ?>" />
<?php endif; ?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cate->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>

</div>