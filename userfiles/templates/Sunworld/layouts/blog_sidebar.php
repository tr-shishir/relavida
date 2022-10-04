<?php
$showHeader = temp_blog_collapse();
?>

<div class="<?php print @$showHeader['sidebar']; ?>">
    <div class="sidebar__widget sidebar-cat categorySideBar">
        <h5><?php _lang("Kategorien", "templates/bamboo"); ?></h5>
        <hr>
        <div class="edit" field="blog_content_main" rel="content">
            <module type="categories" content-id="<?php print PAGE_ID; ?>"/>
        </div>
    </div>
</div>
