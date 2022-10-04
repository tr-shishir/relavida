<?php include template_dir() . "header.php"; ?>
    <div class="portfolio-inner-page" id="portfolio-content-<?php print CONTENT_ID; ?>">
        <?php $post = get_content_by_id(CONTENT_ID); ?>

        <section class="p-t-100 p-b-50 fx-particles">
            <div class="container">
                <div class="row project-holder">
                    <div class="col-12 col-lg-6">
                        <module type="pictures" rel="content" template="skin-5" id="prtfolio-inner-pictures"/>
                    </div>

                    <div class="col-12 col-lg-6 relative">
                        <div class="project-info fixed">
                            <div class="heading">
                                <h1><?php print content_title(); ?></h1>
                            </div>

                            <div class="description">
                                <div class="edit dropcap" field="content" rel="content">
                                    <div class="element">
                                        <p>Lets put and sLorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                        <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                                            publishing
                                            software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                                </div>

                                <div class="table-responsive edit" field="table" rel="content">
                                    <table class="table">
                                        <tr>
                                            <td>Date</td>
                                            <td>29 Jan 2018</td>
                                        </tr>

                                        <tr>
                                            <td>Client</td>
                                            <td>Awesome Studio</td>
                                        </tr>

                                        <tr>
                                            <td>Category</td>
                                            <td>Photographer</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- <div class="edit safe-mode" field="post_share_1" rel="inherit">
                                <div class="element">
                                    <div class="m-t-40">
                                        <module type="sharer" id="post-top-sharer"/>
                                    </div>
                                </div>
                            </div> -->

                            <div class="m-t-40">
                                <module type="btn" text="Visit the project" button_style="btn-default btn-lg"/>
                            </div>
                        </div>
                        <div class="js-in-viewport"></div>
                    </div>
                </div>
            </div>
        </section>

        <div class="edit safe-mode" field="post_related" rel="inherit">
            <div class="element">
                <section class="section p-b-50 nodrop">
                    <div class="container">
                        <div class="text-center m-b-50">
                            <h1 class="bold"><?php print _e("Related Projects"); ?></h1>
                        </div>

                        <module type="posts" limit="3" template="skin-3" hide_paging="true"/>
                    </div>
                </section>
            </div>
        </div>
    </div>

<?php include template_dir() . "footer.php"; ?>