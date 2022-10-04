<?php

/*

type: layout

name: Portfolio

description: Portfolio items

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
<div class="masonry-grid-works js-masonry-grid-works">
    <div class="masonry-grid-works__sizer masonry-grid-works__sizer_w-33 js-masonry-grid-works__sizer"></div>
    <?php if (!empty($data)) : ?>
        <?php
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
        ?>
        <?php foreach ($data as $item) :
            $item = (array)$item;
            $post_time = strtotime(($item['created_at']));
            $current_time = strtotime((date("Y-m-d H:i:s")));
            if ($post_time <= $current_time) :
            $categories = get_categories_for_content($item['content_id']);
            $filterCats = '';
            if ($categories) {
                foreach ($categories as $category) {
                    $filterCats .= 'js-masonry-grid-works__item_' . $category['id'] . ' ';
                }
            }
        ?>

            <div class="masonry-grid-works__item masonry-grid-works__item_w-33 js-masonry-grid-works__item <?php print $filterCats; ?>" itemscope itemtype="<?php print $schema_org_item_type_tag ?>">
                <a class="image-link" href="<?php ($item['is_rss'] == 1) ? print $item['rss_link'] : print $item['link'] ?>" itemprop="url" title="<?php print $item['title'] ?>">
                    <figure class="image-holder">
                        <?php if (!isset($show_fields) or $show_fields == false or in_array('thumbnail', $show_fields)) : ?>
                            <img class="image-holder__img" src="<?php ($item['is_rss'] == 1) ? print $item['rss_image'] : print thumbnail($item['image'], 450, 450); ?>" alt="" /><i class="image-holder__icon"></i>
                        <?php endif; ?>

                        <figcaption class="image-holder__descr">
                            <?php if (!isset($show_fields) or $show_fields == false or in_array('title', $show_fields)) : ?>
                                <?php $blog_titile =  character_limiter($item['title'], $title_character_limit); ?>
                                <h3 class="image-holder__heading"><?php print $blog_titile; ?></h3>
                            <?php endif; ?>
                            <?php if (!isset($show_fields) or $show_fields == false or in_array('description', $show_fields)) : ?>
                                <?php $blog_description =  character_limiter(strip_tags($item['content']), $description_character_limit); ?>
                                <p class="image-holder__description" itemprop="description"><?php print $blog_description; ?></p>
                            <?php endif; ?>
                        </figcaption>
                    </figure>
                </a>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<input type="hidden" name="blog_category_status" id="blog_<?= PAGE_ID ?>" data-<?= PAGE_ID ?>="blog" value="<?= PAGE_ID ?>">

<?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)) : ?>
    <?php print paging("num={$pages_count}&paging_param={$paging_param}&current_page={$current_page}") ?>
<?php endif; ?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cate->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>