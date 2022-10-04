<style>
.page-breadcumb-container .breadcrumb-bg {
    position: relative;
}
</style>

<div class="page-breadcumb-container blog-breadcumb edit" field="layout-breadcrumb<?php print $params['id'] ?>"
    rel="module">
    <div class="breadcrumb-bg bg-cover"
        style="background-image: url('<?php print template_url(); ?>/assets/images/hero-bg.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="page-breadcumb-container-content">
                <?php if(!empty(get_content("layout_file=layouts__blog.php&id=".PAGE_ID))) : ?>
                <div class="blog-breadcumb-header allow-drop">
                    <?php if(CATEGORY_ID){ ?>
                    <h1><?php (isset(get_category_by_id(CATEGORY_ID)['title'])) ? print (get_category_by_id(CATEGORY_ID)['title']) : "" ; ?>
                    </h1>
                    <?php } else{ ?>
                    <h1 class="edit" rel="content" field="blog_breadcumb_header">Blog</h1>

                    <?php } ?>
                </div>
                <module type="breadcrumb" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>