<?php
$showHeader = temp_blog_collapse();
?>

<div class="<?php print @$showHeader['sidebar']; ?>">
    <div class="sidebar__widget categorySideBar">
        <h6><?php _lang("Kategorien", "templates/bamboo"); ?></h6>
        <hr>
        <div class="edit" field="blog_content_main_wrapper" rel="content">
            <module type="categories" content-id="<?php print PAGE_ID; ?>"/>
        </div>
    </div>
</div>
