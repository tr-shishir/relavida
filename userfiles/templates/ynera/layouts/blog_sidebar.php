<?php
$showHeader = temp_blog_collapse();
?>

<style>
.blog-sidebar .module-categories {
    margin: 12px auto;
}

.blog-sidebar>h6 {
    font-size: 18px;
    text-transform: uppercase;
    font-weight: 600;
    color: #555555;
    position: relative;
    padding-bottom: 10px;
    position: relative;
}

.blog-sidebar>h6::after {
    content: "";
    width: 40px;
    height: 3px;
    background-color: rgba(0, 0, 0, 0.1);
    position: absolute;
    bottom: 0;
    left: 0;
}

.blog-sidebar .categorySideBar ul.nav li a:not(:last-child) {
    border-color: transparent !important;
}

.categorySideBar ul.nav li a {
    color: #039f7b;
}

.blog-sidebar .categorySideBar .module.module-categories {
    border: 0 !important;
}

.categorySideBar .module.module-categories {
    border: none !important;
}

.categorySideBar .module.module-categories {
    margin-top: 0;
}

.categorySideBar ul.nav li a:not(:last-child) {
    border: none;
}

.blog-sidebar hr {
    display: none !important;
    border: none !important;
}
</style>

<div class="<?php print @$showHeader['sidebar']; ?>">
    <div class="sidebar__widget categorySideBar blog-sidebar">
        <h6><?php _lang("Kategorien"); ?></h6>
        <hr>
        <div class="edit" field="blog_content_main_wrapper" rel="content">
            <module type="categories" content-id="<?php print PAGE_ID; ?>" />
        </div>
    </div>
</div>