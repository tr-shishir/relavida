<?php include template_dir() . "header.php"; ?>

<?php
$cats = content_categories(CONTENT_ID);

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
<style>
    .dt_rss_img {
        height: 700px;
        width: auto;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
</style>
<div id="blog-content-<?php print CONTENT_ID; ?>" class="blog-inner-main">
<module type="breadcrumb" />

<?php
    $rssfound = false;
    $post = get_content_by_id(CONTENT_ID);


    if (!($post)) {

        if (CONTENT_ID == 'rss-notfound') {
            $post = [];
        } else {

            $rssItem = rss_single();

            // dd($rssItem);

            $id = explode('-', CONTENT_ID);
            $rssid = end($id);

            // dd($rssid);


            foreach ($rssItem as $item) {
                if ($rssid == $item['id']) {

                    $post = [
                        "id" =>  $item['id'],

                        "subtype" => $item['subtype'],
                        "url" => $item['slug'],
                        "title" => $item['title'],
                        "parent" => $item['parent'],
                        "description" =>  $item['description'],
                        "content" => $item['description'],
                        "created_at" => $item['created_at'],
                        "posted_at" => $item['created_at'],
                        "categories" => $item['category'],
                        "media" =>  [

                            "created_at" => $item['created_at'],

                            "filename" => $item['image'],

                        ],
                    ];
                    $rssfound = true;
                }
            }
        }
    }
    ?>

    <!-- START: Header Title -->
    <div class="nk-header-title nk-header-title-lg">
        <div class="bg-image blog-inner-image">
        <?php if ($rssfound) { ?>
            <?php if(isset($post['media']['filename'])): ?>
                <div class="dt_rss_img" style="background-image: url('<?php print thumbnail($post['media']['filename'], 1200, 700, true); ?>')"></div>
            <?php endif; ?>
        <?php }else{ ?>
            <div style="background-image: url(<?php print thumbnail(get_picture(CONTENT_ID), 1920, 1920); ?>);"></div>
        <?php } ?>
        </div>
        <div class="nk-header-table">
            <div class="nk-header-table-cell">
                <div class="container">
                    <!--                    <module data-type="pictures" data-template="slider" rel="content"/>-->

                </div>
            </div>
        </div>

    </div>

    <!-- END: Header Title -->


    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="nk-gap-4"></div>

                <!-- START: Post -->
                <div class="nk-blog-post nk-blog-post-single">
                <?php if ($rssfound) { ?>
                    <h1>
                    <?=$post['title']?>
                    </h1>
                    <?php }else{ ?>
                    <h1 class="edit display-4" field="title" rel="content">Why you should Always First</h1>
                    <?php } ?>

                    <div class="nk-post-meta">
                        <div class="nk-post-date">August 14, 2016</div>
                        <div class="nk-post-category">
                            <?php if ($postCats): ?>
                                <?php foreach ($postCats as $cat): ?>
                                    <a href="<?php print $cat['url']; ?>">[ <?php print $cat['title']; ?> ]</a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($post['content']){ ?>
                        <!-- START: Post Text -->
                        <div class="nk-post-text">
                            <div class="<?php if(is_logged() == true){ ?>edit<?php } ?>" field="content" rel="content">
                                <?php if(is_logged() != true){ ?>
                                    <p><?php print $post['content']; ?></p>
                                <?php }else{ ?>
                                    <?php if ($rssfound) {
                                        print $post['content'];
                                    } else {?>
                                <p align="justify">This text is set by default and is suitable for edit in real time. By default the drag and drop core feature will allow you to position it anywhere on
                                    the site. Get creative, Make Web.</p>
                                <?php } }?>
                            </div>
                        </div>
                        <!-- END: Post Text -->
                    <?php } ?>

                    <!-- END: Post Share -->
                </div>
                <!-- END: Post -->

                <div class="nk-gap-3"></div>
            </div>
        </div>
    </div>

    <div class="edit" rel="content" field="comments">
        <module data-type="comments" data-template="default" data-content-id="<?php print CONTENT_ID; ?>"/>
    </div>

    <!-- START: Pagination -->
    <div class="nk-pagination nk-pagination-center">
        <div class="container">
            <?php if ($content = next_content()): ?>
                <a class="nk-pagination-prev" href="<?php print content_link($content['id']); ?>">
                    <span class="pe-7s-angle-left"></span>
                    <?php print $content['title']; ?>
                </a>
            <?php endif; ?>
            <a class="nk-pagination-center" href="<?php print page_link(); ?>">
                <span class="nk-icon-squares"></span>
            </a>
            <?php if ($content = prev_content()): ?>
                <a class="nk-pagination-next" href="<?php print content_link($content['id']); ?>">
                    <?php print $content['title']; ?>
                    <span class="pe-7s-angle-right"></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- END: Pagination -->
</div>

<?php include template_dir() . "footer.php"; ?>
