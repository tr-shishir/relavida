<?php

/*

type: layout

name: Blog Posts

position: 9

*/

?>


<div class="nodrop edit safe-mode" field="layout-skin-9-<?php print $params['id'] ?>" rel="module">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
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
                <br/>
                <br/>
                <module type="posts" template="skin-1" />
            </div>
        </div>

        <div class="nk-gap-4"></div>
    </div>
</div>