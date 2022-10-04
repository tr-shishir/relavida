<?php

/*

type: layout

name: Blog Posts 4 per row

position: 18

*/

?>

<?php
if (!$classes['padding_top']) {
    $classes['padding_top'] = 'p-t-50';
}
if (!$classes['padding_bottom']) {
    $classes['padding_bottom'] = 'p-b-50';
}

$layout_classes = ' ' . $classes['padding_top'] . ' ' . $classes['padding_bottom'] . ' ';
?>

<section class="section <?php print $layout_classes; ?> edit safe-mode nodrop" field="layout-skin-18-<?php print $params['id'] ?>" rel="module">
    <div class="container">
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
        <module type="posts"/>
    </div>
</section>