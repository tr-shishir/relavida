<?php include template_dir() . "header.php"; ?>

<div id="portfolio-content-<?php print CONTENT_ID; ?>">

    <div class="container">
        <div class="nk-portfolio-single">

            <div class="nk-gap-4 mb-14"></div>
            <h1 class="edit display-4 nk-portfolio-title" field="title" rel="content">Why you should Always First</h1>
            <div class="clearfix"></div>
            <div class="row ">
                <div class="edit" field="content_body" rel="content">
                    <div class="col-lg-8">
                        <div class="nk-portfolio-info">
                            <div class="nk-portfolio-text">
                                <p>Nullam lobortis neque turpis, nec tempus sem pharetra at. Donec et quam, ullamcorper velit. Aliquam maximus ullamcorper ligula, at placerat dui hendrerit sed. Sed
                                    metus urna, bibendum id tortor, feugiat ipsum. Aliquam vehicula neque sit amet dolor malesuada pretium.</p>
                                <p>Curabitur tristique, felis ut mattis auctor, elit ante laoreet libero, ac lorem quam vitae libero. Suspen disse aliquet eget risus quis vehicula.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <table class="nk-portfolio-details">
                            <tr>
                                <td>
                                    <strong>Client:</strong>
                                </td>
                                <td>Anna Doe</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Date:</strong>
                                </td>
                                <td>06.20.2016</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="nk-gap-4 mt-14"></div>

        </div>
    </div>

    <module type="pictures" class="nk-img-fit" template="inner" content-id="<?php print CONTENT_ID ?>" id="portfolio-holder-<?php print CONTENT_ID ?>"/>
    <br/>

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
