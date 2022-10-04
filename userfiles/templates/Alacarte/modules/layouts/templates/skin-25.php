<?php

/*

type: layout

name: Blog With Sidebar

position: 24

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-70';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-70';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="blogWithSidebarLayout section <?php print $layout_classes; ?> safe-mode nodrop" field="layout-skin-22-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include TEMPLATE_DIR . 'layouts' . DS . "blog_sidebar.php" ?>
            </div>
            <div class="<?php if($GLOBALS['custom_active_category'] == get_content('layout_file=layouts__blog.php')[0]['id']) {
                print "col-md-12" ;
            } else{
                print "col-md-9" ;
            } ?>">
            <?php if(!empty(get_content("layout_file=layouts__blog.php&id=".PAGE_ID))) : ?>
                <div class="blog-breadcumb">
                    <div class="blog-breadcumb-header allow-drop">
                        <?php if(CATEGORY_ID){ ?>
                            <h1><?php (isset(get_category_by_id(CATEGORY_ID)['title'])) ? print (get_category_by_id(CATEGORY_ID)['title']) : "" ; ?></h1>
                        <?php } else{ ?>
                            <h1 class="edit" rel="content" field="blog_breadcumb_header">Blog</h1>

                        <?php } ?>
                    </div>
                    <module type="breadcrumb"/>
                </div>
            <?php endif; ?>
                <module type="posts" hide_paging="true" limit="4" />
            </div>
        </div>
    </div>
</section>