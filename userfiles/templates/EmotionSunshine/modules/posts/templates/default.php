<?php

/*

type: layout

name: Default

description: Grid Columns

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
$columns = get_option('columns', $params['id']);
if ($columns === null or $columns === false or $columns == '') {
    $columns = 'col-12 col-md-4 col-lg-3';
}

$columns_xl = get_option('columns-xl', $params['id']);
$thumb_quality = '1920';
if ($columns_xl != null or $columns_xl != false or $columns_xl != '') {
    if ($columns_xl == 'col-xl-12') {
        $thumbs_columns = 1;
    } else if ($columns_xl == 'col-xl-6') {
        $thumbs_columns = 2;
    } else if ($columns_xl == 'col-xl-4') {
        $thumbs_columns = 3;
    } else if ($columns_xl == 'col-xl-3') {
        $thumbs_columns = 4;
    } else if ($columns_xl == 'col-xl-2') {
        $thumbs_columns = 6;
    }

    $thumb_quality = 1920 / $thumbs_columns;
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
<?php
?>
<div class="row blog-posts">
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
        ?>
                <div class="m-b-40 col-12 col-md-6 col-lg-4 col-xl-4" itemscope itemtype="<?php print $schema_org_item_type_tag ?>">
                    <a href="<?php ($item['is_rss'] == 1) ? print $item['rss_link'] : print $item['link'] ?>" itemprop="url">
                        <div class="post">
                            <?php if (!isset($show_fields) or $show_fields == false or in_array('thumbnail', $show_fields)) : ?>
                                <div class="image" style="background-image: url('<?php ($item['is_rss'] == 1) ? print $item['rss_image'] : print thumbnail($item['image'], $thumb_quality, $thumb_quality, true); ?>');"></div>
                            <?php endif; ?>
                            <div class="description">
                                <?php
                                $cats = content_categories($item['content_id']);

                                $postCats = array();
                                if ($cats) {
                                    foreach ($cats as $cat) {
                                        $postCats[] = array(
                                            'title' => $cat['title'],
                                            'url' => category_link($cat['id'])
                                        );
                                    }
                                }
                                ?>

                                <?php if ($postCats) : ?>
                                    <p class="cats" style="display:none;">
                                        .<?php foreach ($postCats as $cat) : ?>&nbsp;<?php print $cat['title']; ?> .<?php endforeach; ?>
                                    </p>
                                <?php endif; ?>

                                <?php if (!isset($show_fields) or $show_fields == false or in_array('title', $show_fields)) : ?>
                                    <div class="blog-post-title">
                                        <?php $blog_titile =  character_limiter($item['title'], $title_character_limit); ?>
                                        <h3><?php print $blog_titile; ?></h3>
                                    </div>
                                <?php endif; ?>
                                <?php if (!isset($show_fields) or $show_fields == false or in_array('created_at', $show_fields)) : ?>
                                    <small class="blog-date"><?php echo date('d M Y', strtotime($item['created_at'])); ?></small>
                                <?php endif; ?>
                                <?php if (!isset($show_fields) or $show_fields == false or in_array('description', $show_fields)) : ?>
                                    <?php $blog_description =  character_limiter(strip_tags($item['content']), $description_character_limit); ?>
                                    <p><?php print $blog_description; ?></p>
                                <?php endif; ?>
                                <?php if (!isset($show_fields) or $show_fields == false or in_array('read_more', $show_fields)) : ?>
                                    <a href="<?php ($item['is_rss'] == 1) ? print $item['rss_link'] : print $item['link'] ?>" itemprop="url" class="blog-read-more-text"><span><?php (get_option('data-read-more-text') != null) ? print get_option('data-read-more-text') : print "Bericht lesen" ?></span></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<input type="hidden" name="blog_category_status" id="blog_<?= PAGE_ID ?>" data-<?= PAGE_ID ?>="blog" value="<?= PAGE_ID ?>">
<?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)) : ?>
    <module type="pagination" template="bootstrap4" pages_count="<?php echo $pages_count; ?>" paging_param="<?php echo $paging_param; ?>" />
<?php endif; ?>
<?php if (CATEGORY_ID != false) : ?>
    <?php if ($cate->show_category == 2) : ?>
        <module type="category-details" />
    <?php endif; ?>
<?php endif; ?>