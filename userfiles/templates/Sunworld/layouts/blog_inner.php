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
    <div class="blog-inner-page" id="blog-content-<?php print CONTENT_ID; ?>">
        <?php $post = get_content_by_id(CONTENT_ID); ?>
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
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <section class="p-t-20 p-b-50">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <module type="breadcrumb" />
                                    <div class="heading text-left">
                                        <h1><?php if ($rssfound) {
                                                    print $post['title'];
                                                } else {
                                                    print content_title();
                                                } ?></h1>
                                    </div>
            <!-- testing -->

                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="p-t-0 p-b-50">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <?php if ($rssfound) { ?>
                                        <?php if(isset($post['media']['filename'])): ?>
                                            <div class="dt_rss_img" style="background-image: url('<?php print thumbnail($post['media']['filename'], 1200, 700, true); ?>')"></div>
                                        <?php endif; ?>
                                    <?php }else{ ?>
                                        <module type="pictures" rel="content" template="skin-3" id="blog-post-pictures" />
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <?php if($post['content']){ ?>
                        <section class="p-t-0 p-b-10 section">
                            <div class="">
                                <div class="">
                                    <div class="">
                                        <div class="description <?php if(is_logged() == true){ ?>edit<?php } ?> dropcap" field="content" rel="content">
                                        <?php if(is_logged() != true){ ?>
                                            <p><?php print $post['content']; ?></p>
                                        <?php }else{
                                            if ($rssfound) {
                                                print $post['content'];
                                            }else{
                                            ?>
                                            <div class="element">
                                                <p align="justify"><?php print _e("This text is set by default and is suitable for edit in real time. By default the drag and drop core feature will allow you to position it anywhere on the site. Get creative, Make Web."); ?></p>
                                            </div>
                                            <?php } } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php } ?>
                </div>
            </div>
        </div>


        <module type="comments" template="skin-1" data-content-id="<?php print CONTENT_ID; ?>"/>
    </div>

<?php include template_dir() . "footer.php"; ?>