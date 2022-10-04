<?php
$showHeader = temp_blog_collapse();
?>

<style>
    .blog-sidebar .module-categories {
        margin: 12px auto;
    }
</style>

<div class="<?php print @$showHeader['sidebar']; ?>">
    <div class="sidebar__widget categorySideBar blog-sidebar">
        <h6><?php _lang("Kategorien"); ?></h6>
        <hr>
        <div class="edit" field="blog_content_main_wrapper" rel="content">
            <module type="categories" content-id="<?php print PAGE_ID; ?>"/>
        </div>
    </div>
</div>
