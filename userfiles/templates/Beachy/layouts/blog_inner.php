<?php include template_dir() . "header.php"; ?>
<style>
    .dt_rss_img {
        height: 700px;
        width: auto;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
</style>
<div class="main-content blog-inner-main" id="blog-content-<?php print CONTENT_ID; ?>">
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
    <?php
$picture = get_picture(CONTENT_ID);

if (!$picture) {
    $picture = '';
}
if(isset($post['id'])){
    $itemData = content_data($post['id']);
    $itemTags = content_tags($post['id']);
}
?>

    <?php if ($picture != '' AND $picture != false): ?>
    <section class="section-19">
        <div class="container">
            <module type="breadcrumb"/>
            <module type="pictures" content-id="<?php print CONTENT_ID; ?>" template="blog" />

            <?php /*


             <div class="background-image-holder d-flex" style="background-image: url('<?php print $picture; ?>');">


            <div class="row w-100 m-0 align-self-center">
                <div class="col-lg-12">
                    <div class="d-flex w-100 h-100">
                        <div class="w-100 align-self-center info-holder text-white">
                            <h1 class="m-b-30"><?php echo $post['title']; ?></h1>
                            <h5><?php echo date('d M Y', strtotime($post['updated_at'])); ?></h5>
                        </div>
                    </div>
                </div>*/ ?>
            </div>
        </div>
</div>
</section>
<?php else: ?>
    <section class="section-19">
        <div class="container">
            <?php if(isset($post['media']['filename'])): ?>
                <div class="dt_rss_img" style="background-image: url('<?php print thumbnail($post['media']['filename'], 1200, 700, true); ?>')"></div>
            <?php endif; ?>
        </div>
    </section>
<?php /*
            <section class="section-19">
                <div class="container">
                    <div class="text-holder d-flex bg-silver">
                        <div class="row w-100 m-0 align-self-center">
                            <div class="col-lg-12">
                                <div class="d-flex w-100 h-100">
                                    <div class="w-100 align-self-center info-holder">
                                        <h1 class="m-b-30 text-dark"><?php echo $post['title']; ?></h1>
<h5 class="text-primary"><?php echo date('d M Y', strtotime($post['updated_at'])); ?></h5>
</div>
</div>
</div>
</div>
</div>
</div>
</section>*/ ?>
<?php endif; ?>


<div class="blog-inner-page" id="blog-content-<?php print CONTENT_ID; ?>">

    <div class="container m-t-30 m-b-50">
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="text-holder text-start pb-4">
                    <h1 class="m-b-30 text-dark edit plain-text" field="title" rel="content">
                    <?php if ($rssfound) {
                            print $post['title'];
                        } else {
                            print content_title();
                        } ?></h1>
                </div>
                <?php if($post['content']){ ?>
                    <div class="description <?php if(is_logged() == true){ ?>edit<?php } ?> dropcap typography-area" field="content" rel="content">
                        <?php if(is_logged() != true){ ?>
                            <p><?php print $post['content']; ?></p>
                        <?php }else { if ($rssfound) {
                                print $post['content'];
                            }else{
                        ?>
                        <?php

                            //include(template_dir() . 'elements' . DS . 'paragraph-highlight.php');
                            //include(template_dir() . 'elements' . DS . 'paragraph-lead.php');
                            include(template_dir() . 'elements' . DS . 'paragraph.php');
                            //include(template_dir() . 'elements' . DS . 'titles' . DS . 'title-2.php');
                            //include(template_dir() . 'elements' . DS . 'paragraph.php');
                            //include(template_dir() . 'elements' . DS . 'blockquote.php');
                            //include(template_dir() . 'elements' . DS . 'titles' . DS . 'title-3.php');
                            //include(template_dir() . 'elements' . DS . 'paragraph.php');
                            // include(template_dir() . 'elements' . DS . 'ordered-list.php');
                            //include(template_dir() . 'elements' . DS . 'paragraph.php');
                            //include(template_dir() . 'elements' . DS . 'unordered-list.php');
                            ?>
                        <?php } } ?>
                    </div>
                <?php } ?>

                <div class="text-right m-b-20">
                    <h6 class="text-dark"><?php echo date('d M Y', strtotime($post['created_at'])); ?></h6>
                </div>

                <div class="">
                    <div class="m-t-40 m-b-40 row">
                        <div class="col-sm-4">
                            <?php if ($itemTags): ?>
                            <div class="posts-tags">
                                <?php foreach ($itemTags as $tag): ?>
                                <a href="<?php print content_link(PAGE_ID); ?>/tags:<?php print url_title($tag) ?>"><span
                                        class="badge badge-primary"><?php echo $tag; ?></span></a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="edit safe-mode nodrop blog-inner-page" field="blog-inner" rel="page">
    <module type="comments" template="skin-1" />
</div>
</div>

<script>
    jQuery(window).on("load", function(){
        jQuery("body").addClass("blog-inner-body");
    });
</script>
<?php include template_dir() . "footer.php"; ?>